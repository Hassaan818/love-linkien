<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\ChecklistStoreRequest;
use App\Http\Resources\ChecklistResource;
use App\Services\Api\V1\CheckListService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class ChecklistController extends Controller
{
    use ApiResponseTrait;

    public function __construct(protected CheckListService $checkListService) {}

    public function getChecklist()
    {
        $userId = auth()->user()->id;
        $response = $this->checkListService->checkList($userId);

        if ($response['code'] === 2000) {
            return $this->success(
                ['checklists'
                => ChecklistResource::collection($response['data']['checklists'])],
                $response['message']
            );
        }

        return $this->response([], $response['message']);
    }

    public function createCheckList(ChecklistStoreRequest $request)
    {
        $data = $request->validated();
        $userId = auth()->user()->id;
        $response = $this->checkListService->storeCheckList($userId, $data);

        if ($response['code'] === 2000) {
            return $this->success(
                ['checklist'
                => new ChecklistResource($response['data']['checklist'])],
                $response['message']
            );
        }

        return $this->internalError([], $response['message']);
    }

    public function updateStatus(Request $request, $id)
    {
        $userId = auth()->user()->id;
        $data = $request->validate([
            'status' => 'required'
        ]);
        $response = $this->checkListService->updateStatus($id, $userId, $data);
        if ($response['code'] === 2000) {
            return $this->success(
                ['checklist'
                => new ChecklistResource($response['data']['checklist'])],
                $response['message']
            );
        }
        if ($response['code'] === 4004) {
            return $this->notFound([], $response['message']);
        }

        return $this->internalError([], $response['message']);
    }

    public function deleteCheckList(Request $request)
    {
        $id = $request->id;
        $userId = auth()->user()->id;
        $response = $this->checkListService->deleteCheckList($id, $userId);
        if ($response['code'] === 2000) {
            return $this->success([], $response['message']);
        }
        if ($response['code'] === 4004) {
            return $this->notFound([], $response['message']);
        }

        return $this->internalError([], $response['message']);
    }
}
