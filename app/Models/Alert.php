<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Alert extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'message',
        'category',
        'area_name',
        'severity',
        'published_by',
        'is_active',
    ];

    public function publisher()
    {
        return $this->belongsTo(User::class, 'published_by');
    }
}
