<?php
use Symfony\Component\DependencyInjection;

function initialize($basePath)
{
    error_reporting(-1);
    ini_set('html_errors','Off');
    ini_set('display_errors','Off');

    if ( phpversion() < '5.5' ) {
        pr("PHP Version need >= 5.5");
        exit;
    }

    require_once $basePath . '/composer/vendor/autoload.php';

    // init config
    Lib\Config::init( $basePath . '/app/config');
    if ( conf('app.path') !== $basePath ) {
       pr('base path setting error!');
       exit;
    }

    if (isTraining()) {
        error_reporting(E_ALL);
        ini_set('html_errors','On');
        ini_set('display_errors','On');
    }

    date_default_timezone_set(conf('app.timezone'));
    diInit();

}

function getDefaultSlimConfig()
{
    $container = new \Slim\Container();

    if (isTraining()) {
        $container['settings']['displayErrorDetails'] = true;
    }

    // Override the default Not Found Handler
    $container['notFoundHandler'] = function ($c) {
        return function ($request, $response) use ($c) {

            $error = json_encode([
                'error' => [
                    'code'    => '100',
                    'message' => 'Page not found',
                ]
            ]);

            return $c['response']
                ->withStatus(404)
                ->withHeader('Content-Type', 'application/json')
                ->write($error)
            ;

        };
    };

    return $container;
}

function isTraining()
{
    if ( 'training' === conf('app.env') ) {
        return true;
    }
    return false;
}

function conf($key)
{
    return Lib\Config::get($key);
}

function pr($data, $writeLog=false)
{
    if (is_object($data) || is_array($data)) {
        print_r($data);

        if ($writeLog) {
            di('log')->record(
                print_r($data, true)
            );
        }
    }
    else {
        echo $data;
        echo "\n";

        if ($writeLog) {
            di('log')->record($data);
        }
    }
}


/**
 *  包裝了 Symfony Dependency-Injection
 *  提供了簡易的取用方式 DI->get( $service )
 */
function di($getParam=null)
{
    static $container;
    if ($container) {
        if ($getParam) {
            return $container->get($getParam);
        }
        return $container;
    }

    $container = new DependencyInjection\ContainerBuilder();
    return $container;
}

/**
 *
 */
function diInit()
{
    $di = di();
    $basePath = conf('app.path');

    // log folder
    $di->setDefinition('log', new DependencyInjection\Definition(
        'Lib\Log'
    ));
    $di->get('log')->init( $basePath . '/var' );

    // cache
    $di->setDefinition('cache', new DependencyInjection\Definition(
        'Bridge\Cache'
    ));
    $di->get('cache')->init( $basePath . '/var/cache' );

}
