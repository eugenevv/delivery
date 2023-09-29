<?php

namespace app\models;

class Orders
{
    private static array $orders = [
        ['id' => 1, 'name' => 'Товар #1', 'weight' => 0.1],
        ['id' => 2, 'name' => 'Товар #2', 'weight' => 0.2],
        ['id' => 3, 'name' => 'Товар #3', 'weight' => 0.3],
        ['id' => 4, 'name' => 'Товар #4', 'weight' => 0.4],
    ];

    /**
     * @return array|array[]
     */
    public static function getOrders(): array
    {
        return self::$orders;
    }


}