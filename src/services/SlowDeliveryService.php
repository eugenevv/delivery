<?php

namespace app\services;

class SlowDeliveryService extends DeliveryService
{
    const BASE_PRICE_RUR = 150;

    public function __construct()
    {
        parent::__construct();
    }

    public function getPrice()
    {
        $coefficient = $this->getValueFromBody('coefficient');
        $price = self::BASE_PRICE_RUR * $coefficient;

        return $price;
    }

    public function getDate()
    {
        return $this->getValueFromBody('date');
    }

    public function getError()
    {
        return $this->getValueFromBody('error');
    }
}