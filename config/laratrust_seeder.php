<?php

return [
    'role_structure' => [
        'system' => [
            'users' => 'c,r,u,d',
            'roles' => 'c,r,u,d'
        ],
        'admin' => [
            'users' => 'c,r,u,d',
            'roles' => 'r'
        ],
    ],
    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete',
        'i' => 'inport',
        'e' => 'export',
    ]
];
