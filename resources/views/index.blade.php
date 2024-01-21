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
                    Main goal of this project is to let businesses to find potential advetisers for their products/services and increase sales. Also, for advertisers is to earn extra money by advetising other businesses on social media platforms.
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
                There are two types of customers in my web application:
Advertisers - can see all active advert campaigns created by other businesses and get enrolled to advertise any of them. Following advert description and instruction advertiser has to make a post or upload a story to companies selected social media account (specified in advert details). My web application has to track that post or story, identify if it contains the same advertised product/service for which user is enrolled to advertise and reward him with points. Also, Bringlu web application can create 'magic' links which advertisers has to use to redirect potential clients to that specific product website through my web application. For each 'magic' link click advertisers will also be rewarded by extra points. (Future implementation)
                </p>
                <p class="text-center text-bringlu-grey mt-4">
                Business - can create custom advert campaigns by filling a form. 
Business customer needs to specify advert title, industry of his advertised product, advert description (specifying how the advertiser should present his product/service), start and end date to indicate how long the advert suppose to be active on the advertiser`s social media.
Select priority level, advert category and main social media from the dropdowns.
Finally, add some extra comments and tick checkbox to activate advert and make it visible for advertisers.
                </p>
            </div>
        </section>
        @endsection