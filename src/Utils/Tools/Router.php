<?php

namespace AoLogs\Utils\Tools;

use AoScrud\Utils\Tools\RouterGerator;
use AoScrud\Utils\Traits\BuildTrait;

class Router extends RouterGerator
{

    use BuildTrait;

    protected $configs = [
        'prefix' => 'logs',
        'as' => 'logs.',
    ];

    protected $routes = [
        ['method' => 'get', 'url' => '/',     'configs' => ['as' => 'index', 'uses' => '@index']],
        ['method' => 'get', 'url' => '/{id}', 'configs' => ['as' => 'show',  'uses' => '@show']],
    ];

    public function foreign($foreign)
    {
        $this->configs['prefix'] = '{' . $foreign . '}/logs';
        return $this;
    }

}