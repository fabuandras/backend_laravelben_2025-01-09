<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Agency extends Model
{
    use HasFactory;

    protected $primaryKey = 'agency_id';

    protected $fillable = [
        'name',
        'country',
        'type',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'agency_id');
    }
}
