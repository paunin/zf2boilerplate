<?php
return array(
    'zf-oauth2' => array(
        'allow_implicit' => true,
    ),
    'db' => array(
        'adapters' => array(
            'Zend\\Db\\Adapter\\Adapter' => array(
                'driver' => 'Pdo',
                'dsn' => 'mysql:dbname=zf2template;host=127.0.0.1',
                'driver_options' => array(
                    1002 => 'SET NAMES \'UTF8\'',
                ),
                'host' => '127.0.0.1',
                'database' => 'zf2template',
            ),
        ),
    ),
    'router' => array(
        'routes' => array(
            'oauth' => array(
                'options' => array(
                    'route' => '/oauth',
                ),
            ),
        ),
    ),
);
