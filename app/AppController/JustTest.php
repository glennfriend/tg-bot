<?php
namespace AppController;

/**
 *
 */
class JustTest extends BaseController
{

    /**
     *  
     */
    protected function hello()
    {
        put("Hello World");
    }

    /**
     *  test to master id
     */
    protected function send()
    {
        $telegram = new \Telegram\Bot\Api(conf('bot.token'));
        $chatId = conf('bot.master_id');

        $message = [
            'chat_id'                   => $chatId,
            'text'                      => 'Hello World',
            'parse_mode'                => '',
            'disable_web_page_preview'  => '',
            'reply_to_message_id'       => '',
            'reply_markup'              => ''
        ];

        $response = $telegram->sendMessage($message);
        $messageId = $response->getMessageId();
        put( $messageId );
    }

}
