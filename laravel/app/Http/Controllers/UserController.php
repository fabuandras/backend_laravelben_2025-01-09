<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        if ($user->agency_id) {
            $users = $user->agency->users;
        } else {
            $users = User::all();
        }
        return response()->json($users, 200);
    }

    public function show(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) return response()->json(['message'=>'User not found'], 404);

        $authUser = $request->user();
        if ($authUser->agency_id && $authUser->agency_id !== $user->agency_id) {
            return response()->json(['message'=>'Unauthorized'], 403);
        }

        return response()->json($user, 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'agency_id' => 'nullable|exists:agencies,agency_id',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'agency_id' => $validated['agency_id'] ?? null,
        ]);

        return response()->json($user, 201);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) return response()->json(['message'=>'User not found'], 404);

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,'.$id,
            'password' => 'sometimes|string|min:6|confirmed',
            'agency_id' => 'nullable|exists:agencies,agency_id',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);

        return response()->json($user, 200);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) return response()->json(['message'=>'User not found'], 404);

        $user->delete();
        return response()->json(['message'=>'User deleted'], 200);
    }
}
