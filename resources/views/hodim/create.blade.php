@extends('layouts.home')
@section('title',"Filiallar")
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
      <h1>Yangi hodim</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahifa</a></li>
          <li class="breadcrumb-item"><a href="{{ route('hodim.index') }}">Hodimlar</a></li>
          <li class="breadcrumb-item active">Yangi hodim</li>
        </ol>
      </nav>
    </div>

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
      <div class="card-body">
        <div class="row py-2">
          <div class="col-4 text-center">
              <a href="{{ route('hodim.index') }}" class="btn btn-muted w-100  card-title py-1"><i class="bi bi-people"></i> Aktiv hodimlar</a>
          </div>
          <div class="col-4 text-center">
              <a href="{{ route('hodimLock') }}" class="btn btn-muted w-100 card-title py-1"><i class="bi bi-person-lock"></i> Bloklangan hodimlar</a>
          </div>
          <div class="col-4 text-center">
              <a href="{{ route('hodim.create') }}" class="btn btn-primary text-white w-100 card-title py-1"><i class="bi bi-person-plus"></i> Yangi hodim</a>
          </div>
        </div>
        <form action="{{ route('hodim.store') }}" method="post" class="row">
            @csrf
            <div class="col-lg-6">
                <label for="filial" class="mt-3">Filialni tanlang</label>
                <select name="filial" class="form-select" required>
                  <option value="{{ request()->cookie('filial_id') }}">{{ request()->cookie('filial_name') }}</option>
                </select>
                <label for="name" class="mt-3">Hodim FIO</label>
                <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
                <label for="address" class="mt-3">Yashash manzili</label>
                <input type="text" name="address" value="{{ old('address') }}" class="form-control" required>
                <label for="phone" class="mt-3">Telefon raqami</label>
                <input type="text" name="phone" value="{{ old('phone') }}" class="form-control phone" required>
            </div>
            <div class="col-lg-6">
                <label for="tkun" class="mt-3">Tug'ilgan kuni</label>
                <input type="date" name="tkun" value="{{ old('tkun') }}" class="form-control" required>
                <label for="filial_name" class="mt-3">Lavozimi</label>
                <select name="type" class="form-select" required>
                    <option value="">Tanlang</option>
                    <option value="Operator">Operator</option>
                    <option value="Admin">Admin</option>
                    @if(Auth::user()->type=="SuperAdmin")
                    <option value="SuperAdmin">SuperAdmin</option>
                    @endif
                </select>
                <label for="email" class="mt-3">Login</label>
                <input type="text" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required>
                <label for="password" class="mt-3">Parol(min: 8)</label>
                <input type="password" name="password" value="{{ old('password') }}" class="form-control @error('password') is-invalid @enderror" required>
            </div>
            <div class="col-12 text-center">
                
            <button type="submit" class="btn btn-primary mt-3">Hodim qo'shish</button>
            </div>
        </form>
      </div>
    </div>

  </main>

@endsection
