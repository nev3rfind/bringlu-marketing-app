@extends('layouts.app')
    @section('content')
    <div class="mt-8 text-center">
        <h1 class="font-medium leading-tight text-4xl mt-0 mb-2 text-bringlu-blue">Edit Advert 
        <a class="show-link" href="{{ action('\App\Http\Controllers\BusinessController@show', ['advert' => $advert->id]) }}"> {{$advert->advert_name}} </a>    
        <i class="ml-4 fa-solid fa-pen-to-square"></i></h1>
    </div>
    <div class="container grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 mt-8">
        <div class="col-span-12 p-2 bg-grey rounded-xl shadow-lg hover:shadow-2xl">
            <form class="w-full max-w-xxl" action="{{ route('business.update', ['advert' => $advert->id] ) }}" method="post">
                @method('PUT')
                @csrf
                <div class="flex flex-wrap -mx-3 mb-4">
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="bringlu-label-plain" for="advert_name">
                             Advert Title
                        </label>
                        <input class="bringlu-input-plain px-4" id="advert-Name" name="advert_name" type="text" placeholder="" value="{{$advert->advert_name}}">
                        @error('advert_name')
                            <p class="text-red-500 text-xs italic">Please make an advert title!</p>
                        @enderror
                    </div>
                    <div class="w-full md:w-1/2 px-3">
                        <label class="bringlu-label-plain" for="industry">
                            Industry
                        </label>
                        <input class="bringlu-input-plain px-4" id="industry" name="industry" type="text" placeholder="" value="{{$advert->industry}}">
                        @error('industry')
                            <p class="text-red-500 text-xs italic">Please fill out the industry field.</p>
                        @enderror
                    </div>
                </div>
                <div class="flex flex-wrap -mx-3 mb-4">
                    <div class="w-full px-3">
                        <label class="bringlu-label-plain" for="description">
                            Advert Description
                        </label>
                        <textarea class="block p-2.5 w-full text-sm bringlu-input-plain px-4" id="description" name="description" placeholder="">{{$advert->description}}</textarea>
                        @error('description')
                        <p class="text-red-500 text-xs italic">Please describe your advert into the great details</p>
                        @enderror
                    </div>
                </div>
                <div class="flex flex-wrap -mx-3 mb-4">
                    <div class="w-full md:w-1/2 px-3">
                    <label class="bringlu-label-plain" for="start_date">
                            Advertising campaign start date
                        </label>
                        <div class="relative">
                            <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                            </div>
                            <input datepicker datepicker-autohide datepicker-format="yyyy/mm/dd" datepicker-buttons type="text" id="start_date" name="start_date" class="bringlu-input-plain block w-full p-2.5 px-10" placeholder="Select advert start date" value="{{$advert->start_date}}">
                        </div>
                    </div>
                    <div class="w-full md:w-1/2 px-3">
                    <label class="bringlu-label-plain" for="end_date">
                            Advertising campaign end date
                        </label>
                        <div class="relative">
                            <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                            </div>
                            <input datepicker datepicker-autohide datepicker-format="yyyy/mm/dd" datepicker-buttons type="text" id="end_date" name="end_date" class="bringlu-input-plain block w-full p-2.5 px-10" placeholder="" value="{{$advert->end_date}}">
                        </div>
                    </div>
                </div>
                <div class="flex flex-wrap -mx-3 mb-4">
                    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="priority_level">
                            Priority level
                        </label>
                        <div class="relative">
                            <select id="priority_level" name="priority_level" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                            <option selected disabled>Select priority</option>
                                <option {{ $advert->priority_level == 3 ? 'selected' : '' }} value="3">High</option>
                                <option {{ $advert->priority_level == 2 ? 'selected' : '' }} value="2">Medium</option>
                                <option {{ $advert->priority_level == 1 ? 'selected' : '' }} value="1">Low</option>
                            </select>
                        </div>
                    </div>
                    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="category_id">
                        Advert category
                        </label>
                        <div class="relative">
                            <select id="category_id" name="advert_category_id" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                            <option selected disabled >Select advert category</option>
                                @foreach($advertCategories as $category)
                                    <option {{ $advert->advert_category_id == $category->id ? 'selected' : ''}} value="{{ $category->id}}">{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="media_id">
                        Main social media (to advertise)
                        </label>
                        <div class="relative">
                            <select id="media_id" name="advert_media_id" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                            <option selected disabled >Select social media</option>
                                @foreach($mediaTypes as $type)
                                    <option {{ $advert->advert_media_id == $type->id ? 'selected' : ''}} value="{{ $type->id }}">{{ $type->media_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="flex flex-wrap -mx-3 mb-4">
                    <div class="w-full px-3">
                        <label class="bringlu-label-plain" for="web_Url">
                            Advertised product or service link
                        </label>
                        <input class="bringlu-input-plain px-4" id="web_Url" name="web_url" type="url" value="{{ $advert->web_url }}">
                    </div>
                </div>
                <div class="flex flex-wrap -mx-3 mb-4">
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="bringlu-label-plain" for="advertisers_Count">
                             Maximum enrolled advertisers count per ad
                        </label>
                        <input class="bringlu-input-plain px-4" id="advertisers_Count" name="max_advertisers_count" type="number" value="{{ $advert->max_advertisers_count }}">
                    </div>
                </div>
                <div class="flex flex-wrap -mx-3 mb-4">
                    <div class="w-full px-3">
                        <label class="bringlu-label-plain" for="comments">
                            Additional comments
                        </label>
                        <textarea class="block p-2.5 w-full text-sm bringlu-input-plain px-4" id="comments" name="comments" type="text" placeholder="Please put here any extra comments">{{ $advert->comments }}</textarea>
                        @error('comments')
                        <p class="text-red-500 text-xs italic">Please add some comments for advertisers</p>
                        @enderror
                    </div>
                </div>
                <div class="flex flew-wrap -mx-3 mb-4">
                    <div class="w-full md:w-1/2 px-3 mb-6 mt-8 md:mb-0">
                        <div class="flex items-center">
                            <input checked id="current_status" name="current_status" type="checkbox" value="1" class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="current_status" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Advert Status (checked - active | unchecked - disabled) </label>
                        </div>
                    </div>
                </div>
                <div class="flex flew-wrap -mx-3 mb-4">
                    <div class="w-full text-end px-3 ">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                        Edit form
                    </button>
                    </div>
                </div>
        </form>
</div>
</div>
@endsection