@extends('layouts.home')
@section('title',"Yangi xona")
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
      <h1>Yangi xona qo'shish</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahifa</a></li>
          <li class="breadcrumb-item"><a href="{{ route('room.index') }}">Xonalar</a></li>
          <li class="breadcrumb-item active">Yangi xona qo'shish</li>
        </ol>
      </nav>
    </div>

    <div class="card">
      <div class="card-body">
        <div class="row">
            <div class="col-12">
                <h5 class="card-title pb-0 w-100 text-center">Yangi xona qo'shish</h5>
            </div>
        </div>
        <form action="{{ route('room.store') }}" method="post" class="row">
            @csrf
            <div class="col-lg-4">
                <label for="room_name" class="mt-3">Xona nomi</label>
                <input type="text" name="room_name" value="{{ old('room_name') }}" class="form-control" required>
            </div>
            <div class="col-lg-4">
                <label for="room_sigimi" class="mt-3">Xona Sig'imi</label>
                <input type="number" name="room_sigimi" value="{{ old('room_sigimi') }}" class="form-control" required>
            </div>
            <div class="col-lg-4">
                <label for="room_max_sigimi" class="mt-3">Max Sig'imi</label>
                <input type="number" name="room_max_sigimi" value="{{ old('room_max_sigimi') }}" class="form-control" required>
            </div>
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-primary mt-3">Xonani qo'shish</button>
            </div>
        </form>
      </div>
    </div>

  </main>

@endsection
