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
        <div class="col-4">
            <div class="card m-1">
                <div class="card-body pt-3 px-0">
                    <div class="align-items-center">
                        <div class="text-center">
                            <h4 class="text-danger mb-1">150 000 so'm</h4>
                            <span class="text-success small mt-0 fw-bold"style="text-align:left;">
                                Kassada mavjud
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
        
        <div class="col-4">
            <div class="card m-1">
                <div class="card-body pt-3 px-0">
                    <div class="align-items-center">
                        <div class="text-center">
                            <h4 class="text-danger mb-1">150 000 so'm</h4>
                            <span class="text-success small mt-0 fw-bold"style="text-align:left;">
                                Kassada mavjud
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
        
        <div class="col-4">
            <div class="card m-1">
                <div class="card-body pt-3 px-0">
                    <div class="align-items-center">
                        <div class="text-center">
                            <h4 class="text-danger mb-1">150 000 so'm</h4>
                            <span class="text-success small mt-0 fw-bold"style="text-align:left;">
                                Kassada mavjud
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
    </div>         
        <div class="card">
            <div class="card-body pt-4 text-center">
                <h5>Balans</h5>
                
            </div>
        </div>
        
   

  </main>

@endsection
