<?php

return [
    'class' => \yii\db\Connection::class,
    'dsn' => 'pgsql:host='.getenv('DB_HOST').';port='.getenv('DB_PORT').';dbname='.getenv('DB_NAME'),
    'username' => getenv('DB_USER'),
    'password' => getenv('DB_PASSWORD'),
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
