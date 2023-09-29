<?php

namespace app\services;

use app\mock\services\HttpClient;
use app\models\DTO\DeliveryRequestDTO;
use GuzzleHttp\Psr7\Response;

abstract class DeliveryService
{
    const DELIVERY_FAST = 'fast';
    const DELIVERY_SLOW = 'slow';

    private static DeliveryRequestDTO $deliveryRequestDTO;
    private HttpClient $client;

    public function __construct()
    {
        $this->client = HttpClient::getInstance();
    }

    public static function createService(DeliveryRequestDTO $deliveryRequestDTO)
    {
        self::$deliveryRequestDTO = $deliveryRequestDTO;
        if (self::$deliveryRequestDTO->getDelivery() === self::DELIVERY_FAST) {
            return new FastDeliveryService();
        } else if (self::$deliveryRequestDTO->getDelivery() === self::DELIVERY_SLOW) {
            return new SlowDeliveryService();
        }
    }

    public function request(): Response
    {
        $query = 'ordersWeight=' . self::$deliveryRequestDTO->getOrdersWeight()
            . '&source=' . self::$deliveryRequestDTO->getSourceKladr()
            . '&target=' . self::$deliveryRequestDTO->getTargetKladr()
            . '&delivery=' . self::$deliveryRequestDTO->getDelivery();

        return $this->client->request('GET', '/?' . $query);
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function getValueFromBody(string $name)
    {
        $response = $this->request();
        $contents = $response->getBody()->getContents();
        $values = json_decode($contents, true);
        return $values[$name];
    }

    public function getJson()
    {
        $values = [
            'price' => $this->getPrice(),
            'date' => $this->getDate(),
            'error' => $this->getError(),
        ];

        return json_encode($values);
    }

    abstract public function getPrice();

    abstract public function getDate();

    abstract public function getError();
}