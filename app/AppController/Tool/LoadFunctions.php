<?php
namespace AppController\Tool;

class LoadFunctions
{
    public static $request;
    public static $response;
    public static $args;

    public static function init($request, $response, $args)
    {
        self::$request  = $request;
        self::$response = $response;
        self::$args     = $args;

        include "appControllerHelper.php";
    }
}

