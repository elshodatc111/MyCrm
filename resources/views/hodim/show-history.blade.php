@extends('layouts.home')
@section('title',"Hodim tarixi")
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
      <h1>Hodim</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahifa</a></li>
          <li class="breadcrumb-item"><a href="{{ route('hodim.index') }}">Hodimlar</a></li>
          <li class="breadcrumb-item"><a href="{{ route('hodim.show', $User->id ) }}">Hodim</a></li>
          <li class="breadcrumb-item active">Hodim tarixi</li>
        </ol>
      </nav>
    </div>
    @if(session()->has('success'))
      <div class="alert alert-success">
        {{ session()->get('success') }}
      </div>
    @endif
    @if(session()->has('error'))
      <div class="alert alert-danger">
        {{ session()->get('error') }}
      </div>
    @endif
    

 
    <div class="card">
        <div class="card-body">
            <h5 class="w-100 text-center card-title">{{ $User->name }} qilgan ishlari.</h5>
            <div class="table-responsive">
                <table class="table text-center table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Status</th>
                            <th>Summa</th>
                            <th>Tulov xolati</th>
                            <th>Izoh</th>
                            <th>Vaqt</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($History as $item)
                        <tr>
                            <td>{{ $loop->index+1 }}</td>
                            <td style="text-align:left;">{{ $item['status'] }}</td>
                            <td>{{ $item['summa'] }}</td>
                            <td>{{ $item['type'] }}</td>
                            <td>{{ $item['izoh'] }}</td>
                            <td>{{ $item['created_at'] }}</td>
                        </tr>
                        @empty
                        <tr>
                          <td colspan=6 class='text-center'>Hodimning tarixi mavjud emas.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>


  </main>

@endsection
