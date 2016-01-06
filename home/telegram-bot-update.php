<?php
/**
 *  該程式僅供於 training 環境使用
 *      - 不使用 web hook
 *      - 資料直接取得 https://api.telegram.org/bot???:??????/getUpdates
 *
 */
$basePath = dirname(__DIR__);
require_once $basePath . '/app/bootstrap.php';
initialize($basePath);

if (!isTraining()) {
    echo ErrorSupportHelper::getJson('4002');
    exit;
}

$telegram = new \Telegram\Bot\Api(conf('bot.token'));
try {
    $updates = $telegram->getUpdates();
}
catch(\Telegram\Bot\Exceptions\TelegramResponseException $e) {
    put($e->getMessage());
    return;
}

$messages = new Messages();
$result = [];
foreach ($updates as $update) {
    $message = MessageHelper::makeMessageByTelegramUpdate($update);
    $id = $messages->addMessage($message);
    $result[] = $id;

    // execute command controller
    if ($id) {
        $controller = new \CommandController\Enter();
        $controller->home($id);
    }
}

echo json_encode($result, true);