@extends('layouts.home')
@section('title',"Hodimlar")
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
      <h1>Hodim</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahifa</a></li>
          <li class="breadcrumb-item"><a href="{{ route('hodim.index') }}">Hodimlar</a></li>
          <li class="breadcrumb-item active">Hodim</li>
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
        <div class="row">
            <div class="col-lg-4 pt-3">
                <table class="table" style="font-size:14px;">
                    <tr>
                        <th>Hodim FIO:</th>
                        <td style="text-align:right">{{ $Users->name }}</td>
                    </tr>
                    <tr>
                        <th>Yashash manzili:</th>
                        <td style="text-align:right">{{ $Users->address }}</td>
                    </tr>
                    <tr>
                        <th>Telefon raqami:</th>
                        <td style="text-align:right">{{ $Users->phone }}</td>
                    </tr>
                    <tr>
                        <th>Tug'ilgan kuni:</th>
                        <td style="text-align:right">{{ $Users->tkun }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-lg-4 pt-3">
                <table class="table" style="font-size:14px;">
                    <tr>
                        <th>Lavozimi:</th>
                        <td style="text-align:right">{{ $Users->type }}</td>
                    </tr>
                    <tr>
                        <th>Faoliyati:</th>
                        <td style="text-align:right">
                            @if($Users->status == 'true')
                                <span class="badge bg-success">Faol</span>
                            @else
                                <span class="badge bg-danger">Bloklangan</span>
                            @endif
                    </tr>
                    <tr>
                        <th>Login:</th>
                        <td style="text-align:right">{{ $Users->email }}</td>
                    </tr>
                    <tr>
                        <th>Ro'yhatga olindi:</th>
                        <td style="text-align:right">{{ $Users->created_at }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-lg-4">
                <h5 class="w-100 text-center card-title mb-1 pb-1">SMS xabar yuborish</h5>
                <form action="{{ route('sendmes') }}" method="post" id="form">
                    @csrf
                    <input type="hidden" name="phone" value="{{ $phone }}">
                    <textarea name="text" class="form-control" required></textarea>
                    <button class="btn btn-primary mt-2 w-100">SMS yuborish</button>
                </form>
            </div>
        </div>
      </div>
    </div>
    
    @if($Users->status == 'true')
    <div class="card">
        <div class="card-body">
            <h5 class="w-100 card-title text-center">Ish haqi to'lash</h5>
            <form action="" method="post" id="form">
                @csrf
                <div class="row">
                    <div class="col-lg-4">
                        <input type="text" class="form-control mb-2" placeholder="To'lov summasi" required>
                    </div>
                    <div class="col-lg-2">
                        <select name="" class="form-select mb-2" required>
                            <option value="">Tanlang</option>
                            <option value="Naqt">Naqt</option>
                            <option value="Plastik">Plastik</option>
                        </select>
                    </div>
                    <div class="col-lg-4">
                        <input type="text" class="form-control mb-2" placeholder="To'lov haqida" required>
                    </div>
                    <div class="col-lg-2">
                        <button class="btn btn-primary w-100">To'lov</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endif
    <div class="card">
        <div class="card-body">
            <h5 class="w-100 text-center card-title">Joriy oyda qabul qilgan to'lovlar va tashriflar</h5>
            <div class="table-responsive">
                <table class="table text-center table-bordered">
                    <tr>
                        <th>Jami to'lovlar</th>
                        <th>Naqt to'lovlar</th>
                        <th>Plastik to'lovlar</th>
                        <th>Chegirmalar</th>
                        <th>Yangi tashriflar</th>
                    </tr>
                    <tr>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>


    <div class="card">
        <div class="card-body">
            <h5 class="w-100 text-center card-title">O'tgan oyda qabul qilgan to'lovlar va tashriflar</h5>
            <div class="table-responsive">
                <table class="table text-center table-bordered">
                    <tr>
                        <th>Jami to'lovlar</th>
                        <th>Naqt to'lovlar</th>
                        <th>Plastik to'lovlar</th>
                        <th>Chegirmalar</th>
                        <th>Yangi tashriflar</th>
                    </tr>
                    <tr>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="w-100 text-center card-title">Jami to'langan ish haqi</h5>
            <div class="table-responsive">
                <table class="table text-center table-bordered">
                    <tr>
                        <th>#</th>
                        <th>To'lov summasi</th>
                        <th>To'lov turi</th>
                        <th>To'lov vaqti</th>
                        <th>To'lov haqida</th>
                        <th>Meneger</th>
                    </tr>
                    <tr>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>


  </main>

@endsection
