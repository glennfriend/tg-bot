<?php

class ModuleSetting extends ModuleSettingBase
{

    /**
     *  autoload
     *      - module 裡面所需載入的程式
     */
    public function loader()
    {
        $basePath = $this->get('basePath');

        $loader = new Composer\Autoload\ClassLoader();
        $loader->addPsr4('AppModule\\',     "{$basePath}/app/AppModule/");
        $loader->addPsr4('CommandModule\\', "{$basePath}/app/CommandModule/");

        $filesMap = $this->findFoldersFiles([
            "{$basePath}/app/AppModule/components",
            "{$basePath}/app/CommandModule/components",
        ]);
        $loader->addClassMap($filesMap);
        $loader->register();
    }

    /**
     *
     */
    public function perform()
    {
        $this->loader();
    }
}
