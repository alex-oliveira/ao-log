<?php

if (!function_exists('AoLogs')) {

    /**
     * @return \AoLogs\Tools
     */
    function AoLogs()
    {
        return app('AoLogs');
    }

}