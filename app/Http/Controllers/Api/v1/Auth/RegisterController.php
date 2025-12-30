<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Controller;

use App\Http\Requests\Api\UserRegisterRequest;
use App\Models\Role;
use App\Models\User;
use App\Traits\ApiResponse;
use Exception;
// use Illuminate\Auth\Events\Registered;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB, Hash};

class RegisterController extends Controller
{
    use ApiResponse;

    /**
     * @OA\Post(
     *     path="/api/v1/register",
     *     summary="User registration",
     *     description="Register a new user with full name, email, phone number, and password",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"full_name", "email", "phone_country_code", "phone_number", "password"},
     *             @OA\Property(
     *                 property="full_name",
     *                 type="string",
     *                 description="User's full name",
     *                 example="John Doe",
     *                 minLength=2,
     *                 maxLength=255
     *             ),
     *             @OA\Property(
     *                 property="email",
     *                 type="string",
     *                 format="email",
     *                 description="User's email address (must be unique)",
     *                 example="user@example.com"
     *             ),
     *             @OA\Property(
     *                 property="phone_country_code",
     *                 type="string",
     *                 description="Phone country code with + sign",
     *                 example="+1",
     *                 pattern="^\+[1-9]\d{0,3}$"
     *             ),
     *             @OA\Property(
     *                 property="phone_number",
     *                 type="string",
     *                 description="Phone number without country code, 6-15 digits",
     *                 example="1234567890",
     *                 minLength=6,
     *                 maxLength=15
     *             ),
     *             @OA\Property(
     *                 property="password",
     *                 type="string",
     *                 format="password",
     *                 description="User password (must meet password requirements)",
     *                 example="Password123!",
     *                 minLength=8
     *             ),
     *             @OA\Property(
     *                 property="password_confirmation",
     *                 type="string",
     *                 format="password",
     *                 description="Password confirmation (must match password)",
     *                 example="Password123!"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Registration successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="User created successfully"),
     *             @OA\Property(property="data", type="object", nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Validation failed"),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="email", type="array", @OA\Items(type="string", example="The email has already been taken.")),
     *                 @OA\Property(property="phone_number", type="array", @OA\Items(type="string", example="The phone number must be between 6 and 15 digits.")),
     *                 @OA\Property(property="password", type="array", @OA\Items(type="string", example="The password must be at least 8 characters."))
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="An error occurred during registration")
     *         )
     *     )
     * )
     */
    public function register(UserRegisterRequest $request)
    {
        try {
            $data = $request->validated();

            $parts = explode(' ', trim($data['full_name']), 2);

            $firstName = $parts[0];
            $lastName  = $parts[1] ?? '';

            DB::beginTransaction();
            $user = User::create([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'encrypt_password' => jsencode_userdata($data['password'])
            ]);

            $user->user_detail()->create([
                'phone_number' => $data['phone_number'],
                'phone_country_code' => $data['phone_country_code']
            ]);

            //Check role exists 
            $roleName = config('constant.role.player');
            $roleExists = Role::where('name', $roleName)->exists();
            if(!$roleExists) {
                throw new Exception(__('message.role.player.not_exist'));
            }
            
            //Assing role player
            $user->assignRole(config('constant.role.player.name'));

            DB::commit();

            $data = [
                'user' => [
                    'id' => $user->id,
                    'email' => $user->email,
                    'full_name' => $user->full_name
                ],
                'token' => $user->createToken(config('constant.sanctum.token_name'))->plainTextToken
            ];

            //Sent email verification link
            // $user->sendEmailVerificationNotification();

            return $this->successResponse(message: __('message.register.success'), data: $data);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->apiCatchResponse($e->getMessage());
        }
    }
}
