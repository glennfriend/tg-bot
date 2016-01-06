<?php
use Telegram;

/**
 *
 */
class BotHelper
{
    /**
     *  send message
     *  @return send message id or false
     */
    public static function sendMessage($toId, $text)
    {
        $message = [
            'chat_id'                   => $toId,
            'text'                      => $text,
            'parse_mode'                => '',
            'disable_web_page_preview'  => '',
            'reply_to_message_id'       => '',
            'reply_markup'              => ''
        ];
        $response = self::getTelegram()->sendMessage($message);
        return $response->getMessageId();
    }

    // --------------------------------------------------------------------------------
    // private
    // --------------------------------------------------------------------------------

    protected static function getTelegram()
    {
        return new Telegram\Bot\Api(conf('bot.token'));
    }

}
