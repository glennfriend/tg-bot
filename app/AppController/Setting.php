<?php
namespace AppController;

/**
 *
 */
class Setting extends BaseController
{

    /**
     *  
     */
    protected function webhook()
    {
        $status = attrib('status');
        switch (strtolower($status)) {
            case 'on':
                put('根據測試, 必須夾帶 crt 檔案才能正確設定 web hook, 請手動設定.');
                /*
                $telegram = new \Telegram\Bot\Api(conf('bot.token'));
                $response = $telegram->setWebhook([
                    'url' => conf('bot.hook_file')
                ]);
                put( $response );
                */
                return;

            case 'off':
                // 該指令關閉 web hook, 通常用於開發環境
                $telegram = new \Telegram\Bot\Api(conf('bot.token'));
                $response = $telegram->removeWebhook();
                put( $response->getDecodedBody() );
                return;

            default:
                break;
        }
        put('fail');
    }

}
