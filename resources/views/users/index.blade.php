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
    
    
    @if(session()->has('success'))
      <div class="alert alert-success">
        {{ session()->get('success') }}
      </div>
    @endif
    <div class="card">
      <div class="card-body">
        <div class="row py-2">
          <div class="col-lg-3 mt-1 col-6 text-center">
              <a href="{{ route('user.index') }}" class="btn btn-primary w-100"><i class="bi bi-people"></i> Barcha tashriflar</a>
          </div>
          <div class="col-lg-3 mt-1 col-6 text-center">
              <a href="{{ route('userDebet') }}" class="btn btn-Secondary text-primary w-100"><i class="bi bi-cash-coin"></i> Qarzdorlar</a>
          </div>
          <div class="col-lg-3 mt-1 col-6 text-center">
              <a href="{{ route('userPay') }}" class="btn btn-Secondary text-primary w-100"><i class="bi bi-cart-check"></i> To'lovlar</a>
          </div>
          <div class="col-lg-3 mt-1 col-6 text-center">
              <a href="{{ route('user.create') }}" class="btn btn-Secondary text-primary w-100"><i class="bi bi-person-plus"></i> Yangi tashrif</a>
          </div>
      </div><hr class="p-0 m-0">
        @if (Session::has('message'))
            <div class="alert alert-success">{{ Session::get('message') }}</div>
        @elseif(Session::has('update'))
          <div class="alert alert-primary">{{ Session::get('update') }}</div>
        @elseif(Session::has('delete'))
          <div class="alert alert-danger">{{ Session::get('delete') }}</div>
        @endif
        <table class="table datatable table-striped text-center" style="font-size:14px;">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Talaba</th>
                    <th>Telefon raqami</th>
                    <th>Yashash manzil</th>
                    <th>Tug'ilgan kuni</th>
                    <th>Guruhlar soni</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
              @forelse($User as $item)
                <tr>
                    <td class="text-center">{{ $loop->index+1 }}</td>
                    <td style="text-align:left;">{{ $item['name'] }}</td>
                    <td class="text-center">{{ $item['phone'] }}</td>
                    <td style="text-align:left;">{{ $item['address'] }}</td>
                    <td class="text-center">{{ $item['tkun'] }}</td>
                    <td class="text-center">{{ $item['guruh'] }}</td>
                    <td class="text-center">
                        <a href="{{ route('user.show', $item['id'] ) }}" class="btn btn-success py-0 px-1"><i class="bi bi-eye"></i></a>
                        @if(Auth::user()->type=='Admin' OR Auth::user()->type=='SuperAdmin')
                        <a href="{{ route('user.edit', $item['id'] ) }}" class="btn btn-primary py-0 px-1"><i class="bi bi-pencil"></i></a>
                        @if(Auth::user()->type=='SuperAdmin')
                        <form action="{{ route('user.destroy',$item['id'] ) }}" method="post" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger px-1 py-0"><i class="bi bi-trash"></i></button>
                        </form>
                        @endif
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan='7' class="text-center">Talabalar mavjud emas</td>
                </tr>
              @endforelse
            </tbody>
        </table>
      </div>
    </div>

  </main>

@endsection
