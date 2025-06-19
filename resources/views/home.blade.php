<x-main-layout>

    <!-- Bagian Header -->
    <header class="relative">
        <img src="{{ asset('img/home-banner.jpg') }}" alt="Header Image" class="w-full h-64 md:h-96 object-cover">

        <div class="absolute inset-0 bg-black/40 flex flex-col items-center justify-center text-center px-4">
            <h1 class="text-white text-2xl md:text-4xl font-bold">Welcome to Sulawesi Utara</h1>
            <p class="text-white text-sm mt-2 max-w-2xl text-balance">
                Looking for ideas this week? Explore exciting destinations, try delicious local food,
                and don’t miss the latest events around you!
            </p>
        </div>
    </header>

    <!-- Bagian Rekomendasi -->
    <section class="container mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <h2 class="text-md md:text-xl font-semibold mb-8 uppercase text-[#486284]">Rekomendasi</h2>

        <div class="flex justify-center flex-wrap gap-8 md:gap-16">
            <!-- Icon Menu Item -->
            @php
                $recomendations = [
                    [
                        'img' => 'https://cdn.pixabay.com/photo/2018/05/21/22/44/logo-3419889_960_720.png',
                        'label' => 'Pegunungan',
                        'slug' => 'gunung',
                        'route' => 'tourplace.index',
                    ],
                    [
                        'img' =>
                            'https://png.pngtree.com/png-clipart/20230521/original/pngtree-beach-logo-design-vector-or-t-shirt-png-image_9166769.png',
                        'label' => 'Pantai',
                        'slug' => 'pantai',
                        'route' => 'tourplace.index',
                    ],
                    [
                        'img' =>
                            'https://png.pngtree.com/png-vector/20220718/ourmid/pngtree-culiner-logo-illustration-png-image_6005675.png',
                        'label' => 'Kuliner',
                        'slug' => null,
                        'route' => 'culinaryplace.index',
                    ],
                    [
                        'img' =>
                            'https://png.pngtree.com/png-vector/20240529/ourmid/pngtree-an-icon-for-an-island-logo-vector-png-image_6967911.png',
                        'label' => 'Pulau',
                        'slug' => 'pulau',
                        'route' => 'tourplace.index',
                    ],
                    [
                        'img' => 'https://images.icon-icons.com/2642/PNG/512/google_map_location_logo_icon_159350.png',
                        'label' => 'Destinasi',
                        'slug' => null,
                        'route' => 'tourplace.index',
                    ],
                ];
            @endphp

            @foreach ($recomendations as $item)
                <a href="{{ route($item['route'], ['category' => $item['slug']]) }}"
                    class="flex flex-col items-center w-24">
                    <img src="{{ $item['img'] }}" alt="Rekomendasi {{ $item['label'] }}"
                        class="w-20 h-20 object-contain mb-2">
                    <span class="text-sm font-medium text-center">{{ $item['label'] }}</span>
                </a>
            @endforeach
        </div>
    </section>

    <!-- Bagian Events -->
    <section class="container mx-auto py-10 px-4 sm:px-6 lg:px-8" x-data="{ tab: 'event' }">

        <!-- Tabs -->
        <div class="flex justify-center mb-10">
            <div class="bg-white shadow-md rounded-lg overflow-hidden inline-flex text-sm">
                <button @click="tab = 'event'"
                    :class="tab === 'event' ? 'bg-[#486284] text-white' : 'hover:bg-gray-200 text-gray-500'"
                    class="px-6 py-2 font-semibold transition">Event</button>
                <button @click="tab = 'calendar'"
                    :class="tab === 'calendar' ? 'bg-[#486284] text-white' : 'hover:bg-gray-200 text-gray-500'"
                    class="px-6 py-2 font-semibold transition">Kalender</button>
            </div>
        </div>

        <!-- Search Form -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-10" x-show="tab === 'event'">
            <h3 class="text-md md:text-xl font-semibold uppercase text-[#486284] text-center md:text-left">Event</h3>
            <form id="searchEventForm" action="{{ route('home') }}" method="GET" class="w-full md:w-1/4">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari event..."
                        autocomplete="off"
                        class="w-full border border-[#486284] rounded-xl py-2 pl-5  focus:outline-none focus:ring-2 focus:ring-[#3b5d85] focus:border-transparent">
                    <svg class="absolute right-3 top-2.5 w-5 h-5 text-[#486284]" fill="none" stroke="currentColor"
                        stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
                    </svg>
                </div>
            </form>
        </div>

        <!-- Events Card -->
        <div x-show="tab === 'event'" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse ($eventPlaces as $eventPlace)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition">
                    <a href="{{ route('eventplace.show', [$eventPlace->subCategory->slug, $eventPlace->slug]) }}">
                        @php $status = $eventPlace->status; @endphp
                        <div class="relative aspect-video w-full">
                            <img src="{{ $eventPlace->firstImage ? asset('storage/' . $eventPlace->firstImage->image) : asset('img/placeholder.webp') }}"
                                alt="Event" class="w-full h-full object-cover">
                            <span
                                class="absolute top-2 left-2 px-3 py-1 text-xs font-medium rounded-full shadow
                            {{ $status['type'] === 'upcoming' ? 'bg-blue-600 text-white' : '' }}
                            {{ $status['type'] === 'ongoing' ? 'bg-green-600 text-white' : '' }}
                            {{ $status['type'] === 'ended' ? 'bg-gray-500 text-white' : '' }}">
                                {{ $status['text'] }}
                            </span>
                        </div>
                        <div class="p-4">
                            <span class="block text-xs text-center text-gray-500">
                                {{ \Carbon\Carbon::parse($eventPlace->start_time)->format('d/m/Y H:i') }} -
                                {{ \Carbon\Carbon::parse($eventPlace->end_time)->format('d/m/Y H:i') }}
                            </span>
                            <h3 class="font-semibold my-2 text-[#486284] line-clamp-2">{{ $eventPlace->business_name }}
                            </h3>
                            <p class="text-xs line-clamp-3">{{ $eventPlace->description }}</p>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-span-full text-center text-gray-500">
                    Tidak ada event yang ditemukan.
                </div>
            @endforelse
        </div>

        <!-- Kalender View -->
        <div x-show="tab === 'calendar'" class="bg-white p-6 rounded-xl shadow-md">
            <h3 class="text-xl font-semibold text-[#486284] mb-4">Kalender Event</h3>
            <div id="calendar"></div>
        </div>

        <!-- Paginator -->
        <div class="mt-10" x-show="tab === 'event'">
            {{ $eventPlaces->links('pagination::main') }}
        </div>
    </section>

    <!-- Debounce Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('searchEventForm');
            const input = form.querySelector('input[name="search"]');
            let timer;

            // Saat mengetik, simpan scroll dan submit setelah delay
            input.addEventListener('input', () => {
                clearTimeout(timer);
                timer = setTimeout(() => {
                    localStorage.setItem('scrollPosition', window.scrollY);
                    form.submit();
                }, 700);
            });

            // Kembalikan scroll jika tersedia
            const scrollY = localStorage.getItem('scrollPosition');
            if (scrollY !== null) {
                window.scrollTo(0, parseInt(scrollY));
                localStorage.removeItem('scrollPosition');
            }
        });
    </script>

</x-main-layout>
