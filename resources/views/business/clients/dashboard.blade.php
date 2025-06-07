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
    <!-- Dashboard Cards Grid (3x2) with Drag and Drop -->
    <div id="dashboard-grid" class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        @foreach($dashboardCards as $card)
        <div class="dashboard-card bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow duration-300 cursor-move" 
             data-card-id="{{ $card->id }}" 
             data-position="{{ $card->position }}">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="text-xl font-bold text-gray-800">{{ $card->title }}</h3>
                    <p class="text-gray-600 text-sm">{{ $card->description }}</p>
                </div>
                <div class="flex items-center space-x-2">
                    <!-- Drag Handle -->
                    <div class="drag-handle text-gray-400 hover:text-gray-600 cursor-move" title="Drag to reorder">
                        <i class="fas fa-grip-vertical text-lg"></i>
                    </div>
                    <!-- Edit Button -->
                    <button 
                        onclick="openEditModal({{ $card->id }}, '{{ $card->title }}', '{{ $card->current_value }}')"
                        class="edit-btn text-blue-500 hover:text-blue-700 transition-colors duration-200 hidden"
                        title="Edit {{ $card->title }}"
                    >
                        <i class="fas fa-edit text-lg"></i>
                    </button>
                </div>
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

    <!-- Control Buttons -->
    <div class="text-center mb-8 space-x-4">
        <button 
            onclick="toggleEditMode()"
            id="editModeBtn"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg"
        >
            Edit Dashboard
        </button>
        
        <button 
            onclick="toggleDragMode()"
            id="dragModeBtn"
            class="bg-green-500 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg"
        >
            Reorder Cards
        </button>
    </div>

    <!-- Dashboard History Table -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Dashboard History</h2>
        
        @if($history->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Card
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Previous Value
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Deactivated At
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($history as $historyItem)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $historyItem->dashboardCard->title }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $historyItem->value }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($historyItem->updated_at)->format('M d, Y H:i') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="text-gray-500 text-center py-8">No history available yet.</p>
        @endif
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

<!-- Include SortableJS from CDN -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

<script>
let editMode = false;
let dragMode = false;
let sortable = null;

// Initialize drag and drop functionality
function initializeDragAndDrop() {
    const grid = document.getElementById('dashboard-grid');
    
    sortable = Sortable.create(grid, {
        animation: 150,
        disabled: true, // Start disabled
        ghostClass: 'sortable-ghost',
        chosenClass: 'sortable-chosen',
        dragClass: 'sortable-drag',
        handle: '.drag-handle',
        onEnd: function(evt) {
            // Get new order
            const cards = Array.from(grid.children);
            const newOrder = cards.map((card, index) => ({
                id: card.dataset.cardId,
                position: index + 1
            }));
            
            // Send to server
            updateCardPositions(newOrder);
        }
    });
}

// Update card positions on server
function updateCardPositions(newOrder) {
    fetch(`/business/clients/{{ $client->id }}/dashboard/reorder`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ order: newOrder })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update position display
            newOrder.forEach(item => {
                const card = document.querySelector(`[data-card-id="${item.id}"]`);
                const positionElement = card.querySelector('.text-sm.text-gray-500');
                positionElement.textContent = `Position: ${item.position}`;
                card.dataset.position = item.position;
            });
            
            // Show success message
            showNotification('Card positions updated successfully!', 'success');
        } else {
            showNotification('Failed to update positions', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Error updating positions', 'error');
    });
}

// Toggle edit mode
function toggleEditMode() {
    editMode = !editMode;
    const editButtons = document.querySelectorAll('.edit-btn');
    const editModeBtn = document.getElementById('editModeBtn');
    
    if (editMode) {
        editButtons.forEach(btn => btn.classList.remove('hidden'));
        editModeBtn.textContent = 'Exit Edit Mode';
        editModeBtn.className = 'bg-red-500 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-lg';
        
        // Disable drag mode if active
        if (dragMode) {
            toggleDragMode();
        }
    } else {
        editButtons.forEach(btn => btn.classList.add('hidden'));
        editModeBtn.textContent = 'Edit Dashboard';
        editModeBtn.className = 'bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg';
    }
}

// Toggle drag mode
function toggleDragMode() {
    dragMode = !dragMode;
    const dragModeBtn = document.getElementById('dragModeBtn');
    const cards = document.querySelectorAll('.dashboard-card');
    
    if (dragMode) {
        sortable.option('disabled', false);
        dragModeBtn.textContent = 'Exit Reorder Mode';
        dragModeBtn.className = 'bg-red-500 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-lg';
        
        // Add visual feedback
        cards.forEach(card => {
            card.classList.add('border-2', 'border-dashed', 'border-green-300');
        });
        
        // Disable edit mode if active
        if (editMode) {
            toggleEditMode();
        }
        
        showNotification('Drag and drop mode enabled. Drag cards to reorder them.', 'info');
    } else {
        sortable.option('disabled', true);
        dragModeBtn.textContent = 'Reorder Cards';
        dragModeBtn.className = 'bg-green-500 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg';
        
        // Remove visual feedback
        cards.forEach(card => {
            card.classList.remove('border-2', 'border-dashed', 'border-green-300');
        });
    }
}

// Edit modal functions
function openEditModal(cardId, cardTitle, currentValue) {
    if (!editMode) return;
    
    document.getElementById('modalTitle').textContent = 'Edit ' + cardTitle;
    document.getElementById('cardValue').value = currentValue;
    document.getElementById('editForm').action = `/business/clients/{{ $client->id }}/dashboard/card/${cardId}`;
    document.getElementById('editModal').classList.remove('hidden');
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
}

// Show notification
function showNotification(message, type) {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 ${
        type === 'success' ? 'bg-green-500 text-white' :
        type === 'error' ? 'bg-red-500 text-white' :
        'bg-blue-500 text-white'
    }`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    // Remove after 3 seconds
    setTimeout(() => {
        notification.remove();
    }, 3000);
}

// Initialize when page loads
document.addEventListener('DOMContentLoaded', function() {
    // Add CSRF token to meta tag if not present
    if (!document.querySelector('meta[name="csrf-token"]')) {
        const meta = document.createElement('meta');
        meta.name = 'csrf-token';
        meta.content = '{{ csrf_token() }}';
        document.head.appendChild(meta);
    }
    
    initializeDragAndDrop();
    
    // Hide edit buttons initially
    const editButtons = document.querySelectorAll('.edit-btn');
    editButtons.forEach(btn => btn.classList.add('hidden'));
});

// Close modal when clicking outside
document.getElementById('editModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeEditModal();
    }
});
</script>

<style>
.sortable-ghost {
    opacity: 0.4;
}

.sortable-chosen {
    transform: scale(1.05);
}

.sortable-drag {
    transform: rotate(5deg);
}

.dashboard-card {
    transition: all 0.3s ease;
}

.dashboard-card:hover {
    transform: translateY(-2px);
}

.drag-handle {
    transition: all 0.2s ease;
}

.drag-handle:hover {
    transform: scale(1.1);
}
</style>
@endsection