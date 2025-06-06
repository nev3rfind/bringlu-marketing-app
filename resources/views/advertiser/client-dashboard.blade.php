@extends('layouts.app')
@section('content')
<x-alert />
<div class="container grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 mt-16">
    <!-- Greeting Card -->
    <div class="col-span-8 p-2 bg-grey rounded-xl transform transition-all hover:-translate-y-2 duration-300 shadow-lg hover:shadow-2xl">
        <div class="p-2">
            <h2 class="font-bold text-3xl mb-2">Hello {{ auth()->user()->first_name }} {{ auth()->user()->last_name }},</h2>
            <div class="my-4">
                <a role='button' href='#' class="text-white bg-orange-500 px-3 py-1 rounded-md hover:bg-purple-700">Advertiser Dashboard <i class="fa-solid fa-chart-line"></i></a>
            </div>
            <p class="text-lg text-gray-600">
                Welcome to your personal dashboard. Here you can view your earnings, forms, and other important information.
            </p>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="col-span-4 p-2 bg-grey rounded-xl transform transition-all hover:-translate-y-2 duration-300 shadow-lg hover:shadow-2xl">
        <div class="p-2">
            <h2 class="font-bold text-3xl mb-2 text-center">Quick Stats</h2>
            <p class="text-lg text-gray-600">Pending forms: <span class="font-bold">{{ $forms->where('status', 'pending')->count() }}</span></p>
            <p class="text-lg text-gray-600">Submitted forms: <span class="font-bold">{{ $forms->where('status', 'submitted')->count() }}</span></p>
            <p class="text-lg text-gray-600">Total forms: <span class="font-bold">{{ $forms->count() }}</span></p>
        </div>
    </div>
</div>

@if($dashboard)
<!-- Dashboard Cards -->
<div class="container grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-5 mt-8">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h3 class="text-lg font-bold text-gray-800 mb-2">Earnings</h3>
        <p class="text-2xl font-semibold text-green-600">{{ $dashboard->earnings }}</p>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h3 class="text-lg font-bold text-gray-800 mb-2">Profit</h3>
        <p class="text-2xl font-semibold text-green-600">{{ $dashboard->profit }}</p>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h3 class="text-lg font-bold text-gray-800 mb-2">Revenue</h3>
        <p class="text-2xl font-semibold text-green-600">{{ $dashboard->revenue }}</p>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h3 class="text-lg font-bold text-gray-800 mb-2">Pay Date</h3>
        <p class="text-2xl font-semibold text-blue-600">{{ $dashboard->pay_date }}</p>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h3 class="text-lg font-bold text-gray-800 mb-2">Total</h3>
        <p class="text-2xl font-semibold text-purple-600">{{ $dashboard->total }}</p>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h3 class="text-lg font-bold text-gray-800 mb-2">Status</h3>
        <p class="text-2xl font-semibold text-gray-600">{{ $dashboard->status }}</p>
    </div>
</div>
@endif

<!-- Forms Section -->
<div class="container p-5">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h3 class="text-xl font-bold mb-4">My Forms</h3>
        <div class="overflow-x-auto">
            <table class="table-auto w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="py-3 px-6">Title</th>
                        <th class="py-3 px-6">Description</th>
                        <th class="py-3 px-6 text-center">Status</th>
                        <th class="py-3 px-6 text-center">Created Date</th>
                        <th class="py-3 px-6 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($forms as $form)
                    <tr class="bg-white border-b">
                        <td class="py-4 px-6 font-medium">{{ $form->title }}</td>
                        <td class="py-4 px-6">{{ Str::limit($form->description, 50) }}</td>
                        <td class="py-4 px-6 text-center">
                            @if($form->status === 'pending')
                                <span class="medium-priority">{{ $form->status }}</span>
                            @elseif($form->status === 'submitted')
                                <span class="high-priority">{{ $form->status }}</span>
                            @elseif($form->status === 'accepted')
                                <span class="active-badge">{{ $form->status }}</span>
                            @else
                                <span class="disabled-badge">{{ $form->status }}</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-center">{{ $form->created_at->format('Y-m-d') }}</td>
                        <td class="py-4 px-6 text-center">
                            @if($form->status === 'pending')
                                <a href="{{ route('advertiser.form.show', $form->id) }}">
                                    <button class="bg-blue-500 hover:bg-blue-700 text-white text-xs px-3 py-1 rounded">
                                        Fill Form
                                    </button>
                                </a>
                            @else
                                <span class="text-gray-500 text-xs">{{ ucfirst($form->status) }}</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection