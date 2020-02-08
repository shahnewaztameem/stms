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
    <!-- Fontawesome CDN -->
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <!-- Styles -->
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
    
    @yield('header_tag')
</head>
<body>
  <div id="app">

   <header class="header">
    <img src="{{ asset('/img/logo.png') }}" alt="App-Logo" class="logo">

    <form action="#" class="search">
        <input type="text" name="search" id="search" class="search__input" placeholder="Search">

        <button class="search__button">
          
        </button>
    </form>
   </header>

   <div class="content">
    <nav class="sidebar">
        <ul class="side-nav">
          @if (auth()->user()->user_type == 0)
            <li class="side-nav__item @if (request()->is('admin/home')) side-nav__item--active @endif">
                <a href="{{ route('admin.home') }}" class="side-nav__link">
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="side-nav__item @if (request()->is('admin/client-list') || request()->is('admin/client/*')) side-nav__item--active @endif">
                <a href="{{ route('admin.client.list') }}" class="side-nav__link">
                    <span>Clients</span>
                </a>
            </li>
            <li class="side-nav__item">
                <a href="#" class="side-nav__link">
                    <span>Projects</span>
                </a>
            </li>
            <li class="side-nav__item @if (request()->is('admin/manager-list') || request()->is('admin/user/*')) side-nav__item--active @endif">
                <a href="{{ route('admin.user.create') }}" class="side-nav__link">
                    <span>Manager</span>
                </a>
            </li>
           @endif

           <li class="side-nav__item">
            <a class="side-nav__link" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();document.getElementById('logout-form').submit();">{{ __('Logout') }}
             </a>

             <form id="logout-form" action="{{ route('logout') }}" method="POST"
                   style="display: none;">
                 @csrf
             </form>
           </li>

        </ul>
    </nav>

    <main class="main-view py-4">
      <div class="container-fluid">
          @yield('content')
      </div>
      <!-- /.container -->
     </main>
   </div>

   {{-- SCRIPTS --}}
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
  </div>
</body>
</html>