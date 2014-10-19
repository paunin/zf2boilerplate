<?php
/**
 * Configuration file generated by ZF Apigility Admin
 *
 * The previous config file has been stored in application.config.old
 */
return array(
    'modules' => array(
        'Application',
        'ZF\\Apigility',
        'ZF\\Apigility\\Provider',
        'AssetManager',
        'ZF\\ApiProblem',
        'ZF\\MvcAuth',
        'ZF\\OAuth2',
        'ZF\\Hal',
        'ZF\\ContentNegotiation',
        'ZF\\ContentValidation',
        'ZF\\Rest',
        'ZF\\Rpc',
        'ZF\\Versioning',
        'ZF\\DevelopmentMode',
        'ZF\Apigility\Documentation',
        'ZF\\Apigility\\Documentation\\Swagger',
        'DoctrineModule',
        'DoctrineORMModule',
        'Server'
    ),
    'module_listener_options' => array(
        'module_paths' => array(
            './module',
            './vendor'
        ),
        'config_glob_paths' => array(
            'config/autoload/{,*.}{global,local}.php'
        )
    )
);
