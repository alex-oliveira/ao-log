<?php

namespace AoLogs\Controllers;

use AoLogs\Services\LogService;
use AoScrud\Controllers\AoScrudController;

class AoLogsController extends AoScrudController
{

    //------------------------------------------------------------------------------------------------------------------
    // DYNAMIC
    //------------------------------------------------------------------------------------------------------------------

    protected $dynamicClass;

    public function getDynamicClass()
    {
        return $this->dynamicClass;
    }

    //------------------------------------------------------------------------------------------------------------------
    // CONSTRUCTOR
    //------------------------------------------------------------------------------------------------------------------

    public function __construct(LogService $service)
    {
        $this->service = $service->setDynamicClass($this->getDynamicClass());
    }

}