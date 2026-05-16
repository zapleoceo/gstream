<?php

declare(strict_types=1);

namespace kirillbdev\WCUkrShipping\NovaPoshta\Address;

use kirillbdev\WCUkrShipping\Cloud\Services\CloudService;
use kirillbdev\WCUkrShipping\NovaPoshta\Address\Domain\City;
use kirillbdev\WCUkrShipping\NovaPoshta\Address\Domain\SearchWarehousesResult;
use kirillbdev\WCUkrShipping\NovaPoshta\Address\Domain\Warehouse;

if ( ! defined('ABSPATH')) {
    exit;
}

class CloudAddressProvider implements AddressProviderInterface
{
    private CloudService $cloudService;

    public function __construct(CloudService $cloudService)
    {
        $this->cloudService = $cloudService;
    }

    /**
     * @return City[]
     */
    public function getDefaultCities(string $lang): array
    {
        $response = $this->cloudService->api()->post('addresses/search', [
            'courier' => 'nova_poshta',
            'filters' => [
                'addressType' => 'city',
                'page' => 1,
                'locale' => $lang === 'uk' ? 'ua' : $lang
            ]
        ]);

        if ($response->isOk()) {
            return array_map(function (array $address) {
                return new City($address['ref'], $address['name']);
            }, $response->get('addresses'));
        }

        return [];
    }

    /**
     * @return City[]
     */
    public function searchCities(string $query, string $lang): array
    {
        $response = $this->cloudService->api()->post('addresses/search', [
            'courier' => 'nova_poshta',
            'filters' => [
                'addressType' => 'city',
                'page' => 1,
                'locale' => $lang === 'uk' ? 'ua' : $lang,
                'query' => $query
            ]
        ]);

        if ($response->isOk()) {
            return array_map(function (array $address) {
                return new City($address['ref'], $address['name']);
            }, $response->get('addresses'));
        }

        return [];
    }

    public function searchWarehouses(
        string $cityRef,
        string $query,
        string $lang,
        int $page
    ): ?SearchWarehousesResult {
        $response = $this->cloudService->api()->post('addresses/search', [
            'courier' => 'nova_poshta',
            'filters' => [
                'addressType' => 'warehouse',
                'cityRef' => $cityRef,
                'page' => $page,
                'locale' => $lang === 'uk' ? 'ua' : $lang,
                'query' => $query
            ]
        ]);

        if (!$response->isOk()) {
            return null;
        }

        $total = (int)$response->get('total');
        $warehouses = array_map(function (array $address) {
            return new Warehouse($address['ref'], $address['name'], (int)$address['number']);
        }, $response->get('addresses'));

        return new SearchWarehousesResult($warehouses, $total);
    }
}