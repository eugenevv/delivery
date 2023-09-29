<?php

namespace app\mock\models\DTO;

class DeliveryRequestDTO
{
    const ORDERS_WEIGHT_QUERY_KEY = "ordersWeight";
    const SOURCE_KLADR_QUERY_KEY = "source";
    const TARGET_KLADR_QUERY_KEY = "target";
    const DELIVERY_QUERY_KEY = "delivery";

    private static ?DeliveryRequestDTO $instance = null;

    private float $ordersWeight = 0.0;
    private string $sourceKladr = '';
    private string $targetKladr = '';
    private string $delivery = '';

    public function __construct()
    {
    }

    /**
     * @return DeliveryRequestDTO
     */
    public static function getInstance(): DeliveryRequestDTO
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Предотвращаем дубли синглтона от десериализации
     *
     * @return void
     */
    final private function __wakeup(): void
    {
    }

    /**
     * Предотвращаем дубли синглтона от клонирования
     *
     * @return void
     */
    final private function __clone()
    {
    }

    /**
     * @return string
     */
    public function getOrdersWeight(): string
    {
        return $this->ordersWeight;
    }

    /**
     * @return string
     */
    public function getSourceKladr(): string
    {
        return $this->sourceKladr;
    }

    /**
     * @return string
     */
    public function getTargetKladr(): string
    {
        return $this->targetKladr;
    }

    /**
     * @return string
     */
    public function getDelivery(): string
    {
        return $this->delivery;
    }

    /**
     * @param string $query
     * @return void
     */
    public function fillFromUriQuery(string $query): void
    {
        parse_str($query, $output);
        $this->ordersWeight = (float)$output[self::ORDERS_WEIGHT_QUERY_KEY];
        $this->sourceKladr = $output[self::SOURCE_KLADR_QUERY_KEY];
        $this->targetKladr = $output[self::TARGET_KLADR_QUERY_KEY];
        $this->delivery = $output[self::DELIVERY_QUERY_KEY];
    }
}