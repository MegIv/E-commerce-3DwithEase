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
            <div class="w-8 h-8 bg-black rounded-full flex items-center justify-center text-white font-bold">3D</div>
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
                            Get Started
                        </a>
                    @endif
                @endauth
            @endif
        </div>
    </nav>

    <header class="max-w-7xl mx-auto px-4 sm:px-8 pt-12 pb-20">
        <div class="max-w-4xl">
            <h1 class="text-5xl sm:text-7xl font-medium tracking-tight leading-[1.1] mb-6">
                INDUSTRIAL <br>
                <span class="text-orange-brand font-normal italic">3D PRINTING</span> SOLUTIONS
            </h1>
            <p class="text-gray-500 max-w-xl text-lg mb-8">
                The 3D-Print platform offers you the best resources to manufacture your parts from your 3D files with precision and speed.
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
                <img src="https://images.unsplash.com/photo-1631541909061-71e349d1f203?q=80&w=1905&auto=format&fit=crop" alt="3D Printing Product" class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                <div class="absolute bottom-4 left-4">
                    <span class="text-xs font-mono bg-white/90 px-2 py-1 rounded">Project — 2025</span>
                </div>
            </div>
            <div class="relative group overflow-hidden rounded-2xl h-64 bg-gray-100">
                <img src="https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?q=80&w=2070&auto=format&fit=crop" alt="Engineers working" class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
            </div>
            <div class="relative group overflow-hidden rounded-2xl h-64 bg-gray-100">
                <img src="https://images.unsplash.com/photo-1617791160536-598cf32026fb?q=80&w=1964&auto=format&fit=crop" alt="Finished Product" class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                <div class="absolute bottom-4 left-4">
                    <span class="text-3xl font-bold text-white">150+</span>
                    <p class="text-white text-xs opacity-80">Work of Clients</p>
                </div>
            </div>
        </div>
    </header>

    <section class="bg-[#111111] text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-8">
            <p class="text-center text-gray-400 text-sm mb-10">More Than 200+ Companies trusted Us Worldwide</p>
            <div class="flex flex-wrap justify-center gap-10 md:gap-20 opacity-60 grayscale">
                <span class="text-xl font-bold">Greenish</span>
                <span class="text-xl font-bold">Apple</span>
                <span class="text-xl font-bold">Google</span>
                <span class="text-xl font-bold">Amazon</span>
                <span class="text-xl font-bold">Leafe</span>
                <span class="text-xl font-bold">Mindfulness</span>
            </div>

            <div class="mt-24">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-light uppercase tracking-wide">Available Capacity In</h2>
                    <h2 class="text-4xl font-bold text-orange-brand mt-1">NUMBER OF MACHINES</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-0 border border-gray-800">
                    <div class="p-8 border-r border-gray-800 hover:bg-gray-900 transition">
                        <div class="flex justify-between items-start mb-8">
                            <h3 class="text-xl font-semibold">3D Plastic Printing</h3>
                            <div class="w-1 h-8 bg-orange-brand"></div>
                        </div>
                        <ul class="space-y-4 text-sm text-gray-400">
                            <li class="flex justify-between">
                                <span>Stereolithography</span>
                                <span class="text-white">17</span>
                            </li>
                            <li class="flex justify-between">
                                <span>Powder Laser Sintering</span>
                                <span class="text-white">44</span>
                            </li>
                            <li class="flex justify-between">
                                <span>MultiJet Fusion</span>
                                <span class="text-white">21</span>
                            </li>
                        </ul>
                    </div>

                    <div class="p-8 border-r border-gray-800 hover:bg-gray-900 transition">
                        <div class="flex justify-between items-start mb-8">
                            <h3 class="text-xl font-semibold">3D Metal Printing</h3>
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
                            <h3 class="text-xl font-semibold">Injection</h3>
                            <div class="w-1 h-8 bg-orange-brand"></div>
                        </div>
                        <ul class="space-y-4 text-sm text-gray-400">
                            <li class="flex justify-between">
                                <span>Vacuum cast</span>
                                <span class="text-white">28</span>
                            </li>
                            <li class="flex justify-between">
                                <span>Plastic Injection</span>
                                <span class="text-white">153</span>
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
                        Access industrial 3D printing facilities for plastic (SLA, SLS, MJF) and metal (SLM / DMLS), in small and large formats.
                    </p>
                    <div class="h-px w-full bg-gray-200 mt-6 group-hover:bg-orange-brand transition"></div>
                </div>

                <div class="group cursor-pointer">
                    <h3 class="text-2xl font-bold mb-2 text-orange-brand">VACUUM CASTING</h3>
                    <p class="text-gray-700 text-sm leading-relaxed max-w-sm">
                        An excellent alternative between 3D printing and traditional plastic injection. It delivers quality parts at competitive unit costs.
                    </p>
                    <div class="h-px w-full bg-orange-brand mt-6"></div>
                </div>

                <div class="group cursor-pointer">
                    <h3 class="text-2xl font-bold mb-2 group-hover:text-orange-brand transition">FINISHES</h3>
                    <p class="text-gray-500 text-sm leading-relaxed max-w-sm">
                        For a better visual effect, you have access to a wide range of finishes, from sandblasting to varnished paint, or even metalization.
                    </p>
                    <div class="h-px w-full bg-gray-200 mt-6 group-hover:bg-orange-brand transition"></div>
                </div>
            </div>

            <div class="relative h-[500px] w-full bg-gray-100 rounded-lg overflow-hidden">
                <img src="https://images.unsplash.com/photo-1565043589221-1a6a8bc66953?q=80&w=1935&auto=format&fit=crop" class="w-full h-full object-cover" alt="Industrial Machine">
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