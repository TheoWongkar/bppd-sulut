<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\EventPlace;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EventParticipant>
 */
class EventParticipantFactory extends Factory
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
            'event_place_id' => EventPlace::inRandomOrder()->first()->id,
            'stage_name' => fake()->userName(),
            'portfolio_pdf' => 'portfolios/' . fake()->uuid() . '.pdf',
            'field' => fake()->jobTitle(),
            'description' => fake()->paragraph(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'instagram_link' => 'https://instagram.com/' . fake()->userName(),
            'facebook_link' => 'https://facebook.com/' . fake()->userName(),
            'status' => fake()->randomElement(['Menunggu Persetujuan', 'Ditolak', 'Diterima']),
        ];
    }
}
