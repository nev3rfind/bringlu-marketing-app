@extends('layouts.app')
@section('content')
<div class="mt-8 text-center">
    <h1 class="font-medium leading-tight text-4xl mt-0 mb-2 text-bringlu-blue">
        Dashboard for {{ $client->first_name }} {{ $client->last_name }}
    </h1>
    <p class="text-gray-600">Manage client dashboard metrics and values</p>
</div>

<x-alert />

<div class="container mx-auto px-4 py-8">
    <!-- Dashboard Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($dashboardCards as $card)
        <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="text-xl font-bold text-gray-800">{{ $card->title }}</h3>
                    <p class="text-gray-600 text-sm">{{ $card->description }}</p>
                </div>
                <button 
                    onclick="openEditModal({{ $card->id }}, '{{ $card->title }}', '{{ $card->current_value }}')"
                    class="text-blue-500 hover:text-blue-700 transition-colors duration-200"
                    title="Edit {{ $card->title }}"
                >
                    <i class="fas fa-edit text-lg"></i>
                </button>
            </div>
            
            <div class="text-3xl font-bold text-bringlu-blue mb-2">
                {{ $card->current_value }}
            </div>
            
            <div class="text-sm text-gray-500">
                Position: {{ $card->position }}
            </div>
        </div>
        @endforeach
    </div>

    <!-- Back Button -->
    <div class="mt-8 text-center">
        <a href="{{ route('clients.all') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Back to Clients
        </a>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg font-medium text-gray-900" id="modalTitle">Edit Card Value</h3>
            <form id="editForm" method="POST" class="mt-4">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="cardValue" class="block text-sm font-medium text-gray-700 mb-2">
                        Value
                    </label>
                    <input 
                        type="text" 
                        id="cardValue" 
                        name="value" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required
                    >
                </div>
                <div class="flex justify-end space-x-3">
                    <button 
                        type="button" 
                        onclick="closeEditModal()"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded"
                    >
                        Cancel
                    </button>
                    <button 
                        type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                    >
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openEditModal(cardId, cardTitle, currentValue) {
    document.getElementById('modalTitle').textContent = 'Edit ' + cardTitle;
    document.getElementById('cardValue').value = currentValue;
    document.getElementById('editForm').action = `/business/clients/{{ $client->id }}/dashboard/card/${cardId}`;
    document.getElementById('editModal').classList.remove('hidden');
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('editModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeEditModal();
    }
});
</script>
@endsection