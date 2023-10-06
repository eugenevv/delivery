<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Yii 2 Basic Project Template</h1>
    <br>
</p>

[![Latest Stable Version](https://img.shields.io/packagist/v/yiisoft/yii2-app-basic.svg)](https://packagist.org/packages/yiisoft/yii2-app-basic)
[![Total Downloads](https://img.shields.io/packagist/dt/yiisoft/yii2-app-basic.svg)](https://packagist.org/packages/yiisoft/yii2-app-basic)
[![build](https://github.com/yiisoft/yii2-app-basic/workflows/build/badge.svg)](https://github.com/yiisoft/yii2-app-basic/actions?query=workflow%3Abuild)

СОДЕРЖАТЕЛЬНАЯ ЧАСТЬ
--------------------

      models/
         Delivery.php            Упрощенная модель (без БД) служб доставок на стороне клиента 
         Kladr.php               Упрощенная модель (без БД) КЛАДРА на стороне клиента
         Orders.php              Упрощенная модель (без БД) товаров на стороне клиента
      mock/                      Эмуляция взаимодействия с сервисами транспортных компаний. Можно добавить фабрику или стратегию
      services/           
         DeliveryService.php     Родительский класс сервисов доставки на стороне клиента
         FastDeliveryService.php Класс сервиса быстрой доставки на стороне клиента
         SlowDeliveryService.php Класс сервиса медленной доставки на стороне клиента

ТРЕБОВАНИЯ
----------
- Минимальная гарантированная версия Git 2.34.1 
- Минимальная гарантированная версия Docker 24.0.5
- Минимальная гарантированная версия docker-compose 1.29.2
- Минимальная гарантированная версия PHP 7.4

УСТАНОВКА
--------------------------

Клонируем проект

    git clone git@github.com:eugenevv/delivery.git

Переходим в папку проекта

    cd delivery

Стартуем контейнер

    docker-compose up -d

Устанавливаем зависимости композера и запускаем триггеры

    docker exec -it delivery_app composer install

Прописываем домен в `/etc/hosts` 

      127.0.0.1	delivery.local
        
Заходим на страницу проекта:

    http://delivery.local/delivery
