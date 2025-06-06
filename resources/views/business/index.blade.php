@extends('layouts.app')
        @section('content')
        <x-alert />
        <div class="container grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 mt-16">
          <!-- Greeting Card -->
          <div class="col-span-8 p-2 bg-grey rounded-xl transform transition-all hover:-translate-y-2 duration-300 shadow-lg hover:shadow-2xl">
            <div class="p-2">
                <h2 class="font-bold text-3xl mb-2 ">Hello {{ auth()->user()->first_name }} {{ auth()->user()->last_name }},</h2>
                <div class="my-4">
                  <a role='button' href='#' class="text-white bg-green-500 px-3 py-1 rounded-md hover:bg-purple-700">Business customer <i class="fa-solid fa-briefcase"></i></a>
                </div>
                  <p class="text-lg text-gray-600">Here you see all your advert campaigns activity, create new adverts, edit current ones.
                    Also, newly implemented features allows business customers to see pending adverts requests. These requests made by advertisers can be confirmed or rejected in the
                    "Check pending adverts section". 
                  </p>
            </div>
          </div>
         <!-- Activity card -->
         <div class="col-span-4 p-2 bg-grey rounded-xl transform transition-all hover:-translate-y-2 duration-300 shadow-lg hover:shadow-2xl">
            <div class="p-2">
            <h2 class="font-bold text-3xl mb-2 text-center">Recent activity</h2>
              <p class="text-lg text-gray-600">Count of <span class="medium-priority">pending</span>adverts: <span class="font-bold">{{ $requestsCount['pending'] }}</span></p>
              <p class="text-lg text-gray-600">Count of <span class="disabled-badge">rejected</span> adverts: <span class="font-bold">{{ $requestsCount['rejected'] }}</span></p>
              <p class="text-lg text-gray-600">Count of <span class="high-priority">confirmed</span>adverts: <span class="font-bold">{{ $requestsCount['confirmed'] }}</span></p>
              <p class="text-lg text-gray-600"><span class="font-bold">Total</span> <span class="all-ads">all</span>adverts: <span class="font-bold">{{ $requestsCount['all'] }}</span></p>
              <p class="text-lg text-gray-600"><span class="font-bold">Total</span> adverts campaigns views:<span class="font-bold"> {{ $campaignsViews }}</span></p>
              <p class="text-lg text-gray-600"><span class="font-bold">Total</span> created adverts campaigns:<span class="font-bold"> {{ $advertsCount }}</span></p>
            </div>
          </div>
          <!-- Create ad card -->
            <div class="col-span-3 p-2 bg-grey rounded-xl transform transition-all hover:-translate-y-2 duration-300 shadow-lg hover:shadow-2xl">
              <a href="{{url('business/create')}}">
                <div class="flex justify-center items-center text-8xl">
                  <i class="fa-solid fa-plus"></i>
                </div>
                <p class="text-2xl text-center pt-2">Create advert</p>
              </a>
            </div>
            <!-- Check pending adverts -->
            <div class="col-span-3 p-2 bg-grey rounded-xl transform transition-all hover:-translate-y-2 duration-300 shadow-lg hover:shadow-2xl">
              <a href="{{route('adverts.pending')}}">
                <div class="flex justify-center items-center text-7xl py-4 ">
                <i class="fa-solid fa-clock"></i>
                </div>
                <p class="text-xl text-center pb-2">Check <span class="medium-priority">pending</span> adverts</p>
              </a>
            </div>
             <!-- Check active adverts -->
             <div class="col-span-3 p-2 bg-grey rounded-xl transform transition-all hover:-translate-y-2 duration-300 shadow-lg hover:shadow-2xl">
             <a href="{{route('adverts.active')}}">
                <div class="flex justify-center items-center text-7xl py-4">
                <i class="fa-solid fa-circle-check"></i>
                </div>
                <p class="text-xl text-center pb-2">Check <span class="high-priority">active</span> adverts</p>
              </a>
            </div>
            <!-- Check all adverts -->
            <div class="col-span-3 p-2 bg-grey rounded-xl transform transition-all hover:-translate-y-2 duration-300 shadow-lg hover:shadow-2xl">
            <a href="{{route('adverts.all')}}">
                <div class="flex justify-center items-center text-7xl py-4">
                <i class="fa-solid fa-rectangle-ad"></i>
                </div>
                <p class="text-xl text-center pb-2">Check <span class="all-ads">all</span> adverts</p>
              </a>
            </div>
            <!-- Manage clients -->
            <div class="col-span-6 p-2 bg-grey rounded-xl transform transition-all hover:-translate-y-2 duration-300 shadow-lg hover:shadow-2xl">
              <a href="{{ route('clients.all') }}">
                <div class="flex justify-center items-center text-7xl py-4">
                  <i class="fa-solid fa-users"></i>
                </div>
                <p class="text-xl text-center pb-2">Manage <span class="text-orange-500">Clients</span></p>
              </a>
            </div>
            <!-- Spacer -->
            <div class="col-span-6"></div>
            
            <div class="col-span-12 p-4 bg-grey rounded-xl shadow-lg">
              <div class="p-2">
                <h2 class="font-bold text-3xl mb-2 text-center">My created adverts campaigns</h2>
              </div>
              <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                <div class="overflow-y h-72">
                  <table class="table-auto overflow-scroll w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700">
                      <tr class="uppercase">
                        <th scope="col" class="py-3 px-6">
                            Advert Title
                        </th>
                        <th scope="col" class="py-3 px-6">
                            Industry
                        </th>
                        <th scope="col" class="py-3 px-6">
                            Start date
                        </th>
                        <th scope="col" class="py-3 px-6">
                            End date
                        </th>
                        <th scope="col" class="py-3 px-6 text-center">
                            Current status
                        </th>
                        <th scope="col" class="py-3 px-6 text-center">
                            Max adv. count
                        </th>
                        <th scope="col" class="py-3 px-6 text-center">
                            Last updated
                        </th>
                        <th scope="col" class="py-3 px-6">
                            Action
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($adverts as $advert)
                      <tr class="bg-white border-b ">
                        <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap show-link">
                          <a href="{{ route('business.show', $advert->id) }}"> {{$advert->advert_name}} </a>
                        </th>
                        <td class="py-4 px-6">
                        {{$advert->industry}}
                        </td>
                        <td class="py-4 px-6">
                        {{$advert->start_date}}
                        </td>
                        <td class="py-4 px-6">
                        {{$advert->end_date}}
                        </td>
                        <td class="py-4 px-6 text-center">
                        @if($advert->current_status)
                        <span class="active-badge">Active</span>
                        @else
                        <span class="disabled-badge">Disabled</span>
                        @endif
                        </td>
                        <td class="py-2 px-2 text-center">
                        {{$advert->max_advertisers_count}}
                        </td>
                        <td class="py-4 px-6 text-center">
                        {{ \Carbon\Carbon::parse($advert->updated_at)->diffForHumans() }}
                        </td>
                        <td class="py-4 px-6">
                          <div class="flex">
                             <a href="{{ route('business.edit',  $advert->id) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline mr-4"><i class="fa-solid fa-pen-to-square"></i></a>
                            <!-- <a href="{{ action('\App\Http\Controllers\BusinessController@destroy', ['advert' => $advert->id]) }}" class="font-medium text-blue-600 dark:text-red-500 hover:underline"><i class="fa-solid fa-trash"></i></a> -->
                              <button type="button" data-modal-toggle="popup-modal" class="font-medium text-blue-600 dark:text-red-500 hover:underline" title="Delete"><i class="fa-solid fa-trash"></i> </button>
                          </div>
                        </td>
                      </tr>
                      <!-- Delete confirmation modal -->
                      <div id="popup-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 md:inset-0 h-modal md:h-full">
                        <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-toggle="popup-modal">
                                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                                <div class="p-6 text-center">
                                    <svg aria-hidden="true" class="mx-auto mb-4 w-14 h-14 text-gray-400 dark:text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to delete this advert?</h3>
                                    <form action="{{ route('business.destroy', $advert->id) }}" method="POST">
                                     @csrf  
                                    @method('DELETE')                                     
                                      <button data-modal-toggle="popup-modal" type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                        Yes, I'm sure
                                    </button>
                        </form>
                <button data-modal-toggle="popup-modal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">No, cancel</button>
            </div>
        </div>
    </div>
    <!-- Delete confirmation modal END -->
</div>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
        </div>
        @endsection