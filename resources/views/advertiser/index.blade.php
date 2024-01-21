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
          <!-- Create ad card -->
            <div class="col-span-12 p-4 bg-grey rounded-xl shadow-lg">
              <div class="p-2">
                <h2 class="font-bold text-3xl mb-2 text-center">All active adverts</h2>
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
                            Advert Media
                        </th>
                        <th scope="col" class="py-3 px-6">
                            End date
                        </th>
                        <th scope="col" class="py-3 px-6 text-center">
                            Max advert. count
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
                        <td class="py-4 px-6">
                        {{$advert->advert_name}}
                        </td>
                        <td class="py-4 px-6">
                        {{$advert->industry}}
                        </td>
                        <td class="py-4 px-6">
                        {{$advert->advertMedias->media_name}}
                        </td>
                        <td class="py-4 px-6">
                        {{$advert->end_date}}
                        </td>
                        <td class="py-4 px-6 text-center">
                        {{$advert->max_advertisers_count}}
                        </td>
                        <td class="py-4 px-6 text-center">
                        {{ \Carbon\Carbon::parse($advert->updated_at)->diffForHumans() }}
                        </td>
                        <td>
                        <a href="{{ route('advert.show', $advert->id) }}">
                        <button class="bg-blue-500 hover:bg-blue-700 text-white text-xs font-bold py-2 px-4 rounded-full">
                          View details
                        </button>
                        </a>
                        </td>
                      </tr>
                      <!-- Delete confirmation modal -->
                      <!-- Delete confirmation modal END -->
                      </div>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="col-span-12 pt-8">
              <div class="p-2">
                <h2 class="text-3xl mb-2 text-center">
                <a href="{{ route('advert.activity') }}">
                  <button type="button" class="bg-green-500 text-white rounded-md px-7 py-3 uppercase">View my adverts activity</button>
                </a>
                </h2>
              </div>
            </div>
        </div>
        @endsection