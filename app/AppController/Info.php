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
        $response = getResponse();

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

    /**
     *  get list
     */
    protected function getItems()
    {
        $telegram = new \Telegram\Bot\Api(conf('bot.token'));
        $updates = $telegram->getUpdates();
        $messages = new \Messages();

        $result = [];
        foreach ($updates as $update) {
            $message = \MessageHelper::makeMessageByTelegramUpdate($update);
            $result[] = $messages->addMessage($message);
        }

        put($result);
    }

    /**
     *  get list by web-hook
     */
    protected function getHookItems()
    {
        $telegram = new \Telegram\Bot\Api(conf('bot.token'));
        $updates = $telegram->getWebhookUpdates();
        print_r($updates);
        return;

        if (!$updates) {
            // ?
        }

    }

}
