@extends('layouts.home')
@section('title',"Tashriflar")
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
      <h1>To'lovlar</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahifa</a></li>
          <li class="breadcrumb-item active">To'lovlar</li>
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
    <div class="card">
      <div class="card-body pt-4">
        <table class="table datatable table-bordered text-center" style="font-size:14px;">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Talaba</th>
                    <th>To'lov summasi</th>
                    <th>To'lov turi</th>
                    <th>To'lov vaqti</th>
                    <th>To'lov haqida</th>
                    <th>Operator</th>
                    <th>To'lov holati</th>
                </tr>
            </thead>
            <tbody>
              @forelse($Tulovlar as $item)
                <tr>
                  <td>{{ $loop->index+1 }}</td>
                  <td style="text-align:left;"><a href="{{ route('user.show',$item['talaba_id']) }}">{{ $item['talaba'] }}</a></td>
                  <td>{{ $item['summa'] }}</td>
                  <td style="text-align:left;">{{ $item['type'] }}</td>
                  <td>{{ $item['created_at'] }}</td>
                  <td style="text-align:left;">{{ $item['comment'] }}</td>
                  <td>{{ $item['admin'] }}</td>
                  <td style="text-align:right;">  
                    @if($item['status']=='true')
                      <i class="bg-success text-white p-1">Tasdiq</i>
                    @else
                      <i class="bg-danger text-white p-1">Kutilmoqda</i>
                    @endif
                  </td>
                </tr>
              @empty

              @endforelse
            </tbody>
        </table>
      </div>
    </div>

  </main>

@endsection
