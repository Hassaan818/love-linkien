<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\VenueResource;
use App\Services\Api\V1\VenueService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class VenueController extends Controller
{
    use ApiResponseTrait;
    public function __construct(protected VenueService $venueService) {}

    public function getVenues(Request $request)
    {
        $response = $this->venueService->getVenues();

        if ($response['code'] === 2000) {
            return $this->success([
                'venues' => VenueResource::collection($response['data']['venues'])
            ], $response['message']);
        }

        if ($response['code'] === 4004) {
            return $this->notFound([], $response['message']);
        }

        return $this->internalError([], $response['message']);
    }
}
