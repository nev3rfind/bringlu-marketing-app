@extends('layouts.app')
        @section('content')
        <x-alert />
        <div class="container grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 mt-16">
          <!-- Greeting Card -->
          <div class="col-span-8 p-2 bg-grey rounded-xl transform transition-all hover:-translate-y-2 duration-300 shadow-lg hover:shadow-2xl">
            <div class="p-2">
                <h2 class="font-bold text-3xl mb-2 ">Hello {{ auth()->user()->first_name }} {{ auth()->user()->last_name }},</h2>
                <div class="my-4">
                  <a role='button' href='#' class="text-white bg-orange-500 px-3 py-1 rounded-md hover:bg-purple-700">Advertiser <i class="fa-solid fa-rectangle-ad"></i></a>
                </div>
                  <p class="text-lg text-gray-600">Here you can view all active advertisiment campaigns published by businesses
                    You can also view details of each campaign and requested to advetise.
                    Requests progress can be tracked by pressing <span class="font-bold">'View My Adverts Activity' </span> button
                  </p>
            </div>
          </div>
         <!-- Activity card -->
         <div class="col-span-4 p-2 bg-grey rounded-xl transform transition-all hover:-translate-y-2 duration-300 shadow-lg hover:shadow-2xl">
            <div class="p-2">
            <h2 class="font-bold text-3xl mb-2 text-center">My activity</h2>
              <p class="text-lg text-gray-600">Currently advertising: <span class="font-bold">{{ $requestsCount['confirmed'] }}</span> adverts</p>
              <p class="text-lg text-gray-600">Rejected requests: <span class="font-bold">{{ $requestsCount['rejected'] }}</span></p>
              <p class="text-lg text-gray-600">Pending requests:  <span class="font-bold">{{ $requestsCount['pending'] }}</span></p>
              <p class="text-lg text-gray-600"><span class="font-bold">Total</span> requests:  <span class="font-bold">{{ $requestsCount['all'] }}</span></p>
            </div>
          </div>
          
          <!-- Dashboard Cards Section -->
          <div class="col-span-12 p-4 bg-grey rounded-xl shadow-lg">
              <div class="p-2">
                  <h2 class="font-bold text-3xl mb-2 text-center">My Dashboard</h2>
              </div>
              <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                  @foreach($dashboardCards as $card)
                  <div class="bg-white rounded-lg shadow-md p-4 hover:shadow-lg transition-shadow duration-300">
                      <div class="flex justify-between items-start mb-2">
                          <div>
                              <h3 class="text-lg font-bold text-gray-800">{{ $card->title }}</h3>
                              <p class="text-gray-600 text-sm">{{ $card->description }}</p>
                          </div>
                      </div>
                      <div class="text-2xl font-bold text-bringlu-blue mb-2">
                          {{ $card->current_value }}
                      </div>
                  </div>
                  @endforeach
              </div>
          </div>

          <!-- Referral Forms Section -->
          <div class="col-span-12 p-4 bg-grey rounded-xl shadow-lg">
              <div class="p-2 flex justify-between items-center">
                  <h2 class="font-bold text-3xl mb-2">My Referral Forms</h2>
                  <button 
                      onclick="openReferralModal()"
                      class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded"
                  >
                      Submit Referral Form
                  </button>
              </div>
              <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                  <div class="overflow-y h-72">
                      <table class="table-auto overflow-scroll w-full text-sm text-left text-gray-500">
                          <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                              <tr class="uppercase">
                                  <th scope="col" class="py-3 px-6">Form ID</th>
                                  <th scope="col" class="py-3 px-6">Referral Name</th>
                                  <th scope="col" class="py-3 px-6">Company</th>
                                  <th scope="col" class="py-3 px-6">Template</th>
                                  <th scope="col" class="py-3 px-6">Expected Revenue</th>
                                  <th scope="col" class="py-3 px-6 text-center">Submission Date</th>
                                  <th scope="col" class="py-3 px-6 text-center">Status</th>
                              </tr>
                          </thead>
                          <tbody>
                              @forelse($referralForms as $form)
                              <tr class="bg-white border-b">
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
                                          <span class="medium-priority">{{ $form->status }}</span>
                                      @elseif($form->status === 'accepted')
                                          <span class="high-priority">{{ $form->status }}</span>
                                      @else
                                          <span class="disabled-badge">{{ $form->status }}</span>
                                      @endif
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
        <div id="referralModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
            <div class="relative top-10 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white">
                <div class="mt-3">
                    <h3 class="text-lg font-medium text-gray-900 text-center mb-4">Submit Referral Form</h3>
                    <form id="referralForm" method="POST" action="{{ route('advertiser.referral.store') }}">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="referral_name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Referral Name *
                                </label>
                                <input 
                                    type="text" 
                                    id="referral_name" 
                                    name="referral_name" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required
                                >
                            </div>
                            <div>
                                <label for="company" class="block text-sm font-medium text-gray-700 mb-2">
                                    Company *
                                </label>
                                <input 
                                    type="text" 
                                    id="company" 
                                    name="company" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required
                                >
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                                Address *
                            </label>
                            <textarea 
                                id="address" 
                                name="address" 
                                rows="3"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required
                            ></textarea>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="template" class="block text-sm font-medium text-gray-700 mb-2">
                                    Template *
                                </label>
                                <select 
                                    id="template" 
                                    name="template" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required
                                >
                                    <option value="">Select Template</option>
                                    <option value="foxecom_commercial">Foxecom Commercial Template</option>
                                    <option value="foxecom_baked">Foxecom Baked</option>
                                    <option value="foxecom_super_shopify">Foxecom Super Shopify</option>
                                </select>
                            </div>
                            <div>
                                <label for="expected_revenue" class="block text-sm font-medium text-gray-700 mb-2">
                                    Expected Revenue ($) *
                                </label>
                                <input 
                                    type="number" 
                                    id="expected_revenue" 
                                    name="expected_revenue" 
                                    step="0.01"
                                    min="0"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required
                                >
                            </div>
                        </div>
                        
                        <div class="flex justify-end space-x-3 mt-6">
                            <button 
                                type="button" 
                                onclick="closeReferralModal()"
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded"
                            >
                                Cancel
                            </button>
                            <button 
                                type="submit"
                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded"
                            >
                                Submit Referral
                            </button>
                        </div>
                    </form>
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

        // Close modal when clicking outside
        document.getElementById('referralModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeReferralModal();
            }
        });
        </script>
        @endsection