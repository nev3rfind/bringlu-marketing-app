@extends('layouts.app')
@section('content')
<div class="mt-8 text-center">
    <h1 class="font-medium leading-tight text-4xl mt-0 mb-2 text-bringlu-blue">
        Referral Forms for {{ $client->first_name }} {{ $client->last_name }}
    </h1>
    <p class="text-gray-600">Review and manage client referral form submissions</p>
</div>

<x-alert />

<div class="container mx-auto px-4 py-8">
    @php
        $referralForms = \App\Models\ReferralForm::where('user_id', $client->id)
            ->orderBy('created_at', 'desc')
            ->get();
    @endphp

    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Submitted Referral Forms</h2>
        
        @if($referralForms->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Form ID
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Referral Name
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Company
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Template
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Expected Revenue
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Submitted
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Viewed
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($referralForms as $form)
                    <tr class="{{ !$form->viewed ? 'bg-red-50' : '' }}">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            #{{ $form->id }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $form->referral_name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $form->company }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ ucwords(str_replace('_', ' ', $form->template)) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            ${{ number_format($form->expected_revenue, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($form->created_at)->format('M d, Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            @if($form->status === 'pending')
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Pending
                                </span>
                            @elseif($form->status === 'accepted')
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    Accepted
                                </span>
                            @else
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                    Rejected
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                            @if($form->viewed)
                                <span class="text-green-600"><i class="fas fa-check-circle"></i></span>
                            @else
                                <span class="text-red-600"><i class="fas fa-times-circle"></i></span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div class="flex space-x-2">
                                <button 
                                    onclick="viewReferralForm({{ $form->id }})"
                                    class="bg-blue-500 hover:bg-blue-700 text-white text-xs font-bold py-1 px-3 rounded"
                                >
                                    View
                                </button>
                                @if($form->status === 'pending')
                                    <form method="POST" action="{{ route('business.referral.update', ['form' => $form->id, 'action' => 'accept']) }}" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white text-xs font-bold py-1 px-3 rounded">
                                            Accept
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('business.referral.update', ['form' => $form->id, 'action' => 'reject']) }}" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white text-xs font-bold py-1 px-3 rounded">
                                            Reject
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="text-gray-500 text-center py-8">No referral forms submitted yet.</p>
        @endif
    </div>

    <!-- Back Button -->
    <div class="mt-8 text-center">
        <a href="{{ route('clients.all') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Back to Clients
        </a>
    </div>
</div>

<!-- Referral Form View Modal -->
<div id="referralViewModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-10 mx-auto p-5 border w-full max-w-4xl shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">Referral Form Details</h3>
                <button onclick="closeReferralViewModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <div id="referralFormContent" class="space-y-4">
                <!-- Content will be loaded here -->
            </div>
            
            <div class="flex justify-end mt-6 pt-4 border-t">
                <button 
                    onclick="closeReferralViewModal()"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded"
                >
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function viewReferralForm(formId) {
    fetch(`/business/referral/${formId}/view`, {
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
                        <label class="block text-sm font-medium text-gray-700">Form ID</label>
                        <p class="mt-1 text-sm text-gray-900">#${form.id}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Submitted By</label>
                        <p class="mt-1 text-sm text-gray-900">${form.user.first_name} ${form.user.last_name}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Referral Name</label>
                        <p class="mt-1 text-sm text-gray-900">${form.referral_name}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Company</label>
                        <p class="mt-1 text-sm text-gray-900">${form.company}</p>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Address</label>
                        <p class="mt-1 text-sm text-gray-900">${form.address}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Template</label>
                        <p class="mt-1 text-sm text-gray-900">${form.template.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase())}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Expected Revenue</label>
                        <p class="mt-1 text-sm text-gray-900">$${parseFloat(form.expected_revenue).toLocaleString('en-US', {minimumFractionDigits: 2})}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Status</label>
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
                        <label class="block text-sm font-medium text-gray-700">Submitted Date</label>
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
            
            document.getElementById('referralFormContent').innerHTML = content;
            document.getElementById('referralViewModal').classList.remove('hidden');
            
            // Update the row to remove red highlighting
            const rows = document.querySelectorAll('tr');
            rows.forEach(row => {
                if (row.innerHTML.includes(`#${formId}`)) {
                    row.classList.remove('bg-red-50');
                    // Update viewed icon
                    const viewedCell = row.children[7];
                    viewedCell.innerHTML = '<span class="text-green-600"><i class="fas fa-check-circle"></i></span>';
                }
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error loading form details');
    });
}

function closeReferralViewModal() {
    document.getElementById('referralViewModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('referralViewModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeReferralViewModal();
    }
});
</script>
@endsection