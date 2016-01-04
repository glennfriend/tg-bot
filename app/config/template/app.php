<?php

/**
 *  app config
 *  example:
 *      echo conf('app.env');
 *
 */
return [

    /**
     *  Environment
     *
     *      training    - 開發者環境
     *      production  - 正式環境
     */
    'env' => 'production',

    /**
     *  app path
     */
    'path' => '/var/www/bot',

    /**
     *  Project name
     */
    'name' => 'I am BOT',

    /**
     *  timezone
     *
     *      +0 => UTC
     *      -7 => America/Los_Angeles
     *      +8 => Asia/Taipei
     */
    'timezone' => 'Asia/Taipei',

];
