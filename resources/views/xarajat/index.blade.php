@extends('layouts.home')
@section('title',"Xarajatlar")
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
      <h1>Xarajatlar</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahifa</a></li>
          <li class="breadcrumb-item active">Xarajatlar</li>
        </ol>
      </nav>
    </div>
    
    @if(session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @elseif(session()->has('error'))
        <div class="alert alert-danger"> 
            {{ session()->get('error') }}
        </div>
    @endif
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-body pt-3 px-0">
                    <div class="align-items-center">
                        <div class="text-center">
                            <h4 class="text-danger mb-1">{{ $Kassa }} so'm</h4>
                            <span class="text-success small mt-0 fw-bold"style="text-align:left;">
                                Kassada mavjud
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-6">
            <div class="card">
                <div class="card-body pt-3 px-0">
                    <div class="align-items-center">
                        <div class="text-center">
                            <h4 class="text-danger mb-1">{{ $Tasdiqlanmagan }} so'm</h4>
                            <span class="text-success small mt-0 fw-bold"style="text-align:left;">
                                Tasdiqlanmagan xarajatlar
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body px-0">
                    <div class="align-items-center">
                        <div class="text-center">
                            <h5 class="card-title">Xarajatlar uchun chiqim qilish</h5>
                            <form action="{{ route('store') }}" id="form1" class="row" method="post">
                                @csrf
                                <div class="col-lg-5">
                                    <input type="text" id="summa1" name='summa' class="form-control mt-2" placeholder="Xarajat summasi" style="border-radius:0;" required>
                                </div>
                                <div class="col-lg-5">
                                    <input type="text" class="form-control mt-2" name='comment' placeholder="Xarajat haqida" style="border-radius:0;" required>
                                </div>
                                <div class="col-lg-2">
                                    <button class="btn btn-primary w-100 mt-2" style="border-radius:0;">Xarajat</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="align-items-center">
                        <div class="text-center">
                            <h5 class="card-title">Tasdiqlanmagan chiqimlar</h5>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Xarajat summasi</th>
                                        <th>Xarajat haqida</th>
                                        <th>Xarajat vaqti</th>
                                        <th>Operator</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($Xaralatlar as $item)
                                    <tr>
                                        <td>{{ $loop->index+1 }}</td>
                                        <td>{{ $item['summa'] }}</td>
                                        <td>{{ $item['comment'] }}</td>
                                        <td>{{ $item['operator'] }}</td>
                                        <td>{{ $item['created_at'] }}</td>
                                        <td>
                                            @if(Auth::user()->type!='Operator')
                                            <form action="" method="post" style="display:inline;">
                                                <button class="btn btn-success px-1 py-0" title="Tasdiqlash"><i class="bi bi-check"></i></button>
                                            </form>
                                            @endif
                                            <form action="{{ route('delete',$item['id']) }}" method="post" style="display:inline;">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-danger px-1 py-0" title="O'chirish"><i class="bi bi-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                        <tr>
                                            <td colspan=6 class='text-center'>Tasdiqlanmagan xarajatlar mavjud emas.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
        
    </div>
    

  </main>

@endsection
