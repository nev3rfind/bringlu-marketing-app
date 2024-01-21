<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-30 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- First Name -->
            <div>
                <x-input-label for="first_name" :value="__('First name')" />

                <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name')" required autofocus />

                <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
            </div>
            <!-- Last Name -->
            <div>
                <x-input-label for="last_name" :value="__('Last name')" />

                <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')" required autofocus />

                <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />

                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />

                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Phone number -->
            <div class="mt-4">
                <x-input-label for="phone" :value="__('Phone number')" />

                <x-text-input id="phone" class="block mt-1 w-full" type="tel" name="phone" :value="old('phone')" required />

                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />

                <x-text-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required />

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
            <h3 class="mt-2 mb-2 text-gray-500">Select account type</h3>
            <div class="flex items-center pl-4 mt-2 rounded border border-gray-200 dark:border-gray-700">
    <input checked id="bordered-radio-1" type="radio" value="1" name="account_type" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
    <label for="bordered-radio-1" class="py-4 ml-2 w-full text-sm font-medium text-gray-900 dark:text-gray-300">Advertiser</label>
</div>
<div class="mt-2 flex items-center pl-4 rounded border border-gray-200 dark:border-gray-700">
    <input id="bordered-radio-2" type="radio" value="2" name="account_type" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
    <label for="bordered-radio-2" class="py-4 ml-2 w-full text-sm font-medium text-gray-900 dark:text-gray-300">Business account</label>
</div>
            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-primary-button class="ml-4">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
            
        </form>
    </x-auth-card>
</x-guest-layout>
