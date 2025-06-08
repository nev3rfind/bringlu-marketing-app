@extends('layouts.app')
        @section('content')
        <x-alert />
        <div class="container grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 mt-16 gap-6">
          <!-- Greeting Card -->
          <div class="col-span-8 p-6 foxecom-card-premium">
            <div class="p-2">
                <h2 class="font-bold text-3xl mb-2 text-foxecom-dark">Hello {{ auth()->user()->first_name }} {{ auth()->user()->last_name }},</h2>
                <div class="my-4">
                  <a role='button' href='#' class="text-white bg-green-500 px-4 py-2 rounded-lg hover:bg-green-600 transition duration-300 shadow-foxecom">
                    Business customer <i class="fa-solid fa-briefcase ml-2"></i>
                  </a>
                </div>
                <p class="text-lg text-foxecom-gray">Manage referral forms and track submissions from your clients</p>
            </div>
          </div>
         <!-- Activity card -->
         <div class="col-span-4 p-6 foxecom-card">
            <div class="p-2">
            <h2 class="font-bold text-3xl mb-2 text-center text-foxecom-dark">Referral Statistics</h2>
              <p class="text-lg text-foxecom-gray">Pending forms: <span class="font-bold text-yellow-600">{{ $referralStats['pending'] }}</span></p>
              <p class="text-lg text-foxecom-gray">Accepted forms: <span class="font-bold text-green-600">{{ $referralStats['accepted'] }}</span></p>
              <p class="text-lg text-foxecom-gray">Rejected forms: <span class="font-bold text-red-600">{{ $referralStats['rejected'] }}</span></p>
              <p class="text-lg text-foxecom-gray">Viewed forms: <span class="font-bold text-blue-600">{{ $referralStats['viewed'] }}</span></p>
              <p class="text-lg text-foxecom-gray">Unviewed forms: <span class="font-bold text-red-500">{{ $referralStats['unviewed'] }}</span></p>
              <p class="text-lg text-foxecom-gray"><span class="font-bold">Total</span> forms: <span class="font-bold">{{ $referralStats['total'] }}</span></p>
            </div>
          </div>

          <!-- Referral Forms Table -->
          <div class="col-span-12 p-6 foxecom-card">
              <div class="p-2">
                  <h2 class="font-bold text-3xl mb-4 text-center text-foxecom-dark">All Referral Forms</h2>
              </div>
              <div class="foxecom-table-container">
                  <div class="foxecom-table-body">
                      <table class="foxecom-table">
                          <thead class="text-xs text-gray-700 uppercase bg-gray-50 sticky top-0">
                              <tr class="uppercase">
                                  <th scope="col" class="py-3 px-6">Form ID</th>
                                  <th scope="col" class="py-3 px-6">Submitted By</th>
                                  <th scope="col" class="py-3 px-6">Referral Name</th>
                                  <th scope="col" class="py-3 px-6">Company</th>
                                  <th scope="col" class="py-3 px-6">Template</th>
                                  <th scope="col" class="py-3 px-6">Expected Revenue</th>
                                  <th scope="col" class="py-3 px-6 text-center">Status</th>
                                  <th scope="col" class="py-3 px-6 text-center">Viewed</th>
                                  <th scope="col" class="py-3 px-6 text-center">Submitted Date</th>
                                  <th scope="col" class="py-3 px-6 text-center">Actions</th>
                              </tr>
                          </thead>
                          <tbody>
                              @forelse($referralForms as $form)
                              <tr class="border-b cursor-pointer hover:bg-gray-50 {{ !$form->viewed ? 'unviewed-row' : 'bg-white' }}" 
                                  onclick="viewReferralForm({{ $form->id }})">
                                  <td class="py-4 px-6 font-medium">#{{ $form->id }}</td>
                                  <td class="py-4 px-6">{{ $form->user->first_name }} {{ $form->user->last_name }}</td>
                                  <td class="py-4 px-6">{{ $form->referral_name }}</td>
                                  <td class="py-4 px-6">{{ $form->company }}</td>
                                  <td class="py-4 px-6">{{ ucwords(str_replace('_', ' ', $form->template)) }}</td>
                                  <td class="py-4 px-6">${{ number_format($form->expected_revenue, 2) }}</td>
                                  <td class="py-4 px-6 text-center">
                                      @if($form->status === 'pending')
                                          <span class="pending-badge">Pending</span>
                                      @elseif($form->status === 'accepted')
                                          <span class="active-badge">Accepted</span>
                                      @else
                                          <span class="disabled-badge">Rejected</span>
                                      @endif
                                  </td>
                                  <td class="py-4 px-6 text-center">
                                      @if($form->viewed)
                                          <span class="text-green-600"><i class="fas fa-check-circle"></i></span>
                                      @else
                                          <span class="text-red-600"><i class="fas fa-times-circle"></i></span>
                                      @endif
                                  </td>
                                  <td class="py-4 px-6 text-center">
                                      {{ \Carbon\Carbon::parse($form->created_at)->format('M d, Y H:i') }}
                                  </td>
                                  <td class="py-4 px-6 text-center" onclick="event.stopPropagation()">
                                      <button 
                                          onclick="viewReferralForm({{ $form->id }})"
                                          class="bg-blue-500 hover:bg-blue-700 text-white text-xs font-bold py-1 px-3 rounded mr-1"
                                      >
                                          View
                                      </button>
                                  </td>
                              </tr>
                              @empty
                              <tr>
                                  <td colspan="10" class="py-8 text-center text-gray-500">
                                      No referral forms submitted yet.
                                  </td>
                              </tr>
                              @endforelse
                          </tbody>
                      </table>
                  </div>
              </div>
          </div>
        </div>

        <!-- Referral Form View Modal -->
        <div id="referralViewModal" class="foxecom-modal hidden">
            <div class="foxecom-modal-content">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-foxecom-dark">Referral Form Details</h3>
                    <button onclick="closeReferralViewModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <div id="referralFormContent" class="space-y-4 mb-6">
                    <!-- Content will be loaded here -->
                </div>
                
                <div class="flex justify-between items-center pt-4 border-t">
                    <div class="flex space-x-3">
                        <button 
                            id="acceptBtn"
                            onclick="updateReferralStatus('accept')"
                            class="foxecom-btn-success"
                        >
                            Accept
                        </button>
                        <button 
                            id="rejectBtn"
                            onclick="updateReferralStatus('reject')"
                            class="foxecom-btn-danger"
                        >
                            Reject
                        </button>
                    </div>
                    <button 
                        onclick="closeReferralViewModal()"
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
        let currentFormId = null;

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

        function viewReferralForm(formId) {
            currentFormId = formId;
            
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
                                <label class="block text-sm font-medium text-foxecom-dark">Form ID</label>
                                <p class="mt-1 text-sm text-gray-900">#${form.id}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-foxecom-dark">Submitted By</label>
                                <p class="mt-1 text-sm text-gray-900">${form.user.first_name} ${form.user.last_name}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-foxecom-dark">Referral Name</label>
                                <p class="mt-1 text-sm text-gray-900">${form.referral_name}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-foxecom-dark">Company</label>
                                <p class="mt-1 text-sm text-gray-900">${form.company}</p>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-foxecom-dark">Address</label>
                                <p class="mt-1 text-sm text-gray-900">${form.address}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-foxecom-dark">Template</label>
                                <p class="mt-1 text-sm text-gray-900">${form.template.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase())}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-foxecom-dark">Expected Revenue</label>
                                <p class="mt-1 text-sm text-gray-900">$${parseFloat(form.expected_revenue).toLocaleString('en-US', {minimumFractionDigits: 2})}</p>
                            </div>
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
                    
                    document.getElementById('referralFormContent').innerHTML = content;
                    
                    // Show/hide action buttons based on status
                    const acceptBtn = document.getElementById('acceptBtn');
                    const rejectBtn = document.getElementById('rejectBtn');
                    
                    if (form.status === 'pending') {
                        acceptBtn.style.display = 'inline-block';
                        rejectBtn.style.display = 'inline-block';
                    } else {
                        acceptBtn.style.display = 'none';
                        rejectBtn.style.display = 'none';
                    }
                    
                    document.getElementById('referralViewModal').classList.remove('hidden');
                    
                    // Update the row to remove red highlighting
                    const row = document.querySelector(`tr[onclick*="${formId}"]`);
                    if (row) {
                        row.classList.remove('unviewed-row');
                        row.classList.add('bg-white');
                        // Update viewed icon
                        const viewedCell = row.children[7];
                        viewedCell.innerHTML = '<span class="text-green-600"><i class="fas fa-check-circle"></i></span>';
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Error loading form details', 'error');
            });
        }

        function updateReferralStatus(action) {
            if (!currentFormId) return;
            
            fetch(`/business/referral/${currentFormId}/${action}`, {
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
                    const statusElement = document.querySelector('#referralFormContent .inline-flex');
                    if (statusElement) {
                        const newStatus = data.status;
                        statusElement.className = `inline-flex px-2 py-1 text-xs font-semibold rounded-full ${
                            newStatus === 'accepted' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'
                        }`;
                        statusElement.textContent = newStatus.charAt(0).toUpperCase() + newStatus.slice(1);
                    }
                    
                    // Hide action buttons
                    document.getElementById('acceptBtn').style.display = 'none';
                    document.getElementById('rejectBtn').style.display = 'none';
                    
                    // Update the table row
                    const row = document.querySelector(`tr[onclick*="${currentFormId}"]`);
                    if (row) {
                        const statusCell = row.children[6];
                        const statusClass = data.status === 'accepted' ? 'active-badge' : 'disabled-badge';
                        const statusText = data.status.charAt(0).toUpperCase() + data.status.slice(1);
                        statusCell.innerHTML = `<span class="${statusClass}">${statusText}</span>`;
                    }
                } else {
                    showNotification('Error updating form status: ' + (data.error || 'Unknown error'), 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Error updating form status', 'error');
            });
        }

        function closeReferralViewModal() {
            document.getElementById('referralViewModal').classList.add('hidden');
            currentFormId = null;
        }

        // Close modal when clicking outside
        document.getElementById('referralViewModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeReferralViewModal();
            }
        });
        </script>
        @endsection