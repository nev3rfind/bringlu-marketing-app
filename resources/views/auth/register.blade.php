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
        <div class="max-w-2xl w-full space-y-8">
            <!-- Header -->
            <div class="text-center">
                <div class="w-16 h-16 bg-foxecom-orange rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-white text-xl font-bold">FE</span>
                </div>
                <h2 class="text-3xl font-bold text-foxecom-dark">Join FoxEcom</h2>
                <p class="mt-2 text-foxecom-gray">Partner Registration Form</p>
            </div>

            <!-- Register Form -->
            <div class="foxecom-card p-8">
                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <!-- Personal Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- First Name -->
                        <div>
                            <label for="first_name" class="block text-sm font-medium text-foxecom-dark mb-2">
                                First name *
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
                                Last name *
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
                    </div>

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-foxecom-dark mb-2">
                            E-mail address *
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
                            Phone number *
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

                    <!-- Title/Role -->
                    <div>
                        <label class="block text-sm font-medium text-foxecom-dark mb-3">Which title describe you the best? *</label>
                        <div class="space-y-3">
                            <div class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50">
                                <input id="solo_developer" type="radio" value="Solo developer" name="title" 
                                       class="h-4 w-4 text-foxecom-orange focus:ring-foxecom-orange border-gray-300"
                                       {{ old('title') == 'Solo developer' ? 'checked' : '' }}>
                                <label for="solo_developer" class="ml-3 text-sm font-medium text-foxecom-dark">
                                    Solo developer
                                </label>
                            </div>
                            <div class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50">
                                <input id="agency" type="radio" value="Agency" name="title" 
                                       class="h-4 w-4 text-foxecom-orange focus:ring-foxecom-orange border-gray-300"
                                       {{ old('title') == 'Agency' ? 'checked' : '' }}>
                                <label for="agency" class="ml-3 text-sm font-medium text-foxecom-dark">
                                    Agency
                                </label>
                            </div>
                            <div class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50">
                                <input id="merchants" type="radio" value="Merchants or store owners" name="title" 
                                       class="h-4 w-4 text-foxecom-orange focus:ring-foxecom-orange border-gray-300"
                                       {{ old('title') == 'Merchants or store owners' ? 'checked' : '' }}>
                                <label for="merchants" class="ml-3 text-sm font-medium text-foxecom-dark">
                                    Merchants or store owners
                                </label>
                            </div>
                            <div class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50">
                                <input id="other_title" type="radio" value="Other" name="title" 
                                       class="h-4 w-4 text-foxecom-orange focus:ring-foxecom-orange border-gray-300"
                                       {{ old('title') == 'Other' ? 'checked' : '' }}
                                       onchange="toggleOtherInput()">
                                <label for="other_title" class="ml-3 text-sm font-medium text-foxecom-dark">
                                    Other:
                                </label>
                                <input type="text" name="other_title" id="other_title_input" 
                                       class="ml-2 flex-1 border-0 border-b border-gray-300 focus:border-foxecom-orange focus:ring-0 bg-transparent"
                                       placeholder="Please specify" value="{{ old('other_title') }}"
                                       style="display: {{ old('title') == 'Other' ? 'block' : 'none' }};">
                            </div>
                        </div>
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Company Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Company Name -->
                        <div>
                            <label for="company_name" class="block text-sm font-medium text-foxecom-dark mb-2">
                                Company name *
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-building text-foxecom-gray"></i>
                                </div>
                                <input id="company_name" name="company_name" type="text" required 
                                       class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-foxecom-orange focus:border-transparent"
                                       placeholder="Your Company Ltd" value="{{ old('company_name') }}">
                            </div>
                            @error('company_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Company Website -->
                        <div>
                            <label for="company_website" class="block text-sm font-medium text-foxecom-dark mb-2">
                                Company website *
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-globe text-foxecom-gray"></i>
                                </div>
                                <input id="company_website" name="company_website" type="url" required 
                                       class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-foxecom-orange focus:border-transparent"
                                       placeholder="https://yourcompany.com" value="{{ old('company_website') }}">
                            </div>
                            @error('company_website')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- PayPal Email -->
                    <div>
                        <label for="paypal_email" class="block text-sm font-medium text-foxecom-dark mb-2">
                            PayPal email *
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fab fa-paypal text-foxecom-gray"></i>
                            </div>
                            <input id="paypal_email" name="paypal_email" type="email" required 
                                   class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-foxecom-orange focus:border-transparent"
                                   placeholder="paypal@example.com" value="{{ old('paypal_email') }}">
                        </div>
                        @error('paypal_email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Commission Structure -->
                    <div>
                        <label class="block text-sm font-medium text-foxecom-dark mb-3">Commission Structure *</label>
                        <p class="text-sm text-foxecom-gray mb-4">Select the themes you're interested in promoting:</p>
                        
                        <div class="space-y-4">
                            <!-- Megamog Theme -->
                            <div class="flex items-start p-4 border border-gray-300 rounded-lg hover:bg-gray-50">
                                <input id="megamog" type="checkbox" value="megamog" name="commission_structure[]" 
                                       class="h-4 w-4 text-foxecom-orange focus:ring-foxecom-orange border-gray-300 rounded mt-1"
                                       {{ in_array('megamog', old('commission_structure', [])) ? 'checked' : '' }}>
                                <div class="ml-3 flex-1">
                                    <label for="megamog" class="text-sm font-medium text-foxecom-dark">
                                        Commission Structure for Megamog theme
                                    </label>
                                    <div class="mt-2">
                                        <img src="{{ asset('images/megamog_theme.png') }}" alt="Megamog Theme" 
                                             class="w-full max-w-md rounded-lg shadow-sm">
                                    </div>
                                </div>
                            </div>

                            <!-- Minimog Theme -->
                            <div class="flex items-start p-4 border border-gray-300 rounded-lg hover:bg-gray-50">
                                <input id="minimog" type="checkbox" value="minimog" name="commission_structure[]" 
                                       class="h-4 w-4 text-foxecom-orange focus:ring-foxecom-orange border-gray-300 rounded mt-1"
                                       {{ in_array('minimog', old('commission_structure', [])) ? 'checked' : '' }}>
                                <div class="ml-3 flex-1">
                                    <label for="minimog" class="text-sm font-medium text-foxecom-dark">
                                        Commission Structure for Minimog theme
                                    </label>
                                    <div class="mt-2">
                                        <img src="{{ asset('images/minimog_theme.png') }}" alt="Minimog Theme" 
                                             class="w-full max-w-md rounded-lg shadow-sm">
                                    </div>
                                </div>
                            </div>
                        </div>
                        @error('commission_structure')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Company Type Selection -->
                    <div>
                        <label class="block text-sm font-medium text-foxecom-dark mb-3">Company Type *</label>
                        <div class="space-y-3">
                            <div class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50">
                                <input id="foxecom_partner" type="radio" value="1" name="company_type_id" 
                                       class="h-4 w-4 text-foxecom-orange focus:ring-foxecom-orange border-gray-300"
                                       {{ old('company_type_id') == '1' ? 'checked' : '' }} required>
                                <label for="foxecom_partner" class="ml-3 text-sm font-medium text-foxecom-dark">
                                    <i class="fas fa-handshake text-foxecom-orange mr-2"></i>
                                    FoxEcom Partner
                                </label>
                            </div>
                            <div class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50">
                                <input id="foxecom_customer" type="radio" value="2" name="company_type_id" 
                                       class="h-4 w-4 text-foxecom-orange focus:ring-foxecom-orange border-gray-300"
                                       {{ old('company_type_id') == '2' ? 'checked' : '' }} required>
                                <label for="foxecom_customer" class="ml-3 text-sm font-medium text-foxecom-dark">
                                    <i class="fas fa-user-circle text-foxecom-orange mr-2"></i>
                                    FoxEcom Customer
                                </label>
                            </div>
                        </div>
                        @error('company_type_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-foxecom-dark mb-2">
                            Password *
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
                            Confirm Password *
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

                    <!-- Submit Button -->
                    <button type="submit" 
                            class="w-full bg-foxecom-orange hover:bg-orange-600 text-white font-bold py-3 px-4 rounded-lg transition duration-300 transform hover:scale-105 shadow-foxecom">
                        <i class="fas fa-user-plus mr-2"></i>
                        Register as Partner
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

    <script>
        function toggleOtherInput() {
            const otherRadio = document.getElementById('other_title');
            const otherInput = document.getElementById('other_title_input');
            
            if (otherRadio.checked) {
                otherInput.style.display = 'block';
                otherInput.focus();
            } else {
                otherInput.style.display = 'none';
                otherInput.value = '';
            }
        }

        // Hide other input when other radio buttons are selected
        document.querySelectorAll('input[name="title"]').forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value !== 'Other') {
                    document.getElementById('other_title_input').style.display = 'none';
                    document.getElementById('other_title_input').value = '';
                }
            });
        });
    </script>
</body>
</html>