<?php

namespace AoLogs;

use AoLogs\Services\LogService;
use AoLogs\Tools\Router;
use AoLogs\Tools\Schema;

class Tools
{
    //------------------------------------------------------------------------------------------------------------------
    // SCHEMA
    //------------------------------------------------------------------------------------------------------------------

    /**
     * @return Schema
     */
    public function schema()
    {
        return Schema::build();
    }

    //------------------------------------------------------------------------------------------------------------------
    // ROUTER
    //------------------------------------------------------------------------------------------------------------------

    /**
     * @return Router
     */
    public function router($controller = null)
    {
        $router = Router::build();

        if (isset($controller))
            $router->controller($controller);

        return $router;
    }

    //------------------------------------------------------------------------------------------------------------------
    // REGISTRY
    //------------------------------------------------------------------------------------------------------------------

    public function regitry($method, $obj, $data, $user_id = null)
    {
        $data['user_id'] = $user_id ? $user_id : Auth()->id();
        $data['operation'] = $method;

        $service = new LogService();
        $service->setDynamicClass(get_class($obj));

        $log = $service->create($data);
        $obj->logs()->save($log);

        return $log;
    }

    public function get($obj, $data, $user_id = null)
    {
        return $this->regitry('GET', $obj, $data, $user_id);
    }

    public function post($obj, $data, $user_id = null)
    {
        return $this->regitry('POST', $obj, $data, $user_id);
    }

    public function put($obj, $data, $user_id = null)
    {
        return $this->regitry('PUT', $obj, $data, $user_id);
    }

    public function delete($obj, $data, $user_id = null)
    {
        return $this->regitry('DELETE', $obj, $data, $user_id);
    }

}