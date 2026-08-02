<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IncidentCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'type',
        'icon',
        'risk_level',
    ];

    public function incidents()
    {
        return $this->hasMany(Incident::class, 'category_id');
    }
}
