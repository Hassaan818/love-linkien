<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\WeddingStoreRequest;
use App\Http\Resources\WeddingResource;
use App\Services\Api\V1\WeddingService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class BridalController extends Controller
{
    use ApiResponseTrait;
    public function __construct(protected WeddingService $weddingService) {}
    public function getWeddingInfo()
    {
        $userId = auth()->user()->id;
        $response = $this->weddingService->getInfo($userId);

        if ($response['code'] === 2000) {
            return $this->success([
                'wedding_info' => new WeddingResource($response['data']['weddingInfo'])
            ], $response['message']);
        }

        if ($response['code'] === 4004) {
            return $this->notFound([], $response['message']);
        }
    }

    public function store(WeddingStoreRequest $request)
    {
        $validatedData = $request->validated();
        $userId = auth()->user()->id;

        $response = $this->weddingService->store($userId, $validatedData);

        if ($response['code'] === 2000) {
            return $this->success([
                'wedding' => new WeddingResource($response['data']['wedding'])
            ], $response['message']);
        }

        return $this->error([], $response['message']);
    }
}
