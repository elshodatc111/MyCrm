@extends('layouts.home')
@section('title',"Plastik to'lovlar")
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
      <h1>Moliya</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahifa</a></li>
          <li class="breadcrumb-item"><a href="{{ route('moliya.index') }}">Moliya</a></li>
          <li class="breadcrumb-item active">Plastik to'lovlar</li>
        </ol>
      </nav>
    </div>
    @if(session()->has('success'))
      <div class="alert alert-success">
        {{ session()->get('success') }}
      </div>
    @endif
    <div class="text-center">
      <div class="card info-card px-1 sales-card">
        <h5 class="card-title" style="font-weight:700;">Tasdiqlanmagan plastik to'lovlar</h5>
        <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Talaba</th>
                  <th>Tulov summasi</th>
                  <th>Tulov vaqti</th>
                  <th>Guruh</th>
                  <th>To'lov haqida</th>
                  <th>Operator</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                @forelse($Tulovlar as $item)
                <tr>
                  <td>{{ $loop->index+1 }}</td>
                  <td style="text-align:left"><a href="{{ route('user.show', $item['student_id'] ) }}">{{ $item['user_name'] }}</a></td>
                  <td>{{ $item['summa'] }}</td>
                  <td>{{ $item['created_at'] }}</td>
                  <td>{{ $item['guruh'] }}</td>
                  <td>{{ $item['izoh'] }}</td>
                  <td><a href="{{ route('hodim.show',$item['admin_id'] ) }}">{{ $item['admin_email'] }}</a></td>
                  <td>
                    @if(Auth::user()->type=='Admin' || Auth::user()->type()=='SuperAdmin')
                    <form action="{{ route('CheckEdit',$item['id'] ) }}" method="post" style="display:inline;">
                      @csrf
                      <input type="hidden" name="type" value="naqt">
                      <button class="submit btn btn-primary px-1 py-0" title="Tasdiqlash"><i class="bi bi-check2-all"></i></button>
                    </form>
                    @endif
                    <form action="{{ route('CheckDestroy',$item['id'] ) }}" method="post" style="display:inline;">
                      @csrf
                      <input type="hidden" name="type" value="naqt">
                      <button class="submit btn btn-danger px-1 py-0" title="To'lovni o'chirish"><i class="bi bi-trash"></i></button>
                    </form>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan=8 class="text-center">Tasdiqlanmagan to'lovlar mavjud emas</td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
      </div>
    </div>
    




        
        
        
    </div>

  </main>

@endsection
