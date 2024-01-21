<header>
    <nav class="container flex items-center py-4 mt-4 sm:mt-12">
        <div class="py-1 text-xl font-bold text-teal-600"><a href="{{url('/')}}">Bringlu</a></div>
        <ul class="sm:flex flex-1 justify-end items-center gap-12 text-bringlu-blue uppercase text-sm">
            <li class="mx-4 my-6 md:my-0 cursor-pointer hover:text-cyan-500 duration-500"><a href="{{url('/')}}">Home</a></li>
            <li class="cursor-pointer hover:text-cyan-500 duration-500"><a href="{{url('/#about')}}">About</a></li>
            @if (Route::has('login'))
                @auth
                    <a href="{{ route('user.account-type', auth()->user()->id) }}"><button type="button" class="bg-green-500 text-white rounded-md px-7 py-3 uppercase">My account</button></a>
                    <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </a>
                    </form>
                    @else
                        <a href="{{ route('login') }}"><button type="button" class="bg-bringlu-red text-white rounded-md px-7 py-3 uppercase">Login</button></a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"><button type="button" class="bg-bringlu-blue text-white rounded-md px-7 py-3 uppercase">Register</button></a>
                        <a href="{{ route('login.account-selection') }}"><button type="button" class="bg-black text-white rounded-md px-7 py-3 uppercase"><i class="fa-brands fa-github"></i></button></a>
                    @endif
                @endauth
            @endif
        </ul>
        <div class="flex sm:hidden flex-1 justify-end">
            <i class="text-2xl fas fa-bars"></i>
        </div>
    </nav>
</header>
