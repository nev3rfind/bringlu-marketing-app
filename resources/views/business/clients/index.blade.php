@extends('layouts.app')
@section('content')
<div class="mt-8 text-center">
    <h1 class="font-medium leading-tight text-4xl mt-0 mb-2 text-bringlu-blue">All Clients</h1>
</div>
<x-alert />
<div class="container grid grid-cols-1 gap-4 p-5">
    <div class="col-span-12 p-4 bg-grey rounded-xl shadow-lg">
        <div class="foxecom-table-container">
            <div class="foxecom-table-body">
                <table class="foxecom-table">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 sticky top-0">
                        <tr class="uppercase">
                            <th scope="col" class="py-3 px-6 text-left">Email</th>
                            <th scope="col" class="py-3 px-6 text-left">Name</th>
                            <th scope="col" class="py-3 px-6 text-left">Title</th>
                            <th scope="col" class="py-3 px-6 text-left">Company Website</th>
                            <th scope="col" class="py-3 px-6 text-left">PayPal Email</th>
                            <th scope="col" class="py-3 px-6 text-left">Company Type</th>
                            <th scope="col" class="py-3 px-6 text-center">Register Date</th>
                            <th scope="col" class="py-3 px-6 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clients as $client)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="py-4 px-6">{{ $client->email }}</td>
                            <td class="py-4 px-6">{{ $client->first_name }} {{ $client->last_name }}</td>
                            <td class="py-4 px-6">
                                <span class="text-sm">{{ $client->title ?? 'Not specified' }}</span>
                            </td>
                            <td class="py-4 px-6">
                                @if($client->company_website)
                                    <a href="{{ $client->company_website }}" target="_blank" 
                                       class="text-foxecom-orange hover:text-orange-600 underline">
                                        {{ $client->company_website }}
                                    </a>
                                @else
                                    <span class="text-gray-400">Not provided</span>
                                @endif
                            </td>
                            <td class="py-4 px-6">{{ $client->paypal_email ?? 'Not provided' }}</td>
                            <td class="py-4 px-6">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $client->company_type_id == 1 ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                    {{ $client->company_type_text }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                {{ \Carbon\Carbon::parse($client->created_at)->format('Y-m-d') }}
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="flex justify-center space-x-2">
                                    <a href="{{ route('clients.dashboard', $client->id) }}">
                                        <button class="bg-blue-500 hover:bg-blue-700 text-white text-xs font-bold py-2 px-4 rounded">
                                            Manage Dashboard
                                        </button>
                                    </a>
                                    <a href="{{ route('clients.forms', $client->id) }}">
                                        <button class="bg-green-500 hover:bg-green-700 text-white text-xs font-bold py-2 px-4 rounded">
                                            Process Forms
                                        </button>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection