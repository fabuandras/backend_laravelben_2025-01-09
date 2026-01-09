<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        $admins = User::where('is_admin', true)->get();
        return response()->json($admins, 200);
    }

    public function show($id)
    {
        $admin = User::where('id', $id)->where('is_admin', true)->first();
        if (!$admin) return response()->json(['message' => 'Admin not found'], 404);
        return response()->json($admin, 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'agency_id' => 'nullable|exists:agencies,agency_id',
        ]);

        $admin = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'agency_id' => $validated['agency_id'] ?? null,
            'is_admin' => true,
        ]);

        return response()->json($admin, 201);
    }

    public function update(Request $request, $id)
    {
        $admin = User::where('id', $id)->where('is_admin', true)->first();
        if (!$admin) return response()->json(['message' => 'Admin not found'], 404);

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,'.$id,
            'password' => 'sometimes|string|min:6|confirmed',
            'agency_id' => 'nullable|exists:agencies,agency_id',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        }

        $admin->update($validated);

        return response()->json($admin, 200);
    }

    public function destroy($id)
    {
        $admin = User::where('id', $id)->where('is_admin', true)->first();
        if (!$admin) return response()->json(['message' => 'Admin not found'], 404);

        $admin->delete();
        return response()->json(['message' => 'Admin deleted'], 200);
    }
}
