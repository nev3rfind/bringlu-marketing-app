<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-30 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <form method="POST" action="{{ route('login.continue-github') }}">
            @csrf
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
                <x-primary-button class="ml-4">
                {{ __('Continue with GitHub') }}
                </x-primary-button>
            </div>
            
        </form>
    </x-auth-card>
</x-guest-layout>
