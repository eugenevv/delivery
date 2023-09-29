<?php

namespace app\models;

class Kladr
{
    private static $data = [
        'sourceKladr' => [
            ['number' => '7700000000000', 'name' => 'Москва'],
            ['number' => '7800000000000', 'name' => 'Санкт-Петербург'],
        ],
        'targetKladr' => [
            ['number' => '5400000100000', 'name' => 'Новосибирск'],
            ['number' => '7000000100000', 'name' => 'Томск'],
        ],
    ];

    /**
     * @return \string[][]
     */
    public static function getSourceCities()
    {
        return self::$data['sourceKladr'];
    }

    /**
     * @return \string[][]
     */
    public static function getTargetCities()
    {
        return self::$data['targetKladr'];
    }
}