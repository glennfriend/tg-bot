<?php
namespace AppController\Tool;

class LoadHelper
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

    /**
     *  get slim request
     */
    public static function getRequest()
    {
        return self::$request;
    }

    /**
     *  get slim response
     */
    public static function getResponse()
    {
        return self::$response;
    }

}
