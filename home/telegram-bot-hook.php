<?php
/**
 *  該程式只能在 production 環境使用
 *      - 必須使用 web hook
 *
 */
$basePath = dirname(__DIR__);
require_once $basePath . '/app/bootstrap.php';
initialize($basePath, 'home');

$input = file_get_contents("php://input");
$data = json_decode($input, true);

if (isTraining()) {
    $content = print_r($data, true);
    if ($content) {
        di('log')->write('telegram-bot-hook.log', $content);
    }
}


if (!is_array($data)) {
    exit;
}

$message = MessageHelper::makeMessageByArray($data);
if (!$message) {
    exit;
}

$messages = new Messages();
$messageId = $messages->addMessage($message);

// execute command controller
$controller = new CommandModule\Enter();
$controller->home($messageId);
