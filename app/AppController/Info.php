<?php
namespace AppController;

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
        if (!$info) {
            $error = [
                'error' => [
                    'code'    => '100',
                    'message' => 'get getMe() fail',
                ]
            ];
            put($error);
            return;
        }

        put($info);
    }

}
