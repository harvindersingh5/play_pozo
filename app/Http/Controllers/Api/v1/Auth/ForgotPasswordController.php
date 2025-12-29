<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Rules\PhoneOrEmail;
use App\Traits\{ApiResponse, UserTrait};
use Exception;
use Illuminate\Support\Facades\{Validator, Password};

class ForgotPasswordController extends Controller
{
    use ApiResponse, UserTrait;

    /**
     * @OA\Post(
     *     path="/api/v1/forgot-password",
     *     operationId="forgotPassword",
     *     tags={"Authentication"},
     *     summary="Send password reset link via email or phone",
     *     description="Sends a password reset link if the user exists and is eligible.<br/>
     *     If phone_country_code is provided, phone_email must be an phone number. <br/>
     *     If phone_country_code is not provided, phone_email must be a email.",
     *
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"phone_email"},
     *             @OA\Property(
     *                 property="phone_email",
     *                 type="string",
     *                 example="user@example.com",
     *                 description="User email OR phone number"
     *             ),
     *             @OA\Property(
     *                 property="phone_country_code",
     *                 type="string",
     *                 example="+91",
     *                 nullable=true,
     *                 description="Required when phone number is used"
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Reset link sent successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="We have emailed your password reset link.")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Validation failed"),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 example={
     *                     "phone_email": {
     *                         "The phone email field is required."
     *                     }
     *                 }
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="User not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="User not found")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Something went wrong")
     *         )
     *     )
     * )
     */
    public function forgotPassword(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'phone_email' =>  [
                    'required',
                    'string',
                    new PhoneOrEmail()
                ],
                'phone_country_code' => [
                    'nullable',
                    'string',
                    'regex:' . config('validation.phone_number_country_code.regex'),
                ],
            ]);

            //Throw validation failed messages
            if ($validator->fails()) {
                return $this->validationErrorResponse(errors: $validator->errors());
            }

            $data = $validator->validated();
            // $user = User::where('email', $data['email'])->verified()->active()->first(); // get authenticated user
            $user = $this->getUserByEmailOrPhone(phone_country_code: $data['phone_country_code'] ?? null, phone_email: $data['phone_email']); // get user by email

            if (!$user) {
                throw new Exception(__('message.not_found', ['attribute' => 'User']));
            }

            // We will send the password reset link to this user. Once we have attempted
            // to send the link, we will examine the response then see the message we
            // need to show to the user. Finally, we'll send out a proper response.
            $status = Password::sendResetLink(
                [
                    'email' => $user->email
                ]
            );

            if ($status == Password::RESET_LINK_SENT) {
                // if ($request->expectsJson()) {
                return $this->successResponse(message: __($status));
                // }
            }
            return $this->errorResponse(__($status));
        } catch (Exception $e) {
            return $this->apiCatchResponse($e->getMessage());
        }
    }
}
