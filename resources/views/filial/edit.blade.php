@extends('layouts.home')
@section('title',"Filiallar")
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
      <h1>Filialni yangilash</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahifa</a></li>
          <li class="breadcrumb-item"><a href="{{ route('filial.index') }}">Filiallar</a></li>
          <li class="breadcrumb-item active">Filialni yangilash</li>
        </ol>
      </nav>
    </div>


    <div class="card">
      <div class="card-body">
        <div class="row">
            <div class="col-12">
            <h5 class="card-title">Filialni yangilash</h5>
            </div>
        </div>
        <form action="{{ route('filial.update', $filial->id ) }}" method="post">
            @csrf
            @method('PUT')
            <label for="filial_name">Filial nomi</label>
            <input type="text" name="filial_name" value="{{ $filial->filial_name }}" class="form-control mb-2" required>
            <label for="filial_addres">Filial manzili</label>
            <input type="text" name="filial_addres" value="{{ $filial->filial_addres }}" class="form-control" required>
            <button type="submit" class="btn btn-primary mt-3">O'zgarishlarni yangilash</button>
        </form>
      </div>
    </div>

  </main>

@endsection
