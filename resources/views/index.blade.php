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
    <section class="relative min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-50 to-orange-50">
        <div class="container mx-auto px-4 text-center">
            <!-- FoxEcom Logo -->
            <div class="mb-8">
                <div class="w-20 h-20 bg-orange-500 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <span class="text-white text-2xl font-bold">FE</span>
                </div>
            </div>
            
            <!-- Main Heading -->
            <div class="max-w-4xl mx-auto">
                <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold text-gray-900 mb-8">
                    FoxEcom Referral Platform
                </h1>
                
                <p class="text-xl md:text-2xl text-gray-600 mb-12 max-w-2xl mx-auto">
                    Best referral management system ever!
                </p>
                
                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-6 justify-center items-center mb-16">
                    <a href="{{ route('login') }}" class="w-full sm:w-auto">
                        <button type="button" class="w-full sm:w-auto bg-orange-500 hover:bg-orange-600 text-white font-bold py-4 px-8 rounded-lg text-lg transition duration-300 transform hover:scale-105 shadow-lg">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            Login to Continue
                        </button>
                    </a>
                    
                    <a href="{{ route('register') }}" class="w-full sm:w-auto">
                        <button type="button" class="w-full sm:w-auto bg-white hover:bg-gray-50 text-gray-900 border-2 border-orange-500 font-bold py-4 px-8 rounded-lg text-lg transition duration-300 transform hover:scale-105 shadow-lg">
                            <i class="fas fa-user-plus mr-2"></i>
                            Register Now
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </section>
</body>
</html>