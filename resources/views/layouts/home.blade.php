<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>@yield('title')</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <link href="https://atko.tech/crm/img/favicon.png" rel="icon">
  <link href="https://atko.tech/crm/img/apple-touch-icon.png" rel="apple-touch-icon">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link href="https://atko.tech/crm/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://atko.tech/crm/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="https://atko.tech/crm/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="https://atko.tech/crm/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="https://atko.tech/crm/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="https://atko.tech/crm/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="https://atko.tech/crm/vendor/simple-datatables/style.css" rel="stylesheet">
  <link href="https://atko.tech/crm/css/style.css" rel="stylesheet">
</head>
<body>
  <header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
      <a href="{{ route('home') }}" class="logo d-flex align-items-center">
        <img src="https://atko.tech/crm/img/logo.png" alt="">
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div>
    @guest
        @if (Route::has('login'))
            <nav class="header-nav ms-auto">
                <ul class="d-flex align-items-center">
                    <li class="nav-item pe-3">
                        <a class="nav-link nav-profile d-flex align-items-center pe-0" 
                        href="{{ route('login') }}">Kirish</a>
                    </li>
                </ul>
            </nav>
        @endif
    @else
        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">
                <li class="nav-item">
                    <a class="nav-link nav-icon" href="#sss">
                        <i class="bi bi-bell"></i>
                        <span class="badge bg-primary badge-number">4</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-icon" href="#ssa">
                        <i class="bi bi-chat-left-text"></i>
                        <span class="badge bg-success badge-number">3</span>
                    </a>
                </li>
                <li class="nav-item dropdown pe-3">
                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <span class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::user()->email }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6>{{ Auth::user()->name }}</h6>
                            <span>
                              @if(Auth::user()->type=='SuperAdmin' AND Auth::user()->filial=='NULL')
                                <a href="{{ route('changeFilial') }}">{{ request()->cookie('filial_name') }} filial</a>
                              @else
                                {{ request()->cookie('users') }}
                              @endif
                            </span>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                                <i class="bi bi-person"></i>
                                <span>Kabinet</span>
                            </a>
                        </li>
                        <li>
                        @if(Auth::user()->type=='SuperAdmin')
                        <hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                                <i class="bi bi-gear"></i>
                                <span>Sozlamalar</span>
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
                                <i class="bi bi-coin"></i>
                                <span>Balans</span>
                            </a>
                        </li>
                        @endif
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Chiqish</span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    @endguest
  </header>
@auth
  <aside id="sidebar" class="sidebar">
    
    <ul class="sidebar-nav" id="sidebar-nav">    
      <li class="nav-item">
        <a class="nav-link " href="{{ route('home') }}">
          <i class="bi bi-house-door"></i>
          <span>Bosh sahifa</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-people"></i></i><span>Tashriflar</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="forms-elements.html">
              <i class="bi bi-circle"></i><span>Tashriflar</span>
            </a>
          </li>
          <li>
            <a href="forms-layouts.html">
              <i class="bi bi-circle"></i><span>Qarzdorlar</span>
            </a>
          </li>
          <li>
            <a href="forms-editors.html">
              <i class="bi bi-circle"></i><span>To'lovlar</span>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="users-profile.html">
          <i class="bi bi-list-columns-reverse"></i>
          <span>Guruhlar</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-faq.html">
          <i class="bi bi-file-earmark"></i>
          <span>Hisobotlar</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-contact.html">
          <i class="bi bi-chat"></i>
          <span>Murojatlar</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-login.html">
          <i class="bi bi-cash-coin"></i>
          <span>Moliya</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-error-404.html">
          <i class="bi bi-dash-circle"></i>
          <span>O'qituvchilar</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-blank.html">
          <i class="bi bi-chat-left-text"></i>
          <span>Eslatmalar</span>
        </a>
      </li>
      @if(Auth::user()->type=='SuperAdmin')
      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-blank.html">
          <i class="bi bi-person-arms-up"></i>
          <span>Hodimlar</span>
        </a>
      </li>
      @if(Auth::user()->filial=='NULL')
      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-blank.html">
          <i class="bi bi-door-open"></i>
          <span>Xonalar</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-register.html">
          <i class="bi bi-bar-chart-line"></i>
          <span>Statistika</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('filial.index') }}">
            <i class="bi bi-house-check"></i>
            <span>Filiallar</span>
        </a>
      </li>
      @endif
      @endif
    </ul>
  </aside>
  
@yield('content')
  
@endauth
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  
  <script src="https://atko.tech/crm/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="https://atko.tech/crm/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="https://atko.tech/crm/vendor/chart.js/chart.umd.js"></script>
  <script src="https://atko.tech/crm/vendor/echarts/echarts.min.js"></script>
  <script src="https://atko.tech/crm/vendor/quill/quill.min.js"></script>
  <script src="https://atko.tech/crm/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="https://atko.tech/crm/vendor/tinymce/tinymce.min.js"></script>
  <script src="https://atko.tech/crm/vendor/php-email-form/validate.js"></script>
  <script src="https://atko.tech/crm/js/main.js"></script>
</body>
</html>