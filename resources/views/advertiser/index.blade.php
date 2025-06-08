@extends('layouts.app')
        @section('content')
        <x-alert />
        <div class="container grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 mt-16 gap-6">
          <!-- Greeting Card -->
          <div class="col-span-8 p-6 foxecom-card-premium">
            <div class="p-2">
                <h2 class="font-bold text-3xl mb-2 text-foxecom-dark">Hello {{ auth()->user()->first_name }} {{ auth()->user()->last_name }},</h2>
                <div class="my-4">
                  <a role='button' href='#' class="text-white bg-foxecom-orange px-4 py-2 rounded-lg hover:bg-orange-600 transition duration-300 shadow-foxecom">
                    Advertiser <i class="fa-solid fa-rectangle-ad ml-2"></i>
                  </a>
                </div>
                <p class="text-lg text-foxecom-gray">Here you can submit your referral forms, see their progress and review your dashboard.</p>
            </div>
          </div>
         <!-- Referral Activity card -->
         <div class="col-span-4 p-6 foxecom-card">
            <div class="p-2">
            <h2 class="font-bold text-3xl mb-2 text-center text-foxecom-dark">My Referrals</h2>
              <p class="text-lg text-foxecom-gray">Pending forms: <span class="font-bold text-yellow-600">{{ $referralStats['pending'] }}</span></p>
              <p class="text-lg text-foxecom-gray">Accepted forms: <span class="font-bold text-green-600">{{ $referralStats['accepted'] }}</span></p>
              <p class="text-lg text-foxecom-gray">Rejected forms: <span class="font-bold text-red-600">{{ $referralStats['rejected'] }}</span></p>
              <p class="text-lg text-foxecom-gray"><span class="font-bold">Total</span> forms: <span class="font-bold">{{ $referralStats['total'] }}</span></p>
            </div>
          </div>
          
          <!-- Dashboard Cards Section -->
          <div class="col-span-12 p-6 foxecom-card">
              <div class="p-2">
                  <h2 class="font-bold text-3xl mb-4 text-center text-foxecom-dark">My Dashboard</h2>
              </div>
              <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                  @foreach($dashboardCards as $card)
                  <div class="foxecom-card p-6">
                      <div class="flex justify-between items-start mb-2">
                          <div>
                              <h3 class="text-lg font-bold text-foxecom-dark">{{ $card->title }}</h3>
                              <p class="text-foxecom-gray text-sm">{{ $card->description }}</p>
                          </div>
                      </div>
                      <div class="text-2xl font-bold text-foxecom-orange mb-2">
                          {{ $card->current_value }}
                      </div>
                  </div>
                  @endforeach
              </div>
          </div>

          <!-- Referral Forms Section -->
          <div class="col-span-12 p-6 foxecom-card">
              <div class="p-2 flex justify-between items-center">
                  <h2 class="font-bold text-3xl mb-2 text-foxecom-dark">My Referral Forms</h2>
                  <button 
                      onclick="openReferralModal()"
                      class="foxecom-btn-primary"
                  >
                      Submit Referral Form
                  </button>
              </div>
              <div class="foxecom-table-container">
                  <div class="foxecom-table-body">
                      <table class="foxecom-table">
                          <thead class="text-xs text-gray-700 uppercase bg-gray-50 sticky top-0">
                              <tr class="uppercase">
                                  <th scope="col" class="py-3 px-6">Form ID</th>
                                  <th scope="col" class="py-3 px-6">Referral Name</th>
                                  <th scope="col" class="py-3 px-6">Company</th>
                                  <th scope="col" class="py-3 px-6">Template</th>
                                  <th scope="col" class="py-3 px-6">Expected Revenue</th>
                                  <th scope="col" class="py-3 px-6 text-center">Submission Date</th>
                                  <th scope="col" class="py-3 px-6 text-center">Status</th>
                                  <th scope="col" class="py-3 px-6 text-center">Actions</th>
                              </tr>
                          </thead>
                          <tbody>
                              @forelse($referralForms as $form)
                              <tr class="bg-white border-b hover:bg-gray-50">
                                  <td class="py-4 px-6">#{{ $form->id }}</td>
                                  <td class="py-4 px-6">{{ $form->referral_name }}</td>
                                  <td class="py-4 px-6">{{ $form->company }}</td>
                                  <td class="py-4 px-6">
                                      {{ ucwords(str_replace('_', ' ', $form->template)) }}
                                  </td>
                                  <td class="py-4 px-6">${{ number_format($form->expected_revenue, 2) }}</td>
                                  <td class="py-4 px-6 text-center">
                                      {{ \Carbon\Carbon::parse($form->created_at)->format('M d, Y') }}
                                  </td>
                                  <td class="py-4 px-6 text-center">
                                      @if($form->status === 'pending')
                                          <span class="pending-badge">{{ $form->status }}</span>
                                      @elseif($form->status === 'accepted')
                                          <span class="active-badge">{{ $form->status }}</span>
                                      @else
                                          <span class="disabled-badge">{{ $form->status }}</span>
                                      @endif
                                  </td>
                                  <td class="py-4 px-6 text-center">
                                      <button 
                                          onclick="viewAdvertiserReferralForm({{ $form->id }})"
                                          class="bg-blue-500 hover:bg-blue-700 text-white text-xs font-bold py-1 px-3 rounded"
                                      >
                                          View
                                      </button>
                                  </td>
                              </tr>
                              @empty
                              <tr>
                                  <td colspan="8" class="py-8 text-center text-gray-500">
                                      No referral forms submitted yet.
                                  </td>
                              </tr>
                              @endforelse
                          </tbody>
                      </table>
                  </div>
              </div>
          </div>

        <!-- Referral Form Modal -->
        <div id="referralModal" class="foxecom-modal hidden">
            <div class="foxecom-modal-content">
                <h3 class="text-lg font-medium text-foxecom-dark text-center mb-4">Submit Referral Form</h3>
                <form id="referralForm" method="POST" action="{{ route('advertiser.referral.store') }}">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="referral_name" class="block text-sm font-medium text-foxecom-dark mb-2">
                                Referral Name *
                            </label>
                            <input 
                                type="text" 
                                id="referral_name" 
                                name="referral_name" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-foxecom-orange"
                                required
                            >
                        </div>
                        <div>
                            <label for="company" class="block text-sm font-medium text-foxecom-dark mb-2">
                                Company *
                            </label>
                            <input 
                                type="text" 
                                id="company" 
                                name="company" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-foxecom-orange"
                                required
                            >
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="address" class="block text-sm font-medium text-foxecom-dark mb-2">
                            Address *
                        </label>
                        <textarea 
                            id="address" 
                            name="address" 
                            rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-foxecom-orange"
                            required
                        ></textarea>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="template" class="block text-sm font-medium text-foxecom-dark mb-2">
                                Template *
                            </label>
                            <select 
                                id="template" 
                                name="template" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-foxecom-orange"
                                required
                            >
                                <option value="">Select Template</option>
                                <option value="foxecom_commercial">Foxecom Commercial Template</option>
                                <option value="foxecom_baked">Foxecom Baked</option>
                                <option value="foxecom_super_shopify">Foxecom Super Shopify</option>
                            </select>
                        </div>
                        <div>
                            <label for="expected_revenue" class="block text-sm font-medium text-foxecom-dark mb-2">
                                Expected Revenue ($) *
                            </label>
                            <input 
                                type="number" 
                                id="expected_revenue" 
                                name="expected_revenue" 
                                step="0.01"
                                min="0"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-foxecom-orange"
                                required
                            >
                        </div>
                    </div>
                    
                    <div class="flex justify-end space-x-3 mt-6">
                        <button 
                            type="button" 
                            onclick="closeReferralModal()"
                            class="foxecom-btn-secondary"
                        >
                            Cancel
                        </button>
                        <button 
                            type="submit"
                            class="foxecom-btn-primary"
                        >
                            Submit Referral
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Advertiser Referral View Modal -->
        <div id="advertiserReferralViewModal" class="foxecom-modal hidden">
            <div class="foxecom-modal-content">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-foxecom-dark">Referral Form Details</h3>
                    <button onclick="closeAdvertiserReferralViewModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <div id="advertiserReferralFormContent" class="space-y-4 mb-6">
                    <!-- Content will be loaded here -->
                </div>
                
                <div class="flex justify-end pt-4 border-t">
                    <button 
                        onclick="closeAdvertiserReferralViewModal()"
                        class="foxecom-btn-secondary"
                    >
                        Close
                    </button>
                </div>
            </div>
        </div>

        <script>
        function openReferralModal() {
            document.getElementById('referralModal').classList.remove('hidden');
        }

        function closeReferralModal() {
            document.getElementById('referralModal').classList.add('hidden');
            document.getElementById('referralForm').reset();
        }

        function viewAdvertiserReferralForm(formId) {
            fetch(`/advertiser/referral/${formId}/view`, {
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
                                <label class="block text-sm font-medium text-foxecom-dark">Referral Name</label>
                                <p class="mt-1 text-sm text-gray-900">${form.referral_name}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-foxecom-dark">Company</label>
                                <p class="mt-1 text-sm text-gray-900">${form.company}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-foxecom-dark">Template</label>
                                <p class="mt-1 text-sm text-gray-900">${form.template.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase())}</p>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-foxecom-dark">Address</label>
                                <p class="mt-1 text-sm text-gray-900">${form.address}</p>
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
                    
                    document.getElementById('advertiserReferralFormContent').innerHTML = content;
                    document.getElementById('advertiserReferralViewModal').classList.remove('hidden');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error loading form details');
            });
        }

        function closeAdvertiserReferralViewModal() {
            document.getElementById('advertiserReferralViewModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('referralModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeReferralModal();
            }
        });

        document.getElementById('advertiserReferralViewModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeAdvertiserReferralViewModal();
            }
        });
        </script>
        @endsection