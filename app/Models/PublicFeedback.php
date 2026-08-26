<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicFeedback extends Model
{
    use HasFactory;

    protected $table = 'public_feedbacks';

    protected $fillable = [
        'author_name',
        'rating',
        'category',
        'comment',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
