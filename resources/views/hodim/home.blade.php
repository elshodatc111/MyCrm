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
    @if(session()->has('success'))
      <div class="alert alert-success">
        {{ session()->get('success') }}
      </div>
    @endif
    <div class="card">
      <div class="card-body pt-4">
        @if (Session::has('message'))
            <div class="alert alert-success">{{ Session::get('message') }}</div>
        @elseif(Session::has('update'))
          <div class="alert alert-primary">{{ Session::get('update') }}</div>
        @elseif(Session::has('delete'))
          <div class="alert alert-danger">{{ Session::get('delete') }}</div>
        @endif
        <table class="table table-bordered text-center" style="font-size:14px;">
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
                    <a href="{{ route('hodim.edit', $item->id ) }}" class="btn btn-primary p-0 px-1"><i class="bi bi-pencil"></i></a>
                    <a href="{{ route('LockClose', $item->id ) }}" class="btn btn-danger p-0 px-1"><i class="bi bi-lock"></i></a>
                  </td>
                </tr>
                @empty
                    <tr>
                      <td colspan="7" class="text-center">Hodimlar mavjud emas.</td>
                    </tr>
              @endforelse
            </tbody>
        </table>
      </div>
    </div>

  </main>

@endsection
