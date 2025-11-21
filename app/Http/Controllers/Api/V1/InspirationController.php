<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\InspirationStoreRequest;
use App\Http\Requests\Api\V1\InspirationUpdateRequest;
use App\Http\Resources\InspirationResource;
use App\Models\Inspiration;
use App\Services\Api\V1\InpirationService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class InspirationController extends Controller
{
    use ApiResponseTrait;

    public function __construct(protected InpirationService $inpirationService) {}
    public function index()
    {
        $userId = auth()->user()->id;
        $response = $this->inpirationService->getInpiration($userId);
        if ($response['code'] === 2000) {
            return $this->success([
                'inspirations' => InspirationResource::collection($response['data']['inspirations']),
            ], $response['message']);
        }
        if ($response['code'] === 4000) {
            return $this->notFound([], $response['message']);
        }

        return $this->internalError(null, $response['message']);
    }

    public function getInspiration($slug)
    {
        $userId = auth()->user()->id;
        $response = $this->inpirationService->getInspiration($slug, $userId);
        if ($response['code'] === 2000) {
            return $this->success([
                'inspiration' => new InspirationResource($response['data']['inspiration'])
            ], $response['message']);
        }
        if ($response['code'] === 4000) {
            return $this->notFound([], $response['message']);
        }

        return $this->internalError(null, $response['message']);
    }

    public function store(InspirationStoreRequest $request)
    {
        $data = $request->validated();
        $userId = auth()->user()->id;
        $response = $this->inpirationService->storeInspiration($data, $userId);

        if ($response['code'] === 2000) {
            return $this->success([
                'inspiration' => new InspirationResource($response['data']['inspiration'])
            ], $response['message']);
        }
        if ($response['code'] === 4000) {
            return $this->notFound([], $response['message']);
        }

        return $this->internalError(null, $response['message']);
    }

    public function update(InspirationUpdateRequest $request, $slug)
    {
        $data = $request->validated();
        $userId = auth()->user()->id;
        $response = $this->inpirationService->updateInspiration($data, $userId, $slug);
        if ($response['code'] === 2000) {
            return $this->success([
                'inspiration' => new InspirationResource($response['data']['inspiration'])
            ], $response['message']);
        }
        if ($response['code'] === 4004) {
            return $this->notFound([], $response['message']);
        }

        return $this->internalError(null, $response['message']);
    }

    public function delete($slug)
    {
        $userId = auth()->user()->id;
        $response = $this->inpirationService->deleteInspiration($userId, $slug);

        if ($response['code'] === 2000) {
            return $this->success([], $response['message']);
        }
        if ($response['code'] === 4004) {
            return $this->notFound([], $response['message']);
        }

        return $this->internalError(null, $response['message']);
    }
}
