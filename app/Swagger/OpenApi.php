<?php

namespace App\Swagger;

use OpenApi\Annotations as OA;

/**
 * @OA\OpenApi(
 *     @OA\Info(
 *         title="My API Documentation",
 *         version="1.0.0",
 *         description="Laravel API documentation"
 *     )
 * )
 * @OA\PathItem(path="/api")
 */
class OpenApi {}