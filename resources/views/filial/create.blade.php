@extends('layouts.home')
@section('title',"Filiallar")
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
      <h1>Yangi filial</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahifa</a></li>
          <li class="breadcrumb-item"><a href="{{ route('filial.index') }}">Filiallar</a></li>
          <li class="breadcrumb-item active">Yangi filial</li>
        </ol>
      </nav>
    </div>


    <div class="card">
      <div class="card-body">
        <div class="row">
            <div class="col-12">
            <h5 class="card-title">Yangi filial qo'shish</h5>
            </div>
        </div>
        <form action="{{ route('filial.store') }}" method="post">
            @csrf
            <label for="filial_name">Filial nomi</label>
            <input type="text" name="filial_name" class="form-control" required>
            <label for="filial_addres">Filial manzili</label>
            <input type="text" name="filial_addres" class="form-control" required>
            <button type="submit" class="btn btn-primary mt-3">Filalni yaratish</button>
        </form>
      </div>
    </div>

  </main>

@endsection
