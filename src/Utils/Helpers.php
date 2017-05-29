<?php

if (!function_exists('AoLogs')) {

    /**
     * @return \AoLogs\Utils\Tools
     */
    function AoLogs()
    {
        return app('AoLogs');
    }

}