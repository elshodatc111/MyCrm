@extends('layouts.home')
@section('title',"Hodimlar")
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
      <h1>Hodimlar</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahifa</a></li>
          <li class="breadcrumb-item active">Hodimlar</li>
        </ol>
      </nav>
    </div>
    
    <div class="row py-2">
        <div class="col-4 text-center">
            <a href="{{ route('hodim.index') }}" class="btn btn-success w-100"><i class="bi bi-people"></i> Aktiv hodimlar</a>
        </div>
        <div class="col-4 text-center">
            <a href="{{ route('hodimLock') }}" class="btn btn-danger w-100"><i class="bi bi-person-lock"></i> Bloklangan hodimlar</a>
        </div>
        <div class="col-4 text-center">
            <a href="{{ route('hodim.create') }}" class="btn btn-primary w-100"><i class="bi bi-person-plus"></i> Yangi hodim</a>
        </div>
    </div>

    <div class="card">
      <div class="card-body pt-4">
        @if (Session::has('message'))
            <div class="alert alert-success">{{ Session::get('message') }}</div>
        @elseif(Session::has('update'))
          <div class="alert alert-primary">{{ Session::get('update') }}</div>
        @elseif(Session::has('delete'))
          <div class="alert alert-danger">{{ Session::get('delete') }}</div>
        @endif
        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Filial</th>
                    <th>Hodim ismi</th>
                    <th>Login</th>
                    <th>Lavozimi</th>
                    <th>Telefon raqami</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
      </div>
    </div>

  </main>

@endsection
