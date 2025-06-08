<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register - FoxEcom</title>
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased font-Poppins bg-foxecom-light">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <!-- Header -->
            <div class="text-center">
                <div class="w-16 h-16 bg-foxecom-orange rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-white text-xl font-bold">FE</span>
                </div>
                <h2 class="text-3xl font-bold text-foxecom-dark">Join FoxEcom</h2>
                <p class="mt-2 text-foxecom-gray">You are steps away from joining the affiliate network</p>
            </div>

            <!-- Register Form -->
            <div class="foxecom-card p-8">
                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <!-- First Name -->
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-foxecom-dark mb-2">
                            First name
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user text-foxecom-gray"></i>
                            </div>
                            <input id="first_name" name="first_name" type="text" required 
                                   class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-foxecom-orange focus:border-transparent"
                                   placeholder="John" value="{{ old('first_name') }}">
                        </div>
                        @error('first_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Last Name -->
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-foxecom-dark mb-2">
                            Last name
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user text-foxecom-gray"></i>
                            </div>
                            <input id="last_name" name="last_name" type="text" required 
                                   class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-foxecom-orange focus:border-transparent"
                                   placeholder="Doe" value="{{ old('last_name') }}">
                        </div>
                        @error('last_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-foxecom-dark mb-2">
                            E-mail address
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-foxecom-gray"></i>
                            </div>
                            <input id="email" name="email" type="email" required 
                                   class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-foxecom-orange focus:border-transparent"
                                   placeholder="you@example.com" value="{{ old('email') }}">
                        </div>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone number -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-foxecom-dark mb-2">
                            Phone number
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-phone text-foxecom-gray"></i>
                            </div>
                            <input id="phone" name="phone" type="tel" required 
                                   class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-foxecom-orange focus:border-transparent"
                                   placeholder="+1 (555) 123-4567" value="{{ old('phone') }}">
                        </div>
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-foxecom-dark mb-2">
                            Password
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-foxecom-gray"></i>
                            </div>
                            <input id="password" name="password" type="password" required 
                                   class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-foxecom-orange focus:border-transparent"
                                   placeholder="Minimum 6 characters">
                        </div>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-foxecom-dark mb-2">
                            Confirm Password
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-foxecom-gray"></i>
                            </div>
                            <input id="password_confirmation" name="password_confirmation" type="password" required 
                                   class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-foxecom-orange focus:border-transparent"
                                   placeholder="Confirm your password">
                        </div>
                        @error('password_confirmation')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Account Type -->
                    <div>
                        <label class="block text-sm font-medium text-foxecom-dark mb-3">Select account type</label>
                        <div class="space-y-3">
                            <div class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50">
                                <input id="partner" type="radio" value="2" name="account_type" 
                                       class="h-4 w-4 text-foxecom-orange focus:ring-foxecom-orange border-gray-300">
                                <label for="partner" class="ml-3 text-sm font-medium text-foxecom-dark">
                                    FoxEcom Partner
                                </label>
                            </div>
                            <div class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50">
                                <input id="customer" type="radio" value="3" name="account_type" 
                                       class="h-4 w-4 text-foxecom-orange focus:ring-foxecom-orange border-gray-300">
                                <label for="customer" class="ml-3 text-sm font-medium text-foxecom-dark">
                                    FoxEcom Customer
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            class="w-full bg-foxecom-orange hover:bg-orange-600 text-white font-bold py-3 px-4 rounded-lg transition duration-300 transform hover:scale-105 shadow-foxecom">
                        <i class="fas fa-user-plus mr-2"></i>
                        Continue
                    </button>
                </form>

                <!-- Login Link -->
                <div class="mt-6 text-center">
                    <p class="text-foxecom-gray">
                        Already have an account? 
                        <a href="{{ route('login') }}" class="text-foxecom-orange hover:text-orange-600 font-medium">
                            Log in here
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>