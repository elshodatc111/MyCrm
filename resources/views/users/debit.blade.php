@extends('layouts.home')
@section('title',"Tashriflar")
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
      <h1>Tashriflar</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahifa</a></li>
          <li class="breadcrumb-item active">Tashriflar</li>
        </ol>
      </nav>
    </div>
    
    <div class="row py-2">
        <div class="col-lg-3 mt-2 col-6 text-center">
            <a href="{{ route('user.index') }}" class="btn btn-primary w-100"><i class="bi bi-people"></i> Barcha tashriflar</a>
        </div>
        <div class="col-lg-3 mt-2 col-6 text-center">
            <a href="{{ route('userDebet') }}" class="btn btn-primary w-100"><i class="bi bi-cash-coin"></i> Qarzdorlar</a>
        </div>
        <div class="col-lg-3 mt-2 col-6 text-center">
            <a href="{{ route('userPay') }}" class="btn btn-primary w-100"><i class="bi bi-cart-check"></i> To'lovlar</a>
        </div>
        <div class="col-lg-3 mt-2 col-6 text-center">
            <a href="{{ route('user.create') }}" class="btn btn-primary w-100"><i class="bi bi-person-plus"></i> Yangi tashrif</a>
        </div>
    </div>
    @if(session()->has('success'))
      <div class="alert alert-success">
        {{ session()->get('success') }}
      </div>
    @endif
    <div class="card">
      <div class="card-body pt-4">
        @if (Session::has('message'))
            <div class="alert alert-success">{{ Session::get('message') }}</div>
        @elseif(Session::has('update'))
          <div class="alert alert-primary">{{ Session::get('update') }}</div>
        @elseif(Session::has('delete'))
          <div class="alert alert-danger">{{ Session::get('delete') }}</div>
        @endif
        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Filial</th>
                    <th>Hodim ismi</th>
                    <th>Login</th>
                    <th>Lavozimi</th>
                    <th>Telefon raqami</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
              
            </tbody>
        </table>
      </div>
    </div>

  </main>

@endsection
