<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Event;

class Agency extends Model
{
    use HasFactory;

    // Ha az elsődleges kulcs nem 'id'
    protected $primaryKey = 'agency_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
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
}