<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - FoxEcom</title>
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
                <h2 class="text-3xl font-bold text-foxecom-dark">Welcome back</h2>
                <p class="mt-2 text-foxecom-gray">Sign in to your FoxEcom account</p>
            </div>

            <!-- Login Form -->
            <div class="foxecom-card p-8">
                <!-- Session Status -->
                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-foxecom-dark mb-2">
                            Email address
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
                                   placeholder="Enter your password">
                        </div>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember_me" name="remember" type="checkbox" 
                                   class="h-4 w-4 text-foxecom-orange focus:ring-foxecom-orange border-gray-300 rounded">
                            <label for="remember_me" class="ml-2 block text-sm text-foxecom-gray">
                                Remember me
                            </label>
                        </div>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-foxecom-orange hover:text-orange-600">
                                Forgot password?
                            </a>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            class="w-full bg-foxecom-orange hover:bg-orange-600 text-white font-bold py-3 px-4 rounded-lg transition duration-300 transform hover:scale-105 shadow-foxecom">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Sign in
                    </button>
                </form>

                <!-- Register Link -->
                <div class="mt-6 text-center">
                    <p class="text-foxecom-gray">
                        Don't have an account? 
                        <a href="{{ route('register') }}" class="text-foxecom-orange hover:text-orange-600 font-medium">
                            Sign up here
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>