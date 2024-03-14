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
    
      @if(Auth::user()->type=='Operator' or Auth::user()->type=='Admin' or Auth::user()->type=='SuperAdmin' ) 
        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">
                <li class="nav-item">
                    <a class="nav-link nav-icon" href="{{ route('eslatma.index') }}">
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
                                {{ request()->cookie('filial_name') }} filial
                              @endif
                            </span>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('profel.index') }}">
                                <i class="bi bi-person"></i>
                                <span>Kabinet</span>
                            </a>
                        </li>
                        <li>
                        @if(Auth::user()->type=='SuperAdmin')
                        <hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('setting.index') }}">
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
      @endif
    @endguest
  </header>
@auth
  <aside id="sidebar" class="sidebar">
    
    <ul class="sidebar-nav" id="sidebar-nav">   
      
      <li class="nav-item">
        <a class="nav-link {{ request()->is('home') ? '':'collapsed' }} " href="{{ route('home') }}">
          <i class="bi bi-house-door"></i>
          <span>Bosh sahifa</span>
        </a>
      </li>
      @if(Auth::user()->type=='Operator' or Auth::user()->type=='Admin' or Auth::user()->type=='SuperAdmin') 
      <li class="nav-item">
        <a class="nav-link {{ request()->is('user') ? '':'collapsed' }}"  href="{{ route('user.index') }}">
          <i class="bi bi-people"></i></i><span>Tashriflar</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->is('guruh') ? '':'collapsed' }}" href="{{ route('guruh.index') }}">
          <i class="bi bi-list-columns-reverse"></i>
          <span>Guruhlar</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->is('eslatma') ? '':'collapsed' }}" href="{{ route('eslatma.index') }}">
          <i class="bi bi-chat-left-text"></i>
          <span>Eslatmalar</span>
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
      @if(Auth::user()->type=='Admin' OR Auth::user()->type=='SuperAdmin')
      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-faq.html">
          <i class="bi bi-file-earmark"></i>
          <span>Hisobotlar</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->is('techer') ? '':'collapsed' }}" href="{{ route('techer.index') }}">
          <i class="bi bi-dash-circle"></i>
          <span>O'qituvchilar</span>
        </a>
      </li>
      @if(Auth::user()->type=='SuperAdmin')
      <li class="nav-item">
        <a class="nav-link {{ request()->is('hodim') ? '':'collapsed' }}" href="{{ route('hodim.index')}}">
          <i class="bi bi-person-arms-up"></i>
          <span>Hodimlar</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->is('room') ? '':'collapsed' }}" href="{{ route('room.index') }}">
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
      @if(Auth::user()->filial=='NULL')
      <li class="nav-item">
        <a class="nav-link {{ request()->is('filial') ? '':'collapsed' }}" href="{{ route('filial.index') }}">
            <i class="bi bi-house-check"></i>
            <span>Filiallar</span>
        </a>
      </li>
      @endif
      @endif
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
  <script src="https://atko.tech/crm/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js"></script>
  <script>
    $(document).ready(function(){
      $('.phone').inputmask('99 999 9999');
      $('.pasport').inputmask('AA 9999999');
      $('.pnfl').inputmask('99999999999999');
      $('.kodes').inputmask('9 9 9 9 9 9');
    });
  </script>
  <script>
        (function($, undefined) {
            "use strict";
            $(function() {
                var $form1 = $( "#form" );
                var $input1 = $form1.find( "#summa" );
                $input1.on( "keyup", function( event ) {
                    var selection = window.getSelection().toString();
                    if ( selection !== '' ) {return;}
                    if ( $.inArray( event.keyCode, [38,40,37,39] ) !== -1 ) {return;}
                    var $this = $( this );
                    var input1 = $this.val();
                    var input1 = input1.replace(/[\D\s\._\-]+/g, "");
                    input1 = input1 ? parseInt( input1, 10 ) : 0;
                    $this.val( function() {return ( input1 === 0 ) ? "" : input1.toLocaleString( "en-US" );} );
                } );
                var $input2 = $form1.find( "#summa2" );
                $input2.on( "keyup", function( event ) {
                    var selection = window.getSelection().toString();
                    if ( selection !== '' ) {return;}
                    if ( $.inArray( event.keyCode, [38,40,37,39] ) !== -1 ) {return;}
                    var $this = $( this );
                    var input2 = $this.val();
                    var input2 = input2.replace(/[\D\s\._\-]+/g, "");
                    input2 = input2 ? parseInt( input2, 10 ) : 0;
                    $this.val( function() {return ( input2 === 0 ) ? "" : input2.toLocaleString( "en-US" );} );
                } );
                
                var $input3 = $form1.find( "#summa3" );
                $input3.on( "keyup", function( event ) {
                    var selection = window.getSelection().toString();
                    if ( selection !== '' ) {return;}
                    if ( $.inArray( event.keyCode, [38,40,37,39] ) !== -1 ) {return;}
                    var $this = $( this );
                    var input3 = $this.val();
                    var input3 = input3.replace(/[\D\s\._\-]+/g, "");
                    input3 = input3 ? parseInt( input3, 10 ) : 0;
                    $this.val( function() {return ( input3 === 0 ) ? "" : input3.toLocaleString( "en-US" );} );
                } );

                var $form2 = $( "#form1" );
                var $input2 = $form2.find( "#summa1" );
                $input2.on( "keyup", function( event ) {
                    var selection = window.getSelection().toString();
                    if ( selection !== '' ) {return;}
                    if ( $.inArray( event.keyCode, [38,40,37,39] ) !== -1 ) {return;}
                    var $this = $( this );
                    var input2 = $this.val();
                    var input2 = input2.replace(/[\D\s\._\-]+/g, "");
                    input2 = input2 ? parseInt( input2, 10 ) : 0;
                    $this.val( function() {return ( input2 === 0 ) ? "" : input2.toLocaleString( "en-US" );} );
                } );
            });
        })(jQuery);
  </script>
</body>
</html>