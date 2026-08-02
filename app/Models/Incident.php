<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Incident extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'latitude',
        'longitude',
        'address',
        'area_name',
        'severity',
        'status',
        'verified_by',
        'resolved_by',
        'moderator_notes',
        'views_count',
        'upvotes_count',
        'downvotes_count',
        'sms_gateway_status',
    ];

    protected $appends = ['credibility_score', 'credibility_label'];

    public function getCredibilityScoreAttribute()
    {
        $total = $this->upvotes_count + $this->downvotes_count;
        if ($total === 0) return 90; // Default baseline for reported
        return round(($this->upvotes_count / $total) * 100);
    }

    public function getCredibilityLabelAttribute()
    {
        $score = $this->credibility_score;
        if ($score >= 85) return 'High Community Credibility';
        if ($score >= 60) return 'Moderate Credibility';
        return 'Low / Flagged Community Score';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(IncidentCategory::class, 'category_id');
    }

    public function images()
    {
        return $this->hasMany(IncidentImage::class);
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function resolver()
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }
}
