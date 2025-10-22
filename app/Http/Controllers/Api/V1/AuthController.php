<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\LoginRequest;
use App\Http\Requests\Api\V1\SignupRequest;
use App\Http\Resources\LoginResource;
use App\Http\Resources\SignUpResource;
use App\Services\Api\V1\AuthService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use ApiResponseTrait;

    public function __construct(protected AuthService $authService) {}

    public function signup(SignupRequest $request)
    {
        $data = $request->validated();
        $response = $this->authService->signup($data);
        if ($response['code'] === 2000) {
            return $this->success((new SignUpResource($response)), $response['message']);
        } else {
            if ($response['code'] === 4022) {
                return $this->unprocessableEntity([
                    'email' => [
                        $response['message']
                    ]
                ]);
            }
            return $this->internalError(null, $response['message']);
        }
    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        $response = $this->authService->login($data);
        if ($response['code'] == 2000) {
            return $this->success((new LoginResource($response)), $response['message']);
        } else {
            if ($response['code'] == 4010) {
                return $this->error(null, $response['message'], 4010);
            }

            return $this->internalError(null, $response['message']);
        }
    }

    public function logout(Request $request)
    {
        $response = $this->authService->logout_user($request);
        if ($response['code'] === 2000) {
            return $this->success([], $response['message']);
        }
        return $this->internalError(
            null,
            $response['message'],
        );
    }

    public function verifyOtp(Request $request)
    {
        $data = $request->all();
        $response = $this->authService->verifyOtp($data);

        if ($response['code'] === 2000) {
            return $this->success([
                $response['data']
            ], 'Otp Verified Successfully');
        }

        if ($response['code'] == 4004) {
            return $this->notFound(null, $response['message']);
        }

        return $this->internalError(null, $response['message']);
    }
}
