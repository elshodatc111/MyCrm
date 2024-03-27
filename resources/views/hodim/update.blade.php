@extends('layouts.home')
@section('title',"Filiallar")
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
      <h1>Hodimni taxrirlash</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahifa</a></li>
          <li class="breadcrumb-item"><a href="{{ route('hodim.index') }}">Hodimlar</a></li>
          <li class="breadcrumb-item active">Hodimni taxrirlash</li>
        </ol>
      </nav>
    </div>

    @if ($errors->any())
      <div class="alert alert-danger">
        Parol 8 belgidan kam bo'lmasigi kerak.
      </div>
    @endif
    <div class="card">
      <div class="card-body">
        <div class="row">
            <div class="col-12">
                <h5 class="card-title pb-0 w-100 text-center">Hodimni taxrirlash</h5>
            </div>
        </div>
        <form action="{{ route('hodim.update',$Users->id ) }}" method="post" class="row">
            @csrf
            @method('put')
            <div class="col-lg-6">
                <label for="name" class="mt-3">Hodim FIO</label>
                <input type="text" name="name" value="{{ $Users->name }}" class="form-control" required>
                <label for="address" class="mt-3">Yashash manzili</label>
                <input type="text" name="address" value="{{ $Users->address }}" class="form-control" required>
                <label for="phone" class="mt-3">Telefon raqami</label>
                <input type="text" name="phone" value="{{ $Users->phone }}" class="form-control phone" required>
            </div>
            <div class="col-lg-6">
                <label for="tkun" class="mt-3">Tug'ilgan kuni</label>
                <input type="date" name="tkun" value="{{ $Users->tkun }}" class="form-control" required>
                <label for="filial_name" class="mt-3">Lavozimi</label>
                <select name="type" class="form-select" required>
                    <option value="">Tanlang</option>
                    <option value="Operator">Operator</option>
                    <option value="Admin">Admin</option>
                    @if(Auth::user()->type=="SuperAdmin")
                    <option value="SuperAdmin">SuperAdmin</option>
                    @endif
                </select>
                <label for="password" class="mt-3">Parol(min: 8)</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
            </div>
            <div class="col-12 text-center">
              <a href="{{ route('hodim.index') }}" class="btn btn-warning mt-3 text-white"><i class="bi bi-reply-all"></i> Orqaga qaytarish</a>
              <button type="submit" class="btn btn-primary mt-3">O'zgarishlarni saqlash</button>
            </div>
        </form>
      </div>
    </div>

  </main>

@endsection
