<?php

namespace kirillbdev\WCUkrShipping\States;

use kirillbdev\WCUkrShipping\Includes\AppState;

if ( ! defined('ABSPATH')) {
    exit;
}

class CloudSettingsState extends AppState
{
    protected function getState(): array
    {
        return [
            'api_key' => get_option(WCUS_OPTION_CLOUD_API_KEY, ''),
            'connected' => (bool)get_option(WCUS_OPTION_CLOUD_CONNECTED, 0)
        ];
    }
}