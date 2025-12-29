<?php
    return [
        'paths' => ['api/*'],  // only API routes
        'allowed_methods' => ['POST', 'PUT', 'DELETE'],
        'allowed_origins' => [  
                                'http://localhost:3000',
                                'http://192.168.0.133:8000',
                                'http://127.0.0.1:8000/'
                            ],
        'allowed_headers' => [
            // 'Content-Type',
            // 'Authorization',
            // 'Accept',
            '*'
        ],
        // 'supports_credentials' => true, // If server wants to accept cookies from the browser/front-end
    ];
