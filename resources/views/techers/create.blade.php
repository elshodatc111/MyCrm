@extends('layouts.home')
@section('title',"O'qituvchilar")
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Yangi o'qituvchi</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahifa</a></li>
                <li class="breadcrumb-item"><a href="{{ route('techer.index') }}">O'qituvchilar</a></li>
                <li class="breadcrumb-item active">Yangi o'qituvchi</li>
            </ol>
        </nav>
    </div>
    
    @if(session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif

    @if ($errors->any())
      <div class="alert alert-danger">
              @foreach ($errors->all() as $error)
                @if($error=='The email has already been taken.')
                  Login band. Boshqa login kiriting.
                @else
                  Parol 8 belgidan kam bo'lmasigi kerak.
                @endif
              @endforeach
      </div>
    @endif
    <div class="card">
        <div class="card-body pt-4">
            <form action="{{ route('techer.store') }}" method="post" class="row">
                @csrf
                <div class="col-lg-6">
                    <label for="name" class="mt-3">O'qituvchi FIO</label>
                    <input type="text" value="{{ old('name') }}" name="name" class="form-control" required>
                    <label for="address" class="mt-3">Yashash manzili</label>
                    <input type="text" value="{{ old('address') }}" name="address" class="form-control" required>
                    <label for="phone" class="mt-3">Telefon raqam</label>
                    <input type="text" value="{{ old('phone') }}" name="phone" class="form-control phone" required>
                    <label for="tkun" class="mt-3">Tug'ilgan kuni</label>
                    <input type="date" value="{{ old('tkun') }}" name="tkun" class="form-control" required>
                </div>
                <div class="col-lg-6">
                    <label for="email" class="mt-3">Login</label>
                    <input type="text" value="{{ old('email') }}" name="email" class="form-control @error('email') is-invalid @enderror" required>
                    <label for="password" class="mt-3">Parol (min:8)</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                    <label for="TecherAbout" class="mt-3">O'qituvchi haqida</label>
                    <input type="text" value="{{ old('TecherAbout') }}" name="TecherAbout" class="form-control" required>
                    <label for="Mutahasisligi" class="mt-3">Mutahasisligi</label>
                    <input type="text" value="{{ old('Mutahasisligi') }}" name="Mutahasisligi" class="form-control" required>
                </div>
                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-primary w-50 mt-3">O'qituvchini saqlash</button>
                </div>
            </form>
        </div>
    </div>

  </main>

@endsection
