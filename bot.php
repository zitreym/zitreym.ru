<?php
$data = file_get_contents('php://input');
$data = json_decode($data, true);
file_put_contents(__DIR__ . '/message.txt', print_r($data, true));
?>