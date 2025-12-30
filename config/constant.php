<?php
return [
    'pagination_number' => 10,
    'sanctum' => [
        'token_name' => 'auth_user'
    ],

    'role' => [
        'super_admin' =>  ['name' => 'Administrator', 'guard_name' => 'web', 'description' => 'Full access to all system features.'],
        'manager' => ['name' => 'Manager', 'guard_name' => 'web', 'description' => 'Limited access to specific features.'],
        'player' => ['name' => 'Player', 'guard_name' => 'web', 'description' => 'Limited access to specific features.']
    ],

    'date_format' => [
        'js' => 'MM/DD/YYYY',
        'php' => 'm/d/Y'
    ]
];
