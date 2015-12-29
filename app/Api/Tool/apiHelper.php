<?php
namespace Api;

// --------------------------------------------------------------------------------
// warp Api tool functions
// --------------------------------------------------------------------------------

/**
 *  get slim request
 */
function getRequest()
{
    return Tool\LoadFunctions::$request;
}

/**
 *  get slim response
 */
function getResponse()
{
    return Tool\LoadFunctions::$response;
}

/**
 *  取得 route 處理之後取得的參數
 */
function attrib($key, $defaultValue=null)
{
    $val = getRequest()->getAttribute($key);
    if (!$val) {
        $val = $defaultValue;
    }
    return $val;
}

/**
 *  輸出
 */
function put($message)
{
    if (is_array($message)) {
        $message = json_encode($message);
    }
    elseif (is_object($message)) {
        $message = json_encode($message);
    }
    getResponse()->getBody()->write($message);
}

