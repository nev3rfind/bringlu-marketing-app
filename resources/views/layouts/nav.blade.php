<header>
    <nav class="container flex items-center py-4 mt-4 sm:mt-12">
        <div class="py-1 text-xl font-bold text-foxecom-orange">
            <a href="{{url('/')}}">FoxEcom</a>
        </div>
        <ul class="sm:flex flex-1 justify-end items-center gap-12 text-foxecom-dark uppercase text-sm">
            @if (Route::has('login'))
                @auth
                    <a href="{{ route('user.account-type', auth()->user()->id) }}">
                        <button type="button" class="bg-foxecom-orange hover:bg-orange-600 text-white rounded-md px-7 py-3 uppercase shadow-foxecom">
                            My account
                        </button>
                    </a>
                    
                    {{-- Only show Manage Clients for business customers (account_type = 2) --}}
                    @if(auth()->user()->account_type === 2)
                        <a href="{{ route('clients.all') }}">
                            <button type="button" class="bg-green-500 hover:bg-green-600 text-white rounded-md px-7 py-3 uppercase shadow-foxecom">
                                Manage clients
                            </button>
                        </a>
                    @endif
                    
                    <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-foxecom-dark hover:text-foxecom-orange">
                                {{ __('Log Out') }}
                            </a>
                    </form>
                    @else
                        <a href="{{ route('login') }}">
                            <button type="button" class="bg-foxecom-orange hover:bg-orange-600 text-white rounded-md px-7 py-3 uppercase shadow-foxecom">
                                Login
                            </button>
                        </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}">
                            <button type="button" class="bg-white hover:bg-gray-50 text-foxecom-orange border-2 border-foxecom-orange rounded-md px-7 py-3 uppercase shadow-foxecom">
                                Register
                            </button>
                        </a>
                    @endif
                @endauth
            @endif
        </ul>
        <div class="flex sm:hidden flex-1 justify-end">
            <i class="text-2xl fas fa-bars text-foxecom-dark"></i>
        </div>
    </nav>
</header>