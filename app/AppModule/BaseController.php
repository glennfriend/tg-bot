<?php
namespace AppModule;

/**
 *
 */
class BaseController
{

    /**
     *
     */
    public function __call($method, $args)
    {
        if (!method_exists($this, $method)) {
            throw new \Exception("API method '{$method}' is not exist!");
            exit;
        }
        $this->loadHelper($args);
        $this->$method();
    }

    /**
     *  load functions, to help controller
     *
     *  裡面包裹的 help function
     *  僅給 controller 使用
     *  並不給予 view 使用
     */
    protected function loadHelper(Array $args)
    {
        $request  = $args[0];
        $response = $args[1];
        $args     = $args[2];
        Tool\LoadHelper::init($request, $response, $args);
    }

}
