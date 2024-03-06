@extends('layouts.home')
@section('title',"Profel")
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
      <h1>Kabinet</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahifa</a></li>
          <li class="breadcrumb-item active">Kabinet</li>
        </ol>
      </nav>
    </div>
    
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body pt-4 text-center">
                    <h5>{{ Auth::user()->name }}</h5>
                    <table class="table table-bordered">
                        <tr>
                            <th style="text-align:left;">Yashash manzil</th>
                            <td>{{ Auth::user()->address }}</td>
                        </tr>
                        <tr>
                            <th style="text-align:left;">Telefon raqam</th>
                            <td>{{ Auth::user()->phone }}</td>
                        </tr>
                        <tr>
                            <th style="text-align:left;">Tug'ilgan kun</th>
                            <td>{{ Auth::user()->tkun }}</td>
                        </tr>
                        <tr>
                            <th style="text-align:left;">Login</th>
                            <td>{{ Auth::user()->email }}</td>
                        </tr>
                        <tr>
                            <th style="text-align:left;">Ishga olindi</th>
                            <td>{{ Auth::user()->created_at }}</td>
                        </tr>
                    </table>
                    <div class="row">
                        <div class="col-6">
                            <a href="{{ route('Statistika') }}" class="btn btn-primary w-100">Statistika</a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('IshHaqi') }}" class="btn btn-primary w-100">Ish haqi</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body pt-4 text-center">
                    <h5>Parolni yangilash</h5>
                    <form action="" method="post">
                        @csrf
                        <label for="">Joriy parol</label>
                        <input type="password" required class="form-control">
                        <label for="" class="mt-2">Yangi parol</label>
                        <input type="password" required class="form-control">
                        <label for="" class="mt-2">Yangi parolni takrorlang</label>
                        <input type="password" required class="form-control">
                        <button class="btn btn-primary w-100 mt-3">Parolni yangilash</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

  </main>

@endsection
