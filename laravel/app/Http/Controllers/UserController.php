<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * List users
     * - Ha a bejelentkezett user ügynökséghez tartozik, csak a saját ügynökségének user-jeit adja vissza
     * - Különben minden usert
     */
    public function index(Request $request)
    {
        $authUser = $request->user();

        if ($authUser && $authUser->agency_id) {
            // Feltételezi, hogy a User modelben van: agency() kapcsolat
            $users = $authUser->agency->users;
        } else {
            $users = User::all();
        }

        return response()->json($users, 200);
    }

    /**
     * 1. lekérdezés:
     * List VIP users (name + email)
     */
    public function vipUsers()
    {
        $vipUsers = User::where('vip', true)->get(['name', 'email']);

        return response()->json($vipUsers, 200);
    }

    /**
     * Show a single user
     */
    public function show(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $authUser = $request->user();

        // Ha az auth user ügynökséghez tartozik, csak a saját ügynökségén belül nézhet usert
        if ($authUser && $authUser->agency_id && $authUser->agency_id !== $user->agency_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($user, 200);
    }

    /**
     * Create a new user
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users,email',
            'password'  => 'required|string|min:6|confirmed',
            'agency_id' => 'nullable|exists:agencies,agency_id',
            // 'vip'    => 'sometimes|boolean',
        ]);

        $user = User::create([
            'name'      => $validated['name'],
            'email'     => $validated['email'],
            'password'  => Hash::make($validated['password']),
            'agency_id' => $validated['agency_id'] ?? null,
            // 'vip'    => $validated['vip'] ?? false,
        ]);

        return response()->json($user, 201);
    }

    /**
     * Update a user
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => [
                'sometimes',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'password'  => 'sometimes|string|min:6|confirmed',
            'agency_id' => 'nullable|exists:agencies,agency_id',
            // 'vip'    => 'sometimes|boolean',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);

        return response()->json($user, 200);
    }

    /**
     * Delete a user
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted'], 200);
    }
}