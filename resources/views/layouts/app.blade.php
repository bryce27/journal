<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
</head>
<body class="bg-grey-light h-screen antialiased">
    <div id="app">
        <nav class="bg-white h-12 shadow mb-8 px-6 md:px-0">
            <div class="container mx-auto h-full">
                <div class="flex items-center justify-center h-12">
                    <div class="mr-6">
                        <a href="{{ url('/home') }}" class="no-underline hover:underline text-black font-bold text-sm">
                            Home
                        </a>
                        <a href="{{ url('/search') }}" class="no-underline hover:underline text-black font-bold text-sm pl-10">
                            Search
                        </a>
                    </div>
                    <div class="flex-1 text-right">
                        @guest
                            <a class="no-underline hover:underline text-grey-light-darker pr-3 text-sm" href="{{ url('/login') }}">{{ __('Login') }}</a>
                            <a class="no-underline hover:underline text-grey-light-darker text-sm" href="{{ url('/register') }}">{{ __('Register') }}</a>
                        @else
                            <!-- <span class="text-grey-light-darker text-sm pr-4">{{ Auth::user()->name }}</span> -->

                            <a href="{{ route('logout') }}"
                                class="no-underline hover:underline text-black font-bold text-sm"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                {{ csrf_field() }}
                            </form>
                        @endguest
                    </div>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
