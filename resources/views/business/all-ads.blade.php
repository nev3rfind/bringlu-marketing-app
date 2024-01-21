@extends('layouts.app')
    @section('content')
    <div class="mt-8 text-center">
        <h1 class="font-medium leading-tight text-4xl mt-0 mb-2 text-bringlu-blue">All requested/confirmed/rejected adverts</h1>
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
                            Confirm date
                        </th>
                        <th scope="col" class="py-3 px-6 text-center">
                            Last status
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach($allAdverts as $everyAdvert)
                      <tr class="bg-white border-b ">
                        <td class="py-4 px-2 text-center">
                        {{$loop->iteration}}
                        </td>
                        <td class="py-4 px-6 text-left">
                        {{$everyAdvert->advert->advert_name}}
                        </td>
                        <td class="py-4 px-6 text-center">
                        {{$everyAdvert->advert->advertCategories->category_name}}
                        </td>
                        <td class="py-4 px-6 text-center">
                        {{$everyAdvert->advert->advertMedias->media_name}}
                        </td>
                        <td class="py-4 px-6 text-center">
                        {{$everyAdvert->advertiser->email}}
                        </td>
                        <td class="py-4 px-6 text-center">
                        {{ \Carbon\Carbon::parse($everyAdvert->last_actioned_at)->diffForHumans() }}
                        </td>
                        <td class="py-4 px-6 text-center">
                        @if($everyAdvert->advert_status === 'pending')
                        <span class="medium-priority">{{$everyAdvert->advert_status}}</span>
                        @elseif($everyAdvert->advert_status === 'confirmed')
                        <span class="high-priority">{{$everyAdvert->advert_status}}</span>
                        @else
                        <span class="disabled-badge">{{$everyAdvert->advert_status}}</span>
                        @endif
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