<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                        <!--TODO: LOGO AANPASSEN -->
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('texts.dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('advertisements.index')" :active="request()->routeIs('advertisements.index')">
                        {{ __('texts.advertisements') }}
                    </x-nav-link>

                    @auth
                        @if (auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Business'))
                            <x-nav-link :href="route('contracts.index')" :active="request()->routeIs('contracts.index')">
                                {{ __('texts.contracts') }}
                            </x-nav-link>
                        @endif

                        @if (auth()->user()->hasRole('Business'))
                            @php
                                $pageSettingExists = \App\Models\PageSetting::where(
                                    'user_id',
                                    auth()->user()->id,
                                )->exists();
                                $routeName = $pageSettingExists
                                    ? 'landingpage-settings.edit'
                                    : 'landingpage-settings.create';
                            @endphp

                            <x-nav-link :href="route($routeName)" :active="request()->routeIs('landingpage-settings.*')">
                                {{ $pageSettingExists ? __('texts.landingpage') : __('texts.landingpage') }}
                            </x-nav-link>
                        @endif


                        <div class="relative hidden sm:flex sm:items-center sm:ml-6">
                            <div x-data="{ open: false }" @click.away="open = false">
                                <button @click="open = !open"
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                    {{ __('texts.agenda') }}
                                    <svg class="ml-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>

                                <div x-show="open"
                                    class="absolute z-50 mt-2 rounded-md shadow-lg origin-top-right right-0 w-48 py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
                                    @click="open = false">
                                    <a href="{{ route('advertisement.myRentals') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                        :class="{ 'bg-gray-100': request() - > routeIs('advertisement.myRentals') }">
                                        {{ __('texts.myRentals') }}
                                    </a>
                                    @if (!auth()->user()->hasRole('Standard'))
                                        <a href="{{ route('advertisement.rentals') }}"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                            :class="{ 'bg-gray-100': request() - > routeIs('advertisement.rentals') }">
                                            {{ __('texts.rented') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>

                    @endauth
                </div>


            </div>

            @if (Auth::check())
                <!-- Settings Dropdown -->
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('texts.profile') }}
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('profile.history')">
                                {{ __('texts.buy_history') }}
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('profile.favorites')">
                                {{ __('texts.favourite') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('texts.logout') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            @else
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <x-nav-link :href="route('login')" :active="request()->routeIs('login')">
                        {{ __('texts.login') }}
                    </x-nav-link>
                </div>
            @endif

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        @if (Auth::check())
            <!-- Responsive Settings Options -->
            <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                            {{ __('texts.logout') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
    </div>
@else
    <div>
        <x-responsive-nav-link :href="route('login')" :active="request()->routeIs('login')">
            {{ __('Login') }}
        </x-responsive-nav-link>
    </div>
    @endif

    <div x-data="{ open: false }" @click.away="open = false" class="relative inline-block text-left">
        <button @click="open = !open"
            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
            {{ strtoupper(App::getLocale()) }}
        </button>
        <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-100"
            x-transition:enter-start="transform opacity-0 scale-95"
            x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="transform opacity-100 scale-100"
            x-transition:leave-end="transform opacity-0 scale-95"
            class="origin-top-right absolute left-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-10">
            <div class="py-1">
                <a href="{{ route('lang.switch', 'nl') }}"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Nederlands</a>
                <a href="{{ route('lang.switch', 'en') }}"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">English</a>
            </div>
        </div>
    </div>
</nav>
