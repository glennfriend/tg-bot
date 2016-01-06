<?php
namespace CommandController;

/**
 *
 */
class Enter
{

    /**
     *
     */
    public function home($id)
    {
        di('log')->record("--start-- {$id}");

        $messages = new \Messages();
        $message = $messages->getMessage($id);

        /*
            處理 message 物件
                - 決定是否要設定 is used
                - 是否要處理, 另外 call controller
                - 是否不處理
                - 回傳至 user or chat
                    - 目前想法是, 只要 user 是白名單, 就傳
                    - 目前想法是, chat 裡面有一個白名單, 就傳
        */

        di('log')->record('--end--');
    }

}
