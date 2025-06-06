@extends('layouts.app')
@section('content')
<div class="mt-8 text-center">
    <h1 class="font-medium leading-tight text-4xl mt-0 mb-2 text-bringlu-blue">All Clients</h1>
</div>
<x-alert />
<div class="container grid grid-cols-1 gap-4 p-5">
    <div class="col-span-12 p-4 bg-grey rounded-xl shadow-lg">
        <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
            <table class="table-auto w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700">
                    <tr class="uppercase">
                        <th scope="col" class="py-3 px-6 text-left">First Name</th>
                        <th scope="col" class="py-3 px-6 text-left">Last Name</th>
                        <th scope="col" class="py-3 px-6 text-left">Email</th>
                        <th scope="col" class="py-3 px-6 text-center">Register Date</th>
                        <th scope="col" class="py-3 px-6 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clients as $client)
                    <tr class="bg-white border-b">
                        <td class="py-4 px-6">{{ $client->first_name }}</td>
                        <td class="py-4 px-6">{{ $client->last_name }}</td>
                        <td class="py-4 px-6">{{ $client->email }}</td>
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
@endsection