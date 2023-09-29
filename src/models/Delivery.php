<?php

namespace app\models;

class Delivery
{
    private static $data = [
        ['name' => 'fast', 'title' => 'Быстрая'],
        ['name' => 'slow', 'title' => 'Медленная'],
    ];

    /**
     * @return \string[][]
     */
    public static function getDeliveries()
    {
        return self::$data;
    }
}