<?php
return [
    'register' => [
        'success' => 'User created successfully'
    ],
    'login' => [
        'success' => 'User login successfully'
    ],
    'route' => [
        'not_found' => 'API endpoint not found or invalid HTTP method.'
    ],
    'exception' => [
        'authentication' => [
            'message' => 'Unauthenticated',
            'error'   => 'Please login to access this resource',
            'code'    => 401,
        ],

        'validation' => [
            'message' => 'Validation failed',
            'error'   => 'Invalid input data',
            'code'    => 422,
        ],

        'authorization' => [
            'message' => 'Forbidden',
            'error'   => 'You do not have permission to access this resource',
            'code'    => 403,
        ],

        'model_not_found' => [
            'message' => 'Resource not found',
            'error'   => 'The requested resource does not exist',
            'code'    => 404,
        ],

        'route_not_found' => [
            'message' => 'Route not found',
            'error'   => 'The requested endpoint does not exist',
            'code'    => 404,
        ],

        'method_not_allowed' => [
            'message' => 'Method not allowed',
            'error'   => 'This HTTP method is not supported',
            'code'    => 405,
        ],

        'http_exception' => [
            'message' => 'HTTP Exception',
            'error'   => 'An HTTP error occurred',
            'code'    => 500,
        ],
        'default' => [
            'message' => 'Internal server error',
            'error'   => 'Unexpected error',
        ]
    ],
    'not_found' => ':attribute not found'
];