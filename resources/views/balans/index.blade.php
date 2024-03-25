@extends('layouts.home')
@section('title',"Balans")
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
      <h1>Balans</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahifa</a></li>
          <li class="breadcrumb-item active">Balans</li>
        </ol>
      </nav>
    </div>
    
    @if(session()->has('success'))
      <div class="alert alert-success">
        {{ session()->get('success') }}
      </div>
    @endif
    <div class="row"> 
        <div class="col-lg-6">
            <div class="card" style="min-height:115px">
                <div class="card-body">
                    <h4 class="card-title text-center mb-0 pb-1">Tasdiqlanmagan To'lovlar</h4>
                    <div class="row text-center">
                        <div class="col-6">
                            <span class="badge border-primary border-1 text-primary" 
                                style="font-size:16px;">
                                150 000
                            </span>
                            <a href="{{ route('naqtMoliya') }}"><span class="badge bg-primary w-100 m-0">Naqt</span></a>
                        </div>
                        <div class="col-6">
                            <span class="badge border-info border-1 text-info" 
                                style="font-size:16px;">
                                150 000
                            </span>
                            <a href="{{ route('plastikMoliya') }}"><span class="badge bg-info w-100 m-0">Plastik</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
        <div class="col-lg-6">
            <div class="card" style="min-height:115px">
                <div class="card-body">
                    <h4 class="card-title text-center mb-0 pb-1">Tasdiqlanmagan Xarajatlar(Naqt)</h4>
                    <div class="row text-center">
                        <div class="col-6">
                            <span class="badge border-danger border-1 text-danger" 
                                style="font-size:16px;">
                                150 000
                            </span>
                            <a href="{{ route('qaytarildiMoliya') }}"><span class="badge bg-danger w-100 m-0">Qaytarilgan to'lovlar</span></a>
                        </div>
                        <div class="col-6">
                            <span class="badge border-warning border-1 text-warning" 
                                style="font-size:16px;">
                                150 000
                            </span>
                            <a href="{{ route('xarajat') }}"><span class="badge bg-warning w-100 m-0">Xarajatlar</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
        <div class="col-lg-4">
            <div class="card" style="min-height:115px">
                <div class="card-body">
                    <h4 class="card-title text-center mb-0 pb-1">Kassada mavjud summa</h4>
                    <div class="row text-center">
                        <div class="col-6">
                            <span class="badge border-primary border-1 text-primary" 
                                style="font-size:16px;">
                                150 000
                            </span>
                            <span class="badge bg-primary w-100 m-0">Naqt</span>
                        </div>
                        <div class="col-6">
                            <span class="badge border-info border-1 text-info" 
                                style="font-size:16px;">
                                150 000
                            </span>
                            <span class="badge bg-info w-100 m-0">Plastik</span>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
        <div class="col-lg-4">
            <div class="card" style="min-height:115px">
                <div class="card-body">
                    <h4 class="card-title text-center mb-0 pb-1">Tasdiqlanmagan chiqimlar</h4>
                    <div class="row text-center">
                        <div class="col-6">
                            <span class="badge border-primary border-1 text-primary" 
                                style="font-size:16px;">
                                150 000
                            </span>
                            <span class="badge bg-primary w-100 m-0">Naqt</span>
                        </div>
                        <div class="col-6">
                            <span class="badge border-info border-1 text-info" 
                                style="font-size:16px;">
                                150 000
                            </span>
                            <span class="badge bg-info w-100 m-0">Plastik</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
        <div class="col-lg-4">
            <div class="card" style="min-height:115px">
                <div class="card-body">
                    <h4 class="card-title text-center mb-1 pb-2">Kassadan chiqim qilish</h4>
                    <div class="row text-center">
                        <div class="col-6">
                            <button class="btn btn-primary w-100 py-1">Naqt</button>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-info text-white w-100 py-1">Plastik</button>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
        
        
        
        
                
    </div>         
        <div class="card">
            <div class="card-body text-center">
                <h4 class="card-title text-center">Tasdiqlanmagan chiqimlar</h4>
                
            </div>
        </div>
        
   

  </main>

@endsection
