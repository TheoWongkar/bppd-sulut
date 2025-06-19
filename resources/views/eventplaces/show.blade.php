<x-main-layout>

    <!-- Bagian Show Event -->
    <section class="container mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <h2 class="text-md md:text-xl text-center md:text-left font-semibold mb-4 text-[#486284]">
            {{ $eventPlace->business_name }}</h2>

        <!-- Waktu & Status -->
        <div class="flex flex-col md:flex-row items-center text-sm text-gray-500 gap-2 mb-5">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                class="bi bi-calendar-week" viewBox="0 0 16 16">
                <path
                    d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5z" />
                <path
                    d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z" />
            </svg>
            <span>
                {{ \Carbon\Carbon::parse($eventPlace->start_time)->format('d M Y H:i') }} -
                {{ \Carbon\Carbon::parse($eventPlace->end_time)->format('d M Y H:i') }}
            </span>

            @php $status = $eventPlace->status; @endphp
            <span
                class="px-2 py-1 text-xs font-medium rounded-full shadow
                {{ $status['type'] === 'upcoming' ? 'bg-blue-600 text-white' : '' }}
                {{ $status['type'] === 'ongoing' ? 'bg-green-600 text-white' : '' }}
                {{ $status['type'] === 'ended' ? 'bg-gray-500 text-white' : '' }}">
                {{ $status['text'] }}
            </span>
        </div>

        <!-- Layout Event -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Bagian Gambar -->
            <div class="md:col-span-2" x-data="{
                mainImage: '{{ $eventPlace->firstImage ? asset('storage/' . $eventPlace->firstImage->image) : asset('img/placeholder.webp') }}'
            }">
                <!-- Gambar Utama -->
                <div class="aspect-video rounded-xl overflow-hidden shadow-md mb-4">
                    <img :src="mainImage" alt="Thumbnail Event"
                        class="w-full h-full object-cover transition duration-300">
                </div>

                <!-- Galeri -->
                <div class="flex md:grid md:grid-cols-3 gap-2 overflow-x-auto md:overflow-visible">
                    @forelse ($eventPlace->images as $image)
                        @php
                            $imgSrc = asset('storage/' . $image->image);
                        @endphp
                        <img src="{{ $imgSrc }}" alt="Galeri Event"
                            class="w-24 md:w-full h-24 object-cover rounded-md flex-shrink-0 border-2 border-transparent hover:border-[#486284] cursor-pointer transition duration-200"
                            @click="mainImage = '{{ $imgSrc }}'">
                    @empty
                        @for ($i = 0; $i < 4; $i++)
                            <img src="{{ asset('img/placeholder.webp') }}" alt="Galeri Kosong"
                                class="w-24 md:w-full h-24 object-cover rounded-md flex-shrink-0 border border-gray-300">
                        @endfor
                    @endforelse
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Box Pendaftaran -->
                <div class="bg-white p-4 rounded-xl shadow-md text-center">
                    <p class="mb-3 text-sm">
                        Daftarkan dirimu dan jadilah bagian dari event ini
                    </p>
                    <a href="#"
                        class="inline-block bg-green-600 hover:bg-green-700 text-sm text-white font-semibold w-1/2 py-2 rounded-full transition-color">
                        Daftar
                    </a>
                </div>

                <!-- Box Informasi -->
                <div class="bg-white p-4 rounded-xl shadow-md">
                    <h2 class="text-lg font-semibold mb-2 text-[#486284]">Informasi</h2>
                    <p class="text-sm mb-3">{{ $eventPlace->description }}</p>
                    <div class="flex flex-col gap-3 text-sm text-gray-700">

                        <!-- Instagram -->
                        @if ($eventPlace->instagram_link)
                            <a href="{{ $eventPlace->instagram_link }}"
                                class="flex items-center gap-2 text-[#486284] hover:underline">
                                <x-icons.instagram />
                                Instagram
                            </a>
                        @endif

                        <!-- Facebook -->
                        @if ($eventPlace->facebook_link)
                            <a href="{{ $eventPlace->facebook_link }}"
                                class="flex items-center gap-2 text-[#486284] hover:underline">
                                <x-icons.facebook />
                                Facebook
                            </a>
                        @endif

                        <!-- Tiket Masuk -->
                        <p class="flex items-center gap-2 text-[#486284]">
                            <x-icons.ticket />
                            {{ $eventPlace->ticket_price == 0 ? 'Gratis' : 'Rp ' . number_format($eventPlace->ticket_price, 0, ',', '.') }}
                        </p>

                        <!-- Lokasi -->
                        <p class="flex items-center gap-2 text-[#486284]">
                            <x-icons.location />
                            {{ $eventPlace->address }}
                        </p>
                    </div>
                </div>

                <!-- Gmaps -->
                <iframe src="{{ $eventPlace->gmaps_link }}" width="100%" height="200" style="border:0;"
                    allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="rounded-xl">
                </iframe>
            </div>
        </div>
    </section>

</x-main-layout>
