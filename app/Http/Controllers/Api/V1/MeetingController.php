<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\MeetingStoreRequest;
use App\Http\Resources\MeetingResource;
use App\Services\Api\V1\MeetingService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    use ApiResponseTrait;
    public function __construct(protected MeetingService $meetingService) {}

    public function scheduleMeeting(MeetingStoreRequest $request, $slug)
    {
        $data = $request->validated();
        $userId = auth()->user()->id;

        $response = $this->meetingService->scheduleMeeting($data, $slug, $userId);

        if ($response['code'] === 2000) {
            return $this->success([
                'meeting' => new MeetingResource($response['data']['meeting'])
            ], $response['message']);
        }

        if ($response['code'] === 4004) {
            return $this->notFound([], $response['message']);
        }

        return $this->internalError([], $response['message']);
    }
}
