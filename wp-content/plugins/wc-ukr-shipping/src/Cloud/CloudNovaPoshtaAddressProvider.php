<?php

namespace kirillbdev\WCUkrShipping\Cloud;

use kirillbdev\WCUkrShipping\Cloud\Exceptions\CloudApiException;
use kirillbdev\WCUkrShipping\Cloud\Http\CloudApi;
use kirillbdev\WCUkrShipping\Contracts\NovaPoshtaAddressProviderInterface;
use kirillbdev\WCUkrShipping\Exceptions\NovaPoshtaAddressProviderException;
use kirillbdev\WCUkrShipping\Model\NovaPoshta\Area;
use kirillbdev\WCUkrShipping\Model\NovaPoshta\City;
use kirillbdev\WCUkrShipping\Model\NovaPoshta\Warehouse;

if ( ! defined('ABSPATH')) {
    exit;
}

class CloudNovaPoshtaAddressProvider implements NovaPoshtaAddressProviderInterface
{
    /**
     * @return Area[]
     * @throws NovaPoshtaAddressProviderException
     */
    public function getAreas(): array
    {
        try {
            $response = $this->api()->get('novaposhta/areas/load');

            if ($response->isOk()) {
                return array_map(function (array $data) {
                    return new Area($data['ref'], $data['name_ru'], $data['name_ua']);
                }, $response->all());
            }

            throw new NovaPoshtaAddressProviderException($response->getStatusCode() . ' ' . $response->get('message'));
        }
        catch (CloudApiException $e) {
            throw new NovaPoshtaAddressProviderException($e->getMessage());
        }
    }

    /**
     * @return City[]
     * @throws NovaPoshtaAddressProviderException
     */
    public function getCities(int $page, int $limit): array
    {
        try {
            $response = $this->api()->get("novaposhta/cities/load?page=$page&limit=$limit");

            if ($response->isOk()) {
                return array_map(function (array $data) {
                    return new City($data['ref'], $data['area_ref'], $data['name_ru'], $data['name_ua']);
                }, $response->all());
            }

            throw new NovaPoshtaAddressProviderException($response->getStatusCode() . ' ' . $response->get('message'));
        }
        catch (CloudApiException $e) {
            throw new NovaPoshtaAddressProviderException($e->getMessage());
        }
    }

    /**
     * @return Warehouse[]
     * @throws NovaPoshtaAddressProviderException
     */
    public function getWarehouses(int $page, int $limit): array
    {
        try {
            $response = $this->api()->get("novaposhta/warehouses/load?page=$page&limit=$limit");

            if ($response->isOk()) {
                return array_map(function (array $data) {
                    return new Warehouse(
                        $data['ref'],
                        $data['city_ref'],
                        $data['name_ru'],
                        $data['name_ua'],
                        (int)$data['number'],
                        $this->convertWarehouseType($data['type'])
                    );
                }, $response->all());
            }

            throw new NovaPoshtaAddressProviderException($response->getStatusCode() . ' ' . $response->get('message'));
        }
        catch (CloudApiException $e) {
            throw new NovaPoshtaAddressProviderException($e->getMessage());
        }
    }

    private function api(): CloudApi
    {
        return new CloudApi(get_option(WCUS_OPTION_CLOUD_API_KEY));
    }

    private function convertWarehouseType(string $externalType): int
    {
        switch ($externalType) {
            case 'poshtomat':
                return Warehouse::TYPE_POSHTOMAT;
            case 'cargo':
                return Warehouse::TYPE_CARGO;
            default:
                return Warehouse::TYPE_REGULAR;
        }
    }
}