<?php
/**
*   Very simple chat bot @verysimple_bot_menu by Novelsite.ru
*   + menu
*   22.06.2022
*/
header('Content-Type: text/html; charset=utf-8'); // на всякий случай досообщим PHP, что все в кодировке UTF-8

$site_dir = dirname(dirname(__FILE__)).'/'; // корень сайта
$bot_token = '6933909374:AAHGAiNH6kb8hovWYho_wulZrKmf22eFE_I'; // токен вашего бота
$data = file_get_contents('php://input'); // весь ввод перенаправляем в $data
$data = json_decode($data, true); // декодируем json-закодированные-текстовые данные в PHP-массив

$order_chat_id = '123456789';  //chat_id менеджера компании для заявок
$bot_state = ''; // состояние бота, по-умолчанию пустое

// Для отладки, добавим запись полученных декодированных данных в файл message.txt, 
// который можно смотреть и понимать, что происходит при запросе к боту
// Позже, когда все будет работать закомментируйте эту строку:
file_put_contents(__DIR__ . '/message.txt', print_r($data, true));

// Основной код: получаем сообщение, что юзер отправил боту и 
// заполняем переменные для дальнейшего использования
if (!empty($data['message']['text'])) {
    $chat_id = $data['message']['from']['id'];
    $user_name = $data['message']['from']['username'];
    $first_name = $data['message']['from']['first_name'];
    $last_name = $data['message']['from']['last_name'];
    $text = trim($data['message']['text']);
    $text_array = explode(" ", $text);

	// получим текущее состояние бота, если оно есть
	$bot_state = get_bot_state ($chat_id);

    // если текущее состояние бота отправка заявки, то отправим заявку менеджеру компании на $order_chat_id
    if (substr($bot_state, 0, 6) == '/order') {
        $text_return = "
Заявка от @$user_name:
Имя: $first_name $last_name 
$text
";
        message_to_telegram($bot_token, $order_chat_id, $text_return);
        set_bot_state ($chat_id, ''); // не забудем почистить состояние на пустоту, после отправки заявки
    }
    // если состояние бота пустое -- то обычные запросы
    else {
    
    	// вывод информации Помощь
        if ($text == '/help') {
            $text_return = "Привет, $first_name $last_name, вот команды, что я понимаю: 
    /help - список команд
    /about - о нас
    /order - оставить заявку
    ";
            message_to_telegram($bot_token, $chat_id, $text_return);
            set_bot_state ($chat_id, '/help');
        }
        
        // вывод информации о нас
        elseif ($text == '/about') {
            $text_return = "verysimple_bot:
    Я пример самого простого бота для телеграм, написанного на PHP.
    Мой код можно скачивать, дополнять, исправлять. Код доступен в этой статье:
    https://www.novelsite.ru/kak-sozdat-prostogo-bota-dlya-telegram-na-php.html
	также есть дополнение статиь про добавление пунктов меню в бота: 
	https://www.novelsite.ru/dobavlyaem-punkty-menyu-telegram-bota-na-php.html
    ";
            message_to_telegram($bot_token, $chat_id, $text_return);
            set_bot_state ($chat_id, '/about');
        }
		
        // вывод информации об услугах и подменю 
        elseif ($text == '/srv') {
            $num = (int)$text_array[array_key_last($text_array)];
            if ($num == 1) {
				$ret = ["text"=>"⬅️ Вернуться", "callback_data"=>'/srv'],;
                $text_return = 
"<b>Услуга 1</b>:
---------------------
Текст об услуга 1 услуга 1 услуга 1 услуга 1 услуга 1 услуга 1 услуга 1.
";
			}
            elseif ($num == 2) {
				$ret = ["text"=>"⬅️ Вернуться", "callback_data"=>'/srv'],;
                $text_return = 
"<b>Услуга 2</b>:
---------------------
Текст об услуга 2 услуга 2 услуга 2 услуга 2 услуга 2 услуга 2 услуга 2.
";
			}
			else {
				$ret = [];
                $text_return = 
"<b>Услуги</b>:
---------------------
 1. Услуга 1
 2. Услуга 2
";
            }

            $reply_markup = json_encode([
                "inline_keyboard" => [
                    [
                        ["text"=>"Услуга 1", "callback_data"=>'/srv 1'],
                        ["text"=>"Услуга 2", "callback_data"=>'/srv 2'],
                    ],
                    $ret,
                ]
            ]);
                
            message_to_telegram($bot_token, $chat_id, $text_return, $reply_markup);
            set_bot_state ($chat_id, '/srv');
        }
        
        // переход в режим Заявки
        elseif ($text == '/order') {
            $text_return = "$first_name $last_name, для подтверждения Заявки введите текст вашей заявки и нажмите отправить. 
Наши специалисты свяжутся с вами в ближайшее время!
";
            message_to_telegram($bot_token, $chat_id, $text_return);
            set_bot_state ($chat_id, '/order');
        }
	}
}

// функция отправки сообщения от бота в диалог с юзером
function message_to_telegram($bot_token, $chat_id, $text, $reply_markup = '')
{
    $ch = curl_init();
    if ($reply_markup == '') {
        $btn[] = ["text"=>"О нас", "callback_data"=>'/about'];
        $btn[] = ["text"=>"Услуги", "callback_data"=>'/srv'];
        $btn[] = ["text"=>"Контакты", "callback_data"=>'/contact'];
        $btn[] = ["text"=>"Заявка", "callback_data"=>'/order'];
        $reply_markup = json_encode(["keyboard" => [$btn],  "resize_keyboard" => true]);
    }
    $ch_post = [
        CURLOPT_URL => 'https://api.telegram.org/bot' . $bot_token . '/sendMessage',
        CURLOPT_POST => TRUE,
        CURLOPT_RETURNTRANSFER => TRUE,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_POSTFIELDS => [
            'chat_id' => $chat_id,
            'parse_mode' => 'HTML',
            'text' => $text,
            'reply_markup' => $reply_markup,
        ]
    ];

    curl_setopt_array($ch, $ch_post);
    curl_exec($ch);
}

// сохранить состояние бота для пользователя
function set_bot_state ($chat_id, $data)
{
    file_put_contents(__DIR__ . '/users/'.$chat_id.'.txt', $data);
}

// получить текущее состояние бота для пользователя
function get_bot_state ($chat_id)
{
    if (file_exists(__DIR__ . '/users/'.$chat_id.'.txt')) {
        $data = file_get_contents(__DIR__ . '/users/'.$chat_id.'.txt');
        return $data;
    }
    else {
        return '';
    }
}