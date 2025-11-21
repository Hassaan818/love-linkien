<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Availability;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AvailabilityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $availabilities = Availability::with(['slots', 'user'])->orderBy('date', 'desc')->paginate(20);
        return view('admin.availability.index', compact('availabilities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $admins = User::role('admin')->get();
        return view('admin.availability.create', compact('admins'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'date' => 'required|date',
            'user_id' => 'required|exists:users,id',
            'slots_start' => 'required|array',
            'slots_end' => 'required|array',
        ]);

        DB::transaction(function () use ($request) {
            // Create a new Availability
            $availability = Availability::create([
                'date' => $request->date,
                'user_id' => $request->user_id,
            ]);

            $starts = $request->input('slots_start', []);
            $ends = $request->input('slots_end', []);

            foreach ($starts as $i => $start) {
                $end = $ends[$i] ?? null;
                if ($start && $end) {
                    $availability->slots()->create([
                        'start_time' => $start,
                        'end_time' => $end,
                    ]);
                }
            }
        });

        return redirect()->route('admin.availability.index')->with('success', 'Availability saved.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Availability $availability)
    {
        $admins = User::role('admin')->get();
        $availability->load('slots', 'user');
        return view('admin.availability.edit', compact('availability', 'admins'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Availability $availability)
    {
        $data = $request->validate([
            'date' => 'required|date',
            'user_id' => 'required|exists:users,id',
            'slots_start' => 'required|array',
            'slots_end' => 'required|array',
        ]);

        DB::transaction(function () use ($request, $availability) {
            $availability->update([
                'date' => $request->date,
                'user_id' => $request->user_id,
            ]);

            $availability->slots()->delete();

            $starts = $request->input('slots_start', []);
            $ends = $request->input('slots_end', []);

            foreach ($starts as $i => $s) {
                $e = $ends[$i] ?? null;
                if ($s && $e) {
                    $availability->slots()->create([
                        'start_time' => $s,
                        'end_time' => $e,
                    ]);
                }
            }
        });

        return redirect()->route('admin.availability.index')->with('success', 'Availability updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Availability $availability)
    {
        $availability->delete();
        return redirect()->route('admin.availability.index')->with('success', 'Availability deleted.');
    }
}
