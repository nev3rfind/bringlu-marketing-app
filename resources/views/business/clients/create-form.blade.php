@extends('layouts.app')
@section('content')
<div class="mt-8 text-center">
    <h1 class="font-medium leading-tight text-4xl mt-0 mb-2 text-bringlu-blue">
        Create Form for {{ $client->first_name }} {{ $client->last_name }}
    </h1>
</div>

<div class="container grid grid-cols-1 lg:grid-cols-12 mt-8">
    <div class="col-span-12 p-2 bg-grey rounded-xl shadow-lg">
        <form class="w-full max-w-xxl" action="{{ route('clients.forms.store', $client->id) }}" method="post">
            @csrf
            <div class="flex flex-wrap -mx-3 mb-4">
                <div class="w-full px-3">
                    <label class="bringlu-label-plain" for="title">Form Title</label>
                    <input class="bringlu-input-plain px-4" id="title" name="title" type="text" 
                           placeholder="Enter form title" value="{{ old('title') }}" required>
                    @error('title')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex flex-wrap -mx-3 mb-4">
                <div class="w-full px-3">
                    <label class="bringlu-label-plain" for="description">Form Description</label>
                    <textarea class="block p-2.5 w-full text-sm bringlu-input-plain px-4" id="description" 
                              name="description" placeholder="Enter form description" required>{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex flex-wrap -mx-3 mb-4">
                <div class="w-full px-3">
                    <label class="bringlu-label-plain">Form Fields</label>
                    <div id="formFields">
                        <div class="field-group mb-2">
                            <input class="bringlu-input-plain px-4" name="fields[]" type="text" 
                                   placeholder="Enter field label" required>
                        </div>
                    </div>
                    <button type="button" onclick="addField()" 
                            class="bg-blue-500 hover:bg-blue-700 text-white text-xs px-3 py-1 rounded mt-2">
                        Add Field
                    </button>
                </div>
            </div>

            <div class="flex flex-wrap -mx-3 mb-4">
                <div class="w-full text-end px-3">
                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        Create Form
                    </button>
                    <a href="{{ route('clients.forms', $client->id) }}" 
                       class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded ml-2">
                        Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function addField() {
    const fieldsContainer = document.getElementById('formFields');
    const fieldGroup = document.createElement('div');
    fieldGroup.className = 'field-group mb-2 flex items-center';
    fieldGroup.innerHTML = `
        <input class="bringlu-input-plain px-4 flex-1" name="fields[]" type="text" 
               placeholder="Enter field label" required>
        <button type="button" onclick="removeField(this)" 
                class="bg-red-500 hover:bg-red-700 text-white text-xs px-2 py-1 rounded ml-2">
            Remove
        </button>
    `;
    fieldsContainer.appendChild(fieldGroup);
}

function removeField(button) {
    button.parentElement.remove();
}
</script>
@endsection