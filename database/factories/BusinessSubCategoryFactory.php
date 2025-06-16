<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\BusinessCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BusinessSubCategory>
 */
class BusinessSubCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->name();

        return [
            'business_category_id' => BusinessCategory::inRandomOrder()->first()->id,
            'name' => $name,
            'slug' => Str::slug($name),
        ];
    }
}
