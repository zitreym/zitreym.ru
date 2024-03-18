<?php
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
function schetchiki($chat_id)
{
    sendTelegram(
        'sendMessage', 
        array(
            'chat_id' => $chat_id,
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
}
?>