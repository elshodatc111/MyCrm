@extends('layouts.home')
@section('title',"Bosh sahifa")
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahifa</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div>
    
    
    
    <section class="section dashboard">
      <div class="row">
        <div class="col-lg-4">
          <div class="card info-card sales-card">
            <div class="card-body">
              <h5 class="card-title">O'qituvchilar</h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-person-arms-up"></i>
                </div>
                <div class="ps-3">
                  <h6>{{ $Statistika['techers'] }}</h6>
                  <span class="text-success small pt-1 fw-bold">1000</span> <span class="text-muted small pt-2 ps-1">AKTIV O'QITUVCHILAR</span>
                </div>
              </div>
            </div>
          </div>
        </div>
            
        <div class="col-lg-4">
          <div class="card info-card revenue-card">
            <div class="card-body">
              <h5 class="card-title">Tashriflar</h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-person"></i>
                </div>
                <div class="ps-3">
                  <h6>{{ $Statistika['tashriflar'] }}</h6>
                  <span class="text-success small pt-1 fw-bold">100000</span> <span class="text-muted small pt-2 ps-1">AKTIV TASHRIFLAR</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="card info-card customers-card">
            <div class="card-body">
              <h5 class="card-title">Guruhlar</h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-diagram-3"></i>
                </div>
                <div class="ps-3">
                  <h6>{{ $Statistika['guruhlar'] }}</h6>
                  <span class="text-danger small pt-1 fw-bold">100000</span> <span class="text-muted small pt-2 ps-1">AKTIV GURUHLAR</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <div class="card">
      <div class="card-body">
        @foreach($Rooms as $key => $value)
          <h5 class="card-title text-center">Dars jadvali: {{ $value['room_name'] }}</h5>
            <div class="table-responsive">
              <table class="table table-bordered text-center">
                <thaed>
                  <tr>
                    <th  class="bg-primary text-white">Soat/Hafta</th>
                    <th  class="bg-primary text-white">08:00</th>
                    <th  class="bg-primary text-white">09:30</th>
                    <th  class="bg-primary text-white">11:00</th>
                    <th  class="bg-primary text-white">12:30</th>
                    <th  class="bg-primary text-white">14:00</th>
                    <th  class="bg-primary text-white">15:30</th>
                    <th  class="bg-primary text-white">17:00</th>
                    <th  class="bg-primary text-white">18:30</th>
                    <th  class="bg-primary text-white">20:00</th>
                  </tr>
                </thaed>
                <tbody>
                  @foreach ($value['hafta_kun'] as $key => $hafta_kun)
                  <tr>
                      @if($key==0)<th style='text-align:left;' class="bg-primary text-white">Dushanba</th>
                      @elseif($key==1)<th style='text-align:left;' class="bg-primary text-white">Seshanba</th>
                      @elseif($key==2)<th style='text-align:left;' class="bg-primary text-white">Chorshanba</th>
                      @elseif($key==3)<th style='text-align:left;' class="bg-primary text-white">Payshanba</th>
                      @elseif($key==4)<th style='text-align:left;' class="bg-primary text-white">Juma</th>
                      @elseif($key==5)<th style='text-align:left;' class="bg-primary text-white">Shanba</th>@endif
                    @foreach ($hafta_kun as $keys => $soat)
                      @if($soat=='bosh')
                        <td class="bg-danger text-white">bo'sh</td>
                      @else
                        <td class="bg-success text-white" title="{{ $soat['guruh_name'] }}" style="cursor:pointer">
                          <a href="{{ route('guruh.show',$soat['guruh_id'] ) }}" class="text-white">Band</a>
                        </td>
                      @endif
                    @endforeach
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
        @endforeach

      </div>
    </div>

  </main>

@endsection
