<?php
namespace Api;

/**
 *
 */
class Setting extends BaseApi
{

    /**
     *  
     */
    protected function webhook()
    {
        $status = attrib('status');
        switch (strtolower($status)) {
            case 'on':
                // TODO: 未測試!!
                $telegram = new \Telegram\Bot\Api(conf('bot.token'));
                $response = $telegram->setWebhook(conf('bot.hook_file'));
                put( $response );
                exit;

            case 'off':
                $telegram = new \Telegram\Bot\Api(conf('bot.token'));
                $response = $telegram->removeWebhook();
                put( $response->getDecodedBody() );
                exit;
            default:
        }
        put('fail');
    }

}
