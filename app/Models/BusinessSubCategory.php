<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessSubCategory extends Model
{
    /** @use HasFactory<\Database\Factories\BusinessSubCategoryFactory> */
    use HasFactory, Sluggable;

    protected $fillable = [
        'business_category_id',
        'name',
        'slug',
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

    public function category()
    {
        return $this->belongsTo(BusinessCategory::class);
    }

    public function culinaryPlaces()
    {
        return $this->hasMany(CulinaryPlace::class);
    }

    public function tourPlaces()
    {
        return $this->hasMany(TourPlace::class);
    }

    public function eventPlaces()
    {
        return $this->hasMany(EventPlace::class);
    }
}
