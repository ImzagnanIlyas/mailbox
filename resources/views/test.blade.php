<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Bubbly - Boootstrap 4 Admin template by Bootstrapious.com</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- App CSS-->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css">
    <!-- Google fonts - Popppins for copy-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,800">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="{{ asset('css/layout/style.default.css') }}" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="{{ asset('css/layout/custom.css') }}">
  </head>
  <body>
    <!-- navbar-->
    <header class="header">
      <nav class="navbar navbar-expand-lg px-4 py-2 bg-white shadow" style="position: fixed;top: 0;left: 0;width: 100%;z-index: 999;">
        <button class="bg-transparent border-0 sidebar-toggler text-gray-500 mr-4 mr-lg-5 lead"><i class="fas fa-bars"></i></button>
        <a href="#" class="font-weight-bold text-uppercase text-base">Mailbox</a>
        <form id="searchForm" class="col-6 ml-5 d-none d-lg-block">
            <div class="form-group d-flex justofy-content-between position-relative mb-0">
                <button type="submit" class="bg-transparent border-0 pl-0 py-2"><i class="fas fa-search text-gray"></i></button>
                <input type="search" placeholder="Rechercher dans les messages" class="form-control form-control-sm border-0 no-shadow bg-transparent pl-3 my-auto">
                <button type="button" class="bg-transparent border-0 px-2 py-2"><i class="fas fa-sort-down text-gray"></i></button>
            </div>
        </form>
        <ul class="ml-auto d-flex align-items-center list-unstyled mb-0">
          <li class="nav-item dropdown mr-3"><a id="notifications" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle text-gray-400 px-1"><i class="fa fa-bell"></i><span class="notification-icon"></span></a>
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
          </li>
          <li class="nav-item dropdown ml-auto"><a id="userInfo" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle"><img src="{{ asset('img/user.png') }}" alt="user img" style="max-width: 2.5rem;" class="img-fluid rounded-circle shadow bg-primary"></a>
            <div aria-labelledby="userInfo" class="dropdown-menu"><a href="#" class="dropdown-item"><strong class="d-block text-uppercase headings-font-family">IMZAGNAN Ilyas</strong><small>Développeur web</small></a>
              <div class="dropdown-divider"></div><a href="#" class="dropdown-item">Réglages</a><a href="#" class="dropdown-item">Journal d'activité</a>
              <div class="dropdown-divider"></div><a href="login.html" class="dropdown-item">Se déconnecter</a>
            </div>
          </li>
        </ul>
      </nav>
    </header>
    <!-- Sidebar -->
    <div class="d-flex align-items-stretch" style="position: fixed;top: 72px;left: 0;height: 100%;z-index: 998;overflow: auto;">
      <div id="sidebar" class="sidebar py-3">
        <div id="newEmail" class="text-gray-400 text-uppercase px-3 px-lg-3 py-4 font-weight-bold small headings-font-family">
          <button type="button" class="btn btn-primary shadow"><i class="fas fa-edit"></i><span id="legend" class="ml-2">Nouveau message</span></button>
        </div>
        <ul class="sidebar-menu list-unstyled">
          <li class="sidebar-list-item"><a href="#" class="sidebar-link text-muted active"><span class="col-2 d-flex p-0 mr-3"><i class="fas fa-inbox m-auto text-gray"></i></span><span id="legend">Boîte de réception</span></a></li>
          <li class="sidebar-list-item"><a href="#" class="sidebar-link text-muted"><span class="col-2 d-flex p-0 mr-3"><i class="fas fa-star m-auto text-gray"></i></span><span id="legend">Important</span></a></li>
          <li class="sidebar-list-item"><a href="#" class="sidebar-link text-muted"><span class="col-2 d-flex p-0 mr-3"><i class="fas fa-paper-plane m-auto text-gray"></i></span><span id="legend">messages envoyés</span></a></li>
          <li class="sidebar-list-item"><a href="#" class="sidebar-link text-muted"><span class="col-2 d-flex p-0 mr-3"><i class="fas fa-file m-auto text-gray"></i></span><span id="legend">Brouillions</span></a></li>
          <li class="sidebar-list-item"><a href="#" data-toggle="collapse" data-target="#pages" aria-expanded="false" aria-controls="pages" class="sidebar-link text-muted"><span class="col-2 d-flex p-0 mr-3"><i class="fas fa-th-large m-auto text-gray"></i></span><span id="legend">Catégories</span></a>
            <div id="pages" class="collapse" style="max-height: 30vh;overflow: auto;">
              <ul class="sidebar-menu list-unstyled border-left border-primary border-thick">
                <li class="sidebar-list-item"><a href="#" class="sidebar-link text-muted pl-lg-5"><span class="col-2 d-flex p-0 mr-3"><i class="fas fa-square m-auto text-gray"></i></span><span id="legend">Sport</span></a></li>
                <li class="sidebar-list-item"><a href="#" class="sidebar-link text-muted pl-lg-5"><span class="col-2 d-flex p-0 mr-3"><i class="fas fa-square m-auto text-gray"></i></span><span id="legend">Info</span></a></li>
                <li class="sidebar-list-item"><a href="#" class="sidebar-link text-muted pl-lg-5"><span class="col-2 d-flex p-0 mr-3"><i class="fas fa-square m-auto text-gray"></i></span><span id="legend">Info</span></a></li>
                <li class="sidebar-list-item"><a href="#" class="sidebar-link text-muted pl-lg-5"><span class="col-2 d-flex p-0 mr-3"><i class="fas fa-square m-auto text-gray"></i></span><span id="legend">Info</span></a></li>
                <li class="sidebar-list-item"><a href="#" class="sidebar-link text-muted pl-lg-5"><span class="col-2 d-flex p-0 mr-3"><i class="fas fa-square m-auto text-gray"></i></span><span id="legend">Info</span></a></li>
                <li class="sidebar-list-item"><a href="#" class="sidebar-link text-muted pl-lg-5"><span class="col-2 d-flex p-0 mr-3"><i class="fas fa-square m-auto text-gray"></i></span><span id="legend">Info</span></a></li>
                <li class="sidebar-list-item"><a href="#" class="sidebar-link text-muted pl-lg-5"><span class="col-2 d-flex p-0 mr-3"><i class="fas fa-square m-auto text-gray"></i></span><span id="legend">Info</span></a></li>
                <li class="sidebar-list-item"><a href="#" class="sidebar-link text-muted pl-lg-5"><span class="col-2 d-flex p-0 mr-3"><i class="fas fa-plus m-auto text-gray"></i></span><span id="legend">Créer une catégorie</span></a></li>
              </ul>
            </div>
          </li>
          <li class="sidebar-list-item"><a href="#" class="sidebar-link text-muted"><span class="col-2 d-flex p-0 mr-3"><i class="fas fa-envelope m-auto text-gray"></i></span><span id="legend">Tous les messages</span></a></li>
          <li class="sidebar-list-item"><a href="#" class="sidebar-link text-muted"><span class="col-2 d-flex p-0 mr-3"><i class="fas fa-archive m-auto text-gray"></i></span><span id="legend">Archives</span></a></li>
          <li class="sidebar-list-item"><a href="#" class="sidebar-link text-muted"><span class="col-2 d-flex p-0 mr-3"><i class="fas fa-trash m-auto text-gray"></i></span><span id="legend">Corbeille</span></a></li>
        </ul>
      </div>
    </div>
    <!-- content -->
    <div id="content" class="page-holder w-100 d-flex flex-wrap contentSimple">
        <div class="container-fluid px-xl-5">
            <!-- content here -->
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

    <!-- App JS -->
    <script src="{{ asset('js/app.js') }}"></script>
    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.js"></script>
    <!-- Layout JS -->
    <script src="{{ asset('js/layout.js') }}"></script>
  </body>
</html>
