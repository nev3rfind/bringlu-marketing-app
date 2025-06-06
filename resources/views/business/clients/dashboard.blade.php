@extends('layouts.app')
@section('content')
<div class="mt-8 text-center">
    <h1 class="font-medium leading-tight text-4xl mt-0 mb-2 text-bringlu-blue">
        Manage Dashboard - {{ $client->first_name }} {{ $client->last_name }}
    </h1>
</div>
<x-alert />

<div class="container grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-5">
    <!-- Dashboard Cards -->
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h3 class="text-lg font-bold text-gray-800 mb-2">Earnings</h3>
        <p class="text-2xl font-semibold text-green-600 mb-4">{{ $dashboard->earnings }}</p>
        <button onclick="editCard('earnings', '{{ $dashboard->earnings }}')" 
                class="bg-blue-500 hover:bg-blue-700 text-white text-xs px-3 py-1 rounded">
            Edit
        </button>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h3 class="text-lg font-bold text-gray-800 mb-2">Profit</h3>
        <p class="text-2xl font-semibold text-green-600 mb-4">{{ $dashboard->profit }}</p>
        <button onclick="editCard('profit', '{{ $dashboard->profit }}')" 
                class="bg-blue-500 hover:bg-blue-700 text-white text-xs px-3 py-1 rounded">
            Edit
        </button>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h3 class="text-lg font-bold text-gray-800 mb-2">Revenue</h3>
        <p class="text-2xl font-semibold text-green-600 mb-4">{{ $dashboard->revenue }}</p>
        <button onclick="editCard('revenue', '{{ $dashboard->revenue }}')" 
                class="bg-blue-500 hover:bg-blue-700 text-white text-xs px-3 py-1 rounded">
            Edit
        </button>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h3 class="text-lg font-bold text-gray-800 mb-2">Pay Date</h3>
        <p class="text-2xl font-semibold text-blue-600 mb-4">{{ $dashboard->pay_date }}</p>
        <button onclick="editCard('pay_date', '{{ $dashboard->pay_date }}')" 
                class="bg-blue-500 hover:bg-blue-700 text-white text-xs px-3 py-1 rounded">
            Edit
        </button>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h3 class="text-lg font-bold text-gray-800 mb-2">Total</h3>
        <p class="text-2xl font-semibold text-purple-600 mb-4">{{ $dashboard->total }}</p>
        <button onclick="editCard('total', '{{ $dashboard->total }}')" 
                class="bg-blue-500 hover:bg-blue-700 text-white text-xs px-3 py-1 rounded">
            Edit
        </button>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h3 class="text-lg font-bold text-gray-800 mb-2">Status</h3>
        <p class="text-2xl font-semibold text-gray-600 mb-4">{{ $dashboard->status }}</p>
        <button onclick="editCard('status', '{{ $dashboard->status }}')" 
                class="bg-blue-500 hover:bg-blue-700 text-white text-xs px-3 py-1 rounded">
            Edit
        </button>
    </div>
</div>

<!-- History Section -->
<div class="container p-5">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h3 class="text-xl font-bold mb-4">Dashboard History</h3>
        <div class="overflow-x-auto">
            <table class="table-auto w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="py-3 px-6">Field</th>
                        <th class="py-3 px-6">Old Value</th>
                        <th class="py-3 px-6">New Value</th>
                        <th class="py-3 px-6">Updated By</th>
                        <th class="py-3 px-6">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($history as $record)
                    <tr class="bg-white border-b">
                        <td class="py-4 px-6 font-medium">{{ ucfirst($record->field_name) }}</td>
                        <td class="py-4 px-6">{{ $record->old_value }}</td>
                        <td class="py-4 px-6">{{ $record->new_value }}</td>
                        <td class="py-4 px-6">{{ $record->updatedBy->first_name }} {{ $record->updatedBy->last_name }}</td>
                        <td class="py-4 px-6">{{ $record->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg font-medium text-gray-900" id="modalTitle">Edit Field</h3>
            <form id="editForm" method="POST" action="{{ route('clients.dashboard.update', $client->id) }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="field" id="fieldName">
                <div class="mt-4">
                    <input type="text" name="value" id="fieldValue" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="flex justify-center space-x-4 mt-6">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded">
                        Update
                    </button>
                    <button type="button" onclick="closeModal()" 
                            class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function editCard(field, currentValue) {
    document.getElementById('modalTitle').textContent = 'Edit ' + field.charAt(0).toUpperCase() + field.slice(1);
    document.getElementById('fieldName').value = field;
    document.getElementById('fieldValue').value = currentValue;
    document.getElementById('editModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('editModal').classList.add('hidden');
}
</script>
@endsection