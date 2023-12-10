<?php
 
$data = file_get_contents('php://input');
$data = json_decode($data, true);
 
if (empty($data['message']['chat']['id'])) {
	exit();
}
 
define('TOKEN', '6933909374:AAHGAiNH6kb8hovWYho_wulZrKmf22eFE_I');
 
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
$userid = $data['message']['from']['id'];
$username = $data['message']['from']['first_name'];
$lastname = $data['message']['from']['last_name'];
$nameid = $data['message']['from']['username'];
$text = $data['message']['text'];

switch ($text) {
    case 'счетчики':
        sendTelegram(
            'sendMessage', 
            array(
                'chat_id' => $data['message']['chat']['id'],
                'parse_mode' => 'HTML',
                'text' => 'Вы выбрали счетчики',
                'reply_markup' => json_encode(array(
                    'keyboard' => array(
                        array(
                            array(
                                'text' => 'Записать информацию',
                                'url' => '/chet_zapis',
                            ),
                            array(
                                'text' => 'Вывести информацию',
                                'url' => '/chet_output',
                            ),
                        )
                    ),
                    'one_time_keyboard' => TRUE,
                    'resize_keyboard' => TRUE,
                ))
            )
        );
        break;
    case 'Записать информацию':
        sendTelegram(
            'sendMessage', 
            array(
                'chat_id' => $data['message']['chat']['id'],
                'parse_mode' => 'HTML',
                'text' => 'Какой показатель хотите записать?',
                'reply_markup' => json_encode(array(
                    'keyboard' => array(
                        array(
                            array(
                                'text' => 'Горячая вода',
                                'url' => '/chet_gv',
                            ),
                            array(
                                'text' => 'Холодная вода',
                                'url' => '/chet_hv',
                            ),
                            array(
                                'text' => 'Электричество',
                                'url' => '/chet_el',
                            ),
                        )
                    ),
                    'one_time_keyboard' => TRUE,
                    'resize_keyboard' => TRUE,
                ))
            )
        );
        break;
    default:
        sendTelegram(
            'sendMessage', 
            array(
                'chat_id' => $data['message']['chat']['id'],
                'parse_mode' => 'HTML',
                'text' => 'Я не знаю такую команду, попробуй ещё раз',
                'reply_markup' => json_encode(array(
                    'keyboard' => array(
                        array(
                            array(
                                'text' => 'счетчики',
                                'url' => '/chet',
                            ),
                            array(
                                'text' => 'другое',
                                'url' => '/other',
                            ),
                        )
                    ),
                    'one_time_keyboard' => TRUE,
                    'resize_keyboard' => TRUE,
                ))
            )
        );
}