@extends('layouts.app')
@section('content')
<div class="mt-8 text-center">
    <h1 class="font-medium leading-tight text-4xl mt-0 mb-2 text-bringlu-blue">{{ $form->title }}</h1>
    <p class="text-lg text-gray-600 mb-8">{{ $form->description }}</p>
</div>

<div class="container grid grid-cols-1 lg:grid-cols-12 mt-8">
    <div class="col-span-12 p-2 bg-grey rounded-xl shadow-lg">
        <form class="w-full max-w-xxl" action="{{ route('advertiser.form.submit', $form->id) }}" method="post">
            @csrf
            
            @foreach($form->fields as $index => $field)
            <div class="flex flex-wrap -mx-3 mb-4">
                <div class="w-full px-3">
                    <label class="bringlu-label-plain" for="response_{{ $index }}">{{ $field }}</label>
                    <textarea class="block p-2.5 w-full text-sm bringlu-input-plain px-4" 
                              id="response_{{ $index }}" 
                              name="responses[{{ $index }}]" 
                              placeholder="Enter your response for: {{ $field }}" 
                              required></textarea>
                </div>
            </div>
            @endforeach

            <div class="flex flex-wrap -mx-3 mb-4">
                <div class="w-full text-end px-3">
                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        Submit Form
                    </button>
                    <a href="{{ route('advertiser.dashboard') }}" 
                       class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded ml-2">
                        Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection