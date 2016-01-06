<?php
namespace AppController;
use ErrorSupportHelper;

/**
 *
 */
class Info extends BaseController
{

    /**
     *  
     */
    protected function about()
    {
        $telegram = new \Telegram\Bot\Api(conf('bot.token'));

        $info = $telegram->getMe();
        if ($info) {
            $error = ErrorSupportHelper::get('4003');
            put($error);
            return;
        }

        put($info);
    }

}
