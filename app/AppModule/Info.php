<?php
namespace AppModule;
use BotHelper;
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
        $info = BotHelper::getTelegram()->getMe();
        if (!$info) {
            $error = ErrorSupportHelper::get('4003');
            put($error);
            return;
        }

        put($info);
    }

}
