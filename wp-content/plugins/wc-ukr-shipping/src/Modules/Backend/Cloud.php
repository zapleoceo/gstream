<?php

namespace kirillbdev\WCUkrShipping\Modules\Backend;

use kirillbdev\WCUkrShipping\Http\Controllers\CloudController;
use kirillbdev\WCUSCore\Contracts\ModuleInterface;
use kirillbdev\WCUSCore\Http\Routing\Route;

if ( ! defined('ABSPATH')) {
    exit;
}

class Cloud implements ModuleInterface
{
    public function init()
    {

    }

    public function routes()
    {
        return [
            new Route('wcus_cloud_connect', CloudController::class, 'connect'),
            new Route('wcus_cloud_disconnect', CloudController::class, 'disconnect'),
            new Route('wcus_cloud_get_store_info', CloudController::class, 'getStoreInfo')
        ];
    }
}