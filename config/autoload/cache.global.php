<?php
return [
    'cache' => [
        'disabled' => false,

        'adapter' => [
            'name' => 'memcached',
            'options' => [
                'ttl'           => 600,
                'namespace'     => 'zf2template',
                'key_pattern'   => null,
                'readable'      => true,
                'writable'      => true,

                //
                //'servers' => [
                //    ["127.0.0.1", 11211]
                //]
            ],
        ],

        'plugins' => [
            [
                'name' => 'serializer',
                'options' => []
            ]
        ]
    ],
];