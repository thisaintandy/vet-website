<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navigation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <style>
        .banner-content {
            z-index: 2;
            text-align: left;
        }
        .banner h1 {
            font-size: 2em;
            color: #333333;
            margin: 0;
        }
        .banner p {
            font-size: 1em;
            color: #666666;
            margin: 10px 0;
        }
        .banner .cta-button {
            background-color: #0070f3;
            color: #ffffff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 1em;
            cursor: pointer;
            text-transform: uppercase;
        }
        .banner .cta-subtext {
            font-size: 1em;
            color: #666666;
            margin-top: 10px;
        }
        .banner img {
            max-width: 300px;
            height: auto;
            z-index: 2;
        }
        .banner .overlay {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 50%;
            background: linear-gradient(to bottom, rgba(255, 255, 255, 0), rgba(0, 112, 243, 1));
            z-index: 1;
        }
    </style>
</head>
<body>
    <nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
        <!-- Primary Navigation Menu -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <!-- Logo -->
                    <div class="shrink-0 flex items-center">
                        <a href="{{ route('dashboard') }}">
                            <img src="{{ url('/images/paw.png') }}" alt="Dog" class="mx-auto max-w-11">
                        </a>
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            {{ __('Home') }}
                        </x-nav-link>
                    </div>
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <x-nav-link :href="route('book.index')" :active="request()->routeIs('book.index')">
                            {{ __('Book Now') }}
                        </x-nav-link>
                    </div>
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <x-nav-link :href="route('appointments.index')" :active="request()->routeIs('appointments.index')">
                            {{ __('Appointments') }}
                        </x-nav-link>
                    </div>
                </div>

                <!-- Hamburger -->
                <div class="-me-2 flex items-center sm:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
            </div>
        </div>
    </nav>

    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                @if (Route::has('login') || Route::has('admin.login'))
                    <nav class="-mx-3 flex flex-1 justify-end">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                Log in
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                    Register
                                </a>
                            @endif
                        @endauth

                        @if (Auth::guard('admin')->check())
                            <a href="{{ url('admin/dashboard') }}" class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                Admin Dashboard
                            </a>
                        @else
                            <a href="{{ url('admin/login') }}" class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                Admin
                            </a>
                        @endif
                    </nav>
                @endif
            </div>
        </div>
    </header>

    <main>
        <div>
            <div style="margin-top: 100px; margin-left: 25%; margin-right: 50px; padding-right: 200px;">
                <h1 style="font-size: 5rem; font-weight:bold">Helping Paws Clinic</h1>
                <h2 style="font-size: 2rem; font-weight:bold">Always here to help you.</h2>
            </div>
        </div>

        <div class="py-12"></div>

        <!-- Banner at the bottom -->
        <div class="banner">
            <div class="banner-content" style="margin-left: 25%;">
                <h1>Linking your pets to our very best!</h1>
                <p>Get your pet's medical service with our professional veterinarians based in the Philippines.</p>
                <button class="cta-button">24/7 Customer Service</button>
                <p class="cta-subtext">We're here whenever you need us!</p>
            </div>
            <img src="{{ url('/images/dog.png') }}" alt="Dog" class="mx-auto" style="max-width: 100%; max-height: 100vh; height: auto; width: auto">
        </div>
    </main>
</body>
</html>
