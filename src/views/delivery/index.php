<?php

use yii\helpers\Json;
use yii\web\View;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $orderProvider */
/** @var yii\data\ActiveDataProvider $sourceProvider */
/** @var yii\data\ActiveDataProvider $targetProvider */
/** @var yii\data\ActiveDataProvider $deliveryProvider */

$this->title = 'Intelogis';

$this->registerJs(<<<JS
(function (window) {
    class Delivery 
    {
        constructor() 
        {
            this.orders = {};
            this.ordersWeight = 0;
            this.sourceKladr = '';
            this.targetKladr = '';
            this.delivery = '';
            let that = this;
            
            $('.form-check-input').on('click', function(e) {
                if($(e.target).is(':checked')) {
                    that.orders[e.target.attributes.id.value] = parseFloat(e.target.value);    
                }
                else {
                    delete that.orders[e.target.attributes.id.value];
                }
                
                that.ordersWeight = Object.values(that.orders).reduce((accumulator, value) => {
                    return accumulator + value;
                }, 0);
                
                that.request();
            });
            
            $('.form-select-source').on('click', function(e) {
                that.sourceKladr = e.target.value; 
                that.request();
            });
            
            $('.form-select-target').on('click', function(e) {
                that.targetKladr = e.target.value;
                that.request();
            });
            
            $('.form-select-delivery').on('click', function(e) {
                that.delivery = e.target.value;
                that.request();
            });
        }
        
        request()
        {
            let that = this;
            $.Deferred(function (defer) {
                
                if (! that.ordersWeight) return;
                if (! that.sourceKladr) return;
                if (! that.targetKladr) return;
                if (! that.delivery) return;
                
                let query = new URLSearchParams({
                    ordersWeight: that.ordersWeight,
                    sourceKladr: that.sourceKladr,
                    targetKladr: that.targetKladr,
                    delivery: that.delivery
                }).toString();
    
                $.get( "/delivery/get-cost?" + query ).then( defer.resolve, defer.reject ); 
            }).promise().done(that.fillDeliveryFields);
        }
        
        fillDeliveryFields(dataStr)
        {
            if ('' === dataStr)  return;
                
            let dataObj = JSON.parse(dataStr);
            
            $('#delivery-price').text(dataObj['price']);
            $('#delivery-date').text(dataObj['date']);
        }
    }
    
    new Delivery();

})(window);
JS
);
?>
<div class="site-index">

    <div class="body-content">

        <table class="table">
            <thead>
            <tr>
                <th scope="col">Выберите</th>
                <th scope="col">Наименование</th>
                <th scope="col">Вес, кг</th>
            </tr>
            </thead>
            <tbody>
        <?=
        ListView::widget([
            'dataProvider' => $orderProvider,
            'itemView' => '_order',
            'layout' => "{items}\n{pager}"
        ]);
        ?>
            </tbody>
        </table>

        <div class="container text-left">
            <div class="row">
                <div class="col-2">
                    Откуда:
                </div>
                <div class="col col-lg-4">
                    <select class="form-select-source" aria-label="Default select example">
                        <option selected value="">-- Выберите город отправления --</option>
                        <?=
                        ListView::widget([
                            'dataProvider' => $sourceProvider,
                            'itemView' => '_source',
                            'layout' => "{items}\n{pager}"
                        ]);
                        ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="container text-left">
            <div class="row">
                <div class="col-2">
                    Куда:
                </div>
                <div class="col col-lg-4">
                    <select class="form-select-target" aria-label="Default select example">
                        <option selected value="">-- Выберите город прибытия --</option>
                        <?=
                        ListView::widget([
                            'dataProvider' => $targetProvider,
                            'itemView' => '_target',
                            'layout' => "{items}\n{pager}"
                        ]);
                        ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="container text-left">
            <div class="row">
                <div class="col-2">
                    Сервис доставки:
                </div>
                <div class="col col-lg-4">
                    <select class="form-select-delivery" aria-label="Default select example">
                        <option selected value="">-- Выберите доставку --</option>
                        <?=
                        ListView::widget([
                            'dataProvider' => $deliveryProvider,
                            'itemView' => '_delivery',
                            'layout' => "{items}\n{pager}"
                        ]);
                        ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="container text-left">
            <div class="row">
                <div class="col-2">
                    Сумма доставки:
                </div>
                <div class="col col-lg-4">
                    <b><span id="delivery-price"></span></b>
                </div>
            </div>
        </div>

        <div class="container text-left">
            <div class="row">
                <div class="col-2">
                    Дата доставки:
                </div>
                <div class="col col-lg-4">
                    <b><span id="delivery-date"></span></b>
                </div>
            </div>
        </div>
    </div>
</div>
