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
if (!is_array($data['message'])) {
    exit;
}

// add
$type = $data['message']['chat']['type'];

$message = new Message();
$message->setMessageId          ($data['message']['message_id']         );
$message->setUpdateId           ($data['update_id']                     );
$message->setUserId             ($data['message']['from']['id']         );
$message->setFirstName          ($data['message']['from']['first_name'] );
$message->setLastName           ($data['message']['from']['last_name']  );
$message->setChatType           ($type                                  );
$message->setChatId             ($data['message']['chat']['id']         );
$message->setContent            ($data['message']['text']               );
$message->setCreateMessageTime  ($data['message']['date']               );

if ('group'===$type) {
    $message->setChatTitle($data['message']['chat']['title']);
}

$messages = new Messages();
$messages->addMessage($message);

// 
