@extends('layouts.home')
@section('title',"Guruhni taxrirlash")
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
      <h1>Guruhni taxrirlash</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahifa</a></li>
          <li class="breadcrumb-item"><a href="{{ route('guruh.index') }}">Guruhlar</a></li>
          <li class="breadcrumb-item active">Guruhni taxrirlash</li>
        </ol>
      </nav>
    </div>
    @if(session()->has('error'))
      <div class="alert alert-danger">
        {{ session()->get('error') }}
      </div>
    @endif
                
                
        <div class="card">
            <div class="card-body pt-4 text-center">
                <h5>Guruhni yangilash</h5>
                <form action="{{ route('guruh.update',$guruh->id ) }}" method="post" id="form">
                    @csrf
                    @method('put')
                    <label for="guruh_name" class="mt-2">Guruh nomi</label>
                    <input type="text" name="guruh_name" value="{{ $guruh->guruh_name }}" class="form-control" required>
                    <div class="row">
                        <div class="col-6">
                            <label for="test_id" class="mt-2">Guruh uchun test</label>
                            <select name="test_id" class="form-select">
                                <option value="">Tanlang ...</option>
                                @foreach($Test as $item)
                                    <option value="{{ $item->id }}">{{ $item->test_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="guruh_price" class="mt-2">Kurs narxi</label>
                            <select name="guruh_price" class="form-select">
                                <option value="">Tanlang ...</option>
                                @foreach($Setting as $item)
                                    <option value="{{ $item->id }}">{{ $item->summa }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="techer_id" class="mt-2">O'qituvchi</label>
                            <select name="techer_id" class="form-select">
                                <option value="">Tanlang ...</option>
                                @foreach($Techer as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-3">
                            <label for="techer_tulov" class="mt-2">O'qituvchiga to'lov</label>
                            <input type="text" id="summa2" value="{{ $guruh->techer_tulov }}" name="techer_tulov" class="form-control" required>
                        </div>
                        <div class="col-3">
                            <label for="techer_bonus" class="mt-2">O'qituvchiga bonus</label>
                            <input type="text" id="summa" value="{{ $guruh->techer_bonus }}" name="techer_bonus" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary w-50 mt-3" type="submit">Kursni yangilash</button>
                        </div>
                    </div>  
                </form>
            </div>
        </div>
        
   

  </main>

@endsection
