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
            <div class="card-body pt-4 text-center">
                <h5>Yangi guruh</h5>
                <form action="{{ route('store2') }}" method="post" id="form">
                    @csrf
                    <div class="row">
                        <div class="col-lg-4">
                            <label for="" class="mt-2">Guruh nomi</label>
                            <input type="text" value="{{ $Javob['guruh']['guruh_name'] }}" class="form-control" disabled>
                            <label for="" class="mt-2">Darslar boshlanish vaqti</label>
                            <input type="text" value="{{ $Javob['guruh']['guruh_start'] }}" class="form-control" disabled>
                            <label for="" class="mt-2">Darslar tugash vaqti</label>

                            <input type="hidden" name="guruh_end" value="{{ $Javob['guruh_end'] }}">
                            <input type="hidden" name="status" value="true">
                            <input type="hidden" name="id" value="{{ $Javob['guruh']['id'] }}">

                            <input type="text" value="{{ $Javob['guruh_end'] }}" class="form-control" disabled>
                            <label for="" class="mt-2">Guruh uchun testlar</label>
                            <input type="text" value="{{ $Javob['Testlar'] }}" class="form-control" disabled>
                            <label for="" class="mt-2">Dars xonasi</label>
                            <input type="text" value="{{ $Javob['Room'] }}" class="form-control" disabled>
                            
                        </div>
                        <div class="col-lg-4">
                            <label for="" class="mt-2">Guruh narxi</label>
                            <input type="text" value="{{ $Javob['guruh']['guruh_price'] }}" class="form-control" disabled>
                            <label for="" class="mt-2">O'qituvchi</label>
                            <input type="text" value="{{ $Javob['Techer'] }}" class="form-control" disabled>
                            <label for="" class="mt-2">O'qituvchiga to'lov</label>
                            <input type="text" value="{{ $Javob['guruh']['techer_tulov'] }}" class="form-control" disabled>
                            <label for="" class="mt-2">O'qituvchiga bonus</label>
                            <input type="text" value="{{ $Javob['guruh']['techer_bonus'] }}" class="form-control" disabled>
                            <label for="guruh_dars_vaqt" class="mt-2">Dars vaqtini tanlang</label>
                            <select name="guruh_dars_vaqt" class="form-select">
                                <option value="">Tanlang...</option>
                                @foreach($Javob['clock'] as $item)
                                    <option value="{{ $item['id'] }}">{{ $item['text'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <label for="guruh_dars_vaqt" class="mt-4">Dars kunlari</label>
                            <div class="row pt-3" style="border:1px solid blue">
                                @foreach($Javob['kunlar'] as $item )
                                    <div class="col-6">
                                        <p>{{ $item }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-12 mt-3">
                            <button class="btn btn-success w-50">Saqlash</button>
                              </form>
                            
                            <form action="{{ route('guruh.destroy', $Javob['guruh']['id'] ) }}" method="post">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger w-50 mt-3">Bekor qilish</button>
                            </form>
                        </div>
                    </div>
            </div>
        </div>
        
   

  </main>

@endsection
