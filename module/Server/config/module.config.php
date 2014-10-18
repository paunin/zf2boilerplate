<?php
return array(
    'router' => array(
        'routes' => array(
            'server.rpc.info' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/info',
                    'defaults' => array(
                        'controller' => 'Server\\V1\\Rpc\\Info\\Controller',
                        'action' => 'info',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'server.rpc.info',
        ),
    ),
    'service_manager' => array(
        'factories' => array(),
    ),
    'zf-rest' => array(),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'Server\\V1\\Rpc\\Info\\Controller' => 'Json',
        ),
        'accept_whitelist' => array(
            'Server\\V1\\Rpc\\Info\\Controller' => array(
                0 => 'application/vnd.server.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ),
        ),
        'content_type_whitelist' => array(
            'Server\\V1\\Rpc\\Info\\Controller' => array(
                0 => 'application/vnd.server.v1+json',
                1 => 'application/json',
            ),
        ),
    ),
    'zf-hal' => array(
        'metadata_map' => array(),
    ),
    'controllers' => array(
        'factories' => array(
            'Server\\V1\\Rpc\\Info\\Controller' => 'Server\\V1\\Rpc\\Info\\InfoControllerFactory',
        ),
    ),
    'zf-rpc' => array(
        'Server\\V1\\Rpc\\Info\\Controller' => array(
            'service_name' => 'Info',
            'http_methods' => array(
                0 => 'GET',
            ),
            'route_name' => 'server.rpc.info',
        ),
    ),
);
