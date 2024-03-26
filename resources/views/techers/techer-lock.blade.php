@extends('layouts.home')
@section('title',"O'qituvchilar")
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
      <h1>O'qituvchilar</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahifa</a></li>
          <li class="breadcrumb-item"><a href="{{ route('techer.index') }}">O'qituvchilar</a></li>
          <li class="breadcrumb-item active">Bloklangan o'qituvchilar</li>
        </ol>
      </nav>
    </div>
    
    @if(session()->has('success'))
      <div class="alert alert-success">
        {{ session()->get('success') }}
      </div>
    @endif
    <div class="card">
      <div class="card-body">
        <div class="row py-2">
          <div class="col-4 text-center">
              <a href="{{ route('techer.index') }}" class="btn btn-muted w-100  card-title py-1"><i class="bi bi-people"></i> Aktiv o'qituvchilar</a>
          </div>
          <div class="col-4 text-center">
              <a href="{{ route('techerLock') }}" class="btn btn-primary text-white w-100  card-title py-1"><i class="bi bi-person-lock"></i> Bloklangan o'qituvchilar</a>
          </div>
          <div class="col-4 text-center">
              <a href="{{ route('techer.create') }}" class="btn btn-muted w-100  card-title py-1"><i class="bi bi-person-plus"></i> Yangi o'qituvchi</a>
          </div>
        </div>
        
        <div class="table-responsive">
          <table class="table table-striped text-center">
              <thead>
                  <tr>
                      <th>#</th>
                      <th>O'qituvchi</th>
                      <th>Yashash manzili</th>
                      <th>Telefon raqami</th>
                      <th>Tug'ilgan kuni</th>
                      <th>Login</th>
                      <th>Status</th>
                  </tr>
              </thead>
              <tbody>
                @forelse($Techer as $item)
                  <tr>
                    <td>{{ $loop->index+1 }}</td>
                    <td style="text-align:left;">{{ $item->name }}</td>
                    <td style="text-align:left;">{{ $item->address }}</td>
                    <td style="text-align:left;">{{ $item->phone }}</td>
                    <td style="text-align:left;">{{ $item->tkun }}</td>
                    <td style="text-align:left;">{{ $item->email }}</td>
                    <td>
                      <a href="{{ route('techer.show', $item->id ) }}" class="btn btn-success py-0 px-1"><i class="bi bi-eye"></i></a>
                      <a href="{{ route('techerLockClose', $item->id ) }}" class="btn btn-danger py-0 px-1"><i class="bi bi-lock"></i></a>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan='7'>Bloklangan o'qituvchilar mavjud emas</td>
                  </tr>
                @endforelse
              </tbody>
          </table>
        </div>
      </div>
    </div>

  </main>

@endsection
