@extends('layouts.app')
    @section('content')
    <div class="mt-8 text-center">
        <h1 class="font-medium leading-tight text-4xl mt-0 mb-2 text-bringlu-blue">My adverts activity</h1>
    </div>
    <div class="container grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 p-5">
    <div class="col-span-12 p-4 bg-grey rounded-xl shadow-lg">
    <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                <div class="overflow-y h-72">
                  <table class="table-auto overflow-scroll w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700">
                      <tr class="uppercase">
                        <th scope="col" class="px-4 py-3 text-left">
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
                            Advert owner
                        </th>
                        <th scope="col" class="py-3 px-6 text-center">
                            Status
                        </th>
                        <th scope="col" class="py-3 px-6 text-center">
                            Status updated
                        </th>
                        <th scope="col" class="py-3 px-6 text-center">
                            Action
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($advert_status as $status_item)
                      <tr class="bg-white border-b ">
                        <td class="py-4 px-6 text-left">
                        {{$loop->iteration}}
                        </td>
                        <td class="py-4 px-6">
                        {{$status_item->advert->advert_name}}
                        </td>
                        <td class="py-4 px-6 text-center">
                        {{$status_item->advert->advertCategories->category_name}}
                        </td>
                        <td class="py-4 px-6 text-center">
                        {{$status_item->advert->advertMedias->media_name}}
                        </td>
                        <td class="py-4 px-6 text-center">
                        {{$status_item->advert->user->email}}
                        </td>
                        <td class="py-4 px-6 text-center">
                        @if($status_item->advert_status === 'pending')
                        <span class="medium-priority">{{$status_item->advert_status}}</span>
                        @elseif($status_item->advert_status === 'confirmed')
                        <span class="high-priority">{{$status_item->advert_status}}</span>
                        @else
                        <span class="disabled-badge">{{$status_item->advert_status}}</span>
                        @endif
                        </td>
                        <td class="py-4 px-6 text-center">
                        {{ \Carbon\Carbon::parse($status_item->last_actioned_at)->diffForHumans() }}
                        </td>
                        <td class="py-4 px-6 text-center">
                        <a href="{{ route('advert.show', $status_item->advert->id) }}"><button type="button" class="bg-green-300 text-white rounded-md px-4 py-2 hover:bg-green-500">view</button></a>
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