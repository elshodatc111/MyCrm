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
      <div class="card-body pt-4">
        <div class="row">
            <div class="col-lg-6">
                <table class="table">
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
            <div class="col-lg-6">
                <table class="table">
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
        </div>
      </div>
    </div>
    <div class="card">
        <div class="card-body pt-4">
            <h5 class="w-100 text-center">SMS habar yuborish</h5>
            <form action="{{ route('sendmes') }}" method="post" id="form">
                @csrf
                <input type="hidden" name="phone" value="{{ $phone }}">
                <textarea name="text" class="form-control" required></textarea>
                <button class="btn btn-primary mt-3">Send Messege</button>
            </form>
        </div>
    </div>
    @if($Users->status == 'true')
    <div class="card">
        <div class="card-body pt-4">
            <h5 class="w-100 text-center">Ish haqi to'lash</h5>
            <form action="" method="post" id="form">
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <label for="" class="mt-2">To'lov summasi</label>
                        <input type="text" id="summa" class="form-control" required>
                        <label for="" class="mt-2">To'lov turi</label>
                        <select name="" id="" class="form-select" required>
                            <option value="Naqt">Naqt</option>
                            <option value="Plastik">Plastik</option>
                        </select>
                    </div>
                    <div class="col-lg-6">
                        <label for="" class="mt-2">To'lov haqida izoh</label>
                        <input type="text" class="form-control" required>
                        <label for="" class="mt-2">.</label>
                        <button type="submit" class="btn btn-success w-100">Ish haqi to'lov qilish</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endif
    <div class="card">
        <div class="card-body pt-4">
            <h5 class="w-100 text-center">Joriy oyda qabul qilgan to'lovlar va tashriflar</h5>
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
        <div class="card-body pt-4">
            <h5 class="w-100 text-center">O'tgan oyda qabul qilgan to'lovlar va tashriflar</h5>
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
        <div class="card-body pt-4">
            <h5 class="w-100 text-center">Jami to'langan ish haqi</h5>
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
