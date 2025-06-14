<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\BusinessSubCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TourPlace>
 */
class TourPlaceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'business_sub_category_id' => BusinessSubCategory::inRandomOrder()->first()->id,
            'business_name' => fake()->company(),
            'slug' => fake()->slug(),
            'owner_name' => fake()->name(),
            'owner_email' => fake()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'instagram_link' => 'https://instagram.com/' . fake()->userName(),
            'facebook_link' => 'https://facebook.com/' . fake()->userName(),
            'address' => fake()->address(),
            'latitude' => fake()->latitude(-1.5, 1.5),
            'longitude' => fake()->longitude(124.0, 126.0),
            'description' => fake()->paragraph(),
            'ticket_price' => fake()->randomFloat(2, 10000, 50000),
            'facility' => json_encode(['WiFi', 'Toilet', 'Parkir']),
            'status' => fake()->randomElement(['Menunggu Persetujuan', 'Ditolak', 'Diterima']),
        ];
    }
}
