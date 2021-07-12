<?php

return [
    /*
    |--------------------------------------------------------------------------
    | make:bundle command
    |--------------------------------------------------------------------------
    |
    | What should be generated without option?
    |
    */
    'make-bundle' => [
        'nova-ressource' => false,
        'migration'      => true,
        'policy'         => true,
        'resource'       => true,
        'controller'     => false,
        'api-controller' => false,

        'namespaces' => [
            'controller'     => 'Web/',
            'api-controller' => 'Api/',
        ],
    ],
];