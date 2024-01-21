@extends('layouts.app')
    @section('content')
    <div class="mt-8 text-center">
        <h1 class="font-medium leading-tight text-4xl mt-0 mb-2 text-bringlu-blue">Advert details</h1>
    </div>
    <div class="container grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 p-5">
            <div class="text-lg text-center p-10 rounded-lg shadow-lg"><div class="text-black-500 font-bold">Advert Title:</div><div class="text-black-100">{{$advert->advert_name}}</div></div>
            <div class="text-lg text-center p-10 rounded-lg shadow-lg"><div class="text-black-500 font-bold">Industry:</div><div class="text-black-100">{{$advert->industry}}</div></div>
            <div class="text-lg text-center p-10 rounded-lg shadow-lg"><div class="text-black-500 font-bold">Started date:</div><div class="text-black-100">{{$advert->start_date}}</div></div>
            <div class="text-lg text-center p-10 rounded-lg shadow-lg"><div class="text-black-500 font-bold">End date:</div><div class="text-black-100">{{$advert->end_date}}</div></div>
            <div class="col-span-2 before:text-lg text-center p-10 rounded-lg shadow-lg"><div class="text-black-500 font-bold">Description:</div><div class="text-black-100">{{$advert->description}}</div></div>
            <div class="col-span-2 before:text-lg text-center p-10 rounded-lg shadow-lg"><div class="text-black-500 font-bold">Comments:</div><div class="text-black-100">{{$advert->comments}}</div></div>
            <div class="text-lg text-center p-10 rounded-lg shadow-lg"><div class="text-black-500 font-bold">Advert Status:</div><div class="text-black-100">
                @if($advert->current_status)
                <span class="active-badge">Active</span>
                @else
                <span class="disabled-badge">Disabled</span>
                @endif</div>           
            </div>
            <div class="text-lg text-center p-10 rounded-lg shadow-lg"><div class="text-black-500 font-bold">Priority level:</div><div class="text-black-100">
                @if($advert->priority_level === 3)
                <span class="high-priority">High</span>
                @elseif($advert->priority_level === 2)
                <span class="medium-priority">Medium</span>
                @else
                <span class="low-priority">Medium</span>
                @endif</div>
            </div>
            <div class="text-lg text-center p-10 rounded-lg shadow-lg"><div class="text-black-500 font-bold">Primary media:</div><div class="text-black-100">{{$advert->advertMedias->media_name}}</div></div>
            <div class="text-lg text-center p-10 rounded-lg shadow-lg"><div class="text-black-500 font-bold">Advert type:</div><div class="text-black-100">{{$advert->advertCategories->category_name}}</div></div> 
            <div class="col-span-3 before:text-lg text-center p-10 rounded-lg shadow-lg"><div class="text-black-500 font-bold text_underline">Advertised website link (URL)</div><div class="text-blue-500 underline"><a href="{{$advert->web_url}}">{{ \Illuminate\Support\Str::limit($advert->web_url, 80, $end='...') }}</a></div></div>
            <div class="col-span-1 before:text-lg text-center p-10 rounded-lg shadow-lg"><div class="text-black-500 font-bold text_underline">Max advertisers</div><span class="disabled-badge">{{$advert->max_advertisers_count}}</span></div>
            @if ($requestForm)
            <form class="col-span-4" action="{{ route('advert.request', $advert->id) }}" method="POST">
                @csrf
                <div class="text-lg text-center p-10 rounded-lg shadow-lg">
                        <div class="w-full px-3">
                            <label class="text-black-500 font-bold" for="comments">
                                Message for advert owner
                            </label>
                            <textarea class="block p-2.5 w-full text-sm bringlu-input-plain px-4" id="comments" name="extra_details" type="text" placeholder="Please add some message or question to advertiser owner before you start advertising his ad"></textarea>
                            @error('extra_details')
                            <p class="text-red-500 text-xs italic">You must add message for the advert owner!</p>
                            @enderror
                        </div>
                </div>
                <div class="pt-8">
                        <div class="w-full text-end">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                                Request enrollment to advertise
                            </button>
                        </div>
                </div>
            </form>
            
            @else
            <div class="col-span-4 pt-8">
              <div class="p-2">
                <h2 class="text-3xl mb-2 text-center">
                <a href="{{ route('advert.topdf', $advert->id) }}">
                  <button type="button" class="bg-green-500 text-white rounded-md px-7 py-3 uppercase">Click here to download PDF</button>
                </a>
                </h2>
              </div>
            </div>
            @endif                 
    </div>
    @endsection