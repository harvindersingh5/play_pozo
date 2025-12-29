<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Traits\{ApiResponse, UserTrait};
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    use ApiResponse, UserTrait;

    /**
     * @OA\Post(
     *     path="/api/v1/login",
     *     summary="User login",
     *     description="Authenticate user using email OR phone number. <br/>
     *     If phone_country_code is provided, phone_email must be an phone number. <br/>
     *     If phone_country_code is not provided, phone_email must be a email.",
     *     tags={"Authentication"},
     *
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"phone_email","password"},
     *
     *             @OA\Property(
     *                 property="phone_email",
     *                 type="string",
     *                 description="Email address OR phone number. Acts as email when phone_country_code is not present, otherwise acts as phone number.",
     *                 example="user@example.com",
     *                 nullable=false
     *             ),
     *
     *             @OA\Property(
     *                 property="phone_country_code",
     *                 type="string",
     *                 description="Phone country code with + sign. If present, phone_email must be an email.",
     *                 example="+1",
     *                 pattern="^\+[1-9]\d{0,3}$",
     *                 nullable=true
     *             ),
     *
     *             @OA\Property(
     *                 property="password",
     *                 type="string",
     *                 format="password",
     *                 description="User password",
     *                 example="Password123!",
     *                 minLength=8
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Login successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Login successful"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="token", type="string", example="1|abc123token"),
     *                 @OA\Property(
     *                     property="user",
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="email", type="string", example="user@example.com"),
     *                     @OA\Property(property="name", type="string", example="John Doe")
     *                 )
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=401,
     *         description="Invalid credentials",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Invalid credentials")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Validation error"),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(
     *                     property="phone_email",
     *                     type="array",
     *                     @OA\Items(type="string", example="The phone email must be a valid email address.")
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="array",
     *                     @OA\Items(type="string", example="The password field is required.")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function login(LoginRequest $request)
    {
        try {
            $data = $request->validated();

            // Determine login field: email or phone
            $user = $this->getUserByEmailOrPhone(phone_email: $data['phone_email'], phone_country_code: $data['phone_country_code'] ?? null);

            
            // Validate credentials
            if (!$user || !Hash::check($data['password'], $user->password)) {
                return $this->errorResponse(message: __('auth.failed'), code: 401);
            }

            // Create Sanctum token
            $token = $user->createToken(config('constant.sanctum.token_name'))->plainTextToken;

            // Prepare response
            $response = [
                'token' => $token,
                'user' => [
                    'id' => $user->id,
                    'email' => $user->email,
                    'full_name' => $user->full_name
                ]
            ];

            return $this->successResponse(data: $response, message: __('message.login.success'));
        } catch (Exception $e) {
            return $this->apiCatchResponse($e->getMessage());
        }
    }
}
