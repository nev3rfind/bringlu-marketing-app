@extends('layouts.app')
@section('content')
<!-- Landing Page -->
<section class="relative min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-100">
    <div class="container mx-auto px-4 text-center">
        <!-- Main Heading -->
        <div class="max-w-4xl mx-auto">
            <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold text-bringlu-blue mb-8">
                Foxecom Referral Platform
            </h1>
            
            <p class="text-xl md:text-2xl text-bringlu-grey mb-12 max-w-2xl mx-auto">
<<<<<<< HEAD
                Referral management system
=======
                Connect businesses with advertisers through our comprehensive referral management system
>>>>>>> 5f6d59fae498ee0f5d648c7d8c135b5d68846f59
            </p>
            
            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-6 justify-center items-center">
                <a href="{{ route('login') }}" class="w-full sm:w-auto">
                    <button type="button" class="w-full sm:w-auto bg-bringlu-blue hover:bg-blue-700 text-white font-bold py-4 px-8 rounded-lg text-lg transition duration-300 transform hover:scale-105 shadow-lg">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Login to Continue
                    </button>
                </a>
                
                <a href="{{ route('register') }}" class="w-full sm:w-auto">
                    <button type="button" class="w-full sm:w-auto bg-green-500 hover:bg-green-600 text-white font-bold py-4 px-8 rounded-lg text-lg transition duration-300 transform hover:scale-105 shadow-lg">
                        <i class="fas fa-user-plus mr-2"></i>
                        Register Now
                    </button>
                </a>
            </div>
            
            <!-- Additional Info -->
            <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-8 max-w-4xl mx-auto">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="text-bringlu-blue text-3xl mb-4">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Connect</h3>
                    <p class="text-gray-600">Bridge the gap between businesses and advertisers</p>
                </div>
                
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="text-bringlu-blue text-3xl mb-4">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Grow</h3>
                    <p class="text-gray-600">Expand your network and increase revenue</p>
                </div>
                
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="text-bringlu-blue text-3xl mb-4">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Manage</h3>
                    <p class="text-gray-600">Comprehensive referral management tools</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection