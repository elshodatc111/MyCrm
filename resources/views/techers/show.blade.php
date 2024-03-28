@extends('layouts.home')
@section('title',"O'qituvchi")
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
      <h1>O'qituvchilar</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahifa</a></li>
          <li class="breadcrumb-item"><a href="{{ route('techer.index') }}">O'qituvchilar</a></li>
          <li class="breadcrumb-item active">O'qituvchi</li>
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
    <div class="card">
      <div class="card-body">
        <h5 class="card-title w-100 text-center">{{ $Techer['name'] }}</h5>
        <div class="row">
            <div class="col-lg-4">
                <table class="table" style="font-size:14px;">
                    <tr>
                        <th style="text-align:left">Manzili:</th>
                        <td style="text-align:right">{{ $Techer['name'] }}</td>
                    </tr>
                    <tr>
                        <th style="text-align:left">Telefon raqam:</th>
                        <td style="text-align:right">{{ $Techer['phone'] }}</td>
                    </tr>
                    <tr>
                        <th style="text-align:left">Tug'ilgan kuni:</th>
                        <td style="text-align:right">{{ $Techer['tkun'] }}</td>
                    </tr>
                    <tr>
                        <th style="text-align:left">Manzili:</th>
                        <td style="text-align:right">{{ $Techer['address'] }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-lg-4">
                <table class="table" style="font-size:14px;">
                    <tr>
                        <th style="text-align:left">Login:</th>
                        <td style="text-align:right">{{ $Techer['email'] }}</td>
                    </tr>
                    <tr>
                        <th style="text-align:left">O'qituvchi haqida:</th>
                        <td style="text-align:right">{{ $Techer['TecherAbout'] }}</td>
                    </tr>
                    <tr>
                        <th style="text-align:left">Mutahasislgi:</th>
                        <td style="text-align:right">{{ $Techer['Mutahasisligi'] }}</td>
                    </tr>
                    <tr>
                        <th style="text-align:left">Ro'yhatga olindi:</th>
                        <td style="text-align:right">{{ $Techer['created_at'] }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-lg-4">
                <form action="{{ route('sendmes') }}" method="post" class="text-center">
                    @csrf
                    <h5 class="card-title mb-0 pb-1 pt-0">SMS yuborish</h5>
                    <input type="hidden" name="phone" value="{{ $setting['phone'] }}">
                    <textarea name="text" class="form-control" required></textarea>
                    <button class="btn btn-primary w-100 mt-2">SMS yuborish</button>
                </form>
            </div>
        </div>
        
      </div>
    </div>
 
    <div class="card">
        <div class="card-body">
            <table class="table text-center mt-3">
                <tr>
                    <th style="width:33.3333%">
                        <h5 class="w-100 p-0 m-0 card-title text-center">Ish haqi to'lash</h5>
                    </th>
                    <th style="width:33.3333%">
                        <h5 class="w-100 p-0 m-0 card-title text-center">Kassada mavjud ( Naqt: {{ $setting['NaqtMavjud'] }} )</h5>
                    </th>
                    <th style="width:33.3333%">
                        <h5 class="w-100 p-0 m-0 card-title text-center">Kassada mavjud ( Plastik: {{ $setting['PlastikMavjud'] }} )</h5>
                    </th>
                </tr>
            </table>
            <div class="row">
                <div class="col-lg-8">
                    <form action="{{ route('TecherPayIshHaqi') }}" id="form1" method="post" id="form">
                        @csrf
                        <input type="hidden" name="techer_id" value="{{ $Techer->user_id }}">
                        <input type="hidden" name="Naqt" value="{{ $setting['NaqtMavjud'] }}">
                        <input type="hidden" name="Plastik" value="{{ $setting['PlastikMavjud'] }}">
                        <input type="text" id="summa1" name="summa" class="form-control mb-2" placeholder="To'lov summasi" required>
                        <div class="row">
                            <div class="col-6">
                                <select name="guruh_id" class="form-select mb-2" required>
                                    <option value="">Guruh tanlang</option>
                                    @foreach($setting['FormGuruh'] as $item)
                                        <option value="{{ $item['id'] }}">{{ $item['guruh_name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6">
                                <select name="type" class="form-select mb-2" required>
                                    <option value="">To'lov turi</option>
                                    <option value="Naqt">Naqt</option>
                                    <option value="Plastik">Plastik</option>
                                </select>
                            </div>
                        </div>
                        <input type="text" name="commit" class="form-control mb-2" placeholder="To'lov haqida" required>
                        <button type="submit" class="btn btn-primary w-100">To'lov</button>
                    </form>
                </div>
                <div class="col-lg-4">
                    <a href="{{ route('techerPays',$Techer->user_id ) }}" class="btn btn-warning text-white w-100 mt-3">Ish haqi to'lovlari tarixi</a>
                    <a href="" class="btn btn-warning text-white w-100 mt-3">Arxiv guruhlari</a>
                </div>
            </div>
        </div>
    </div>
    ### Kassadagi mavjud Naqt Va Plastik Summalar <br>
    ### Arxiv Guruhlari<br>
    #Guruhlar 
    <div class="card">
        <div class="card-body">
            <h5 class="card-title text-center">Guruhlari</h5>
            <div class="table-responsive">
                <table class="table text-center table-bordered" style="font-size:14px;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Guruh</th>
                            <th>Boshlanish</th>
                            <th>Yakunlanish</th>
                            <th>Talabalar</th>
                            <th>Yangi Guruhga</th>
                            <th>Ish haqi</th>
                            <th>To'langan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($Guruhlar as $item)
                        <tr>
                            <td>{{ $loop->index+1 }}</td>
                            <td style="text-align:left;">{{ $item['guruh_name'] }}</td>
                            <td>{{ $item['guruh_start'] }}</td>
                            <td>{{ $item['guruh_end'] }}</td>
                            <td>{{ $item['talabalar'] }}</td>
                            <td>{{ $item['NewUser'] }}</td>
                            <td>{{ $item['TechTulov'] }}</td>
                            <td>{{ $item['Tulov'] }}</td>
                        </tr>
                        @empty

                        @endforelse
                    </tbody>
                    
                </table>
            </div>
        </div>
    </div>

    
  </main>

@endsection
