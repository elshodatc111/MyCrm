@extends('layouts.home')
@section('title',"Filiallar")
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
      <h1>Filiallar</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahifa</a></li>
          <li class="breadcrumb-item active">Filiallar</li>
        </ol>
      </nav>
    </div>


    <div class="card">
      <div class="card-body">
        <div class="row">
            <div class="col-9">
            <h5 class="card-title">Filiallar </h5>
            </div>
            <div class="col-3 pt-3" style="text-align:right">
                <a href="{{ route('filial.create') }}" class="btn btn-primary"><i class="bi bi-building-add"></i> Yangi filial</a>
            </div>
        </div>
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
                    <th>Filial manzil</th>
                    <th>Filial ochildi</th>
                    <th>Admin</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
              @foreach($Filial as $item)
                <tr>
                    <td>{{ $loop->index+1 }}</td>
                    <td>{{ $item->filial_name }}</td>
                    <td>{{ $item->filial_addres }}</td>
                    <td>{{ $item->created_at }}</td>
                    <td>
                      @foreach($Users as $user)
                      @if($item->user_id = $user->id)
                        {{ $user->email }}
                      @endif
                      @endforeach
                    </td>
                    <td>
                      <a href="{{route('filial.edit', $item->id )}}" class="btn btn-primary py-0 px-1"><i class="bi bi-pencil"></i></a>
                      <form action="{{ route('filial.destroy', $item->id ) }}" method="post" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger p-0 px-1" type="submit"><i class="bi bi-trash"></i></button>
                      </form>
                    </td>
                </tr>
              @endforeach
            </tbody>
        </table>
        <div class="alert alert-danger">O'chirilgan filial barcha ma`lumotlari o'chib ketadi. Qayta tiklash imkoniyati mavjud emas.</div>
      </div>
    </div>

  </main>

@endsection
