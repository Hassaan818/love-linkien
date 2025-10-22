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
                'expires_at' => now()->addMinutes(5),
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

        $user = User::where('email', $data['login'])
            ->where('remember_token', $data['password'])
            ->where('email_verified_at', "Yes")
            ->first();

        if ($user) {
            Auth::login($user);

            $user->remember_token = null;
            $user->save();

            $authenticated_user = $user;
        } else {
            if (!Auth::attempt(['email' => $data['login'], 'password' => $data['password']])) {
                return [
                    'code' => 4010,
                    'message' => "Invalid credentials.",
                ];
            }

            $authenticated_user = Auth::user();
        }

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


    public function verifyOtp($data)
    {
        // dd($data['otp']);
        $otp = Otp::where('one_time_password', $data['otp'])
            ->where('expires_at', '>', now())
            ->first();

        $user = User::find($otp->user_id);

        if (!$user) {
            $this->response['code'] = 4010;
            $this->response['message'] = 'User Not Found';
            return $this->response;
        }

        $token = rand(100000, 999999);
        $user->remember_at = Carbon::now()->addDay();
        $user->email_verified_at = "Yes";
        $user->save();

        Mail::raw("Your One Time Password is: {$token}", function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Login with this code for the first time and then change your password');
        });

        if (!$otp) {
            $this->response['code'] = 4010;
            $this->response['message'] = 'Otp Not Valid';
            return $this->response;
        }

        $this->response['code'] = 2000;
        $this->response['message'] = 'Otp Verified Successfully';
        $this->response['data'] = [
            'remember_token' => $user->remember_token
        ];
        return $this->response;
    }

    public function verifyCodOtp($data)
    {
        $otp = Otp::where('one_time_password', $data['otp'])
            ->where('expires_at', '>', now())
            ->where('type', 'order')
            ->first();

        if (!$otp) {
            $this->response['code'] = 4010;
            $this->response['message'] = 'Otp Not Valid';
            return $this->response;
        }
        $order = Order::find($otp->order_id);
        if ($order && $order->cart) {
            $order->status = 'pending';
            $order->confirmed = 1;

            $cart = $order->cart;
            $cart->status = 3;
            $cart->items()->delete();
            $cart->save();
            $order->save();
        }

        if (!$order) {
            $this->response['code'] = 4040;
            $this->response['message'] = 'Order Not Found';
            return $this->response;
        }

        $otp->delete();

        $this->response['code'] = 2000;
        $this->response['message'] = 'Otp Verified Successfully';
        $this->response['data'] = [
            'order' => $order
        ];
        return $this->response;
    }

    public function resetPassword($data, $remember_token)
    {
        $user = User::where('remember_token', $remember_token)->first();
        if (!$user) {
            $this->response['code'] = 4010;
            $this->response['message'] = 'User Not Found';
            return $this->response;
        }
        $user->password = bcrypt($data['password']);
        $user->remember_at = null;
        $user->remember_token = null;
        $user->save();
        $otp = Otp::where('user_id', $user->id)->first();
        $otp->delete();

        $this->response['code'] = 2000;
        $this->response['message'] = 'Password Reset Successfully';
        return $this->response;
    }
}
