<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\TourImage;
use App\Models\TourPlace;
use App\Models\EventImage;
use App\Models\EventPlace;
use App\Models\TourReview;
use App\Models\CulinaryImage;
use App\Models\CulinaryPlace;
use App\Models\CulinaryReview;
use Illuminate\Database\Seeder;
use App\Models\BusinessCategory;
use App\Models\TourOperatingHour;
use App\Models\BusinessSubCategory;
use App\Models\CulinaryOperatingHour;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Users
        User::factory(10)->make()->tap(function ($users) {
            $users[0]->name = 'admin';
            $users[0]->email = 'admin@bppd.com';
            $users[0]->role = 'Admin';
        })->each->save();

        // Array Kategori dan Subkategori
        $categories = [
            'Kuliner' => ['Makanan', 'Minuman', 'Snack'],
            'Tempat Wisata' => ['Destinasi', 'Desa Pariwisata', 'Gunung', 'Pulau', 'Pantai'],
            'Event' => ['Seni', 'Pameran', 'Bazar'],
        ];

        // Looping Kategori dan Subkategori
        foreach ($categories as $categoryName => $subCategories) {
            $category = BusinessCategory::factory()->create([
                'name' => $categoryName
            ]);

            foreach ($subCategories as $subCategoryName) {
                BusinessSubCategory::factory()->create([
                    'business_category_id' => $category->id,
                    'name' => $subCategoryName
                ]);
            }
        }

        // Hari
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

        // Tempat Kuliner
        CulinaryPlace::factory()->count(10)->create()->each(function ($place) use ($days) {

            // Buat 5 gambar untuk setiap tempat
            CulinaryImage::factory()->count(5)->create([
                'culinary_place_id' => $place->id,
            ]);

            // Buat Jam operasional Senin - Minggu
            foreach ($days as $day) {
                CulinaryOperatingHour::factory()->create([
                    'culinary_place_id' => $place->id,
                    'day' => $day,
                    'open_time' => '08:00:00',
                    'close_time' => '20:00:00',
                ]);
            }

            // Optional: Buat review 1-3 untuk setiap tempat
            CulinaryReview::factory()->count(rand(1, 3))->create([
                'culinary_place_id' => $place->id,
            ]);
        });

        // Tempat Wisata
        TourPlace::factory()->count(10)->create()->each(function ($place) use ($days) {

            // Buat 5 gambar untuk setiap tempat
            TourImage::factory()->count(5)->create([
                'tour_place_id' => $place->id,
            ]);

            // Buat jam operasional Senin - Minggu
            foreach ($days as $day) {
                TourOperatingHour::factory()->create([
                    'tour_place_id' => $place->id,
                    'day' => $day,
                    'open_time' => '08:00:00',
                    'close_time' => '20:00:00',
                ]);
            }

            // Optional: Buat review 1-3 untuk setiap tempat
            TourReview::factory()->count(rand(1, 3))->create([
                'tour_place_id' => $place->id,
            ]);
        });

        // Tempat Kegiatan
        EventPlace::factory()->count(10)->create()->each(function ($place) {

            // Buat 5 gambar untuk setiap tempat
            EventImage::factory()->count(5)->create([
                'event_place_id' => $place->id,
            ]);
        });
    }
}
