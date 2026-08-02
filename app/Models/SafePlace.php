<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SafePlace extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'address',
        'area_name',
        'latitude',
        'longitude',
        'phone',
        'is_24_7',
    ];
}
