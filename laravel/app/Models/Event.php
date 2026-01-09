<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'events';

    protected $primaryKey = 'event_id';

    // auto-increment PK
    public $incrementing = true;

    // nincs created_at / updated_at
    public $timestamps = false;

    protected $fillable = [
        'name',
        'agency_id',
        'limit',
        'date',
        'location',
        'status',
    ];

    protected $casts = [
        'date' => 'date',
        'status' => 'integer',
        'limit' => 'integer',
    ];
}