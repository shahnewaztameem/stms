<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('site_title', config('app.name'))</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    
    <!-- animate css  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.0/animate.min.css" integrity="sha512-kb1CHTNhoLzinkElTgWn246D6pX22xj8jFNKsDmVwIQo+px7n1yjJUZraVuR/ou6Kmgea4vZXZeUDbqKtXkEMg==" crossorigin="anonymous" />
    <!-- Fontawesome CDN -->
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <!-- Styles -->
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/login.css') }}" rel="stylesheet">
    
    @yield('header_tag')
</head>
<body class="@yield('bg_image') bg_image">
<div id="app">

    <nav class="navbar navbar-expand-md navbar-light custom-navbar-design bg-white shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand navbar-custom-logo" href="{{ route('home') }}">
                STMS
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                @auth
                    {{-- {{ auth()->user()->user_type }} --}}
                <ul class="navbar-nav justify-content-end d-flex flex-fill">
                    {{-- ADMIN OPTIONS --}}
                    @if (auth()->user()->user_type == 0)
                        <li class="nav-item">
                            <a href="{{ route('home') }}" class="nav-link">
                                <span @if (request()->is('admin/home') || request()->is('admin/home/*')) class="border-bottom-custom" @endif>
                                    Home
                                </span>
                            </a>
                        </li>
                        <!-- /.nav-item -->
                        
                        <li class="nav-item">
                            <a href="{{ route('admin.client.list') }}" class="nav-link">
                                <span @if (request()->is('admin/client-list') || request()->is('admin/client-list/*')) class="border-bottom-custom" @endif>
                                    Client List
                                </span>
                            </a>
                        </li>
                        <!-- /.nav-item -->
                    
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                               <span @if (request()->is('admin/task/*')) class="border-bottom-custom" @endif>
                                    Tasks
                                </span>
                                <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                                <a class="dropdown-item" href="{{ route('admin.task.all') }}">
                                    All Tasks
                                </a>

                                <div role="separator" class="dropdown-divider"></div>
                                
                                <a class="dropdown-item" href="{{ route('admin.task.create') }}">
                                    Add Task
                                </a>
                                
                            </div>
                        </li>

                    {{-- CLIENT OPTIONS --}}
                    @elseif(auth()->user()->user_type == 1)
                        <li class="nav-item">
                            <a href="{{ route('client.home') }}" class="nav-link">
                                <span @if (request()->is('client/task/*')) class="border-bottom-custom" @endif>
                                    All Tasks
                                </span>
                            </a>
                        </li>
                    {{-- USER OPTIONS --}}
                    @else
                        <li class="nav-item">
                            <a href="{{ route('user.home') }}" class="nav-link">
                                <span @if (request()->is('user/task/*')) class="border-bottom-custom" @endif>
                                    All Tasks
                                </span>
                            </a>
                        </li>
                    @endif  
                </ul>
                @endauth

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else

                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>

                                <img src="{{asset('/img/profile-picture-placeholder.svg')}}" alt="Profile Picture"
                                     class="rounded-circle" width="45">
                                <span class="caret"></span>

                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <div class="dropdown-item">
                                    <p class="mb-0">{{ auth()->user()->name }}</p>
                                </div>
                                <!-- /.dropdown-item -->

                                @if (auth()->user()->user_type == 1)
                                    
                                    <div role="separator" class="dropdown-divider"></div>

                                    <a class="dropdown-item" href="{{ route('client.change.pass') }}">
                                        Change Password
                                    </a>
                                @endif

                                <div role="separator" class="dropdown-divider"></div>

                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        <div class="container-fluid">
            @yield('content')
        </div>
        <!-- /.container -->
    </main>

    

    <script src="{{ mix('/js/app.js') }}"></script>

    
    <script>
        $.fn.selectpicker.Constructor.BootstrapVersion = 4;
    </script>

    <script>
        $(function() {
            $('select').selectpicker({
                actionsBox: true,
                liveSearch: true,
                width: '100%',
                selectedTextFormat: 'count > 3',
                showTick: true,
                size: 4,
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        } );
    </script>


    @yield('customJS')

<script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js" integrity="sha512-Eak/29OTpb36LLo2r47IpVzPBLXnAMPAVypbSZiZ4Qkf8p/7S/XRG5xp7OKWPPYfJT6metI+IORkR5G8F900+g==" crossorigin="anonymous"></script>
<script>
  new WOW().init();
</script>

</div>
</body>
</html>
