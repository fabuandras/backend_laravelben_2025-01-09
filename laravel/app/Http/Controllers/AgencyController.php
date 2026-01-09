<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agency;

class AgencyController extends Controller
{
    /**
     * List all agencies
     */
    public function index()
    {
        return response()->json(Agency::all(), 200);
    }

    /**
     * Show a single agency
     */
    public function show($id)
    {
        $agency = Agency::find($id);
        if (!$agency) {
            return response()->json(['message' => 'Agency not found'], 404);
        }
        return response()->json($agency, 200);
    }

    /**
     * Create a new agency
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'type' => 'required|string|size:1',
        ]);

        $agency = Agency::create($validated);

        return response()->json($agency, 201);
    }

    /**
     * Update an agency
     */
    public function update(Request $request, $id)
    {
        $agency = Agency::find($id);
        if (!$agency) return response()->json(['message' => 'Agency not found'], 404);

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'country' => 'sometimes|string|max:255',
            'type' => 'sometimes|string|size:1',
        ]);

        $agency->update($validated);

        return response()->json($agency, 200);
    }

    /**
     * Delete an agency
     */
    public function destroy($id)
    {
        $agency = Agency::find($id);
        if (!$agency) return response()->json(['message' => 'Agency not found'], 404);

        $agency->delete();
        return response()->json(['message' => 'Agency deleted'], 200);
    }
}
