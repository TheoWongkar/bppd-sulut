<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\CulinaryPlace;
use App\Models\CulinaryReview;
use App\Models\BusinessCategory;
use Illuminate\Support\Facades\Auth;

class CulinaryPlaceController extends Controller
{
    public function index(Request $request)
    {
        // Validasi input dari query string
        $validated = $request->validate([
            'search'   => 'nullable|string|max:255',
            'category' => 'nullable|string|exists:business_sub_categories,slug',
        ]);

        // Ambil kategori utama "Tempat Wisata"
        $category = BusinessCategory::where('name', 'Kuliner')->first();

        // Ambil semua subkategori jika kategori ditemukan, jika tidak kembalikan koleksi kosong
        $subCategories = $category ? $category->subCategories : collect();

        // Ambil nilai pencarian dan slug subkategori dari hasil validasi
        $search = $validated['search'] ?? null;
        $selectedSubCategorySlug = $validated['category'] ?? null;

        // Query tempat wisata
        $culinaryPlaces = CulinaryPlace::with(['subCategory', 'firstImage'])
            ->withAvg('reviews', 'rating') // Ambil rata-rata rating dari relasi reviews
            ->where('status', 'Diterima') // Tampilkan hanya data yang telah di setujui admin
            ->when($search, function ($query, $search) {
                $query->where('business_name', 'like', '%' . $search . '%');
            })
            ->when($selectedSubCategorySlug, function ($query, $slug) {
                $query->whereHas('subCategory', function ($q) use ($slug) {
                    $q->where('slug', $slug);
                });
            })
            ->orderByDesc('reviews_avg_rating') // Urutkan berdasarkan rating tertinggi
            ->paginate(9) // Pagination 9 item per halaman
            ->appends($request->query()); // Tetap bawa query string saat navigasi halaman

        // Kirim data ke view
        return view('culinaryplaces.index', compact('culinaryPlaces', 'subCategories'));
    }

    public function show(string $subCategory, string $slug)
    {
        // Ambil data tempat wisata beserta relasi terkait
        $culinaryPlace = CulinaryPlace::with([
            'subCategory',
            'firstImage',
            'images',
            'operatingHours',
            'reviews'
        ])->where('slug', $slug)->firstOrFail();

        // Daftar hari dalam seminggu
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

        // Dapatkan nama hari ini dalam Bahasa Indonesia
        $today = Carbon::now()->locale('id')->isoFormat('dddd');

        // Ambil data jam operasional hari ini
        $todayData = $culinaryPlace->operatingHours->firstWhere('day', $today);

        // Cek apakah tempat wisata sedang buka saat ini
        $isOpen = false;
        if ($todayData) {
            $now = Carbon::now();
            $openTime = Carbon::createFromTimeString($todayData->open_time);
            $closeTime = Carbon::createFromTimeString($todayData->close_time);

            $isOpen = $now->between($openTime, $closeTime);
        }

        // Format jam operasional harian untuk ditampilkan
        $operatingHours = collect($days)->map(function ($day) use ($culinaryPlace) {
            $dayData = $culinaryPlace->operatingHours->firstWhere('day', $day);

            return [
                'day'   => $day,
                'open'  => $dayData ? Carbon::parse($dayData->open_time)->format('H.i') : '-',
                'close' => $dayData ? Carbon::parse($dayData->close_time)->format('H.i') : '-',
            ];
        });

        // Hitung total ulasan dan rata-rata rating
        $totalReviews = $culinaryPlace->reviews->count();
        $averageRating = round($culinaryPlace->reviews->avg('rating'), 1);

        // Hitung jumlah rating untuk setiap tingkat bintang
        $ratingCounts = $culinaryPlace->reviews->groupBy('rating')->map->count();

        // Format distribusi rating dari bintang 5 ke 1
        $ratings = collect([
            5 => 'Luar biasa',
            4 => 'Bagus',
            3 => 'Biasa',
            2 => 'Buruk',
            1 => 'Sangat buruk',
        ])->map(function ($label, $rate) use ($ratingCounts, $totalReviews) {
            $jumlah = $ratingCounts[$rate] ?? 0;
            $persentase = $totalReviews ? round(($jumlah / $totalReviews) * 100) : 0;

            return [
                'label'      => $label,
                'jumlah'     => $jumlah,
                'persentase' => $persentase,
            ];
        });

        // Ambil data review
        $reviews = CulinaryReview::with('user')
            ->where('culinary_place_id', $culinaryPlace->id)
            ->latest()
            ->get();

        // Ambil data review saya
        $myReview = $culinaryPlace->reviews->firstWhere('user_id', Auth::id());

        // Kirim data ke view
        return view('culinaryplaces.show', compact(
            'culinaryPlace',
            'operatingHours',
            'averageRating',
            'totalReviews',
            'ratings',
            'isOpen',
            'reviews',
            'myReview'
        ));
    }

    public function storeReview(Request $request, string $subCategory, string $slug)
    {
        // Cek apakah pengguna sudah login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Validasi input dari form
        $validated = $request->validate([
            'rating'      => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        // Cari data tempat wisata berdasarkan slug
        $culinaryPlace = CulinaryPlace::where('slug', $slug)->firstOrFail();

        // Ambil ID user yang sedang login
        $userId = Auth::id();

        // Simpan review baru
        CulinaryReview::create([
            'user_id'       => $userId,
            'culinary_place_id' => $culinaryPlace->id,
            'rating'        => $validated['rating'],
            'comment'       => $validated['comment'],
        ]);

        // Redirect kembali dengan pesan sukses
        return redirect()->back()
            ->with('success', 'Ulasan berhasil dikirim!');
    }

    public function updateReview(Request $request, string $subCategory, string $slug)
    {
        // Pastikan user login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Validasi input dari form
        $validated = $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        // Cari tempat kuliner berdasarkan slug
        $culinaryPlace = CulinaryPlace::where('slug', $slug)->firstOrFail();

        // Ambil review user yang sedang login untuk tempat ini
        $review = CulinaryReview::where('culinary_place_id', $culinaryPlace->id)
            ->where('user_id', Auth::id())
            ->first();

        // Jika review tidak ditemukan, redirect atau buat pesan error
        if (!$review) {
            return redirect()->back()->with('error', 'Ulasan tidak ditemukan.');
        }

        // Update data review
        $review->update([
            'rating'  => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Ulasan berhasil diperbarui!');
    }
}
