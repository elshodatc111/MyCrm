@extends('layouts.home')
@section('title',"Yangi guruh")
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
      <h1>Yangi guruh</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahifa</a></li>
          <li class="breadcrumb-item"><a href="{{ route('guruh.index') }}">Guruhlar</a></li>
          <li class="breadcrumb-item active">Yangi guruh</li>
        </ol>
      </nav>
    </div>
    @if(session()->has('error'))
      <div class="alert alert-danger">
        {{ session()->get('error') }}
      </div>
    @endif
                
                
        <div class="card">
            <div class="card-body text-center">
                <div class="row mt-2">
                    <div class="col-lg-3 col-6 mt-1">
                        <a href="{{ route('guruh.index') }}" class="btn btn-muted p-1 w-100 card-title"><i class="bi bi-list-check"> Barcha guruhlar</i></a>
                    </div>
                    <div class="col-lg-3 col-6 mt-1">
                        <a href="{{ route('indexNew') }}" class="btn btn-muted p-1 w-100 card-title"><i class="bi bi-list-stars"> Yangi guruhlar</i></a>
                    </div>
                    <div class="col-lg-3 col-6 mt-1">
                        <a href="{{ route('indexActiv') }}" class="btn btn-muted p-1 w-100 card-title"><i class="bi bi-list-ul"> Aktiv guruhlar</i></a>
                    </div>
                    <div class="col-lg-3 col-6 mt-1">
                        <a href="{{ route('guruh.create') }}" class="btn btn-primary text-white p-1 w-100 card-title"><i class="bi bi-plus"> Yangi guruh</i></a>
                    </div>
                </div>
                <form action="{{ route('guruh.store') }}" method="post" id="form">
                    @csrf
                    <div class="row pb-4">
                        <div class="col-lg-6">
                            <label for="guruh_name" class="mt-2">Guruh nomi</label>
                            <input type="text" name="guruh_name" value="{{ old('guruh_name') }}" class="form-control" required>
                            <div class="row">
                                <div class="col-6">
                                    <label for="test_id" class="mt-2">Guruh uchun test</label>
                                    <select name="test_id" class="form-select">
                                        <option value="">Tanlang ...</option>
                                        @foreach( $Test as $item )
                                        <option value="{{ $item->id }}">{{ $item->test_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label for="room_id" class="mt-2">Darslar xonasi</label>
                                    <select name="room_id" class="form-select">
                                        <option value="">Tanlang ...</option>
                                        @foreach( $Room as $item )
                                        <option value="{{ $item->id }}">{{ $item->room_name }} Sig'imi: {{ $item->room_max_sigimi }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label for="guruh_start" class="mt-2">Dars boshlanish vaqti</label>
                                    <input type="date" name="guruh_start" value="{{ old('guruh_start') }}" class="form-control" required>
                                </div>
                                <div class="col-6">
                                    <label for="guruh_juft_toq" class="mt-2">Dars kunlari</label>
                                    <select name="guruh_juft_toq" class="form-select">
                                        <option value="">Tanlang</option>
                                        <option value="toq">Toq kunlar</option>
                                        <option value="juft">Juft kunlar</option>
                                    </select>
                                </div>
                            </div>  
                        </div>
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-6">
                                    <label for="guruh_price" class="mt-2">Kurs narxi</label>
                                    <select name="guruh_price" class="form-select">
                                        <option value="">Tanlang ...</option>
                                        @foreach( $Setting as $item )
                                        <option value="{{ $item->id }}">{{ $item->summa }} so'm</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label for="techer_id" class="mt-2">O'qituvchi</label>
                                    <select name="techer_id" class="form-select">
                                        <option value="">Tanlang ...</option>
                                        @foreach( $Techer as $item )
                                        <option value="{{ $item->id }}">{{ $item->name }} so'm</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label for="techer_tulov" class="mt-2">O'qituvchiga to'lov</label>
                                    <input type="text" id="summa2" value="0" name="techer_tulov" class="form-control" required>
                                </div>
                                <div class="col-6">
                                    <label for="techer_bonus" class="mt-2">O'qituvchiga bonus</label>
                                    <input type="text" id="summa" value="0" name="techer_bonus" class="form-control" required>
                                </div>
                                <div class="col-6">
                                    <label class="mt-2">.</label>
                                    <button class="btn btn-warning text-white w-100" type="reset">Tozalash</button>
                                </div>
                                <div class="col-6">
                                    <label class="mt-2">.</label>
                                    <button class="btn btn-primary w-100" type="submit">Davom etish</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
   

  </main>

@endsection
