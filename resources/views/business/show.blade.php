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
    </div>
    @endsection