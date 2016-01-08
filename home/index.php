<?php

$basePath = dirname(__DIR__);
require_once $basePath . '/app/bootstrap.php';
initialize($basePath, 'home');

/*
    TODO: 請考慮改成以下方式
        - browser 時輸出 一般訊息  (開發狀態)
        - ajax    時輸出 json type (使用狀態)
*/
$app = new Slim\App(getDefaultSlimConfig());
$app->get('/just-test',             'AppModule\JustTest:hello');
$app->get('/just-test-send',        'AppModule\JustTest:send');
$app->get('/set-webhook/{status}',  'AppModule\Setting:webhook');
$app->get('/info',                  'AppModule\Info:about');

$app->run();
