@extends('layouts.home')
@section('title',"O'qituvchi")
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
      <h1>O'qituvchilar</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahifa</a></li>
          <li class="breadcrumb-item"><a href="{{ route('techer.index') }}">O'qituvchilar</a></li>
          <li class="breadcrumb-item"><a href="{{ route('techer.index') }}">O'qituvchi</a></li>
          <li class="breadcrumb-item active">To'langan ish haqi</li>
        </ol>
      </nav>
    </div>
    
    <div class="card">
        <div class="card-body">
            <h5 class="card-title text-center">Guruhlari</h5>
            <div class="table-responsive">
                <table class="table text-center table-bordered" style="font-size:14px;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Guruh</th>
                            <th>Tulov summa</th>
                            <th>To'lov holati</th>
                            <th>To'lov haqida</th>
                            <th>To'lov vaqti</th>
                            <th>Menegre</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tolovlar as $itme)
                        <tr>
                            <td>{{ $loop->index+1 }}</td>
                            <td>{{ $itme['guruh'] }}</td>
                            <td>{{ $itme['summa'] }}</td>
                            <td>{{ $itme['type'] }}</td>
                            <td>{{ $itme['commit'] }}</td>
                            <td>{{ $itme['tulov_vaqti'] }}</td>
                            <td>{{ $itme['admin'] }}</td>
                        </tr>
                        @empty

                        @endforelse
                    </tbody>
                    
                </table>
            </div>
        </div>
    </div>

    
  </main>

@endsection
