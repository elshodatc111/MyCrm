@extends('layouts.home')
@section('title',"Bloklangan hodimlar")
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
      <h1>Bloklangan hodimlar</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahifa</a></li>
          <li class="breadcrumb-item"><a href="{{ route('hodim.index') }}">Hodimlar</a></li>
          <li class="breadcrumb-item active">Bloklangan hodimlar</li>
        </ol>
      </nav>
    </div>
    
    <div class="card">
      <div class="card-body">
        <div class="row py-2">
          <div class="col-4 text-center">
              <a href="{{ route('hodim.index') }}" class="btn btn-muted w-100  card-title py-1"><i class="bi bi-people"></i> Aktiv hodimlar</a>
          </div>
          <div class="col-4 text-center">
              <a href="{{ route('hodimLock') }}" class="btn btn-primary w-100 text-white card-title py-1"><i class="bi bi-person-lock"></i> Bloklangan hodimlar</a>
          </div>
          <div class="col-4 text-center">
              <a href="{{ route('hodim.create') }}" class="btn btn-muted w-100 card-title py-1"><i class="bi bi-person-plus"></i> Yangi hodim</a>
          </div>
        </div>
        @if (Session::has('message'))
            <div class="alert alert-success">{{ Session::get('message') }}</div>
        @elseif(Session::has('update'))
          <div class="alert alert-primary">{{ Session::get('update') }}</div>
        @elseif(Session::has('delete'))
          <div class="alert alert-danger">{{ Session::get('delete') }}</div>
        @endif
        
        <div class="table-responsive">
          <table class="table table-striped text-center" style="font-size:14px;">
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
                  @forelse($Users as $item)
                      <tr>
                        <td>{{ $loop->index+1 }}</td>
                        <td>{{ $item->filial_name }}</td>
                        <td style="text-align:left">{{ $item->name }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->type }}</td>
                        <td>{{ $item->phone }}</td>
                        <td>
                          <a href="{{ route('hodim.show', $item->id ) }}" class="btn btn-success p-0 px-1"><i class="bi bi-eye"></i></a>
                          <a href="{{ route('LockOpen', $item->id ) }}" class="btn btn-danger p-0 px-1"><i class="bi bi-unlock"></i></a>
                        </td>
                      </tr>
                      @empty
                      <tr>
                        <td colspan="7" class="text-center">Bloklangan hodimalr mavjud emas.</td>
                      </tr>
                    @endforelse
              </tbody>
          </table>
        </div>
      </div>
    </div>

  </main>

@endsection
