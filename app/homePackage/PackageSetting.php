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
     */
    public function diLoader()
    {
        // none
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
