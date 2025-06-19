<x-main-layout>

    <!-- Bagian Show Tour Place -->
    <section>
        <div class="container mx-auto py-10 px-4 sm:px-6 lg:px-8">

            <!-- Judul Tempat -->
            <h2 class="text-md md:text-xl text-center md:text-left font-semibold mb-4 text-[#486284]">
                {{ $tourPlace->business_name }}
            </h2>

            <!-- Gambar Utama dan Galeri -->
            <div x-data="{
                mainImage: '{{ $tourPlace->firstImage ? asset('storage/' . $tourPlace->firstImage->image) : asset('img/placeholder.webp') }}'
            }" class="flex flex-col lg:flex-row gap-4 mb-6">

                <!-- Gambar Utama -->
                <div class="w-full lg:w-3/4">
                    <div class="aspect-video bg-gray-200 rounded-xl overflow-hidden shadow-md">
                        <img :src="mainImage" alt="Thumbnail Tour"
                            class="w-full h-full object-cover object-center transition duration-300 ease-in-out">
                    </div>
                </div>

                <!-- Galeri Thumbnail -->
                <div class="w-full lg:w-1/4">
                    <div class="flex gap-2 overflow-x-auto lg:overflow-visible lg:flex-col">
                        @forelse ($tourPlace->images as $image)
                            <img src="{{ asset('storage/' . $image->image) }}" alt="Galeri Tour"
                                class="w-24 h-24 lg:w-full lg:h-28 object-cover rounded-md cursor-pointer flex-shrink-0 border-2 border-transparent hover:border-[#486284] transition duration-200"
                                @click="mainImage = '{{ asset('storage/' . $image->image) }}'">
                        @empty
                            @for ($i = 0; $i < 4; $i++)
                                <img src="{{ asset('img/placeholder.webp') }}" alt="Galeri Kosong"
                                    class="w-24 h-24 lg:w-full lg:h-28 object-cover rounded-md flex-shrink-0 border border-gray-300">
                            @endfor
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Informasi & Waktu -->
            <div class="grid sm:grid-cols-2 md:grid-cols-[2fr_1fr] lg:grid-cols-[3fr_1fr] gap-6">

                <!-- Informasi Tempat -->
                <div class="bg-white p-4 rounded-xl shadow-md">
                    <h2 class="text-lg font-semibold mb-2 text-[#486284]">Informasi</h2>
                    <p class="text-sm mb-3">{{ $tourPlace->description }}</p>

                    <div class="flex flex-col md:flex-row gap-6 text-sm">

                        <!-- Kontak -->
                        <div class="flex-1 space-y-1">
                            <h3 class="font-semibold text-[#486284]">Hubungi Kami:</h3>

                            <!-- Telepon -->
                            <p class="flex items-center gap-2 text-[#486284]">
                                <x-icons.phone />
                                {{ $tourPlace->phone }}
                            </p>

                            <!-- Instagram -->
                            @if ($tourPlace->instagram_link)
                                <a href="{{ $tourPlace->instagram_link }}"
                                    class="flex items-center gap-2 text-[#486284] hover:underline">
                                    <x-icons.instagram />
                                    Instagram
                                </a>
                            @endif

                            <!-- Facebook -->
                            @if ($tourPlace->facebook_link)
                                <a href="{{ $tourPlace->facebook_link }}"
                                    class="flex items-center gap-2 text-[#486284] hover:underline">
                                    <x-icons.facebook />
                                    Facebook
                                </a>
                            @endif

                            <!-- Alamat -->
                            <p class="flex items-center gap-2 text-[#486284]">
                                <span class="shrink-0">
                                    <x-icons.location />
                                </span>
                                {{ $tourPlace->address }}
                            </p>
                        </div>

                        <!-- Detail Tempat dan Fasilitas -->
                        <div class="flex-1 space-y-3">
                            <div>
                                <h3 class="font-semibold text-[#486284] mb-1">Detail Kami:</h3>

                                <!-- Harga Tiket -->
                                <p class="flex items-center gap-2 text-[#486284]">
                                    <x-icons.ticket />
                                    {{ $tourPlace->ticket_price == 0 ? 'Gratis' : 'Rp ' . number_format($tourPlace->ticket_price, 0, ',', '.') }}
                                </p>
                            </div>

                            <!-- Fasilitas -->
                            <div>
                                <h3 class="font-semibold text-[#486284] mb-1">Fasilitas:</h3>
                                @foreach (json_decode($tourPlace->facility) as $item)
                                    <p class="inline text-[#486284]">{{ $item }},</p>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Google Maps -->
                    <iframe src="{{ $tourPlace->gmaps_link }}" width="100%" height="200" style="border:0;"
                        allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                        class="mt-2 rounded-xl"></iframe>
                </div>

                <!-- Jam Operasional -->
                <div class="w-full">
                    <div class="bg-white rounded-lg py-4 lg:py-6 px-4 lg:px-10 shadow-md">

                        <!-- Judul Waktu -->
                        <h2 class="text-lg font-semibold mb-4 text-[#486284]">Waktu</h2>

                        <!-- Status Buka / Tutup Hari Ini -->
                        <div class="flex items-center justify-center gap-1 mb-4">
                            <span class="{{ $isOpen ? 'text-green-600 font-semibold' : 'text-gray-400' }}">Buka</span>
                            <span class="text-gray-400">/</span>
                            <span class="{{ !$isOpen ? 'text-red-600 font-semibold' : 'text-gray-400' }}">Tutup</span>
                        </div>

                        <!-- Daftar Jam Buka per Hari -->
                        <ul class="text-xs md:text-sm font-semibold space-y-1">
                            @foreach ($operatingHours as $hour)
                                <li class="flex justify-between">
                                    <span>{{ $hour['day'] }}</span>
                                    <span>{{ $hour['open'] }}–{{ $hour['close'] }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Bagian Reviews -->
    <section class="bg-gray-50">
        <div class="container mx-auto py-10 px-4 sm:px-6 lg:px-8">

            <!-- Header Judul dan Aksi -->
            <div class="flex flex-row justify-between items-center gap-4 mb-4">
                <h2 class="text-lg font-semibold">Ulasan</h2>
                <div class="flex items-center gap-2 sm:gap-4">
                    <a href="#review-list" class="text-gray-900 text-sm font-semibold underline">
                        Semua ulasan ({{ $totalReviews }})
                    </a>
                    <label for="comment"
                        class="bg-black text-white text-sm px-4 py-2 rounded-full hover:bg-gray-800 cursor-pointer">
                        Tulis ulasan
                    </label>
                </div>
            </div>

            <!-- Statistik Rating -->
            <div class="flex flex-col md:flex-row items-start gap-4 md:gap-6 mb-10">

                <!-- Bagian Kiri: Nilai Rating -->
                <div class="w-full md:w-1/6">
                    <p class="text-4xl font-bold">{{ $averageRating }}</p>
                    <span class="text-sm text-gray-600 mb-1 block">
                        @if ($averageRating >= 5)
                            Luar Biasa
                        @elseif ($averageRating >= 4)
                            Bagus
                        @elseif ($averageRating >= 3)
                            Biasa
                        @elseif ($averageRating >= 2)
                            Buruk
                        @else
                            Sangat Buruk
                        @endif
                    </span>

                    <!-- Tampilan Bintang -->
                    <div class="flex items-center gap-1 text-green-600 text-lg">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= floor($averageRating))
                                ★
                            @else
                                ☆
                            @endif
                        @endfor
                        <span class="text-xs text-gray-500 ml-1">({{ $totalReviews }})</span>
                    </div>
                </div>

                <!-- Bagian Kanan: Bar Persentase Rating -->
                <div class="flex-1 space-y-2 text-xs sm:text-sm w-full">
                    @foreach ($ratings as $rate => $item)
                        <div class="flex items-center gap-2">
                            <!-- Label Rating -->
                            <span class="w-16 sm:w-20 font-medium text-gray-700">{{ $item['label'] }}</span>

                            <!-- Progress Bar -->
                            <div class="flex-1 bg-gray-200 h-2 rounded-full overflow-hidden">
                                <div class="bg-green-600 h-full transition-all duration-300"
                                    style="width: {{ $item['persentase'] }}%"></div>
                            </div>

                            <!-- Jumlah -->
                            <span class="w-6 text-right text-gray-600">{{ $item['jumlah'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Form & Ulasan Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-8">

                <!-- Form Ulasan Saya -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">
                        {{ $myReview ? 'Edit Ulasan Anda' : 'Tulis Ulasan Anda' }}
                    </h3>

                    <!-- Alert -->
                    @if (session('success'))
                        <div id="alert"
                            class="bg-green-100 text-green-700 px-4 py-2 rounded-lg text-sm mb-4 border border-green-300">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div id="alert"
                            class="bg-red-100 text-red-700 px-4 py-2 rounded-lg text-sm mb-4 border border-red-300">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Form -->
                    <form
                        action="{{ $myReview
                            ? route('tourplace-review.update', [$tourPlace->subCategory->slug, $tourPlace->slug])
                            : route('tourplace-review.store', [$tourPlace->subCategory->slug, $tourPlace->slug]) }}"
                        method="POST" class="space-y-4">
                        @csrf
                        @if ($myReview)
                            @method('PUT')
                        @endif

                        <!-- Rating -->
                        <div class="md:w-2/3">
                            <label for="rating" class="block text-sm font-medium text-gray-700 mb-1">Rating</label>
                            <select id="rating" name="rating"
                                class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm focus:ring-1 focus:ring-green-600 focus:outline-none transition">
                                <option value="">Pilih rating</option>
                                @foreach ([5 => 'Luar Biasa', 4 => 'Bagus', 3 => 'Biasa', 2 => 'Buruk', 1 => 'Sangat Buruk'] as $key => $label)
                                    <option value="{{ $key }}" @selected(old('rating', $myReview->rating ?? '') == $key)>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('rating')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div>
                            <label for="comment" class="block text-sm font-medium text-gray-700 mb-1">Ulasan</label>
                            <textarea id="comment" name="comment" rows="5"
                                class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm focus:ring-1 focus:ring-green-600 focus:outline-none transition"
                                placeholder="Bagikan pengalaman Anda...">{{ old('comment', $myReview->comment ?? '') }}</textarea>
                            @error('comment')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tombol -->
                        <div class="text-right">
                            <button type="submit"
                                class="bg-green-600 text-white px-6 py-2 text-sm font-semibold rounded-full hover:bg-green-700 transition">
                                {{ $myReview ? 'Update Ulasan' : 'Kirim Ulasan' }}
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Daftar Ulasan Pengguna Lain -->
                <div>
                    <h3 id="review-list" class="text-lg font-semibold text-gray-800 mb-4">Ulasan Pengguna Lain</h3>

                    @forelse ($reviews as $review)
                        <div class="bg-white rounded-xl shadow-sm p-5 mb-5">
                            <div class="flex items-start justify-between mb-1">
                                <div class="text-sm font-semibold text-gray-800">{{ $review->user->name }}</div>
                                <div class="text-yellow-500 text-sm">
                                    @for ($i = 1; $i <= 5; $i++)
                                        {{ $i <= $review->rating ? '★' : '☆' }}
                                    @endfor
                                </div>
                            </div>
                            <p class="text-sm text-gray-700 mt-2">{{ $review->comment }}</p>
                            <div class="text-xs text-gray-400 mt-1">{{ $review->updated_at->diffForHumans() }}</div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-600">Belum ada ulasan dari pengguna lain.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    <!-- Scroll ke Alert Jika Ada -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const alertBox = document.getElementById('alert');
            if (alertBox) {
                alertBox.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    </script>

</x-main-layout>
