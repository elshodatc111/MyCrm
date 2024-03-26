@extends('layouts.home')
@section('title',"Tashriflar")
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
      <h1>Qarzdorlar</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahifa</a></li>
          <li class="breadcrumb-item active">Qarzdorlar</li>
        </ol>
      </nav>
    </div>
    
    @if(session()->has('success'))
      <div class="alert alert-success">
        {{ session()->get('success') }}
      </div>
    @endif
    <div class="card">
      <div class="card-body">
        <div class="row py-2">
          <div class="col-lg-3 mt-1 col-6 text-center">
              <a href="{{ route('user.index') }}" class="btn btn-Secondary text-primary w-100"><i class="bi bi-people"></i> Barcha tashriflar</a>
          </div>
          <div class="col-lg-3 mt-1 col-6 text-center">
              <a href="{{ route('userDebet') }}" class="btn btn-primary w-100"><i class="bi bi-cash-coin"></i> Qarzdorlar</a>
          </div>
          <div class="col-lg-3 mt-1 col-6 text-center">
              <a href="{{ route('userPay') }}" class="btn btn-Secondary text-primary w-100"><i class="bi bi-cart-check"></i> To'lovlar</a>
          </div>
          <div class="col-lg-3 mt-1 col-6 text-center">
              <a href="{{ route('user.create') }}" class="btn btn-Secondary text-primary w-100"><i class="bi bi-person-plus"></i> Yangi tashrif</a>
          </div>
      </div><hr class="p-0 m-0">
        <table class="table datatable table-striped text-center">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Talaba</th>
                    <th>Telefon raqam</th>
                    <th>Yashash manzili</th>
                    <th>Guruhlar soni</th>
                    <th>Qarzdorlik</th>
                </tr>
            </thead>
            <tbody>
              @forelse($Debs as $item)
              <tr>
                <td>{{ $loop->index+1 }}</td>
                <td style="text-align:left;">
                  <a href="{{ route('user.show',$item['id'] ) }}">{{ $item['name'] }}</a>
                </td>
                <td>{{ $item['phone'] }}</td>
                <td>{{ $item['address'] }}</td>
                <td>{{ $item['gutuhlari'] }}</td>
                <td><b class="text-danger">{{ $item['debit'] }}</b></td>
              </tr>
              @empty
                <tr>
                  <td colspan=6 class='text-center'>Qarzdor talabalar mavjud emas.</td>
                </tr>
              @endforelse
            </tbody>
        </table>
      </div>
    </div>

  </main>

@endsection
