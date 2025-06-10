@extends('layouts.app')
@section('content')
<div class="mt-8 text-center">
    <h1 class="font-medium leading-tight text-4xl mt-0 mb-2 text-foxecom-dark">
        Referral Forms for {{ $client->display_name }}
    </h1>
    <p class="text-foxecom-gray">Review and manage client referral form submissions</p>
</div>

<x-alert />

<div class="container mx-auto px-4 py-8">
    @php
        $referralForms = \App\Models\ReferralForm::where('user_id', $client->id)
            ->orderBy('created_at', 'desc')
            ->get();
    @endphp

    <div class="foxecom-card p-6">
        <h2 class="text-2xl font-bold text-foxecom-dark mb-4">Submitted Referral Forms</h2>
        
        @if($referralForms->count() > 0)
        <div class="foxecom-table-container">
            <div class="foxecom-table-body">
                <table class="foxecom-table">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 sticky top-0">
                        <tr>
                            <th class="px-6 py-3 text-left">Form ID</th>
                            <th class="px-6 py-3 text-left">Theme Type</th>
                            <th class="px-6 py-3 text-left">Purchase Email</th>
                            <th class="px-6 py-3 text-left">License Code</th>
                            <th class="px-6 py-3 text-left">Submitted</th>
                            <th class="px-6 py-3 text-left">Status</th>
                            <th class="px-6 py-3 text-left">Viewed</th>
                            <th class="px-6 py-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($referralForms as $form)
                        <tr class="{{ !$form->viewed ? 'unviewed-row' : 'bg-white' }} border-b hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium">#{{ $form->id }}</td>
                            <td class="px-6 py-4">{{ $form->theme_type_text }}</td>
                            <td class="px-6 py-4">{{ $form->purchase_email }}</td>
                            <td class="px-6 py-4">{{ $form->license_code ?: 'N/A' }}</td>
                            <td class="px-6 py-4">{{ \Carbon\Carbon::parse($form->created_at)->format('M d, Y H:i') }}</td>
                            <td class="px-6 py-4">
                                @if($form->status === 'pending')
                                    <span class="pending-badge">Pending</span>
                                @elseif($form->status === 'accepted')
                                    <span class="active-badge">Accepted</span>
                                @else
                                    <span class="disabled-badge">Rejected</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($form->viewed)
                                    <span class="text-green-600"><i class="fas fa-check-circle"></i></span>
                                @else
                                    <span class="text-red-600"><i class="fas fa-times-circle"></i></span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <button 
                                    onclick="viewClientReferralForm({{ $form->id }})"
                                    class="bg-blue-500 hover:bg-blue-700 text-white text-xs font-bold py-1 px-3 rounded mr-1"
                                >
                                    View
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @else
        <p class="text-gray-500 text-center py-8">No referral forms submitted yet.</p>
        @endif
    </div>

    <!-- Back Button -->
    <div class="mt-8 text-center">
        <a href="{{ route('clients.all') }}" class="foxecom-btn-secondary">
            Back to Clients
        </a>
    </div>
</div>

<!-- Referral Form View Modal -->
<div id="clientReferralViewModal" class="foxecom-modal hidden">
    <div class="foxecom-modal-content">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-foxecom-dark">Referral Form Details</h3>
            <button onclick="closeClientReferralViewModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <div id="clientReferralFormContent" class="space-y-4 mb-6">
            <!-- Content will be loaded here -->
        </div>
        
        <div class="flex justify-between items-center pt-4 border-t">
            <div class="flex space-x-3">
                <button 
                    id="clientAcceptBtn"
                    onclick="updateClientReferralStatus('accept')"
                    class="foxecom-btn-success"
                >
                    Accept
                </button>
                <button 
                    id="clientRejectBtn"
                    onclick="updateClientReferralStatus('reject')"
                    class="foxecom-btn-danger"
                >
                    Reject
                </button>
            </div>
            <button 
                onclick="closeClientReferralViewModal()"
                class="foxecom-btn-secondary"
            >
                Close
            </button>
        </div>
    </div>
</div>

<!-- Success Notification -->
<div id="successNotification" class="success-notification hide">
    <div class="flex items-center">
        <i class="fas fa-check-circle mr-2"></i>
        <span id="successMessage">Success!</span>
    </div>
</div>

<!-- Error Notification -->
<div id="errorNotification" class="error-notification hide">
    <div class="flex items-center">
        <i class="fas fa-exclamation-circle mr-2"></i>
        <span id="errorMessage">Error!</span>
    </div>
</div>

<script>
let currentClientFormId = null;

function showNotification(message, type = 'success') {
    const notification = document.getElementById(type + 'Notification');
    const messageElement = document.getElementById(type + 'Message');
    
    messageElement.textContent = message;
    notification.classList.remove('hide');
    notification.classList.add('show');
    
    setTimeout(() => {
        notification.classList.remove('show');
        notification.classList.add('hide');
    }, 4000);
}

