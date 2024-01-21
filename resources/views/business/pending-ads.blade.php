@extends('layouts.app')
    @section('content')
    <div class="mt-8 text-center">
        <h1 class="font-medium leading-tight text-4xl mt-0 mb-2 text-bringlu-blue">Pending adverts from requests</h1>
    </div>
    <x-alert />
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
                            Advertiser
                        </th>
                        <th scope="col" class="py-3 px-6 text-center">
                            Advertiser message
                        </th>
                        <th scope="col" class="py-3 px-6 text-center">
                            Request date
                        </th>
                        <th scope="col" class="py-3 px-6 text-center">
                            Approve?
                        </th>
                        <th scope="col" class="py-3 px-6 text-center">
                            Reject?
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach($pendingAdverts as $pendingAdvert)
                      <tr class="bg-white border-b ">
                        <td class="py-4 px-6">
                        {{$loop->iteration}}
                        </td>
                        <td class="py-4 px-6">
                        {{$pendingAdvert->advert->advert_name}}
                        </td>
                        <td class="py-4 px-6">
                        {{$pendingAdvert->advert->advertCategories->category_name}}
                        </td>
                        <td class="py-4 px-6">
                        {{$pendingAdvert->advert->advertMedias->media_name}}
                        </td>
                        <td class="py-4 px-6 text-center">
                        {{$pendingAdvert->advertiser->email}}
                        </td>
                        <td class="py-4 px-6 text-center">
                        view here
                        </td>
                        <td>
                        {{ \Carbon\Carbon::parse($pendingAdvert->last_actioned_at)->diffForHumans() }}
                        </td>
                        <td class="py-4 px-6 text-center">
                          <form action="{{ route('adverts.pending.confirm', ['advert' => $pendingAdvert->advert_id, 'user' => $pendingAdvert->user_id]) }}" method="POST">
                          @method('PUT')
                          @csrf
                        <button type="submit" class="confirm-button"><i class="fa-solid fa-check"></i></button>
                          </form>
                        </td>
                        <td class="py-4 px-6 text-center">
                        <form action="{{ route('adverts.pending.reject', ['advert' => $pendingAdvert->advert_id, 'user' => $pendingAdvert->user_id]) }}" method="POST">
                          @method('PUT')
                          @csrf
                        <button type="submit" class="reject-button"><i class="fa-solid fa-xmark"></i></button>
                          </form>
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