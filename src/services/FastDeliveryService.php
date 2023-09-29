<?php

namespace app\services;

use DateInterval;
use DateTime;

class FastDeliveryService extends DeliveryService
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getPrice()
    {
        return $this->getValueFromBody('price');
    }

    public function getDate()
    {
        $period = $this->getValueFromBody('period');
        $currentDate = new DateTime();
        $currentDate->add(new DateInterval('P' . $period . 'D'));
        $date = $currentDate->format('Y-m-d');

        return $date;
    }

    public function getError()
    {
        return $this->getValueFromBody('error');
    }
}