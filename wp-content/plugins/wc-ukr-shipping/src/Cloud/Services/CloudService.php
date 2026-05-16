<?php

namespace kirillbdev\WCUkrShipping\Cloud\Services;

use kirillbdev\WCUkrShipping\Cloud\Exceptions\CloudApiException;
use kirillbdev\WCUkrShipping\Cloud\Exceptions\CloudServiceException;
use kirillbdev\WCUkrShipping\Cloud\Http\CloudApi;

if ( ! defined('ABSPATH')) {
    exit;
}

class CloudService
{
    public function api(): CloudApi
    {
        return new CloudApi(get_option(WCUS_OPTION_CLOUD_API_KEY));
    }

    /**
     * @param string $apiKey
     * @return array
     *
     * @throws CloudApiException
     * @throws CloudServiceException
     */
    public function connect(string $apiKey): array
    {
        $api = new CloudApi($apiKey);
        $response = $api->get('store');

        if ($response->isOk()) {
            update_option(WCUS_OPTION_CLOUD_API_KEY, $apiKey);
            update_option(WCUS_OPTION_CLOUD_PUBLIC_API_UUID, $response->get('public_api_uuid'));
            update_option(WCUS_OPTION_CLOUD_CONNECTED, 1);

            return $response->all();
        }

        throw new CloudServiceException('Cannot connect to cloud server. ' . $response->get('message'));
    }

    public function disconnect(): void
    {
        delete_option(WCUS_OPTION_CLOUD_API_KEY);
        delete_option(WCUS_OPTION_CLOUD_PUBLIC_API_UUID);
        delete_option(WCUS_OPTION_CLOUD_CONNECTED);
    }

    /**
     * @return array
     * @throws CloudApiException
     */
    public function getStoreInfo(): array
    {
        $response = $this->api()->get('store');

        return $response->isOk() ? $response->all() : [];
    }
}