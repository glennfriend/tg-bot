<?php
$basePath = dirname(__DIR__);
require_once $basePath . '/app/bootstrap.php';
initialize($basePath);

$input = file_get_contents("php://input");
$data = json_decode($input, true);

if (isTraining()) {
    $content = print_r($data, true);
    di('log')->write('telegram-bot-hook.log', $content);
}


if (!is_array($data)) {
    exit;
}

$message = MessageHelper::makeMessageByArray($data);
if (!$message) {
    exit;
}

$messages = new Messages();
$messages->addMessage($message);

// 
