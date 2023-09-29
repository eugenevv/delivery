<?php

namespace app\controllers;

use app\models\Delivery;
use app\models\DTO\DeliveryRequestDTO;
use app\models\Kladr;
use app\models\Orders;
use app\services\DeliveryService;
use yii\data\ArrayDataProvider;
use yii\web\Controller;

class DeliveryController extends Controller
{
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $orderProvider = new ArrayDataProvider([
            'allModels' => Orders::getOrders(),
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'attributes' => ['id', 'name'],
            ],
        ]);

        $sourceProvider = new ArrayDataProvider([
            'allModels' => Kladr::getSourceCities(),
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'attributes' => ['name'],
            ],
        ]);

        $targetProvider = new ArrayDataProvider([
            'allModels' => Kladr::getTargetCities(),
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'attributes' => ['name'],
            ],
        ]);

        $deliveryProvider = new ArrayDataProvider([
            'allModels' => Delivery::getDeliveries(),
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'attributes' => ['title'],
            ],
        ]);

        return $this->render('index', [
            'orderProvider' => $orderProvider,
            'sourceProvider' => $sourceProvider,
            'targetProvider' => $targetProvider,
            'deliveryProvider' => $deliveryProvider,
        ]);
    }

    /**
     * @param string $ordersWeight
     * @param string $sourceKladr
     * @param string $targetKladr
     * @param string $delivery
     * @return false|string
     */
    public function actionGetCost(string $ordersWeight, string $sourceKladr, string $targetKladr, string $delivery)
    {
        $deliveryRequestDTO = DeliveryRequestDTO::getInstance();
        $deliveryRequestDTO->fillFromValues($ordersWeight, $sourceKladr, $targetKladr, $delivery);

        $deliveryService = DeliveryService::createService($deliveryRequestDTO);

        return $deliveryService->getJson();
    }
}