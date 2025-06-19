<x-main-layout>

    <!-- Bagian Register -->
    <section class="min-h-screen flex items-center justify-center bg-gray-100 px-4 sm:px-6">
        <div class="flex flex-col md:flex-row w-full max-w-5xl bg-white shadow-lg rounded-lg overflow-hidden">

            <!-- Ilustrasi Gambar -->
            <div class="md:w-1/2 h-48 md:h-auto bg-cover bg-center relative"
                style="background-image: url('{{ asset('img/login-banner.jpg') }}')">
                <div class="absolute inset-0 bg-black/50"></div>
            </div>

            <!-- Form Register -->
            <div class="w-full md:w-1/2 p-4 sm:p-6 md:p-8 bg-white">
                <h2 class="text-2xl font-semibold text-[#486284] mb-6">Daftar Akun
                </h2>

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <!-- Nama -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" autofocus
                            class="w-full mt-1 py-1 text-sm px-3 border border-gray-300 rounded-md shadow-sm focus:border-[#486284] focus:ring-[#486284]" />
                        @error('name')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                            class="w-full mt-1 py-1 px-3 text-sm border border-gray-300 rounded-md shadow-sm focus:border-[#486284] focus:ring-[#486284]" />
                        @error('email')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div x-data="{ show: false }">
                        <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi</label>
                        <div class="relative">
                            <input :type="show ? 'text' : 'password'" id="password" name="password"
                                class="w-full mt-1 py-1 px-3 pr-10 text-sm border border-gray-300 rounded-md shadow-sm focus:border-[#486284] focus:ring-[#486284]" />

                            <button type="button" @click="show = !show"
                                class="absolute inset-y-0 right-0 flex items-center px-3 text-sm text-gray-500 focus:outline-none">
                                <x-icons.eye class="h-5 w-5" x-show="!show" />
                                <x-icons.eye-off class="h-5 w-5" x-show="show" />
                            </button>
                        </div>
                        @error('password')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Konfirmasi Password -->
                    <div x-data="{ show: false }">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                            Konfirmasi Kata Sandi
                        </label>
                        <div class="relative">
                            <input :type="show ? 'text' : 'password'" id="password_confirmation"
                                name="password_confirmation"
                                class="w-full mt-1 py-1 px-3 pr-10 text-sm border border-gray-300 rounded-md shadow-sm focus:border-[#486284] focus:ring-[#486284]" />

                            <button type="button" @click="show = !show"
                                class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 focus:outline-none">
                                <x-icons.eye class="h-5 w-5" x-show="!show" />
                                <x-icons.eye-off class="h-5 w-5" x-show="show" />
                            </button>
                        </div>
                        @error('password_confirmation')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tombol -->
                    <div>
                        <button type="submit"
                            class="w-full bg-[#486284] text-white py-2 px-4 rounded-md hover:bg-slate-700 transition duration-200">
                            Daftar
                        </button>
                    </div>

                    <!-- Sudah punya akun -->
                    <p class="text-sm text-center text-gray-700">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="text-[#486284] font-medium hover:underline">
                            Masuk di sini
                        </a>
                    </p>
                </form>
            </div>
        </div>
    </section>

</x-main-layout>
