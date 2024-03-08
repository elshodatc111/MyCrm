@extends('layouts.home')
@section('title',"Sozlamalar")
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
      <h1>Sozlamalar</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahifa</a></li>
          <li class="breadcrumb-item active">Sozlamalar</li>
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
        <form action="{{ route('setting.update', $Test->id ) }}" method="post" class="p-3">
            @csrf
            @method('put')
            <h5 class="w-100 text-center">Test nomini yangilash</h5>
            <label for="test_name" class="mt-2">Test nomi</label>
            <input type="text" name="test_name" value="{{ $Test->test_name }}" required class="form-control">
            <div class="w-100 text-center">
                <button class="btn btn-primary mt-3" type="submit">Testni yangilash</button>
            </div>
        </form>
      </div>
    </div>

  </main>

@endsection
