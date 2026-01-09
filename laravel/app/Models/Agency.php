<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Event;
use App\Models\User;

class Agency extends Model
{
    use HasFactory;

    // Ha az elsődleges kulcs nem 'id'
    protected $primaryKey = 'agency_id';

    protected $fillable = [
        'name',
        'country',
        'type',
    ];

    /**
     * Kapcsolat: egy ügynökséghez több esemény tartozik
     */
    public function events()
    {
        return $this->hasMany(Event::class, 'agency_id', 'agency_id');
    }

    /**
     * Kapcsolat: egy ügynökséghez több felhasználó tartozik (ha van users.agency_id)
     */
    public function users()
    {
        return $this->hasMany(User::class, 'agency_id', 'agency_id');
    }
}