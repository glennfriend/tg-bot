<?php
$basePath = dirname(__DIR__);
require_once $basePath . '/app/bootstrap.php';
initialize($basePath);

$input = file_get_contents("php://input");
$data = json_decode($input, true);


if (true) {
    $content  = date("Y-m-d H:i:s") . "\n";
    $content .= print_r($data, true);
    file_put_contents( 'log.log', $content."\n", FILE_APPEND );
}


if (!is_array($data)) {
    exit;
}
if (!is_array($data['message'])) {
    exit;
}

// add
$type = $data['message']['caht']['type'];

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
