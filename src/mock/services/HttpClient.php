<?php

namespace app\mock\services;

use app\mock\models\DTO\DeliveryRequestDTO;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

class HttpClient
{
    private static ?HttpClient $instance = null;
    private DeliveryRequestDTO $deliveryRequestDTO;

    public function __construct()
    {
        $this->deliveryRequestDTO = DeliveryRequestDTO::getInstance();
    }

    /**
     * @return HttpClient
     */
    public static function getInstance(): HttpClient
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


    public function request(string $method, string $uri): ResponseInterface
    {
        $mock = new MockHandler([
            function ($request) {
                $this->deliveryRequestDTO->fillFromUriQuery($request->getUri()->getQuery());
                if ($this->deliveryRequestDTO->getDelivery() === 'fast') {

                    $price = 0;
                    $period = 0;
                    $error = '';


                    $currentTime = strtotime(date("H:i"));
                    $tooLateTime = strtotime("18:00");

                    if ($currentTime > $tooLateTime) {
                        $error = 'Заявки не принимаются. Текущее время больше 18:00.';
                    }
                    else {
                        $price = FastDeliveryService::getPrice($this->deliveryRequestDTO);
                        $period = FastDeliveryService::getPeriod($this->deliveryRequestDTO);
                    }

                    return new Response(200, ['Content-Type' => 'application/json'], json_encode([
                        'price' => $price,
                        'period' => $period,
                        'error' => $error,
                    ]));
                }
                else {
                    $coefficient = SlowDeliveryService::getCoefficient($this->deliveryRequestDTO);
                    $date = SlowDeliveryService::getDate($this->deliveryRequestDTO)->format('Y-m-d');

                    return new Response(200, ['Content-Type' => 'application/json'], json_encode([
                        'coefficient' => $coefficient,
                        'date' => $date,
                        'error' => '',
                    ]));
                }
            },
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);
        return $client->request($method, $uri);
    }
}