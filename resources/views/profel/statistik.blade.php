@extends('layouts.home')
@section('title',"Profel")
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
      <h1>Statistika</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahifa</a></li>
          <li class="breadcrumb-item"><a href="{{ route('profel.index') }}">Kabinet</a></li>
          <li class="breadcrumb-item active">Statistika</li>
        </ol>
      </nav>
    </div>
    
    <div class="card">
        <div class="card-body pt-4 text-center">
            <h5>Statistika</h5>
        </div>
    </div>
            

  </main>

@endsection
