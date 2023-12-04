<?php
$data = file_get_contents('php://input');
$data = json_decode($data, true);
file_put_contents('src/result/index.php', print_r($data, true));
?>