<?php
namespace Bridge;

/**
 *  Log Bridge
 */
class Log
{

    /**
     *  dispatcher
     */
    private static $logPath = null;

    /**
     *
     */
    public static function init($logPath)
    {
        if ($logPath) {
            self::$logPath = $logPath;
        }
    }

    /**
     *  sql log
     */
    public static function sql($content)
    {
        $content = date("Y-m-d H:i:s") .' - '. $content;
        self::write('debug-sql.log', $content);
    }

    /* --------------------------------------------------------------------------------
        private
    -------------------------------------------------------------------------------- */

    /**
     *  write file
     */
    public static function write($file, $content)
    {
        if (!self::$logPath) {
            throw new Exception('LogBrg Error!');
        }

        if (!preg_match('/^[a-z0-9_\-\.]+$/i', $file)) {
            return;
        }

        $filename = self::$logPath .'/'. $file;
        file_put_contents( $filename, $content."\n", FILE_APPEND );
    }

}

