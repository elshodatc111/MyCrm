@extends('layouts.home')
@section('title',"Moliya")
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
      <h1>Moliya</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahifa</a></li>
          <li class="breadcrumb-item active">Moliya</li>
        </ol>
      </nav>
    </div>
    
    <div class="row text-center">
        <div class="col-lg-4">
            <div class="card info-card sales-card">
                <a href="{{ route('naqtMoliya') }}">
                    <div class="card-body">
                        <h5 class="card-title" style="font-weight:700;">Naqt to'lovlar</h5>
                        <div class="d-flex align-items-center row">
                            <div class="col-3">
                                <i class="bi bi-person-arms-up bg-success text-white p-4"
                                    style="border-radius:50%;"></i>
                            </div>
                            <div class="col-9">
                                <h4 class="text-danger mb-1">{{ $Naqt1 }}</h4>
                                <span 
                                    class="text-success small mt-0 fw-bold"
                                    style="text-align:left;">TASDIQLANMAGAN
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card info-card sales-card">
                <a href="{{ route('plastikMoliya') }}">
                    <div class="card-body">
                        <h5 class="card-title" style="font-weight:700;">Pastik to'lovlar</h5>
                        <div class="d-flex align-items-center row">
                            <div class="col-3">
                                <i class="bi bi-person-arms-up bg-primary text-white p-4" style="border-radius:50%;"></i>
                            </div>
                            <div class="col-9">
                                <h4 class="text-danger mb-1">{{ $Plastik1 }}</h4>
                                <span 
                                    class="text-success small mt-0 fw-bold"
                                    style="text-align:left;">TASDIQLANMAGAN
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card info-card sales-card">
                <a href="{{ route('qaytarildiMoliya') }}">
                    <div class="card-body">
                        <h5 class="card-title" style="font-weight:700;">Qaytarilgan to'lovlar</h5>
                        <div class="d-flex align-items-center row">
                            <div class="col-3">
                                <i class="bi bi-person-arms-up bg-danger text-white p-4"
                                    style="border-radius:50%;"></i>
                            </div>
                            <div class="col-9">
                                <h4 class="text-danger mb-1">{{ $Qaytarilgan1 }}</h4>
                                <span 
                                    class="text-success small mt-0 fw-bold"
                                    style="text-align:left;">TASDIQLANMAGAN
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
            

  </main>

@endsection
