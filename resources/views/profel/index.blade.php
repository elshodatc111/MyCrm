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
    @if(session()->has('success'))
      <div class="alert alert-success">
        {{ session()->get('success') }}
      </div>
    @endif
    @if(session()->has('error'))
      <div class="alert alert-danger">
        {{ session()->get('error') }}
      </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">Parol 8 belgidan kam.</div>
    @endif
    <div class="row">
        <div class="col-lg-4">
            <div class="card" style="min-height:280px">
                <div class="card-body pt-4 text-center">
                    <h5>{{ Auth::user()->name }}</h5>
                    <table class="table table-bordered" style="font-size:14px;">
                        <tr>
                            <th style="text-align:left;">Yashash manzil</th>
                            <td style="text-align:left;">{{ Auth::user()->address }}</td>
                        </tr>
                        <tr>
                            <th style="text-align:left;">Telefon raqam</th>
                            <td style="text-align:left;">{{ Auth::user()->phone }}</td>
                        </tr>
                        <tr>
                            <th style="text-align:left;">Tug'ilgan kun</th>
                            <td style="text-align:left;">{{ Auth::user()->tkun }}</td>
                        </tr>
                        <tr>
                            <th style="text-align:left;">Login</th>
                            <td style="text-align:left;">{{ Auth::user()->email }}</td>
                        </tr>
                        <tr>
                            <th style="text-align:left;">Ishga olindi</th>
                            <td style="text-align:left;">{{ Auth::user()->created_at }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card" style="min-height:280px">
                <div class="card-body pt-4 text-center">
                    <h5>Tasdiqlanmagan to'lovlar</h5>
                    <table class="table table-bordered" style="font-size:14px;">
                        <tr>
                            <th style="text-align:left;">Naqt to'lovlar</th>
                            <td style="text-align:right;">{{ $Summa['Naqt'] }}</td>
                        </tr>
                        <tr>
                            <th style="text-align:left;">Plastik to'lovlar</th>
                            <td style="text-align:right;">{{ $Summa['Plastik'] }}</td>
                        </tr>
                        <tr>
                            <th style="text-align:left;">Qaytarilgan to'lovlar</th>
                            <td style="text-align:right;">{{ $Summa['Qaytar'] }}</td>
                        </tr>
                        <tr>
                            <th style="text-align:left;">Xarajatlar</th>
                            <td style="text-align:right;">{{ $Summa['Xarajat'] }}</td>
                        </tr>
                    </table>
                    <div class="row">
                        <div class="col-6">
                            <a href="{{ route('Statistika') }}" class="btn btn-primary w-100" style="border-radius:0;">Statistika</a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('IshHaqi') }}" class="btn btn-primary w-100" style="border-radius:0;">Ish haqi</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card" style="min-height:280px">
                <div class="card-body pt-4 text-center">
                    <h5>Parolni yangilash</h5>
                    <form action="{{ route('profel.update',Auth::user()->id) }}" method="post">
                        @csrf
                        @method('put')
                        <input type="password" style="border-radius:0;" name="thispassword" required class="form-control mb-2" placeholder="Joriy parol">
                        <input type="password" style="border-radius:0;" name="newpassword" required class="form-control mb-2" placeholder="Yangi parol">
                        <input type="password" style="border-radius:0;" name="repetpassword" required class="form-control mb-2" placeholder="Parolni takrorlang">
                        <button class="btn btn-primary w-100 mt-3" style="border-radius:0;">Parolni yangilash</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

  </main>

@endsection
