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

//переменные
$otvet = var_export($data, true);
$admin = 688790193;
$user = $data['message']['from']['id'];
$username = $data['message']['from']['first_name'];
$text = $data['message']['text'];

//ответ на текст
if (!empty($data['message']['text'])) {
    sendTelegram(
        'sendMessage', 
        array(
            'chat_id' => $data['message']['chat']['id'],
            'text' => 'Привет, ' . $username . ''
        )
    );
    exit();	
    sendTelegram(
        'sendMessage', 
        array(
            'chat_id' => $admin,
            'text' => '' . $otvet . ''
        )
    );
    exit();	
}