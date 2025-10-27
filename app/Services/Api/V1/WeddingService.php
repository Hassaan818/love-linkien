<?php

namespace App\Services\Api\V1;

use App\Models\Bride;
use App\Services\Service;

class WeddingService extends Service
{
    public function getInfo($userId)
    {
        $weddingInfo = Bride::where('user_id', $userId)->first();

        if ($weddingInfo) {
            $this->response['code'] = 2000;
            $this->response['message'] = 'Wedding Info Retrieved Successfully';
            $this->response['data'] = [
                'weddingInfo' => $weddingInfo
            ];
            return $this->response;
        }

        $this->response['code'] = 4000;
        $this->response['message'] = 'Wedding Info Not Found';
        $this->response['data'] = null;
        return $this->response;
    }

    public function store($userId, $data)
    {
        $wedding = new Bride();
        $wedding->bride_name = $data['bride_name'];
        $wedding->groom_name = $data['groom_name'];
        $wedding->wedding_date = $data['date'];
        $wedding->user_id = $userId;

        $wedding->save();

        if ($wedding) {
            $this->response['code'] = 2000;
            $this->response['message'] = 'Wedding Info Saved Successfully';
            $this->response['data'] = [
                'wedding' => $wedding
            ];
            return $this->response;
        }

        $this->response['code'] = 4000;
        $this->response['message'] = 'Wedding Not Saved';
        $this->response['data'] = null;
        return $this->response;
    }
}
