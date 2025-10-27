<?php

namespace App\Services\Api\V1;

use App\Enums\CartStatus;
use App\Mail\OtpForgetPasswordMail;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Otp;
use App\Models\User;
use App\Services\Service;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Mail;

class AuthService extends Service
{

    public function signup(array $data)
    {
        try {
            $existingUser = User::where('email', $data['email'])->first();

            if ($existingUser) {
                $this->response['code'] = 4022;
                $this->response['message'] = "Email already exists. Please choose a different Email.";
                return $this->response;
            }

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            $otpCode = rand(100000, 999999);

            Otp::create([
                'user_id' => $user->id,
                'one_time_password' => $otpCode,
                'expires_at' => now()->addDay(),
            ]);

            Mail::raw("Your OTP code is: {$otpCode}", function ($message) use ($user) {
                $message->to($user->email)
                    ->subject('Verify your email - OTP Code');
            });

            $this->response['code'] = 2000;
            $this->response['message'] = "OTP sent to your email for verification.";
            $this->response['data'] = [
                'email' => $user->email,
            ];

            return $this->response;
        } catch (Exception $e) {
            $this->response['code'] = 5000;
            $this->response['message'] = "An error occurred: " . $e->getMessage();
            return $this->response;
        }
    }

    public function login(array $data)
    {
        $verify_email = $this->verify_email($data['login']);

        if (!$verify_email) {
            return [
                'code' => 4010,
                'message' => "Login should be an email address.",
            ];
        }

        $user = User::where('email', $data['login'])->first();

        if (!$user) {
            return [
                'code' => 4010,
                'message' => "User not found.",
            ];
        }

        if (empty($user->email_verified_at) || empty($user->remember_token)) {
            return [
                'code' => 4010,
                'message' => "Your account is not verified. Please verify your email and token first.",
            ];
        }

        if (!Auth::attempt(['email' => $data['login'], 'password' => $data['password']])) {
            return [
                'code' => 4010,
                'message' => "Invalid credentials.",
            ];
        }

        $authenticated_user = Auth::user();
        $user_token = $authenticated_user->createToken('Access Token')->plainTextToken;

        return [
            'code' => 2000,
            'message' => "Login successful.",
            'data' => [
                'user' => $authenticated_user,
                'token' => $user_token,
            ],
        ];
    }

    private function verify_email(string $email): bool
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }

    public function logout_user(object $request): array
    {
        try {
            $user = Auth::user();

            if (!$user) {
                $this->response['code'] = 4040;
                $this->response['message'] = 'User not found';
                return $this->response;
            }

            $token = $request->bearerToken();

            return $this->logoutUserInContext($token);
        } catch (\Exception $e) {
            $this->response['code'] = 5000;
            $this->response['message'] = 'Logout error: ' . $e->getMessage();
            return $this->response;
        }
    }
    protected function logoutUserInContext(string $token): array
    {
        $accessToken = PersonalAccessToken::findToken($token);

        if (!$accessToken) {
            $this->response['code'] = 4010;
            $this->response['message'] = 'Invalid token';
            return $this->response;
        }

        $accessToken->delete();

        $this->response['code'] = 2000;
        $this->response['message'] = 'Logout successful';
        $this->response['data'] = [
            'user_id' => $accessToken->tokenable_id,
            'token_name' => $accessToken->name
        ];

        return $this->response;
    }

    // public function resetPasswordLink($data)
    // {
    //     $user = User::where('email', $data['email'])->first();

    //     if (!$user) {
    //         $this->response['code'] = 4010;
    //         $this->response['message'] = 'User Not Found';
    //         return $this->response;
    //     }

    //     $otp = rand(100000, 999999);
    //     Otp::create([
    //         'user_id' => $user->id,
    //         'one_time_password' => $otp,
    //         'expires_at' => Carbon::now()->addDays(3),
    //     ]);

    //     Mail::to($user->email)->send(new OtpForgetPasswordMail($otp));
    //     $this->response['code'] = 2000;
    //     $this->response['message'] = 'Otp sent';
    //     $this->response['data'] = [];

    //     return $this->response;
    // }


    public function verifyOtp(array $data)
    {
        $otp = Otp::where('one_time_password', $data['otp'])
            ->first();

        if (!$otp) {
            return [
                'code' => 4010,
                'message' => 'OTP is invalid or expired.',
            ];
        }

        $user = User::where('id', $otp->user_id)->first();

        if (!$user) {
            return [
                'code' => 4010,
                'message' => 'User not found.',
            ];
        }

        $user->remember_token = rand(100000, 999999);
        $user->email_verified_at = now();
        $user->save();

        $otp->delete();

        // Mail::raw("Your login token is: {$user->remember_at}", function ($message) use ($user) {
        //     $message->to($user->email)
        //         ->subject('Login Token (use this for first login)');
        // });

        return [
            'code' => 2000,
            'message' => 'OTP verified successfully.',
            'data' => [
                'token' => $user->remember_at,
            ],
        ];
    }
}
