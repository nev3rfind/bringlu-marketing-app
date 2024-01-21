@extends('layouts.app')
    @section('content')
    <div class="mt-8 text-center">
        <h1 class="font-medium leading-tight text-4xl mt-0 mb-2 text-bringlu-blue">Confirmed (active) adverts</h1>
    </div>
    <x-alert />
    <div class="container grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 p-5">
    <div class="col-span-12 p-4 bg-grey rounded-xl shadow-lg">
    <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                <div class="overflow-y h-72">
                  <table class="table-auto overflow-scroll w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700">
                      <tr class="uppercase">
                        <th scope="col" class="px-2 py-3 text-center">
                            List NO.
                        </th>
                        <th scope="col" class="py-3 px-6 text-left">
                            Advert name
                        </th>
                        <th scope="col" class="py-3 px-6 text-center">
                            Advert category
                        </th>
                        <th scope="col" class="py-3 px-6 text-center">
                            Advert media
                        </th>
                        <th scope="col" class="py-3 px-6 text-center">
                            Advertiser
                        </th>
                        <th scope="col" class="py-3 px-6 text-center">
                            Advertiser Full name
                        </th>
                        <th scope="col" class="py-3 px-6 text-center">
                            Confirm date
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach($activeAdverts as $pendingAdvert)
                      <tr class="bg-white border-b ">
                        <td class="py-4 px-2 text-center">
                        {{$loop->iteration}}
                        </td>
                        <td class="py-4 px-6 text-left">
                        {{$pendingAdvert->advert->advert_name}}
                        </td>
                        <td class="py-4 px-6 text-center">
                        {{$pendingAdvert->advert->advertCategories->category_name}}
                        </td>
                        <td class="py-4 px-6 text-center">
                        {{$pendingAdvert->advert->advertMedias->media_name}}
                        </td>
                        <td class="py-4 px-6 text-center">
                        {{$pendingAdvert->advertiser->email}}
                        </td>
                        <td class="py-4 px-6 text-center">
                        {{$pendingAdvert->advertiser->first_name}} {{$pendingAdvert->advertiser->last_name}}
                        </td>
                        <td>
                        {{ \Carbon\Carbon::parse($pendingAdvert->last_actioned_at)->diffForHumans() }}
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
    </div>
    @endsection