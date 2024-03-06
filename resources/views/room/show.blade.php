@extends('layouts.home')
@section('title',"Yangi xona")
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
      <h1>Dars jadvali</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahifa</a></li>
          <li class="breadcrumb-item"><a href="{{ route('room.index') }}">Xonalar</a></li>
          <li class="breadcrumb-item active">Dars jadvali</li>
        </ol>
      </nav>
    </div>

    <div class="card">
      <div class="card-body">
        <div class="row">
            <div class="col-12">
                <h5 class="card-title pb-0 w-100 text-center">{{ $room->room_name }} Dars jadvali</h5>
            </div>
        </div>

      </div>
    </div>

  </main>

@endsection
