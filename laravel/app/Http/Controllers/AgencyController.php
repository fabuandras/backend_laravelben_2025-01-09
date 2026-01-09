<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agency;

class AgencyController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        if ($user->agency_id) {
            return response()->json($user->agency, 200);
        }
        return response()->json(Agency::all(), 200);
    }

    public function show(Request $request, $id)
    {
        $agency = Agency::find($id);
        if (!$agency) return response()->json(['message' => 'Agency not found'], 404);

        $user = $request->user();
        if ($user->agency_id && $user->agency_id !== $agency->agency_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($agency, 200);
    }

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

    public function destroy($id)
    {
        $agency = Agency::find($id);
        if (!$agency) return response()->json(['message' => 'Agency not found'], 404);

        $agency->delete();
        return response()->json(['message' => 'Agency deleted'], 200);
    }
}
