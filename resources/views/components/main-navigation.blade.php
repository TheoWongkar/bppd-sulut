<!-- Bagian Navigasi -->
<nav class="bg-white shadow-sm border-b border-blue-200 py-2 text-[#486284]" x-data="{ open: false }">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            <!-- Logo -->
            <div class="flex items-center gap-3">
                <img src="{{ asset('img/application-logo.svg') }}" alt="Logo Badan Promosi Pariwisata Daerah Sulut"
                    class="h-12 w-12 object-contain" />

                <div class="leading-none">
                    <a href="{{ route('home') }}" class="block">
                        <h1 class="text-sm font-semibold uppercase leading-none text-[#486284]">
                            Badan Promosi <span class="block">Pariwisata Daerah</span>
                        </h1>
                        <span class="text-xs text-gray-500">Provinsi Sulawesi Utara</span>
                    </a>
                </div>
            </div>

            <!-- Menu Desktop -->
            <div class="hidden md:flex items-center space-x-6 text-sm font-medium">
                <a href="{{ route('home') }}" class="hover:text-[#10B981] transition-colors">Beranda</a>
                <a href="#" class="hover:text-[#10B981] transition-colors">Telusuri & Pesan</a>
                <a href="#" class="hover:text-[#10B981] transition-colors">Kuliner</a>
                <a href="#" class="hover:text-[#10B981] transition-colors">Tentang Kami</a>
                <a href="#" class="hover:text-[#10B981] transition-colors">Login</a>
            </div>

            <!-- Tombol Hamburger (Mobile) -->
            <div class="md:hidden">
                <button @click="open = true" class="focus:outline-none focus:ring-2 focus:ring-[#486284] rounded"
                    aria-label="Buka menu">
                    <svg class="w-6 h-6 text-[#486284]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Overlay -->
    <div x-show="open" x-transition.opacity class="fixed inset-0 bg-black/50 z-40 md:hidden" @click="open = false"
        aria-hidden="true">
    </div>

    <!-- Sidebar Mobile -->
    <div x-show="open" x-transition:enter="transition transform ease-out duration-300"
        x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
        x-transition:leave="transition transform ease-in duration-200" x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
        class="fixed top-0 right-0 w-64 h-full bg-white z-50 p-6 shadow-xl md:hidden" style="display: none;">

        <!-- Tombol Tutup -->
        <button @click="open = false"
            class="absolute top-4 right-4 text-gray-500 focus:outline-none focus:ring-2 focus:ring-[#486284]"
            aria-label="Tutup menu">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <!-- Menu Sidebar -->
        <nav class="mt-8 flex flex-col space-y-4 text-sm font-medium">
            <a href="{{ route('home') }}" class="hover:text-[#10B981] transition-colors">Beranda</a>
            <a href="#" class="hover:text-[#10B981] transition-colors">Telusuri & Pesan</a>
            <a href="#" class="hover:text-[#10B981] transition-colors">Kuliner</a>
            <a href="#" class="hover:text-[#10B981] transition-colors">Tentang Kami</a>
            <a href="#" class="hover:text-[#10B981] transition-colors">Login</a>
        </nav>
    </div>
</nav>
