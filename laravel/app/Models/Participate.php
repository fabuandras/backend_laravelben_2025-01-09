<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participate extends Model
{
    protected $table = 'participates';

    public $incrementing = false;

    public $timestamps = false;

    protected $primaryKey = null;

    protected $fillable = [
        'event_id',
        'user_id',
        'present'
    ];

    protected $casts = [
        'present' => 'boolean',
    ];
}