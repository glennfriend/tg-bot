<?php
namespace CommandController;

/**
 *
 */
class ToHelp
{

    public function perform($message)
    {
        $now = date('m-d (w) H:i:s');
        return <<<"EOD"
{$now}
/help 提示訊息
EOD;
    }

}
