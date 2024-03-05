@extends('layouts.home')
@section('title',"Tashriflar")
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
      <h1>Yangi tashrif</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahifa</a></li>
          <li class="breadcrumb-item"><a href="{{ route('user.index') }}">Tashriflar</a></li>
          <li class="breadcrumb-item active">Yangi tashrif</li>
        </ol>
      </nav>
    </div>
    @if (Session::has('error'))
        <div class="alert alert-danger">{{ Session::get('error') }}</div>
    @endif

    @foreach($errors->all() as $messege)
        <div class="alert alert-danger">{{ $messege }}</div>
    @endforeach
    <div class="card">
      <div class="card-body pt-4">
        <form action="{{ route('user.update', $user->id ) }}" method="post">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-lg-6">
                    <label for="name" class="mt-2">FIO</label>
                    <input type="text" name="name" value="{{ $user->name }}" class="form-control" required>
                    <label for="address" class="mt-2">Manzil</label>
                    <input type="text" name="address" value="{{ $user->address }}" class="form-control" required>
                </div>
                <div class="col-lg-6">
                    <label for="phone" class="mt-2">Telefon raqam</label>
                    <input type="text" name="phone" value="{{ $user->phone }}" class="form-control phone" required>
                    <label for="tkun" class="mt-2">Tug'ilgan kun</label>
                    <input type="date" name="tkun" value="{{ $user->tkun }}" class="form-control" required>
                </div>
                <script>
                    function button(){
                        document.getElementById('buttons').style.display='none';
                    }
                </script>
                <div class="col-12 text-center">
                    <button class="btn btn-primary mt-3" type="submit" id="buttons" ondblclick="button()"> Tashrifni yangilash</button>
                </div>
            </div>
        </form>
      </div>
    </div>

  </main>

@endsection
