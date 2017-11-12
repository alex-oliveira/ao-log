<?php

namespace AoLogs\Tools;

use AoScrud\Tools\RouterGerator;
use AoScrud\Traits\AoBuildTrait;

class Router extends RouterGerator
{

    use AoBuildTrait;

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