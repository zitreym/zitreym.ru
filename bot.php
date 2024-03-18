<?php
 require("function_bot/function.php");

$data = file_get_contents('php://input');
$data = json_decode($data, true);
 
if (empty($data['message']['chat']['id'])) {
	exit();
}
 
define('TOKEN', '6933909374:AAHGAiNH6kb8hovWYho_wulZrKmf22eFE_I');

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
        schetchiki($data['message']['chat']['id']);
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