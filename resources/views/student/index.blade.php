<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>ATKO o'quv markazi</title>
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  <link href="https://atko.tech/crm/user/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://atko.tech/crm/user/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="https://atko.tech/crm/user/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="https://atko.tech/crm/user/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="https://atko.tech/crm/user/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="https://atko.tech/crm/user/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link href="https://atko.tech/crm/user/css/style.css" rel="stylesheet">
<body>
  <!--Bosh sahifa-->
  <header id="header">
    <div class="container">
      <h1><a href="index.html">{{ Auth::user()->name }}</a></h1>
      <h2><span>ATKO </span>Koreys tili markaziga xush kelibsiz!!!</h2>
      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link active" href="#header">Bosh sahifa</a></li>
          <li><a class="nav-link" href="#about">Kabinet</a></li>
          <li><a class="nav-link" href="#resume">Tarix</a></li>
          <li><a class="nav-link" href="#services">Kurslarim</a></li>
          <li><a class="nav-link" href="#contact">Bog'lanish</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav>
      <div class="social-links">
        <a href="#" class="twitter"><i class="bi bi-telegram"></i></a>
        <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
        <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
      </div>
    </div>
  </header>
  <!-- Kabinet -->
  <section id="about" class="about">
    <div class="about-me container">
      <div class="section-title">
        <h2>Kabinet</h2>
        <p>Balans: 150 000 so'm</p>
      </div>
      <div class="row">
        <div class="col-lg-6">
          <ul>
            <li class="my-3"><i class="bi bi-chevron-right"></i> 
              <strong>FIO:</strong> <span>{{ Auth::user()->name }}</span>
            </li>
            <li class="my-3"><i class="bi bi-chevron-right"></i> 
              <strong>Yashash manzil:</strong> <span>{{ Auth::user()->address }}</span>
            </li>
            <li class="my-3"><i class="bi bi-chevron-right"></i> 
              <strong>Telefon raqam:</strong> <span>+99 8{{ Auth::user()->phone }}</span>
            </li>
            <li class="my-3"><i class="bi bi-chevron-right"></i> 
              <strong>Tug'ilgan kuningiz:</strong> <span>{{ Auth::user()->tkun }}</span>
            </li>
          </ul>
        </div>
        <div class="col-lg-6">
          <ul>
            <li class="my-3"><i class="bi bi-chevron-right"></i> 
              <strong>Login:</strong> <span>{{ Auth::user()->email }}</span>
            </li>
            <li class="my-3"><i class="bi bi-chevron-right"></i> 
              <strong>Yaqin tanishingiz:</strong> <span>{{ Auth::user()->name }}</span>
            </li>
            <li class="my-3"><i class="bi bi-chevron-right"></i> 
              <strong>Telefon raqami:</strong> <span>{{ Auth::user()->name }}</span>
            </li>
            <li class="my-3"><i class="bi bi-chevron-right"></i> 
              <strong>Markazga tashrif:</strong> <span>{{ Auth::user()->created_at }}</span>
            </li></ul>
        </div>
      </div> 
      <div class="w-100 text-center">
        <button class="btn btn-success"><i class="bi bi-cash-coin"></i> Balansni toldirish</button>
      </div>
      <br><br>   
      <div class="section-title">
        <h2 class="mb-0 pb-0">Chegirmalar</h2>
      </div>  
      <div class="row">
        @forelse($Chegirmalar as $item)
        <div class="col-lg-4">
          <p class="p-3 my-3" style="background-color: rgba(255, 255, 255, 0.05);">
            <i class="text-white bg-danger p-1 w-100 text-center" style="font-size:12px;">Chegirma muddati: {{ $item['guruh_start'] }}</i><br/>
            <b>{{ $item['guruh_name'] }}</b><br>
            Guruhga {{ $item['guruh_tulov'] }} so'm to'lov qiling. <br> {{ $item['guruh_chegirma'] }} so'm chegirma oling.<br>
            <button class="btn btn-success mt-3 text-center text-white"><i class="bi bi-cash-coin"></i> To'lov qolish</button>
          </p>
        </div>
        @empty
        <div class="col-lg-4">
          <p class="p-3 my-3" style="background-color: rgba(255, 255, 255, 0.05);">
            Sizda chegirmalar mavjud emas.
          </p>
        </div>
        @endforelse
      </div>
    </div>
    

    <div class="skills container">
      <div class="section-title">
        <h2 class="m-0 p-0">Test natijalari</h2>
      </div>
      <div class="skills-content">
          <div class="progress">
            <span class="skill">HTML <i class="val">100%</i></span>
            <div class="progress-bar-wrap">
              <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
          </div>
          <div class="progress">
            <span class="skill">CSS <i class="val">90%</i></span>
            <div class="progress-bar-wrap">
              <div class="progress-bar" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
          </div>
          <div class="progress">
            <span class="skill">JavaScript <i class="val">75%</i></span>
            <div class="progress-bar-wrap">
              <div class="progress-bar" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
          </div>
        </div>
    </div>
    <div class="w-100 text-center">
      <a class="btn btn-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="bi bi-box-arrow-in-left"></i>
        <span>Chiqish</span>
      </a>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
    </div>

    
  </section>
  <!-- Tarix -->
  <section id="resume" class="resume">
    <div class="container">

      <div class="section-title">
        <h2>Tarix</h2>
        <p>Mening tarixim</p>
      </div>
        @foreach($History as $item)
        
        @if($item['hodisa']=='GuruhPlus')
          <div class="resume-item pb-0 my-1 row">
            <h4>Guruhga qo'shildi</h4>
            <div class="col-lg-3"><b>Vaqt:</b> {{ $item['hodisa_vaqti'] }}</div>
            <div class="col-lg-3"><b>Guruh:</b> {{ $item['Guruh'] }}</div>
            <div class="col-lg-3"><b>Guruh narxi:</b> {{ $item['Guruh_narxi'] }}</div>
          </div><hr>
        @elseif($item['hodisa']=='Tulov')
        <div class="resume-item pb-0 my-1 row">
          @if($item['type']=='Qaytarildi')
            <h4>To'lov qaytarildi</h4>
            <div class="col-lg-3"><b>Vaqt:</b> {{ $item['hodisa_vaqti'] }}</div>
            <div class="col-lg-3"><b>To'lov turi:</b> Qaytarildi</div>
            <div class="col-lg-3"><b>Summa:</b> {{ $item['summa'] }}</div>
            <div class="col-lg-3"><b>Status:</b> Kutilmoqda...</div>
          @elseif($item['type']=='Naqt')
            <h4>To'lov</h4>
            <div class="col-lg-3"><b>Vaqt:</b> {{ $item['hodisa_vaqti'] }}</div>
            <div class="col-lg-3"><b>To'lov turi:</b> Naqt</div>
            <div class="col-lg-3"><b>Summa:</b> {{ $item['summa'] }}</div>
            <div class="col-lg-3"><b>Status:</b> {{ $item['Status'] }}</div>
          @elseif($item['type']=='Plastik')
            <h4>To'lov</h4>
            <div class="col-lg-3"><b>Vaqt:</b> {{ $item['hodisa_vaqti'] }}</div>
            <div class="col-lg-3"><b>To'lov turi:</b> Plastik</div>
            <div class="col-lg-3"><b>Summa:</b> {{ $item['summa'] }}</div>
            <div class="col-lg-3"><b>Status:</b> {{ $item['Status'] }}</div>
          @elseif($item['type']=='Chegirma')
            <h4>Chegirma</h4>
            <div class="col-lg-3"><b>Vaqt:</b> {{ $item['hodisa_vaqti'] }}</div>
            <div class="col-lg-3"><b>To'lov turi:</b> Chegirma</div>
            <div class="col-lg-3"><b>Summa:</b> {{ $item['summa'] }}</div>
          @else
            <h4>Payme</h4>
            <div class="col-lg-3"><b>Vaqt:</b> {{ $item['hodisa_vaqti'] }}</div>
            <div class="col-lg-3"><b>To'lov turi:</b> Payme</div>
            <div class="col-lg-3"><b>Summa:</b> {{ $item['summa'] }}</div>
          @endif
        </div><hr>
        @elseif($item['hodisa']=='GuruhDelete')
          <div class="resume-item pb-0 my-1 row">
            <h4>Guruhdan o'chirildi</h4>
            <div class="col-lg-3"><b>Vaqt:</b> {{ $item['hodisa_vaqti'] }}</div>
            <div class="col-lg-3"><b>Guruh:</b> {{ $item['Guruh'] }}</div>
            <div class="col-lg-3"><b>Guruh narxi:</b> {{ $item['Guruh_narxi'] }}</div>
            <div class="col-lg-3"><b>Jarima:</b> {{ $item['Guruh_Jarima'] }}</div>
          </div><hr>
        @elseif($item['hodisa']=='Tashrif')
          <div class="resume-item pb-0 my-1 row">
            <h4>Markazga tashrif</h4>
            <div class="col-lg-3"><b>Vaqt:</b> {{ $item['hodisa_vaqti'] }}</div>
          </div><hr>
        @endif
        @endforeach
        
        
        
        

    </div>
  </section>

  <!-- ======= Kurslarim ======= -->
  <section id="services" class="services">
    <div class="container">
      <div class="section-title">
        <h2>Kurslar</h2>
        <p>Mening kurslarim</p>
      </div>
      <div class="row">
        @forelse($Guruhlar as $item )
        <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4">
          <a href="{{ route('userGuruh', $item['id'] ) }}" class="w-100" style="list-style: none;">
            <div class="icon-box w-100">
              <div class="icon"><i class="bx bx-arch"></i></div>
              <h4 class="text-white">{{ $item['guruh_name'] }}</h4>
              <p class="text-white">{{ $item['status'] }}</p>
            </div>
          </a>
        </div>
        @empty
        <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4">Sizning guruhlaringiz mavjud emas.</div>
        @endforelse
      </div>
    </div>
  </section>
  
  <section id="contact" class="contact">
    <div class="container">
      <div class="section-title">
        <h2>Contact</h2>
        <p>Bog'lanish</p>
      </div>
      @if (Session::has('success'))
        <div class="alert alert-danger">{{ Session::get('success') }}</div>
      @endif
      <div class="info-box">
        @foreach($Contacts as $item)
          @if($item['status']=='user')
          <div class="my-2 text-white w-100">
            <div class="row p-3" style="width:70%;background-color: rgba(255, 255, 255, 0.09);margin-left: 30%;">
              <div class="col-2 text-center">
                <img src="https://atko.tech/crm/user/css/01.png" style="width:70%;border-radius:50%;padding:5%">
              </div>
              <div class="col-10">
                <div class="row">
                  <div class="col-7"><h4>{{ Auth::user()->name }}</h4></div>
                  <div class="col-5" style="text-align:right"><i>{{ $item['created_at'] }}</i></div>
                  <div class="col-12">{{ $item['text'] }}</div>
                  <div class="col-12" style="text-align:right">
                    @if($item['admin_type']=='false')<i class="bi bi-check2"></i>
                    @else<i class="bi bi-check2-all"></i>@endif
                  </div>
                </div>
              </div>
            </div>
          </div>
          @else
          <div class="my-2 text-white w-100">
            <div class="row p-3" style="width:70%;background-color: rgba(255, 255, 255, 0.09);">
              <div class="col-2 text-center"><img src="https://atko.tech/crm/user/css/01.png" style="width:70%;border-radius:50%;padding:5%"></div>
              <div class="col-10">
                <div class="row">
                  <div class="col-7"><h4>{{ $item['name'] }}</h4></div>
                  <div class="col-5" style="text-align:right"><i>{{ $item['created_at'] }}</i></div>
                  <div class="col-12">{{ $item['text'] }}</div>
                </div>
              </div>
            </div>
          </div>
          @endif
        @endforeach
      </div>
      
      <form action="{{ route('contact.store') }}" method="post">
        @csrf
        <h3>Bizga savollaringizni qoldiring va biz sizga javob beramiz.</h3>
        <div class="form-group mt-3">
          <textarea class="form-control text-white" name="text" style="background-color:rgba(255,255,255,0.05);border-radius:0;" placeholder="Murojat matni" required></textarea>
        </div>
        <div class="text-center mt-3">
          <button type="submit" class="btn btn-warning text-white" style="border-radius:0;">
          <i class="bi bi-send"></i> Yuborish</button>
        </div>
      </form>

    </div>
  </section>
  

  <div class="credits">
    <a>ATKO o'quv markazi</a>
  </div>


  <script src="https://atko.tech/crm/user/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="https://atko.tech/crm/user/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="https://atko.tech/crm/user/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="https://atko.tech/crm/user/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="https://atko.tech/crm/user/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="https://atko.tech/crm/user/vendor/waypoints/noframework.waypoints.js"></script>
  <script src="https://atko.tech/crm/user/vendor/php-email-form/validate.js"></script>
  <script src="https://atko.tech/crm/user/js/main.js"></script>

</body>

</html>