<?php

namespace kirillbdev\WCUkrShipping\Http\Controllers;

use kirillbdev\WCUkrShipping\Cloud\Exceptions\CloudApiException;
use kirillbdev\WCUkrShipping\Cloud\Exceptions\CloudServiceException;
use kirillbdev\WCUkrShipping\Cloud\Services\CloudService;
use kirillbdev\WCUSCore\Http\Contracts\ResponseInterface;
use kirillbdev\WCUSCore\Http\Controller;
use kirillbdev\WCUSCore\Http\Request;

if ( ! defined('ABSPATH')) {
    exit;
}

class CloudController extends Controller
{
    private const ERROR_TYPE_NOT_CONNECTED = 'not_connected';
    private const ERROR_TYPE_CONNECTION_ERROR = 'connection_error';

    /**
     * @var CloudService
     */
    private $cloudService;

    public function __construct()
    {
        $this->cloudService = wcus_container()->make(CloudService::class);
    }

    /**
     * @param Request $request
     *
     * @return ResponseInterface
     */
    public function connect(Request $request)
    {
        try {
            $store = $this->cloudService->connect($request->get('api_key'));

            return $this->jsonResponse([
                'success' => true,
                'data' => [
                    'name' => $store['name'],
                    'url' => $store['url']
                ]
            ]);
        }
        catch (CloudApiException | CloudServiceException $e) {
            return $this->jsonResponse([
                'success' => false,
                'exception' => $e->getMessage()
            ]);
        }
    }

    public function disconnect(Request $request)
    {
        $this->cloudService->disconnect();

        return $this->jsonResponse([
            'success' => true
        ]);
    }

    public function getStoreInfo(Request $request)
    {
        try {
            return $this->jsonResponse([
                'success' => true,
                'data' => $this->cloudService->getStoreInfo()
            ]);
        }
        catch (CloudApiException $e) {
            return $this->jsonResponse([
                'success' => false,
                'exception' => $e->getMessage()
            ]);
        }
    }
}