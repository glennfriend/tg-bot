<?php

class MessageHelper
{

    /**
     *  return Message object or null
     */
    public static function makeMessageByTelegramUpdate(Telegram\Bot\Objects\Update $update)
    {
        $arr = json_decode(json_encode($update), true);
        if (!is_array($arr)) {
            return null;
        }
        return self::makeMessageByArray($arr);
    }

    /**
     *  return Message object or null
     */
    public static function makeMessageByArray(Array $data)
    {
        if (!is_array($data['message'])) {
            return null;
        }
        if (!is_array($data['message']['from'])) {
            return null;
        }
        if (!is_array($data['message']['chat'])) {
            return null;
        }

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
        return $message;
    }

}
