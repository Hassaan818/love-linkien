<?php

namespace App\Services\Api\V1;

use App\Models\Meeting;
use App\Models\User;
use App\Models\Venue;
use App\Services\Service;

class MeetingService extends Service
{
    public function scheduleMeeting(array $data, int $adminUserId, int $userId): array
    {
        $admin = User::role('admin')->find($adminUserId);

        // $all_arrays = array_merge(['slug' => $slug], $data, ['user_id' => $userId]);
        // dd($all_arrays);

        if (!$admin) {
            $this->response['code'] = 4004;
            $this->response['message'] = 'Admin User Not Found!';
            $this->response['data'] = null;
            return $this->response;
        }

        $meeting = new Meeting();

        $meeting->admin_user_id = $admin->id;
        $meeting->user_id = $userId;

        $meeting->meeting_date = $data['meeting_date'];
        $meeting->start_time = $data['start_time'];
        $meeting->end_time = $data['end_time'];
        $meeting->name = $data['name'];
        $meeting->phone = $data['phone'];
        $meeting->email = $data['email'];
        $meeting->description = $data['description'] ?? null;

        $meeting->save();
        $meeting->load('adminUser');

        if ($meeting) {
            $this->response['code'] = 2000;
            $this->response['message'] = 'Meeting saved successfully';
            $this->response['data'] = [
                'meeting' => $meeting
            ];
            return $this->response;
        }

        $this->response['message'] = 'Meeting not saved';
        $this->response['data'] = null;
        $this->response['code'] = 5000;
        return $this->response;
    }
}
