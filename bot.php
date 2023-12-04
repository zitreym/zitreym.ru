<?php
 
$data = file_get_contents('php://input');
$data = json_decode($data, true);
 
if (empty($data['message']['chat']['id'])) {
	exit();
}
 
define('TOKEN', '6933909374:AAHeBloEuYqLjkIFxedARA_77NmhyyDWehg');
 
// Функция вызова методов API.
function sendTelegram($method, $response)
{
	$ch = curl_init('https://api.telegram.org/bot' . TOKEN . '/' . $method);  
	curl_setopt($ch, CURLOPT_POST, 1);  
	curl_setopt($ch, CURLOPT_POSTFIELDS, $response);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HEADER, false);
	$res = curl_exec($ch);
	curl_close($ch);
 
	return $res;
}
 
// Прислали фото.
if (!empty($data['message']['photo'])) {
	$photo = array_pop($data['message']['photo']);
	$res = sendTelegram(
		'getFile', 
		array(
			'file_id' => $photo['file_id']
		)
	);
	
	$res = json_decode($res, true);
	if ($res['ok']) {
		$src = 'https://api.telegram.org/file/bot' . TOKEN . '/' . $res['result']['file_path'];
		$dest = __DIR__ . '/' . time() . '-' . basename($src);
 
		if (copy($src, $dest)) {
			sendTelegram(
				'sendMessage', 
				array(
					'chat_id' => $data['message']['chat']['id'],
					'text' => 'Фото сохранено'
				)
			);
			
		}
	}
	
	exit();	
}
 
// Прислали файл.
if (!empty($data['message']['document'])) {
	$res = sendTelegram(
		'getFile', 
		array(
			'file_id' => $data['message']['document']['file_id']
		)
	);
	
	$res = json_decode($res, true);
	if ($res['ok']) {
		$src = 'https://api.telegram.org/file/bot' . TOKEN . '/' . $res['result']['file_path'];
		$dest = __DIR__ . '/' . time() . '-' . $data['message']['document']['file_name'];
 
		if (copy($src, $dest)) {
			sendTelegram(
				'sendMessage', 
				array(
					'chat_id' => $data['message']['chat']['id'],
					'text' => 'Файл сохранён'
				)
			);	
		}
	}
	
	exit();	
}
 
// Ответ на текстовые сообщения.
if (!empty($data['message']['text'])) {
	$text = $data['message']['text'];
 
	if (mb_stripos($text, 'привет') !== false) {
		sendTelegram(
			'sendMessage', 
			array(
				'chat_id' => $data['message']['chat']['id'],
				'text' => 'Хай!'
			)
		);
 
		exit();	
	} 
 
	// Отправка фото.
	if (mb_stripos($text, 'фото') !== false) {
		sendTelegram(
			'sendPhoto', 
			array(
				'chat_id' => $data['message']['chat']['id'],
				'photo' => curl_file_create(__DIR__ . '/torin.jpg')
			)
		);
		
		exit();	
	}
 
	// Отправка файла.
	if (mb_stripos($text, 'файл') !== false) {
		sendTelegram(
			'sendDocument', 
			array(
				'chat_id' => $data['message']['chat']['id'],
				'document' => curl_file_create(__DIR__ . '/example.xls')
			)
		);
 
		exit();	
	}
}