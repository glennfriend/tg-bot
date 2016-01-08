<?php
namespace AppModule;
use BotHelper;

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
        $chatId = conf('bot.master_id');
        $text   = 'Hello World';
        $messageId = BotHelper::sendMessage($chatId, $text);
        put( $messageId );
    }

}
