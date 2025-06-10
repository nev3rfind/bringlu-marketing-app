@extends('layouts.app')
        @section('content')
        <x-alert />
        <div class="container grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 mt-16 gap-6">
          <!-- Greeting Card -->
          <div class="col-span-8 p-6 foxecom-card-premium">
            <div class="p-2">
                <h2 class="font-bold text-3xl mb-2 text-foxecom-dark">Hello {{ auth()->user()->display_name }},</h2>
                <div class="my-4">
                  <a role='button' href='#' class="text-white bg-foxecom-orange px-4 py-2 rounded-lg hover:bg-orange-600 transition duration-300 shadow-foxecom">
                    FoxEcom Partner <i class="fa-solid fa-user ml-2"></i>
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
                      @php
                          $latestValue = \App\Models\DashboardCardValue::where('user_id', auth()->user()->id)
                              ->where('dashboard_card_id', $card->id)
                              ->where('is_active', true)
                              ->first();
                      @endphp
                      @if($latestValue)
                          <p class="text-xs text-gray-500">
                              Last updated: {{ \Carbon\Carbon::parse($latestValue->updated_at)->diffForHumans() }}
                          </p>
                      @endif
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
                                  <th scope="col" class="py-3 px-6">Theme Type</th>
                                  <th scope="col" class="py-3 px-6">Purchase Email</th>
                                  <th scope="col" class="py-3 px-6">License Code</th>
                                  <th scope="col" class="py-3 px-6 text-center">Submission Date</th>
                                  <th scope="col" class="py-3 px-6 text-center">Status</th>
                                  <th scope="col" class="py-3 px-6 text-center">Actions</th>
                              </tr>
                          </thead>
                          <tbody>
                              @forelse($referralForms as $form)
                              <tr class="bg-white border-b hover:bg-gray-50">
                                  <td class="py-4 px-6">#{{ $form->id }}</td>
                                  <td class="py-4 px-6">{{ $form->theme_type_text }}</td>
                                  <td class="py-4 px-6">{{ $form->purchase_email }}</td>
                                  <td class="py-4 px-6">{{ $form->license_code ?: 'N/A' }}</td>
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
                                  <td colspan="7" class="py-8 text-center text-gray-500">
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
            <div class="foxecom-modal-content max-w-2xl">
                <h3 class="text-lg font-medium text-foxecom-dark text-center mb-4">Submit Referral Form</h3>
                <form method="POST" action="{{ route('advertiser.referral.store') }}" id="referralForm" enctype="multipart/form-data">
                    @csrf

                    <!-- Theme Type Selection -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-foxecom-dark mb-3">
                            Which FoxEcom's theme you've referred? *
                        </label>
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <input id="minimog_radio" type="radio" value="minimog" name="theme_type" 
                                       class="h-4 w-4 text-foxecom-orange focus:ring-foxecom-orange border-gray-300"
                                       onchange="toggleShopifyUrlInput()" required>
                                <label for="minimog_radio" class="ml-3 text-sm font-medium text-foxecom-dark">
                                    Minimog
                                </label>
                            </div>
                            <div class="flex items-center">
                                <input id="megamog_radio" type="radio" value="megamog" name="theme_type" 
                                       class="h-4 w-4 text-foxecom-orange focus:ring-foxecom-orange border-gray-300"
                                       onchange="toggleShopifyUrlInput()" required>
                                <label for="megamog_radio" class="ml-3 text-sm font-medium text-foxecom-dark">
                                    Megamog
                                </label>
                            </div>
                            <div class="flex items-center">
                                <input id="zest_radio" type="radio" value="zest" name="theme_type" 
                                       class="h-4 w-4 text-foxecom-orange focus:ring-foxecom-orange border-gray-300"
                                       onchange="toggleShopifyUrlInput()" required>
                                <label for="zest_radio" class="ml-3 text-sm font-medium text-foxecom-dark">
                                    Zest
                                </label>
                            </div>
                            <div class="flex items-center">
                                <input id="sleek_radio" type="radio" value="sleek" name="theme_type" 
                                       class="h-4 w-4 text-foxecom-orange focus:ring-foxecom-orange border-gray-300"
                                       onchange="toggleShopifyUrlInput()" required>
                                <label for="sleek_radio" class="ml-3 text-sm font-medium text-foxecom-dark">
                                    Sleek
                                </label>
                            </div>
                            <div class="flex items-center">
                                <input id="hyper_radio" type="radio" value="hyper" name="theme_type" 
                                       class="h-4 w-4 text-foxecom-orange focus:ring-foxecom-orange border-gray-300"
                                       onchange="toggleShopifyUrlInput()" required>
                                <label for="hyper_radio" class="ml-3 text-sm font-medium text-foxecom-dark">
                                    Hyper
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Purchase Email -->
                    <div class="mb-6">
                        <label for="purchase_email" class="block text-sm font-medium text-foxecom-dark mb-2">
                            What is the email used to purchase the theme? *
                        </label>
                        <p class="text-xs text-gray-600 mb-3">
                            <strong>The email must match our record for the lead to be counted as a successful referral.</strong>
                        </p>
                        <p class="text-xs text-gray-500 mb-3">
                            If you bought the theme, fill your email address.<br>
                            If your customer bought the theme, fill their email address.
                        </p>
                        <input 
                            type="email" 
                            id="purchase_email" 
                            name="purchase_email" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-foxecom-orange"
                            placeholder="email@example.com"
                            required
                        >
                    </div>

                    <!-- License Code -->
                    <div class="mb-6">
                        <label for="license_code" class="block text-sm font-medium text-foxecom-dark mb-2">
                            What is the theme's license code? *
                        </label>
                        <input 
                            type="text" 
                            id="license_code" 
                            name="license_code" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-foxecom-orange"
                            placeholder="License code"
                            required
                        >
                    </div>

                    <!-- Shopify Store URL (for non-Minimog/Megamog themes) -->
                    <div class="mb-6" id="shopify_url_section" style="display: none;">
                        <label for="shopify_store_url" class="block text-sm font-medium text-foxecom-dark mb-2">
                            Shopify Store URL
                        </label>
                        <p class="text-xs text-gray-500 mb-3">
                            For themes that are not Minimog and Megamog, please fill in the Shopify store's URL that purchased the theme
                        </p>
                        <input 
                            type="url" 
                            id="shopify_store_url" 
                            name="shopify_store_url" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-foxecom-orange"
                            placeholder="https://yourstore.myshopify.com"
                        >
                    </div>

                    <!-- Proof File Upload -->
                    <div class="mb-6">
                        <label for="proof_file" class="block text-sm font-medium text-foxecom-dark mb-2">
                            Any proof of referral (screenshot...)
                        </label>
                        <p class="text-xs text-gray-500 mb-3">
                            Upload a screenshot or any proof of your referral (optional)
                        </p>
                        <input 
                            type="file" 
                            id="proof_file" 
                            name="proof_file" 
                            accept="image/*,.pdf"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-foxecom-orange"
                        >
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
                            id="submitReferralBtn"
                            class="foxecom-btn-primary"
                        >
                            <span id="submitReferralText">Submit Referral</span>
                            <i class="fas fa-spinner fa-spin ml-2 hidden" id="submitReferralSpinner"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Referral Success Modal -->
        <div id="referralSuccessModal" class="foxecom-modal hidden">
            <div class="foxecom-modal-content">
                <div class="text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mb-4">
                        <i class="fas fa-check text-green-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-foxecom-dark mb-4">That's it! You're done!</h3>
                    <p class="text-sm text-gray-600 mb-6">
                        Having questions? Drop us a message at 
                        <a href="mailto:affiliates@foxecom.com" class="text-foxecom-orange hover:text-orange-600 underline">
                            affiliates@foxecom.com
                        </a>
                    </p>
                    <button 
                        onclick="closeReferralSuccessModal()"
                        class="foxecom-btn-primary"
                    >
                        Continue
                    </button>
                </div>
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
            toggleShopifyUrlInput(); // Reset shopify URL input visibility
        }

        function closeReferralSuccessModal() {
            document.getElementById('referralSuccessModal').classList.add('hidden');
            // Reload page to show updated referral forms
            window.location.reload();
        }

        function toggleShopifyUrlInput() {
            const minimogRadio = document.getElementById('minimog_radio');
            const megamogRadio = document.getElementById('megamog_radio');
            const shopifySection = document.getElementById('shopify_url_section');
            
            // Show Shopify URL section for non-Minimog/Megamog themes
            if (!minimogRadio.checked && !megamogRadio.checked) {
                shopifySection.style.display = 'block';
                document.getElementById('shopify_store_url').required = true;
            } else {
                shopifySection.style.display = 'none';
                document.getElementById('shopify_store_url').required = false;
                document.getElementById('shopify_store_url').value = '';
            }
        }

        // Handle referral form submission
        document.getElementById('referralForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = document.getElementById('submitReferralBtn');
            const submitText = document.getElementById('submitReferralText');
            const submitSpinner = document.getElementById('submitReferralSpinner');
            
            // Show loading state
            submitBtn.disabled = true;
            submitText.textContent = 'Submitting...';
            submitSpinner.classList.remove('hidden');
            
            const formData = new FormData(this);
            
            fetch('{{ route("advertiser.referral.store") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                // Reset button state
                submitBtn.disabled = false;
                submitText.textContent = 'Submit Referral';
                submitSpinner.classList.add('hidden');
                
                if (data.success) {
                    closeReferralModal();
                    document.getElementById('referralSuccessModal').classList.remove('hidden');
                } else {
                    alert(data.message || 'Error submitting form. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                
                // Reset button state
                submitBtn.disabled = false;
                submitText.textContent = 'Submit Referral';
                submitSpinner.classList.add('hidden');
                
                alert('Error submitting form. Please try again.');
            });
        });

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
                            <div class="md:col-span-2">
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

        document.getElementById('referralSuccessModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeReferralSuccessModal();
            }
        });

        document.getElementById('advertiserReferralViewModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeAdvertiserReferralViewModal();
            }
        });

        // Check if we should open referral modal (from registration success)
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('openReferral') === 'true') {
                openReferralModal();
                // Clean up URL
                window.history.replaceState({}, document.title, window.location.pathname);
            }
        });
        </script>
        @endsection