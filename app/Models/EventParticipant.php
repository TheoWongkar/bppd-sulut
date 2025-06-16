<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventParticipant extends Model
{
    /** @use HasFactory<\Database\Factories\EventParticipantFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_place_id',
        'stage_name',
        'portfolio_pdf',
        'field',
        'description',
        'email',
        'phone',
        'instagram_link',
        'facebook_link',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function eventPlace()
    {
        return $this->belongsTo(EventPlace::class);
    }
}
