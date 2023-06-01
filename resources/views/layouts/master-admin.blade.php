<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="{{ asset('css/master.css') }}" rel="stylesheet">
    <link href="{{ asset('css/breadcrumbs.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css" rel="stylesheet">

    @stack('styles')
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/9e4a1959a9.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/master.js') }}"></script>
    @stack('scripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
</head>
<body id="body-pd">
<header class="header" id="header">
    <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i> </div>
</header>
<div class="l-navbar" id="nav-bar">
    <nav class="nav">
        <div>
            <div class="nav_list">
                <a href="/" class="nav_link {{(request()->routeIs('dashboard')?'active':'')}}"> <i class='bx bx-grid-alt nav_icon'></i>   <span class="nav_name">Dashboard</span> </a>
                <li class="mb-1"> </li>
                <a href="{{route('users.index')}}" class="nav_link {{(request()->routeIs('users*')?'active':'')}}"> <i class='bx bx-user nav_icon'></i> <span class="nav_name">Users</span> </a>
                <a href="{{route('exams.index')}}" class="nav_link {{(request()->routeIs('exams*')?'active':'')}}"> <i class='bx bx-message-square-detail nav_icon'></i> <span class="nav_name">Exams</span> </a>
                <a href="{{route('categories.index')}}" class="nav_link {{(request()->routeIs('categories*')?'active':'')}}"> <i class='bx bx-bookmark nav_icon'></i> <span class="nav_name">Categories</span> </a>
                <a href="{{route('courses.index')}}" class="nav_link {{(request()->routeIs('courses*')?'active':'')}}"> <i class='bx bx-folder nav_icon'></i> <span class="nav_name">Courses</span> </a>
                <a href="{{route('questions.index')}}" class="nav_link {{(request()->routeIs('questions*')?'active':'')}}"> <i class='bx bx-bar-chart-alt-2 nav_icon'></i> <span class="nav_name">Questionnaire</span> </a>
            </div>
        </div> <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav_link"> <i class='bx bx-log-out nav_icon'></i> <span class="nav_name">SignOut</span> </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
    </nav>
</div>
<!--Container Main start-->
<div class="container-fluid main-container">
    @yield('content')
</div>

</body>
</html>
