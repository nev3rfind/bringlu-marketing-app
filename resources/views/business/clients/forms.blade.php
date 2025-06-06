@extends('layouts.app')
@section('content')
<div class="mt-8 text-center">
    <h1 class="font-medium leading-tight text-4xl mt-0 mb-2 text-bringlu-blue">
        Manage Forms - {{ $client->first_name }} {{ $client->last_name }}
    </h1>
</div>
<x-alert />

<div class="container p-5">
    <div class="mb-4">
        <a href="{{ route('clients.forms.create', $client->id) }}">
            <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                Create New Form
            </button>
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-lg">
        <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
            <table class="table-auto w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="py-3 px-6">Title</th>
                        <th scope="col" class="py-3 px-6">Description</th>
                        <th scope="col" class="py-3 px-6 text-center">Status</th>
                        <th scope="col" class="py-3 px-6 text-center">Created Date</th>
                        <th scope="col" class="py-3 px-6 text-center">Submitted Date</th>
                        <th scope="col" class="py-3 px-6 text-center">Actions</th>
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
                            {{ $form->submitted_at ? $form->submitted_at->format('Y-m-d') : 'Not submitted' }}
                        </td>
                        <td class="py-4 px-6 text-center">
                            <a href="{{ route('clients.forms.edit', [$client->id, $form->id]) }}">
                                <button class="bg-blue-500 hover:bg-blue-700 text-white text-xs px-3 py-1 rounded mr-2">
                                    Edit
                                </button>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection