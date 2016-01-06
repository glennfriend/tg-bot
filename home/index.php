<?php

$basePath = dirname(__DIR__);
require_once $basePath . '/app/bootstrap.php';
initialize($basePath);

/*
    TODO: 請考慮改成以下方式
        - browser 時輸出 一般訊息  (開發狀態)
        - ajax    時輸出 json type (使用狀態)
*/
$app = new Slim\App(getDefaultSlimConfig());
$app->get('/just-test',             'AppController\JustTest:hello');
$app->get('/just-test-send',        'AppController\JustTest:send');
$app->get('/set-webhook/{status}',  'AppController\Setting:webhook');
$app->get('/list',                  'AppController\Info:getItems');
$app->get('/info',                  'AppController\Info:about');

$app->run();
