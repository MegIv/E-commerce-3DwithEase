<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', '3DwithEase') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Instrument Sans', sans-serif; }
        .text-orange-brand { color: #FF6B00; }
        .bg-orange-brand { background-color: #FF6B00; }
        .border-orange-brand { border-color: #FF6B00; }
        .hover\:bg-orange-dark:hover { background-color: #e65100; }
    </style>
</head>
<body class="antialiased bg-white text-gray-900">

    <nav class="w-full py-6 px-4 sm:px-8 flex justify-between items-center border-b border-gray-100">
        <div class="flex items-center gap-2">
            <!-- <div class="w-8 h-8 bg-black rounded-full flex items-center justify-center text-white font-bold">3D</div> -->
            <img src="{{ asset('images/logoHead.png') }}" alt="Logo 3DwithEase" class="h-8 w-auto">
            <span class="text-xl font-bold tracking-tight">3DwithEase</span>
        </div>

        <div class="hidden md:flex gap-8 text-sm font-medium text-gray-600">
            <a href="#" class="hover:text-black transition">Home</a>
            <a href="#" class="hover:text-black transition">Services</a>
            <a href="#" class="hover:text-black transition">Pricing</a>
            <a href="#" class="hover:text-black transition">Blogs</a>
        </div>

        <div class="flex items-center gap-4">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-sm font-medium hover:text-orange-brand">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium hover:text-orange-brand">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="bg-orange-brand text-white px-5 py-2.5 rounded-full text-sm font-medium hover:bg-orange-dark transition">
                            Daftar
                        </a>
                    @endif
                @endauth
            @endif
        </div>
    </nav>

    <header class="max-w-7xl mx-auto px-4 sm:px-8 pt-12 pb-20">
        <div class="max-w-4xl">
            <h1 class="text-5xl sm:text-7xl font-medium tracking-tight leading-[1.1] mb-6">
                YOUR <br>
                <span class="text-orange-brand font-normal italic">3D PRINTING</span> SOLUTIONS
            </h1>
            <p class="text-gray-500 max-w-xl text-lg mb-8">
                3DwithEase menawarkan solusi melalui cetakkan 3D berkualitas dan customize-able sesuai yang anda butuhkan. 
                <!-- Platfrom 3D-Print menawarkan solusi manufaktur yang dapat di-kostumisasi sesuai kebutuhan anda dari Konsumen hingga Industri. -->
            </p>
            
            <div class="flex gap-4">
                <a href="{{ route('register') }}" class="bg-orange-brand text-white px-8 py-3 rounded-full font-medium hover:bg-orange-dark transition flex items-center gap-2">
                    3D Print Here
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5l15-15m0 0H8.25m11.25 0v11.25" />
                    </svg>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-16">
            <div class="relative group overflow-hidden rounded-2xl h-64 bg-gray-100">
                <img src="https://images.unsplash.com/photo-1611117775350-ac3950990985?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8M0QlMjBwcmludGluZ3xlbnwwfHwwfHx8MA%3D%3D" alt="3D Printing Product" class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                <div class="absolute bottom-4 left-4">
                    <span class="text-xs font-mono bg-white/90 px-2 py-1 rounded">Project — 2025</span>
                </div>
            </div>
            <div class="relative group overflow-hidden rounded-2xl h-64 bg-gray-100">
                <img src="https://images.unsplash.com/photo-1549563316-5384a923453e?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTV8fDNEJTIwcHJpbnRpbmd8ZW58MHx8MHx8fDA%3D" alt="Engineers working" class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
            </div>
            <div class="relative group overflow-hidden rounded-2xl h-64 bg-gray-100">
                <img src="https://plus.unsplash.com/premium_photo-1716396589596-d31f2d33c096?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MjV8fDNEJTIwcHJpbnRpbmd8ZW58MHx8MHx8fDA%3D" alt="Finished Product" class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                <div class="absolute bottom-4 left-4">
                    <span class="text-3xl font-bold text-white">150+</span>
                    <p class="text-white text-xs opacity-80">Work of Clients</p>
                </div>
            </div>
        </div>
    </header>

    {{-- SECTION: KATALOG PRODUK PUBLIC --}}
    <div class="py-16 bg-gray-50" id="katalog">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center mb-12">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Koleksi Aset 3D Terbaru
                </h2>
                <p class="mt-4 text-lg text-gray-500">
                    Telusuri karya terbaik dari para kreator kami.
                </p>
            </div>

            {{-- Grid Produk --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @foreach($products as $product)
                    <div class="bg-white rounded-xl shadow-sm hover:shadow-lg transition-shadow duration-300 overflow-hidden border border-gray-100 flex flex-col">
                        
                        {{-- Gambar Produk --}}
                        <div class="relative aspect-square bg-gray-200 overflow-hidden">
                            @if($product->image)
                                <img src="{{ '/Storage/'. $product->image }}" alt="{{ $product->name }}" class="object-cover w-full h-full hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="flex items-center justify-center h-full text-gray-400">No Image</div>
                            @endif
                            
                            {{-- Badge Toko --}}
                            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                                <p class="text-white text-xs font-medium truncate">{{ $product->store->store_name ?? 'Official Store' }}</p>
                            </div>
                        </div>

                        {{-- Info Produk --}}
                        <div class="p-5 flex-1 flex flex-col">
                            <h3 class="text-lg font-bold text-gray-900 truncate mb-1" title="{{ $product->name }}">
                                {{ $product->name }}
                            </h3>
                            <p class="text-sm text-gray-500 mb-4">{{ $product->category->name ?? 'Umum' }}</p>
                            
                            <div class="mt-auto flex items-center justify-between">
                                {{-- Harga Rupiah Konsisten --}}
                                <span class="text-indigo-600 font-bold text-lg">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </span>
                            </div>

                            {{-- LOGIC INTERAKSI (KUNCI FITUR INI) --}}
                            <div class="mt-4 pt-4 border-t border-gray-100">
                                @if(Route::has('login'))
                                    @auth
                                        {{-- JIKA SUDAH LOGIN (Role Buyer) --}}
                                        @if(Auth::user()->role === 'buyer')
                                            <form action="{{ route('cart.store') }}" method="POST" class="w-full">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" class="w-full flex justify-center items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 transition ease-in-out duration-150">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                                    </svg>
                                                    Tambah ke Keranjang
                                                </button>
                                            </form>
                                        @else
                                            {{-- User Login tapi Seller/Admin --}}
                                            <button disabled class="w-full px-4 py-2 bg-gray-300 rounded-lg font-semibold text-xs text-gray-500 uppercase cursor-not-allowed">
                                                Mode {{ ucfirst(Auth::user()->role) }}
                                            </button>
                                        @endif
                                    @else
                                        {{-- JIKA PUBLIC USER (BELUM LOGIN) --}}
                                        <a href="{{ route('login') }}" class="w-full flex justify-center items-center px-4 py-2 bg-white border border-indigo-600 rounded-lg font-semibold text-xs text-indigo-600 uppercase tracking-widest hover:bg-indigo-50 transition ease-in-out duration-150">
                                            Login untuk Membeli
                                        </a>
                                    @endauth
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Tombol Lihat Semua (Opsional) --}}
            <div class="mt-12 text-center">
                <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                    Lihat Selengkapnya &rarr;
                </a>
            </div>
        </div>
    </div>

    <section class="bg-[#111111] text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-8">
            <p class="text-center text-gray-400 text-sm mb-10">Bekerja sama dengan lebih dari 100+ Perusahaan</p>
            <div class="flex flex-wrap justify-center gap-10 md:gap-20 opacity-60 grayscale">
                <span class="text-xl font-bold">MakerWorld</span>
                <span class="text-xl font-bold">ThingVerse</span>
                <span class="text-xl font-bold">AutoDesk</span>
                <span class="text-xl font-bold">SketchFab</span>
                <span class="text-xl font-bold">FreeCad</span>
                <span class="text-xl font-bold">Printables</span>
            </div>

            <div class="mt-24">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-light uppercase tracking-wide">Kapasitas kami di</h2>
                    <h2 class="text-4xl font-bold text-orange-brand mt-1">DESIGNING & MESIN</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-0 border border-gray-800">
                    <div class="p-8 border-r border-gray-800 hover:bg-gray-900 transition">
                        <div class="flex justify-between items-start mb-8">
                            <h3 class="text-xl font-semibold">3D Printing Plastik</h3>
                            <div class="w-1 h-8 bg-orange-brand"></div>
                        </div>
                        <ul class="space-y-4 text-sm text-gray-400">
                            <li class="flex justify-between">
                                <span>Stereolithography/Resin</span>
                                <span class="text-white">17</span>
                            </li>
                            <li class="flex justify-between">
                                <span>Vacum Casting</span>
                                <span class="text-white">9</span>
                            </li>
                            <li class="flex justify-between">
                                <span>Multi-Jet Fusion Ink</span>
                                <span class="text-white">21</span>
                            </li>
                            <li class="flex justify-between">
                                <span>FDM Polylactic</span>
                                <span class="text-white">44</span>
                            </li>
                        </ul>
                    </div>

                    <div class="p-8 border-r border-gray-800 hover:bg-gray-900 transition">
                        <div class="flex justify-between items-start mb-8">
                            <h3 class="text-xl font-semibold">3D Printing Metal</h3>
                            <div class="w-1 h-8 bg-orange-brand"></div>
                        </div>
                        <ul class="space-y-4 text-sm text-gray-400">
                            <li class="flex justify-between">
                                <span>Selective Laser Melting (SLM)</span>
                                <span class="text-white">16</span>
                            </li>
                            <li class="flex justify-between">
                                <span>Direct Metal Laser Sintering</span>
                                <span class="text-white">8</span>
                            </li>
                        </ul>
                    </div>

                    <div class="p-8 hover:bg-gray-900 transition">
                        <div class="flex justify-between items-start mb-8">
                            <h3 class="text-xl font-semibold">Design avaibility </h3>
                            <div class="w-1 h-8 bg-orange-brand"></div>
                        </div>
                        <ul class="space-y-4 text-sm text-gray-400">
                            <li class="flex justify-between">
                                <span>Skala Industri</span>
                                <span class="text-white">100+</span>
                            </li>
                            <li class="flex justify-between">
                                <span>Skala Konsumen</span>
                                <span class="text-white">300+</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-8 grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            
            <div class="space-y-12">
                <div class="group cursor-pointer">
                    <h3 class="text-2xl font-bold mb-2 group-hover:text-orange-brand transition">3D PRINTING</h3>
                    <p class="text-gray-500 text-sm leading-relaxed max-w-sm">
                        Akses fasilitas 3D Printing sekelas Industri untuk plastik (SLA, SLS, MJF) dan metal (SLM / DMLS) dalam format kecil atau besar
                    </p>
                    <div class="h-px w-full bg-gray-200 mt-6 group-hover:bg-orange-brand transition"></div>
                </div>

                <div class="group cursor-pointer">
                    <h3 class="text-2xl font-bold mb-2 text-orange-brand">VACUUM CASTING</h3>
                    <p class="text-gray-700 text-sm leading-relaxed max-w-sm">
                        Alternatif dari 3D printing plastik injeksi tradisional. Memberikan hasil yang berkualitass dengan harga yang bersaing.
                    </p>
                    <div class="h-px w-full bg-orange-brand mt-6"></div>
                </div>

                <div class="group cursor-pointer">
                    <h3 class="text-2xl font-bold mb-2 group-hover:text-orange-brand transition">FINISHES</h3>
                    <p class="text-gray-500 text-sm leading-relaxed max-w-sm">
                        Untuk hasil post-proccessing yang lebih baik, anda bisa meng-akses banyak pilihan finishing. Mulai dari Sandblasting, Chemical Varnishing, bahkan Metalization.
                    </p>
                    <div class="h-px w-full bg-gray-200 mt-6 group-hover:bg-orange-brand transition"></div>
                </div>
            </div>

            <div class="relative h-[500px] w-full bg-gray-100 rounded-lg overflow-hidden">
                <img src="https://plus.unsplash.com/premium_photo-1715876681035-4d8b010bab0a?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NjF8fDNEJTIwcHJpbnRpbmd8ZW58MHx8MHx8fDA%3Ds" class="w-full h-full object-cover" alt="Industrial Machine">
                <div class="absolute top-0 right-0 w-24 h-24 bg-orange-brand/20"></div>
                <div class="absolute bottom-0 left-0 w-32 h-32 bg-gray-900/10"></div>
            </div>
        </div>
    </section>

    <footer class="bg-orange-brand text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-8 flex flex-col md:flex-row justify-between items-center">
            <div>
                <h2 class="text-3xl font-light">READY TO</h2>
                <h2 class="text-4xl font-bold">START YOUR MANUFACTURING?</h2>
            </div>
            <div class="mt-8 md:mt-0">
                <a href="{{ route('register') }}" class="inline-block bg-white text-orange-brand px-8 py-3 rounded-full font-bold hover:bg-gray-100 transition">
                    Contact Us
                </a>
            </div>
        </div>
    </footer>

</body>
</html>