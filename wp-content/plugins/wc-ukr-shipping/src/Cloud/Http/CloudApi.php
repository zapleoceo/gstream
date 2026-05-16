<?php

namespace kirillbdev\WCUkrShipping\Cloud\Http;

use kirillbdev\WCUkrShipping\Cloud\Exceptions\CloudApiException;

if ( ! defined('ABSPATH')) {
    exit;
}

class CloudApi
{
    private const API_URL = 'https://wcus.qodax.software/api/v1';

    private $apiKey;

    public function __construct(?string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @param string $path
     *
     * @return CloudApiResponse
     *
     * @throws CloudApiException
     */
    public function get(string $path): CloudApiResponse
    {
        $this->validateCredentials();

        $response = wp_remote_get($this->apiUrl($path), [
            'timeout' => apply_filters('wcus_complete_shop_api_timeout', 15),
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $this->apiKey
            ]
        ]);

        if (is_wp_error($response)) {
            $this->processWpError($response);
        }

        $code = wp_remote_retrieve_response_code($response);
        $body = json_decode(wp_remote_retrieve_body($response), true);

        return new CloudApiResponse($code, $body);
    }

    /**
     * @param string $path
     *
     * @return CloudApiResponse
     *
     * @throws CloudApiException
     */
    public function post(string $path, array $data = []): CloudApiResponse
    {
        $this->validateCredentials();

        $response = wp_remote_post($this->apiUrl($path), [
            'timeout' => apply_filters('wcus_complete_shop_api_timeout', 15),
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->apiKey
            ],
            'body' => $data ? json_encode($data, JSON_UNESCAPED_UNICODE) : ''
        ]);

        if (is_wp_error($response)) {
            $this->processWpError($response);
        }

        $code = wp_remote_retrieve_response_code($response);
        $body = json_decode(wp_remote_retrieve_body($response), true);

        return new CloudApiResponse($code, $body);
    }

    /**
     * @throws CloudApiException
     */
    private function validateCredentials(): void
    {
        if ( ! $this->apiKey) {
            throw new CloudApiException('Api key missing.');
        }
    }

    /**
     * @param \WP_Error $error
     *
     * @throws CloudApiException
     */
    private function processWpError(\WP_Error $error): void
    {
        throw new CloudApiException($error->get_error_message() . ' [' . $error->get_error_code() . ']');
    }

    private function apiUrl(string $path): string
    {
        return self::API_URL . '/' . trim($path, '/');
    }
}