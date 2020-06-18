<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title')</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google fonts - Popppins for copy -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,800">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css">

    <!-- theme stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/layout/style.default.css') }}" id="theme-stylesheet">

    <!-- Custom stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/layout/custom.css') }}">

    @yield('style')
</head>
<body>
    <div id="app">
        <!-- navbar-->
        <header class="header">
        <nav class="navbar navbar-expand-lg px-4 py-2 bg-white shadow" style="position: fixed;top: 0;left: 0;width: 100%;z-index: 999;">
            <button class="bg-transparent border-0 sidebar-toggler text-gray-500 mr-4 mr-lg-5 lead"><i class="fas fa-bars"></i></button>
            <a href="#" class="font-weight-bold text-uppercase text-base">boîte mail</a>
            <form id="searchForm" class="col-6 ml-5 d-none d-lg-block">
                <div class="form-group d-flex justofy-content-between position-relative mb-0">
                    <button type="submit" class="bg-transparent border-0 pl-0 py-2"><i class="fas fa-search text-gray"></i></button>
                    <input type="search" placeholder="Rechercher dans les messages" class="form-control form-control-sm border-0 no-shadow bg-transparent pl-3 my-auto">
                    <button type="button" class="bg-transparent border-0 px-2 py-2"><i class="fas fa-sort-down text-gray"></i></button>
                </div>
            </form>
            <ul class="ml-auto d-flex align-items-center list-unstyled mb-0">
                {{-- <li class="nav-item dropdown mr-3"><a id="notifications" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle text-gray-400 px-1"><i class="fa fa-bell"></i><span class="notification-icon"></span></a>
                    <div aria-labelledby="notifications" class="dropdown-menu"><a href="#" class="dropdown-item">
                        <div class="d-flex align-items-center">
                        <div class="icon icon-sm bg-violet text-white"><i class="fab fa-twitter"></i></div>
                        <div class="text ml-2">
                            <p class="mb-0">You have 2 followers</p>
                        </div>
                        </div></a><a href="#" class="dropdown-item">
                        <div class="d-flex align-items-center">
                        <div class="icon icon-sm bg-green text-white"><i class="fas fa-envelope"></i></div>
                        <div class="text ml-2">
                            <p class="mb-0">You have 6 new messages</p>
                        </div>
                        </div></a><a href="#" class="dropdown-item">
                        <div class="d-flex align-items-center">
                        <div class="icon icon-sm bg-blue text-white"><i class="fas fa-upload"></i></div>
                        <div class="text ml-2">
                            <p class="mb-0">Server rebooted</p>
                        </div>
                        </div></a><a href="#" class="dropdown-item">
                        <div class="d-flex align-items-center">
                        <div class="icon icon-sm bg-violet text-white"><i class="fab fa-twitter"></i></div>
                        <div class="text ml-2">
                            <p class="mb-0">You have 2 followers</p>
                        </div>
                        </div></a>
                    <div class="dropdown-divider"></div><a href="#" class="dropdown-item text-center"><small class="font-weight-bold headings-font-family text-uppercase">View all notifications</small></a>
                    </div>
                </li> --}}
                <li class="nav-item dropdown ml-auto"><a id="userInfo" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">
                        <img src="{{ asset('img/user.png') }}" alt="user img" style="max-width: 2.5rem;" class="img-fluid rounded-circle shadow bg-primary"></a>
                        <div aria-labelledby="userInfo" class="dropdown-menu">
                            <a href="#" class="dropdown-item"><strong class="d-block text-uppercase headings-font-family">{{ Auth::user()->name }}</strong><small>{{ Auth::user()->post }}</small></a>
                            {{-- <div class="dropdown-divider"></div><a href="#" class="dropdown-item">Réglages</a><a href="#" class="dropdown-item">Journal d'activité</a> --}}
                            <div class="dropdown-divider"></div>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"class="dropdown-item">
                                <i class="fas fa-sign-out-alt text-gray-400"></i>&nbsp;Se déconnecter
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                        </div>
                </li>
            </ul>
        </nav>
        </header>
        <!-- Sidebar -->
        <div class="d-flex align-items-stretch" style="position: fixed;top: 72px;left: 0;height: 100%;z-index: 998;overflow: auto;">
        <div id="sidebar" class="sidebar py-3">
            <new-email :key="newEmailComponentKey"></new-email>
            <button id="render" @click="newEmailComponentKey += 1" hidden></button>
            <ul class="sidebar-menu list-unstyled">
            <li class="sidebar-list-item"><a href="#" class="sidebar-link text-muted active"><span class="col-2 d-flex p-0 mr-3"><i class="fas fa-inbox m-auto text-gray"></i></span><span id="legend">Boîte de réception</span></a></li>
            <li class="sidebar-list-item"><a href="#" class="sidebar-link text-muted"><span class="col-2 d-flex p-0 mr-3"><i class="fas fa-star m-auto text-gray"></i></span><span id="legend">Important</span></a></li>
            <li class="sidebar-list-item"><a href="#" class="sidebar-link text-muted"><span class="col-2 d-flex p-0 mr-3"><i class="fas fa-paper-plane m-auto text-gray"></i></span><span id="legend">Messages envoyés</span></a></li>
            <li class="sidebar-list-item"><a href="#" class="sidebar-link text-muted"><span class="col-2 d-flex p-0 mr-3"><i class="fas fa-file m-auto text-gray"></i></span><span id="legend">Brouillions</span></a></li>
            <categories userjson="{{ Auth::user() }}"></categories>
            <li class="sidebar-list-item"><a href="#" class="sidebar-link text-muted"><span class="col-2 d-flex p-0 mr-3"><i class="fas fa-envelope m-auto text-gray"></i></span><span id="legend">Tous les messages</span></a></li>
            <li class="sidebar-list-item"><a href="#" class="sidebar-link text-muted"><span class="col-2 d-flex p-0 mr-3"><i class="fas fa-archive m-auto text-gray"></i></span><span id="legend">Messages archivés</span></a></li>
            <li class="sidebar-list-item"><a href="#" class="sidebar-link text-muted"><span class="col-2 d-flex p-0 mr-3"><i class="fas fa-trash m-auto text-gray"></i></span><span id="legend">Corbeille</span></a></li>
            </ul>
        </div>
        </div>
        <!-- content -->
        <div id="content" class="page-holder w-100 d-flex flex-wrap contentSimple">
            <div class="container-fluid px-0">
                <!-- content here -->
                @yield('content')
            </div>
        </div>

        <!-- Theme color -->
        <button type="button" data-toggle="collapse" data-target="#style-switch" id="style-switch-button" class="btn btn-primary btn-sm d-none d-lg-inline-block p-3 collapsed" aria-expanded="false"><i class="fa fa-cog"></i></button>
        <div id="style-switch" class="collapse">
            <h5 class="mb-4">Select theme colour</h5>
            <form class="mb-4">
                <select name="colour" id="colour" class="form-control">
                <option value="">select colour variant</option>
                <option value="default">blue</option>
                <option value="pink">pink</option>
                <option value="violet">violet</option>
                <option value="sea">sea</option>
                <option value="red">red</option>
                <option value="green">green</option>
                </select>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.js"></script>
    <!-- Layout JS -->
    <script src="{{ asset('js/layout.js') }}"></script>

    @yield('script')
</body>
</html>
