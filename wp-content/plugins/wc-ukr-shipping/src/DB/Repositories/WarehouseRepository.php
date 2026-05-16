<?php

namespace kirillbdev\WCUkrShipping\DB\Repositories;

use kirillbdev\WCUkrShipping\DB\Dto\InsertWarehouseDto;
use kirillbdev\WCUkrShipping\Model\NovaPoshta\Warehouse;
use kirillbdev\WCUSCore\Facades\DB;

if ( ! defined('ABSPATH')) {
    exit;
}

class WarehouseRepository
{
    /**
     * @param string $ref
     * @return \stdClass|null
     */
    public function getWarehouseByRef($ref)
    {
        return DB::table(DB::prefixedTable('wc_ukr_shipping_np_warehouses'))
            ->where('ref', $ref)
            ->first();
    }

    public function searchByQuery($query, $cityRef, $page = 1, $limit = 30)
    {
        $q = DB::table(DB::prefixedTable('wc_ukr_shipping_np_warehouses'))
            ->where('city_ref', $cityRef);

        if ($query) {
            $q->whereRaw('(description like %s or description_ru like %s)', [
                "%$query%",
                "%$query%"
            ]);
        }

        $q->orderBy('`number`');

        if ($page > 1) {
            $q->skip(($page - 1) * $limit);
        }

        return $q->limit($limit)->get();
    }

    /**
     * @param string $query
     * @param string $cityRef
     * @return int
     */
    public function countByQuery($query, $cityRef)
    {
        $q = DB::table(DB::prefixedTable('wc_ukr_shipping_np_warehouses'))
            ->where('city_ref', $cityRef);

        if ($query) {
            $q->whereRaw('(description like %s or description_ru like %s)', [
                "%$query%",
                "%$query%"
            ]);
        }

        return $q->count('ref');
    }

    public function clearWarehouses()
    {
        DB::table(DB::prefixedTable('wc_ukr_shipping_np_warehouses'))->truncate();
    }

    /**
     * @param Warehouse[] $warehouses
     * @return void
     */
    public function bulkUpsertWarehouses(array $warehouses): void
    {
        if (count($warehouses) === 0) {
            return;
        }

        global $wpdb;
        $insertValues = [];

        foreach ($warehouses as $warehouse) {
            $values = esc_sql([
                $warehouse->getRef(),
                $warehouse->getNameUa(),
                $warehouse->getNameRu(),
                $warehouse->getCityRef(),
                $warehouse->getNumber(),
                $warehouse->getType(),
            ]);
            $values = array_map(function (string $value) {
                return "'$value'";
            }, $values);
            $insertValues[] = '(' . implode(',', $values) . ')';
        }

        $wpdb->query(
            "INSERT INTO `{$wpdb->prefix}wc_ukr_shipping_np_warehouses`
                    (`ref`, `description`, `description_ru`, `city_ref`, `number`, `warehouse_type`)
                VALUES " . implode(',', $insertValues) . " 
                ON DUPLICATE KEY UPDATE
                    `description` = VALUES(`description`),
                    `description_ru` = VALUES(`description_ru`),
                    `city_ref` = VALUES(`city_ref`),
                    `number` = VALUES(`number`),
                    `warehouse_type` = VALUES(`warehouse_type`)"
        );
    }
}