function viewClientReferralForm(formId) {
    currentClientFormId = formId;
    
    fetch(`/business/clients/referral/${formId}/view`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const form = data.form;
            const content = `
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-foxecom-dark">Form ID</label>
                        <p class="mt-1 text-sm text-gray-900">#${form.id}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-foxecom-dark">Submitted By</label>
                        <p class="mt-1 text-sm text-gray-900">${form.user.name}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-foxecom-dark">Theme Type</label>
                        <p class="mt-1 text-sm text-gray-900">${form.theme_type_text}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-foxecom-dark">Purchase Email</label>
                        <p class="mt-1 text-sm text-gray-900">${form.purchase_email}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-foxecom-dark">License Code</label>
                        <p class="mt-1 text-sm text-gray-900">${form.license_code || 'N/A'}</p>
                    </div>
                    ${form.shopify_store_url ? `
                    <div>
                        <label class="block text-sm font-medium text-foxecom-dark">Shopify Store URL</label>
                        <p class="mt-1 text-sm text-gray-900">
                            <a href="${form.shopify_store_url}" target="_blank" class="text-foxecom-orange hover:text-orange-600 underline">
                                ${form.shopify_store_url}
                            </a>
                        </p>
                    </div>
                    ` : ''}
                    ${form.proof_file_path ? `
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-foxecom-dark">Proof File</label>
                        <p class="mt-1 text-sm text-gray-900">
                            <a href="/storage/${form.proof_file_path}" target="_blank" class="text-foxecom-orange hover:text-orange-600 underline">
                                View Uploaded File
                            </a>
                        </p>
                    </div>
                    ` : ''}
                    <div>
                        <label class="block text-sm font-medium text-foxecom-dark">Status</label>
                        <p class="mt-1 text-sm text-gray-900">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full ${
                                form.status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                form.status === 'accepted' ? 'bg-green-100 text-green-800' :
                                'bg-red-100 text-red-800'
                            }">
                                ${form.status.charAt(0).toUpperCase() + form.status.slice(1)}
                            </span>
                        </p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-foxecom-dark">Submitted Date</label>
                        <p class="mt-1 text-sm text-gray-900">${new Date(form.created_at).toLocaleDateString('en-US', {
                            year: 'numeric',
                            month: 'short',
                            day: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                        })}</p>
                    </div>
                </div>
            `;
            
            document.getElementById('clientReferralFormContent').innerHTML = content;
            
            // Show/hide action buttons based on status
            const acceptBtn = document.getElementById('clientAcceptBtn');
            const rejectBtn = document.getElementById('clientRejectBtn');
            
            if (form.status === 'pending') {
                acceptBtn.style.display = 'inline-block';
                rejectBtn.style.display = 'inline-block';
            } else {
                acceptBtn.style.display = 'none';
                rejectBtn.style.display = 'none';
            }
            
            document.getElementById('clientReferralViewModal').classList.remove('hidden');
            
            // Update the row to remove red highlighting
            const rows = document.querySelectorAll('tr');
            rows.forEach(row => {
                if (row.innerHTML.includes(`#${formId}`)) {
                    row.classList.remove('unviewed-row');
                    row.classList.add('bg-white');
                    // Update viewed icon
                    const viewedCell = row.children[6];
                    viewedCell.innerHTML = '<span class="text-green-600"><i class="fas fa-check-circle"></i></span>';
                }
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Error loading form details', 'error');
    });
}

function updateClientReferralStatus(action) {
    if (!currentClientFormId) return;
    
    fetch(`/business/clients/referral/${currentClientFormId}/${action}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success notification
            showNotification(data.message, 'success');
            
            // Update the status in the modal
            const statusElement = document.querySelector('#clientReferralFormContent .inline-flex');
            if (statusElement) {
                const newStatus = data.status;
                statusElement.className = `inline-flex px-2 py-1 text-xs font-semibold rounded-full ${
                    newStatus === 'accepted' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'
                }`;
                statusElement.textContent = newStatus.charAt(0).toUpperCase() + newStatus.slice(1);
            }
            
            // Hide action buttons
            document.getElementById('clientAcceptBtn').style.display = 'none';
            document.getElementById('clientRejectBtn').style.display = 'none';
            
            // Update the table row
            const rows = document.querySelectorAll('tr');
            rows.forEach(row => {
                if (row.innerHTML.includes(`#${currentClientFormId}`)) {
                    const statusCell = row.children[5];
                    const statusClass = data.status === 'accepted' ? 'active-badge' : 'disabled-badge';
                    const statusText = data.status.charAt(0).toUpperCase() + data.status.slice(1);
                    statusCell.innerHTML = `<span class="${statusClass}">${statusText}</span>`;
                }
            });
        } else {
            showNotification('Error updating form status: ' + (data.error || 'Unknown error'), 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Error updating form status', 'error');
    });
}

function closeClientReferralViewModal() {
    document.getElementById('clientReferralViewModal').classList.add('hidden');
    currentClientFormId = null;
}

// Close modal when clicking outside
document.getElementById('clientReferralViewModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeClientReferralViewModal();
    }
});
</script>
@endsection