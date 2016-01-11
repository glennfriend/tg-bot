<?php

class PackageSetting extends PackageSettingBase
{

    /**
     *  autoload
     *      - module 裡面所需載入的程式
     */
    public function autoloader()
    {
        $basePath = $this->get('basePath');

        $loader = new Composer\Autoload\ClassLoader();
        $loader->addPsr4('AppModule\\',     "{$basePath}/app/homePackage/app/");
        $loader->addPsr4('CommandModule\\', "{$basePath}/app/homePackage/command/");

        $filesMap = $this->findFoldersFiles([
            "{$basePath}/app/homePackage/app/components",
            "{$basePath}/app/homePackage/command/components",
        ]);
        $loader->addClassMap($filesMap);
        $loader->register();
    }

    /**
     *  di loader
     *  @see https://github.com/symfony/dependency-injection
     *  @see http://symfony.com/doc/current/components/dependency_injection/factories.html
     *  @see http://symfony.com/doc/current/components/dependency_injection/introduction.html
     */
    public function diLoader()
    {
        $basePath = conf('app.path');

        $di = di();
        $di->setParameter('app.path', $basePath);

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

    /**
     *
     */
    public function perform()
    {
        $this->autoloader();
        $this->diLoader();
    }
}
