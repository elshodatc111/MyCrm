@extends('layouts.home')
@section('title',"O'qituvchilar")
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>O'qituvchi ma'lumotlarini yangilash</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahifa</a></li>
                <li class="breadcrumb-item"><a href="{{ route('techer.index') }}">O'qituvchilar</a></li>
                <li class="breadcrumb-item active">O'qituvchi ma'lumotlarini yangilash</li>
            </ol>
        </nav>
    </div>
    
    @if(session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif
    <div class="card">
        <div class="card-body pt-4">
            <form action="{{ route('techer.update',$Techer->user_id ) }}" method="post" class="row">
                @csrf
                @method('put')
                <div class="col-lg-6">
                    <label for="name" class="mt-3">O'qituvchi FIO</label>
                    <input type="text" value="{{ $Techer->name }}" name="name" class="form-control" required>
                    <label for="address" class="mt-3">Yashash manzili</label>
                    <input type="text" value="{{ $Techer->address }}" name="address" class="form-control" required>
                    <label for="phone" class="mt-3">Telefon raqam</label>
                    <input type="text" value="{{ $Techer->phone }}" name="phone" class="form-control phone" required>
                    <label for="tkun" class="mt-3">Tug'ilgan kuni</label>
                    <input type="date" value="{{ $Techer->tkun }}" name="tkun" class="form-control" required>
                </div>
                <div class="col-lg-6">
                    <label for="password" class="mt-3">Parol</label>
                    <input type="password" name="password" class="form-control" required>
                    <label for="TecherAbout" class="mt-3">O'qituvchi haqida</label>
                    <input type="text" value="{{ $Techer->TecherAbout }}" name="TecherAbout" class="form-control" required>
                    <label for="Mutahasisligi" class="mt-3">Mutahasisligi</label>
                    <input type="text" value="{{ $Techer->Mutahasisligi }}" name="Mutahasisligi" class="form-control" required>
                </div>
                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-primary w-50 mt-3">O'qituvchini saqlash</button>
                </div>
            </form>
        </div>
    </div>

  </main>

@endsection
