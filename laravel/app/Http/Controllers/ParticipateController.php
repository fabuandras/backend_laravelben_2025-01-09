<?php

namespace App\Http\Controllers;

use App\Models\Participate;
use Illuminate\Http\Request;

class ParticipateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Participate::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'required|integer',
            'user_id'  => 'required|integer',
            'present'  => 'required|boolean',
        ]);

        $participate = Participate::create($validated);

        return response()->json($participate, 201);
    }

    /**
     * Display the specified resource.
     * Összetett kulcs miatt: event_id + user_id
     */
    public function show(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'required|integer',
            'user_id'  => 'required|integer',
        ]);

        $participate = Participate::where('event_id', $validated['event_id'])
            ->where('user_id', $validated['user_id'])
            ->firstOrFail();

        return response()->json($participate);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'required|integer',
            'user_id'  => 'required|integer',
            'present'  => 'required|boolean',
        ]);

        $participate = Participate::where('event_id', $validated['event_id'])
            ->where('user_id', $validated['user_id'])
            ->firstOrFail();

        $participate->update([
            'present' => $validated['present'],
        ]);

        return response()->json($participate);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'required|integer',
            'user_id'  => 'required|integer',
        ]);

        Participate::where('event_id', $validated['event_id'])
            ->where('user_id', $validated['user_id'])
            ->delete();

        return response()->json([
            'message' => 'Participation deleted successfully'
        ]);
    }
}