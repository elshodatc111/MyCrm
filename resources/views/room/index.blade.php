@extends('layouts.home')
@section('title',"Xonalar")
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
      <h1>Xonalar</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahifa</a></li>
          <li class="breadcrumb-item active">Xonalar</li>
        </ol>
      </nav>
    </div>
    
    <div class="row py-2">
        <div class="col-8 text-center"></div>
        <div class="col-4 text-center">
            <a href="{{ route('room.create') }}" class="btn btn-primary w-100"><i class="bi bi-door-open"></i> Yangi xona qo'shish</a>
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
        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Xona nomi</th>
                    <th>Xona Sig'imi</th>
                    <th>Max Sig'imi</th>
                    <th>Admin</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($Rooms as $item)
                    <tr>
                        <td>{{ $loop->index+1 }}</td>
                        <td>{{ $item->room_name }}</td>
                        <td>{{ $item->room_sigimi }}</td>
                        <td>{{ $item->room_max_sigimi }}</td>
                        <td>{{ $item->email }}</td>
                        <td>
                            <a href="{{ route('room.show', $item->id ) }}" class="btn btn-primary px-1 py-0"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('room.edit', $item->id ) }}" class="btn btn-warning px-1 py-0"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('room.destroy', $item->id ) }}" method="post" style="display:inline;">@csrf @method('delete')<button class="btn btn-danger px-1 py-0"><i class="bi bi-trash"></i></button></form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Xonalar mavjud emas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
      </div>
    </div>

  </main>

@endsection
