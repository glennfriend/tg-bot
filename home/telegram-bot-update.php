<?php
/**
 *  該程式僅供於 training 環境使用
 *      - 不使用 web hook
 *      - 資料直接取得 https://api.telegram.org/bot???:??????/getUpdates
 *
 */
$basePath = dirname(__DIR__);
require_once $basePath . '/app/bootstrap.php';
initialize($basePath, 'home');

if (!isTraining()) {
    echo ErrorSupportHelper::getJson('4002');
    exit;
}

$telegram = BotHelper::getTelegram();
try {
    $updates = $telegram->getUpdates();
}
catch(\Telegram\Bot\Exceptions\TelegramResponseException $e) {
    put($e->getMessage());
    return;
}

$result = [];
$messages = new Messages();
foreach ($updates as $update) {

    $message = MessageHelper::makeMessageByTelegramUpdate($update);

    // 從 updates 來的資料會有許多重覆資料
    // 該確認之後再寫入
    $existMessage = $messages->getMessageByMessageId($message->getMessageId());
    if ($existMessage) {
        continue;
    }

    $id = $messages->addMessage($message);
    $result[] = [
        $message->getMessageId(),
        $id
    ];

    // execute command controller
    if ($id) {
        $controller = new \CommandModule\Enter();
        $controller->home($id);
    }
}

echo json_encode($result, true);
