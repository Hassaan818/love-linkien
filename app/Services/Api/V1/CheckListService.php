<?php

namespace App\Services\Api\V1;

use App\Models\Checklist;
use App\Services\Service;

class CheckListService extends Service
{
    public function checkList($userId)
    {
        $checklists = Checklist::where('user_id', $userId)->get();

        if ($checklists) {
            $this->response['code'] = 2000;
            $this->response['message'] = 'Check lists Retrieved Successfully';
            $this->response['data'] = [
                'checklists' => $checklists
            ];
            return $this->response;
        }

        $this->response['code'] = 4000;
        $this->response['message'] = 'Check lists not Found';
        $this->response['data'] = null;
        return $this->response;
    }

    public function storeCheckList($userId, $data)
    {
        $checklist = new Checklist();
        $checklist->task_name = $data['task_name'];
        $checklist->task_date = $data['task_date'];
        $checklist->user_id = $userId;

        $checklist->save();

        if ($checklist) {
            $this->response['code'] = 2000;
            $this->response['message'] = 'Check lists saved Successfully';
            $this->response['data'] = [
                'checklist' => $checklist
            ];
            return $this->response;
        }

        $this->response['code'] = 5000;
        $this->response['message'] = 'Internal Server Error';
        $this->response['data'] = null;
        return $this->response;
    }

    public function deleteCheckList($id, $userId)
    {
        $checklist = Checklist::where('id', $id)
            ->where('user_id', $userId)
            ->first();
        if (!$checklist) {
            $this->response['code'] = 4004;
            $this->response['message'] = 'Checklist not found';
            $this->response['data'] = null;
            return $this->response;
        }
        $deleteChecklist = $checklist->delete();
        if ($deleteChecklist) {
            $this->response['code'] = 2000;
            $this->response['message'] = 'Check lists deleted Successfully';
            $this->response['data'] = [
                'deleteChecklist' => $deleteChecklist
            ];
            return $this->response;
        }

        $this->response['code'] = 5000;
        $this->response['message'] = 'Internal Server Error';
        $this->response['data'] = null;
        return $this->response;
    }
}
