<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Participate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Event::all());
    }

    /**
     * 3. lekérdezés:
     * Állítsd lejártra (status = 2) a legalább 3 hete szervezett eseményeket
     */
    public function expireOldEvents()
    {
        $threeWeeksAgo = Carbon::today()->subWeeks(3);

        $updated = Event::whereDate('date', '<=', $threeWeeksAgo)
            ->update([
                'status' => 2
            ]);

        return response()->json([
            'message' => 'Old events set to expired',
            'updated_rows' => $updated
        ], 200);
    }

    /**
     * 5. lekérdezés:
     * Az egyik kiemelt eseményre hívd meg az egyik VIP vendéget, de csak ha van még hely!
     * (Meghíváskor present = false)
     *
     * POST /api/events/{event_id}/invite-vip
     * Body: { "user_id": 5 }
     */
    public function inviteVipIfHasSpace(Request $request, string $id)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer',
        ]);

        $eventId = (int) $id;
        $userId  = (int) $validated['user_id'];

        $result = DB::transaction(function () use ($eventId, $userId) {
            // Event rekord zárolása, hogy ne legyen ütközés kapacitás ellenőrzésnél
            $event = Event::where('event_id', $eventId)->lockForUpdate()->firstOrFail();

            // VIP ellenőrzés (feltételezve: users.vip boolean)
            $user = User::where('id', $userId)->firstOrFail();
            if (empty($user->vip)) {
                return [
                    'ok' => false,
                    'status' => 422,
                    'message' => 'A felhasználó nem VIP.',
                ];
            }

            // Már szerepel ezen az eseményen?
            $alreadyExists = Participate::where('event_id', $eventId)
                ->where('user_id', $userId)
                ->exists();

            if ($alreadyExists) {
                return [
                    'ok' => false,
                    'status' => 409,
                    'message' => 'A felhasználó már meg van hívva / szerepel ezen az eseményen.',
                ];
            }

            // Kapacitás ellenőrzés
            $currentCount = Participate::where('event_id', $eventId)->count();
            if ($currentCount >= (int) $event->limit) {
                return [
                    'ok' => false,
                    'status' => 409,
                    'message' => 'Nincs több hely az eseményen.',
                ];
            }

            // Meghívás rögzítése
            $participation = Participate::create([
                'event_id' => $eventId,
                'user_id'  => $userId,
                'present'  => false,
            ]);

            return [
                'ok' => true,
                'status' => 201,
                'message' => 'VIP vendég meghívva az eseményre.',
                'data' => $participation,
            ];
        });

        return response()->json(
            ['message' => $result['message']] + (isset($result['data']) ? ['data' => $result['data']] : []),
            $result['status']
        );
    }

    /**
     * 6. lekérdezés:
     * Az egyik eseményt halaszd el egy héttel későbbre!
     *
     * PUT /api/events/{event_id}/postpone-one-week
     */
    public function postponeOneWeek(string $id)
    {
        $event = Event::findOrFail($id);

        $event->update([
            'date' => Carbon::parse($event->date)->addWeek(),
        ]);

        return response()->json([
            'message' => 'Event postponed by one week',
            'event'   => $event
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'agency_id' => 'required|integer',
            'limit'     => 'required|integer|min:1',
            'date'      => 'required|date',
            'location'  => 'required|string|max:255',
            'status'    => 'required|integer',
        ]);

        $event = Event::create($validated);

        return response()->json($event, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $event = Event::findOrFail($id);

        return response()->json($event);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $event = Event::findOrFail($id);

        $validated = $request->validate([
            'name'      => 'sometimes|string|max:255',
            'agency_id' => 'sometimes|integer',
            'limit'     => 'sometimes|integer|min:1',
            'date'      => 'sometimes|date',
            'location'  => 'sometimes|string|max:255',
            'status'    => 'sometimes|integer',
        ]);

        $event->update($validated);

        return response()->json($event);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return response()->json([
            'message' => 'Event deleted successfully'
        ]);
    }
}