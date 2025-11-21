<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Availability;
use App\Models\User;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    public function slotsForAdmin($userId, Request $request)
    {
        $date = $request->query('date');
        $query = Availability::with('slots')->where('user_id', $userId);
        if ($date) $query->where('date', $date);
        $availabilities = $query->get();

        $out = [];
        foreach ($availabilities as $a) {
            foreach ($a->slots as $s) {
                $out[] = [
                    'availability_id' => $a->id,
                    'date' => $a->date->toDateString(),
                    'start' => $s->start_time,
                    'end' => $s->end_time,
                ];
            }
        }

        return response()->json($out);
    }

    public function admins()
    {
        $admins = User::role('admin')->get(['id', 'name', 'email', 'image']);

        $admins = $admins->map(function ($admin) {
            return [
                'id' => $admin->id,
                'name' => $admin->name,
                'email' => $admin->email,
                'image' => $admin->image ? asset($admin->image) : null,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $admins,
        ]);
    }
}
