<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    public function index()
    {
        return view('admin.meetings.index', [
            'meetings' => Meeting::latest()->paginate(10)
        ]);
    }

    public function show(int $id)
    {
        $meeting = Meeting::with('adminUser')->where('id', $id)->first();
        return view('admin.meetings.show', [
            'meeting' => $meeting
        ]);
    }
    public function destroy(int $id)
    {
        $meeting = Meeting::where('id', $id)->first();
        $meeting->delete();
        return to_route('admin.meetings.index')->with('message', 'Meeting Deleted Successfully');
    }
}
