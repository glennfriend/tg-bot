<?php

$masterId = '';

/**
 *  bot config
 */
return [

    /**
     *  bind code path & cod file
     */
    'hook_file' => 'https://www.xxxxxx.com/secret/telegram-bot-hook.php',

    /**
     *  
     */
    'token' => '999999999:aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',

    /**
     *  
     */
    'master_id' => $masterId,

    /**
     *  chat ids
     *  因為該程式可能輸出私人資訊, 避免它人誤用, 必須設定予許的白名單
     *      - 使用者
     *      - 群組
     *
     */
    'allow_chat_ids' => [
        $masterId,
    ],

];
