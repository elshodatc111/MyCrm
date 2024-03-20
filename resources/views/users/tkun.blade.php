@extends('layouts.home')
@section('title',"Tashriflar")
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
      <h1>Tug'ilgan kun</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahifa</a></li>
          <li class="breadcrumb-item active">Tug'ilgan kun</li>
        </ol>
      </nav>
    </div>
    @if(session()->has('success'))
      <div class="alert alert-success">
        {{ session()->get('success') }}
      </div>
    @endif
    <div class="card">
      <div class="card-body pt-4">
        <h5 class="text-center">Tug'ilgan kunlar</h5>
        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">Talaba</th>
                    <th class="text-center">Telefon raqam</th>
                    <th class="text-center">Yashash manzili</th>
                    <th class="text-center">Tug'ilgan kuni</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $item)
                <tr>
                    <td>{{ $loop->index+1 }}</td>
                    <td style="text-align:left;"><a href="{{ route('user.show', $item->id ) }}">{{ $item->name }}</a></td>
                    <td>{{ $item->phone }}</td>
                    <td>{{ $item->address }}</td>
                    <td>{{ $item->tkun }}</td>
                </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan=5>Talabalar orasida tug'ilgan kunlar mavjud emas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
      </div>
    </div>

  </main>

@endsection
