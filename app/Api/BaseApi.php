<?php
namespace Api;

/**
 *
 */
class BaseApi
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
        $this->loadFunctions($args);
        $this->$method();
    }

    /**
     *  load functions, to help Api controller
     *
     *  這裡面包裹的程式, 如同只給 controller 使用的 function
     *  由於 Api 性質的程式無 view
     *  所以並不用處置 "這些 function 不應該被 view 使用" 的問題
     */
    protected function loadFunctions($args)
    {
        $request  = $args[0];
        $response = $args[1];
        $args     = $args[2];
        Tool\LoadFunctions::init($request, $response, $args);
    }


}

