<?php

namespace app\mock\services;

use app\mock\models\DTO\DeliveryRequestDTO;

/**
 * Сервис медленной доставки
 */
class SlowDeliveryService
{
    /** @var int Базовая стоимость, рубли */
    private const BASE_PRICE = 150;

    /**
     * Коэффициент (coefficient) и количество дней (period)
     * в зависимости из какого города (Москва Город) в какой (Новосибирск Город).
     * Цифровые ключи - кладры городов.
     * Конечную цену клиент определит произведением базовой стоимости (self::BASE_PRICE) и коэффициента (coefficient).
     * Возвращаем клиенту дату доставки, добавляя к текущей дате количество дней (period)
     *
     * @var \array|\array[][]
     */
    private static array $deliveryPrice = [
        '7700000000000' => [        // Москва Город
            '5400000100000' => [    // Новосибирск Город
                'coefficient' => 1.1,
                'period' => 8,
            ],
            '7000000100000' => [    // Томск Город
                'coefficient' => 2.2,
                'period' => 7,
            ],
        ],
        '7800000000000' => [        // Санкт-Петербург Город
            '5400000100000' => [    // Новосибирск Город
                'coefficient' => 3.3,
                'period' => 6,
            ],
            '7000000100000' => [    // Томск Город
                'coefficient' => 4.4,
                'period' => 5,
            ],
        ],
    ];

    /**
     * Базовая стоимость, рубли
     *
     * @return int
     */
    public static function getBasePrice(): int
    {
        return self::BASE_PRICE;
    }

    /**
     * @param DeliveryRequestDTO $kladrDTO
     * @return float
     */
    public static function getCoefficient(DeliveryRequestDTO $kladrDTO): float
    {
        return self::$deliveryPrice[$kladrDTO->getSourceKladr()][$kladrDTO->getTargetKladr()]['coefficient'];
    }

    /**
     * @param DeliveryRequestDTO $kladrDTO
     * @return float
     */
    public static function getDate(DeliveryRequestDTO $kladrDTO): \DateTime
    {
        $period = self::$deliveryPrice[$kladrDTO->getSourceKladr()][$kladrDTO->getTargetKladr()]['period'];
        $currentDate = new \DateTime();
        return $currentDate->add(new \DateInterval('P'.$period.'D'));
    }


}