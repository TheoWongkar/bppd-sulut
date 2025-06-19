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
use App\Models\BusinessCategory;
use App\Models\TourOperatingHour;
use App\Models\BusinessSubCategory;
use App\Models\CulinaryOperatingHour;
use App\Models\EventParticipant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat 10 user, set user pertama sebagai admin
        User::factory(10)->make()->tap(function ($users) {
            $users[0]->name = 'admin';
            $users[0]->email = 'admin@bppd.com';
            $users[0]->role = 'Admin';
        })->each->save();

        // Daftar kategori dan subkategori
        $categories = [
            'Kuliner' => ['Makanan', 'Minuman', 'Snack'],
            'Tempat Wisata' => ['Destinasi', 'Desa Pariwisata', 'Gunung', 'Pulau', 'Pantai'],
            'Event' => ['Seni', 'Pameran', 'Bazar'],
        ];

        // Menyimpan subkategori berdasarkan kategori
        $subCategoriesMap = [];

        foreach ($categories as $categoryName => $subCategories) {
            $category = BusinessCategory::factory()->create([
                'name' => $categoryName,
                'slug' => Str::slug($categoryName)
            ]);

            foreach ($subCategories as $subCategoryName) {
                $subCategory = BusinessSubCategory::factory()->create([
                    'business_category_id' => $category->id,
                    'name' => $subCategoryName,
                    'slug' => Str::slug($subCategoryName)
                ]);

                $subCategoriesMap[$categoryName][] = $subCategory;
            }
        }

        $users = User::pluck('id')->toArray(); // Ambil semua user ID
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

        // Seed data kuliner
        $kulinerSubCategories = $subCategoriesMap['Kuliner'];

        CulinaryPlace::factory()->count(100)->create()->each(function ($place) use ($days, $kulinerSubCategories, $users) {
            $subCategory = $kulinerSubCategories[array_rand($kulinerSubCategories)];
            $place->update(['business_sub_category_id' => $subCategory->id]);

            CulinaryImage::factory()->count(5)->create([
                'culinary_place_id' => $place->id,
            ]);

            foreach ($days as $day) {
                CulinaryOperatingHour::factory()->create([
                    'culinary_place_id' => $place->id,
                    'day' => $day,
                    'open_time' => '08:00:00',
                    'close_time' => '20:00:00',
                ]);
            }

            // Assign review ke user acak tanpa duplikat per tempat
            $reviewUserIds = collect($users)->shuffle()->take(rand(1, 3));
            foreach ($reviewUserIds as $userId) {
                CulinaryReview::factory()->create([
                    'culinary_place_id' => $place->id,
                    'user_id' => $userId,
                ]);
            }
        });

        // Seed data tempat wisata
        $wisataSubCategories = $subCategoriesMap['Tempat Wisata'];

        TourPlace::factory()->count(100)->create()->each(function ($place) use ($days, $wisataSubCategories, $users) {
            $subCategory = $wisataSubCategories[array_rand($wisataSubCategories)];
            $place->update(['business_sub_category_id' => $subCategory->id]);

            TourImage::factory()->count(5)->create([
                'tour_place_id' => $place->id,
            ]);

            foreach ($days as $day) {
                TourOperatingHour::factory()->create([
                    'tour_place_id' => $place->id,
                    'day' => $day,
                    'open_time' => '08:00:00',
                    'close_time' => '20:00:00',
                ]);
            }

            // Review user acak tanpa duplikat
            $reviewUserIds = collect($users)->shuffle()->take(rand(1, 3));
            foreach ($reviewUserIds as $userId) {
                TourReview::factory()->create([
                    'tour_place_id' => $place->id,
                    'user_id' => $userId,
                ]);
            }
        });

        // Seed data event
        $eventSubCategories = $subCategoriesMap['Event'];

        EventPlace::factory()->count(100)->create()->each(function ($place) use ($eventSubCategories, $users) {
            $subCategory = $eventSubCategories[array_rand($eventSubCategories)];
            $place->update(['business_sub_category_id' => $subCategory->id]);

            EventImage::factory()->count(5)->create([
                'event_place_id' => $place->id,
            ]);

            // Setidaknya satu peserta event, dari user yang belum pernah daftar di event ini
            $participantUserIds = collect($users)->shuffle()->take(rand(1, 3));
            foreach ($participantUserIds as $userId) {
                EventParticipant::factory()->create([
                    'event_place_id' => $place->id,
                    'user_id' => $userId,
                ]);
            }
        });
    }
}
