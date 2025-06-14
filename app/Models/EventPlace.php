<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventPlace extends Model
{
    /** @use HasFactory<\Database\Factories\EventPlaceFactory> */
    use HasFactory, Sluggable;

    protected $fillable = [
        'user_id',
        'business_sub_category_id',
        'business_name',
        'slug',
        'owner_name',
        'owner_email',
        'phone',
        'instagram_link',
        'facebook_link',
        'address',
        'latitude',
        'longitude',
        'description',
        'ticket_price',
        'facility',
        'start_time',
        'end_time',
    ];

    protected $casts = [
        'facility' => 'array',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(BusinessSubCategory::class, 'business_sub_category_id');
    }

    public function images()
    {
        return $this->hasMany(EventImage::class);
    }
}
