@extends('layouts.app')
        @section('content')
        <!-- Home -->
        <section class="relative">
            <div class="container flex flex-col-reverse lg:flex-row items-center gap-12 mt-14 lg:mt-28">
                <!-- Content -->
                <div class="flex flex-1 flex-col items-center lg:items-center">
                    <h2 class="text-bringlu-blue text-3xl md:text-4 lg:text-5xl text-center lg:text-left mb-6">
                        Bringlu
                    </h2>
                    <p class="text-bringlu-grey text-lg text-center lg:text-left mb-6">
                    Foxecom referal platform
                    </p>
                    <div class="flex justify-center flex-wrap gap-6">
                        <button type="button" class="btn btn-purple hover:bg-pringlu-purple hover:text-black">Advertiser</button>
                        <button type="button" class="btn btn-white hover:bg-bringlu-purple hover:text-white">Business</button>
                    </div>
                </div>
            </div>
        </section>
        <!-- About -->
        <section id="about" class="bg-bringlu-white py-28 mt-20 lg:mt-60">
            <!-- Heading -->
            <div class="sm:w-3/4 lg:w-5/12 mx-auto px-2">
                <h1 class="text-3xl text-center text-bringlu-blue">About</h1>
                <p class="text-center text-bringlu-grey mt-4">
               Just another page
</p>
            </div>
        </section>
        @endsection