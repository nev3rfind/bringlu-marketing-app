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
            <div class="foxecom-card p-8" id="registrationForm">
                <form method="POST" action="{{ route('register') }}" class="space-y-6" id="registerForm">
                    @csrf

                    <!-- Your Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-foxecom-dark mb-2">
                            Your name (How we should call you?) *
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user text-foxecom-gray"></i>
                            </div>
                            <input id="name" name="name" type="text" required 
                                   class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-foxecom-orange focus:border-transparent"
                                   placeholder="John Doe" value="{{ old('name') }}">
                        </div>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Title/Role -->
                    <div>
                        <label class="block text-sm font-medium text-foxecom-dark mb-3">Which title describe your title the best? *</label>
                        <div class="space-y-3">
                            <div class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50">
                                <input id="solo_developer" type="radio" value="Solo developer" name="title" 
                                       class="h-4 w-4 text-foxecom-orange focus:ring-foxecom-orange border-gray-300"
                                       {{ old('title') == 'Solo developer' ? 'checked' : '' }}
                                       onchange="toggleOtherInput()">
                                <label for="solo_developer" class="ml-3 text-sm font-medium text-foxecom-dark">
                                    Solo developer
                                </label>
                            </div>
                            <div class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50">
                                <input id="agency" type="radio" value="Agency" name="title" 
                                       class="h-4 w-4 text-foxecom-orange focus:ring-foxecom-orange border-gray-300"
                                       {{ old('title') == 'Agency' ? 'checked' : '' }}
                                       onchange="toggleOtherInput()">
                                <label for="agency" class="ml-3 text-sm font-medium text-foxecom-dark">
                                    Agency
                                </label>
                            </div>
                            <div class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50">
                                <input id="merchants" type="radio" value="Merchants/Store owners" name="title" 
                                       class="h-4 w-4 text-foxecom-orange focus:ring-foxecom-orange border-gray-300"
                                       {{ old('title') == 'Merchants/Store owners' ? 'checked' : '' }}
                                       onchange="toggleOtherInput()">
                                <label for="merchants" class="ml-3 text-sm font-medium text-foxecom-dark">
                                    Merchants/Store owners
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

                    <!-- Company Website -->
                    <div>
                        <label for="company_website" class="block text-sm font-medium text-foxecom-dark mb-2">
                            Your company website *
                        </label>
                        <p class="text-xs text-gray-500 mb-2">(If not applicable, type N/A)</p>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-globe text-foxecom-gray"></i>
                            </div>
                            <input id="company_website" name="company_website" type="text" required 
                                   class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-foxecom-orange focus:border-transparent"
                                   placeholder="https://yourcompany.com or N/A" value="{{ old('company_website') }}">
                        </div>
                        @error('company_website')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Contact Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-foxecom-dark mb-2">
                            Your contact email *
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
                            Your account password *
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

                    <!-- Terms and Conditions -->
                    <div class="bg-orange-50 p-4 rounded-lg border border-orange-200">
                        <div class="space-y-3">
                            <div class="flex items-start">
                                <input id="terms_agreement" type="checkbox" name="terms_agreement" value="1" required
                                       class="h-4 w-4 text-foxecom-orange focus:ring-foxecom-orange border-gray-300 rounded mt-1">
                                <label for="terms_agreement" class="ml-3 text-sm text-foxecom-dark">
                                    By submitting this form, you've agreed to 
                                    <a href="https://docs.foxecom.com/legal/fox-affiliate-program/terms-and-conditions" target="_blank" 
                                       class="text-foxecom-orange hover:text-orange-600 underline font-medium">
                                        Fox Affiliate Program Terms and Conditions
                                    </a> *
                                </label>
                            </div>
                            
                            <div class="flex items-start">
                                <input id="understand_checkbox" type="checkbox" name="understand_checkbox" value="1" required
                                       class="h-4 w-4 text-foxecom-orange focus:ring-foxecom-orange border-gray-300 rounded mt-1">
                                <label for="understand_checkbox" class="ml-3 text-sm text-foxecom-dark">
                                    Yes I understand
                                </label>
                            </div>
                            
                            <div class="flex items-start">
                                <input id="questions_checkbox" type="checkbox" name="questions_checkbox" value="1"
                                       class="h-4 w-4 text-foxecom-orange focus:ring-foxecom-orange border-gray-300 rounded mt-1">
                                <label for="questions_checkbox" class="ml-3 text-sm text-foxecom-dark">
                                    Have questions? Drop us a message at 
                                    <a href="mailto:affiliates@foxecom.com" class="text-foxecom-orange hover:text-orange-600 underline">
                                        affiliates@foxecom.com
                                    </a>
                                </label>
                            </div>
                        </div>
                        @error('terms_agreement')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        @error('understand_checkbox')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Payment Policy -->
                    <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                        <div class="flex items-start">
                            <input id="payment_policy" type="checkbox" name="payment_policy" value="1" required
                                   class="h-4 w-4 text-foxecom-orange focus:ring-foxecom-orange border-gray-300 rounded mt-1">
                            <label for="payment_policy" class="ml-3 text-sm text-foxecom-dark">
                                Make sure you've read and understood the 
                                <a href="https://docs.foxecom.com/legal/fox-affiliate-program/terms-and-conditions/payment-process-and-policy#commission-structure" target="_blank" 
                                   class="text-blue-600 hover:text-blue-800 underline font-medium">
                                    Payment, Process, & Policy
                                </a> in Fox Affiliate Program T&C *
                            </label>
                        </div>
                        
                        <div class="mt-3 space-y-2">
                            <div class="flex items-start">
                                <input id="understand_policy" type="checkbox" name="understand_policy" value="1" required
                                       class="h-4 w-4 text-foxecom-orange focus:ring-foxecom-orange border-gray-300 rounded mt-1">
                                <label for="understand_policy" class="ml-3 text-sm text-foxecom-dark">
                                    Yes I understand
                                </label>
                            </div>
                            
                            <div class="flex items-start">
                                <input id="policy_questions" type="checkbox" name="policy_questions" value="1"
                                       class="h-4 w-4 text-foxecom-orange focus:ring-foxecom-orange border-gray-300 rounded mt-1">
                                <label for="policy_questions" class="ml-3 text-sm text-foxecom-dark">
                                    Have questions? Drop us a message at 
                                    <a href="mailto:affiliates@foxecom.com" class="text-foxecom-orange hover:text-orange-600 underline">
                                        affiliates@foxecom.com
                                    </a>
                                </label>
                            </div>
                        </div>
                        @error('payment_policy')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        @error('understand_policy')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Affiliate Program Info -->
                    <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                        <p class="text-sm text-foxecom-dark">
                            In case you forgot<br>
                            Visit <a href="https://foxecom.com/pages/affiliate" target="_blank" 
                                   class="text-green-600 hover:text-green-800 underline font-medium">
                                the official Affiliate Program
                            </a> by FoxEcom today
                        </p>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" id="submitBtn"
                            class="w-full bg-foxecom-orange hover:bg-orange-600 text-white font-bold py-3 px-4 rounded-lg transition duration-300 transform hover:scale-105 shadow-foxecom">
                        <i class="fas fa-user-plus mr-2"></i>
                        <span id="submitText">Register as Partner</span>
                        <i class="fas fa-spinner fa-spin ml-2 hidden" id="loadingSpinner"></i>
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

    <!-- Success Modal -->
    <div id="successModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mb-4">
                    <i class="fas fa-check text-green-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">You're all set! 👏</h3>
                <div class="text-sm text-gray-600 space-y-3 mb-6">
                    <p class="font-semibold text-green-600">Welcome aboard!</p>
                    <p>We will reach out soon to send you information about our marketing goodies and product updates.</p>
                    <p>Having questions? Drop us a message at 
                        <a href="mailto:affiliates@foxecom.com" class="text-foxecom-orange hover:text-orange-600 underline">
                            affiliates@foxecom.com
                        </a>
                    </p>
                    <p class="font-semibold">Want to get a head start? 🔥</p>
                </div>
                <div class="flex justify-center space-x-3">
                    <button onclick="openReferralModal()" 
                            class="bg-foxecom-orange hover:bg-orange-600 text-white font-bold py-2 px-4 rounded">
                        Submit your theme referral now
                    </button>
                    <button onclick="closeSuccessModal()" 
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                        Continue to Dashboard
                    </button>
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

        function closeSuccessModal() {
            document.getElementById('successModal').classList.add('hidden');
            window.location.href = '/advertiser';
        }

        function openReferralModal() {
            // Close success modal first
            document.getElementById('successModal').classList.add('hidden');
            // Redirect to dashboard where referral modal can be opened
            window.location.href = '/advertiser?openReferral=true';
        }

        // Handle form submission with AJAX
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent default form submission
            
            const submitBtn = document.getElementById('submitBtn');
            const submitText = document.getElementById('submitText');
            const loadingSpinner = document.getElementById('loadingSpinner');
            
            // Show loading state
            submitBtn.disabled = true;
            submitText.textContent = 'Registering...';
            loadingSpinner.classList.remove('hidden');
            
            // Create FormData object
            const formData = new FormData(this);
            
            // Submit form via fetch
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                if (response.ok) {
                    // Hide the registration form
                    document.getElementById('registrationForm').style.display = 'none';
                    // Show success modal
                    document.getElementById('successModal').classList.remove('hidden');
                } else {
                    // If there are validation errors, reload the page to show them
                    window.location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Reset button state
                submitBtn.disabled = false;
                submitText.textContent = 'Register as Partner';
                loadingSpinner.classList.add('hidden');
                alert('An error occurred. Please try again.');
            });
        });
    </script>
</body>
</html>