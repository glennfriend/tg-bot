<?php

function initialize($basePath, $moduleName)
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
    ConfigManager::init( $basePath . '/app/config');
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

    // load module setting
    switch($moduleName)
    {
        case 'home':
            include __DIR__ . "/{$moduleName}-module-setting.php";

            $moduleSetting = new ModuleSetting();
            $moduleSetting->set('basePath', $basePath);
            $moduleSetting->perform();
            break;

        default:
            throw new Exception('Warning! setting file error!'); 
            exit;
    }

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

            $error = ErrorSupportHelper::getJson('4001');
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
    return ConfigManager::get($key);
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

    $container = new Symfony\Component\DependencyInjection\ContainerBuilder();
    return $container;
}

/**
 *  @see https://github.com/symfony/dependency-injection
 *  @see http://symfony.com/doc/current/components/dependency_injection/factories.html
 *  @see http://symfony.com/doc/current/components/dependency_injection/introduction.html
 */
function diInit()
{
    // $basePath = conf('app.path');

    $di = di();
    $di->setParameter('app.path', conf('app.path') );

    /*
    $di->register('abc', 'Lib\Abc')
        ->addArgument('%app.path%');                    // __construct
        ->setProperty('setDb', [new Reference('db')]);  // ??
    */

    // log & log folder
    $di->register('log', 'Bridge\Log')
        ->addMethodCall('init', ['%app.path%/var']);

    // cache
    $di->register('cache', 'Bridge\Cache')
        ->addMethodCall('init', ['%app.path%/var/cache']);

}
