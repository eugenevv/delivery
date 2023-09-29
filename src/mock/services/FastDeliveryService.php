<?php

namespace app\mock\services;

use app\mock\models\DTO\DeliveryRequestDTO;

class FastDeliveryService
{
    /**
     * Стоимость доставки (price) рублей за 1 кг и количество дней (period)
     * в зависимости из какого города (Москва Город) в какой (Новосибирск Город).
     * Цифровые ключи - кладры городов
     *
     * @var \array|\array[][]
     */
    protected static array $deliveryPrice = [
        '7700000000000' => [        // Москва Город
            '5400000100000' => [    // Новосибирск Город
                'price' => 1111.1,
                'period' => 4,
            ],
            '7000000100000' => [    // Томск Город
                'price' => 2222.2,
                'period' => 3,
            ],
        ],
        '7800000000000' => [        // Санкт-Петербург Город
            '5400000100000' => [    // Новосибирск Город
                'price' => 3333.3,
                'period' => 2,
            ],
            '7000000100000' => [    // Томск Город
                'price' => 4444.4,
                'period' => 1,
            ],
        ],
    ];

    /**
     * @param DeliveryRequestDTO $deliveryRequestDTO
     * @return float
     */
    public static function getPrice(DeliveryRequestDTO $deliveryRequestDTO): float
    {
        return self::$deliveryPrice[$deliveryRequestDTO->getSourceKladr()][$deliveryRequestDTO->getTargetKladr()]['price'] * $deliveryRequestDTO->getOrdersWeight();
    }

    /**
     * @param DeliveryRequestDTO $deliveryRequestDTO
     * @return int
     */
    public static function getPeriod(DeliveryRequestDTO $deliveryRequestDTO): int
    {
        return self::$deliveryPrice[$deliveryRequestDTO->getSourceKladr()][$deliveryRequestDTO->getTargetKladr()]['period'];
    }
}