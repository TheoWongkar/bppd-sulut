<?php

namespace Database\Factories;

use App\Models\EventPlace;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EventImage>
 */
class EventImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'event_place_id' => EventPlace::inRandomOrder()->first()->id,
            'image' => 'sample/placeholder.webp',
        ];
    }
}
