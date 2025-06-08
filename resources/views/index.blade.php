<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>FoxEcom Referral Platform</title>
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased font-Poppins bg-foxecom-light">
    <!-- Landing Page -->
    <section class="relative min-h-screen flex items-center justify-center">
        <div class="container mx-auto px-4 text-center">
            <!-- FoxEcom Logo -->
            <div class="mb-8">
                <div class="w-20 h-20 bg-foxecom-orange rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-white text-2xl font-bold">FE</span>
                </div>
            </div>
            
            <!-- Main Heading -->
            <div class="max-w-4xl mx-auto">
                <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold text-foxecom-dark mb-8">
                    FoxEcom Referral Platform
                </h1>
                
                <p class="text-xl md:text-2xl text-foxecom-gray mb-12 max-w-2xl mx-auto">
                    Connect businesses with advertisers through our comprehensive referral management system
                </p>
                
                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-6 justify-center items-center">
                    <a href="{{ route('login') }}" class="w-full sm:w-auto">
                        <button type="button" class="w-full sm:w-auto bg-foxecom-orange hover:bg-orange-600 text-white font-bold py-4 px-8 rounded-lg text-lg transition duration-300 transform hover:scale-105 shadow-foxecom">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            Login to Continue
                        </button>
                    </a>
                    
                    <a href="{{ route('register') }}" class="w-full sm:w-auto">
                        <button type="button" class="w-full sm:w-auto bg-white hover:bg-gray-50 text-foxecom-dark border-2 border-foxecom-orange font-bold py-4 px-8 rounded-lg text-lg transition duration-300 transform hover:scale-105 shadow-foxecom">
                            <i class="fas fa-user-plus mr-2"></i>
                            Register Now
                        </button>
                    </a>
                </div>
                
                <!-- Additional Info -->
                <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-8 max-w-4xl mx-auto">
                    <div class="foxecom-card p-6">
                        <div class="text-foxecom-orange text-3xl mb-4">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-2 text-foxecom-dark">Connect</h3>
                        <p class="text-foxecom-gray">Bridge the gap between businesses and advertisers</p>
                    </div>
                    
                    <div class="foxecom-card p-6">
                        <div class="text-foxecom-orange text-3xl mb-4">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-2 text-foxecom-dark">Grow</h3>
                        <p class="text-foxecom-gray">Expand your network and increase revenue</p>
                    </div>
                    
                    <div class="foxecom-card p-6">
                        <div class="text-foxecom-orange text-3xl mb-4">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-2 text-foxecom-dark">Manage</h3>
                        <p class="text-foxecom-gray">Comprehensive referral management tools</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>