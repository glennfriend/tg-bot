<?php
namespace Api;

/**
 *
 */
class Info extends BaseApi
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

        $infos = [];
        foreach ($updates as $update) {
            $message = $update->getMessage();
            $infos[] = [
                'update_id'     => $update->getUpdateId(),
                'message_id'    => $message->getMessageId(),
                'user_id'       => $message->getFrom()->getId(),
                'chat_id'       => $message->getChat()->getId(),
                'date'          => $message->getDate(),
                'date_format'   => date("Y-m-d H:i:s", $message->getDate()),
                'text'          => $message->getText(),
            ];
        }
        put($infos);
    }

    /**
     *  get list by web-hook
     */
    protected function getHookItems()
    {
        // TODO: 未經測試
        exit;

        $telegram = new \Telegram\Bot\Api(conf('bot.token'));
        $updates = $telegram->getWebhookUpdates();
        print_r($updates);
        exit;

        if (!$updates) {
            // ?
        }

    }

/*
    protected function _about()
    {
        print_r( attrib('name') );
    }
*/

}
