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
    @if(session()->has('error'))
      <div class="alert alert-danger">
        {{ session()->get('error') }}
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
    
    ### O'tgan Oyda qabul qilgan to'lovlari ####<br>

    @if($Users->status == 'true')
    <div class="card">
        <div class="card-body">
            
            <div class="row pt-3">
                <div class="col-lg-4"><h5 class="w-100 p-0 card-title text-center">Ish haqi to'lash</h5></div>
                <div class="col-lg-4"><h5 class="w-100 p-0 card-title text-center">Kassada mavjud(Naqt: <p class="text-success p-0 m-0" style="display:inline">{{ $Kassa['Naqt'] }})<p></h5></div>
                <div class="col-lg-4"><h5 class="w-100 p-0 card-title text-center">Kassada mavjud(Plastik: <p class="text-success p-0 m-0" style="display:inline">{{ $Kassa['Plastik'] }})<p></h5></div>
            </div>
            <hr class="m-0 p-0 mb-2">
            <form action="{{ route('HodimPayIshHaqi') }}" id="form1" method="post" id="form">
                @csrf
                <input type="hidden" name="id" value="{{ $Users->id }}">
                <div class="row">
                    <input type="hidden" name="Naqt" value="{{ $Kassa['Naqt'] }}">
                    <input type="hidden" name="Plastik" value="{{ $Kassa['Plastik'] }}">
                    <div class="col-lg-4">
                        <input type="text" id="summa1" name="summa" class="form-control mb-2" placeholder="To'lov summasi" required>
                    </div>
                    <div class="col-lg-2">
                        <select name="type" class="form-select mb-2" required>
                            <option value="">Tanlang</option>
                            <option value="Naqt">Naqt</option>
                            <option value="Plastik">Plastik</option>
                        </select>
                    </div>
                    <div class="col-lg-4">
                        <input type="text" name="commit" class="form-control mb-2" placeholder="To'lov haqida" required>
                    </div>
                    <div class="col-lg-2">
                        <button type="submit" class="btn btn-primary w-100">To'lov</button>
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
                        <th>Qaytarilgan to'lov</th>
                    </tr>
                    <tr>
                        <td>{{ $JoriyOy['JamiTolov'] }}</td>
                        <td>{{ $JoriyOy['TulovNaqt'] }}</td>
                        <td>{{ $JoriyOy['TulovPlastik'] }}</td>
                        <td>{{ $JoriyOy['TulovChegirma'] }}</td>
                        <td>{{ $JoriyOy['Tashrif'] }}</td>
                        <td>{{ $JoriyOy['TulovQaytarildi'] }}</td>
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
                        <th>Qaytarilgan to'lov</th>
                    </tr>
                    <tr>
                        <td>{{ $OtganOy['JamiTolov'] }}</td>
                        <td>{{ $OtganOy['TulovNaqt'] }}</td>
                        <td>{{ $OtganOy['TulovPlastik'] }}</td>
                        <td>{{ $OtganOy['TulovChegirma'] }}</td>
                        <td>{{ $OtganOy['Tashrif'] }}</td>
                        <td>{{ $OtganOy['TulovQaytarildi'] }}</td>
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
                    @forelse($HodimTulov as $item)
                    <tr>
                        <td>{{ $loop->index+1 }}</td>
                        <td>{{ $item['summa'] }}</td>
                        <td>{{ $item['type'] }}</td>
                        <td>{{ $item['created_at'] }}</td>
                        <td style="text-align:left">{{ $item['commit'] }}</td>
                        <td>{{ $item['admin_id'] }}</td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan=6 class='text-center'>Ish haqi to'lovlari mavjud emas.</td>
                        </tr>
                    @endforelse
                </table>
            </div>
        </div>
    </div>

    <div class="w-100 text-center">
        <a href="{{ route('history', $Users->id ) }}" class="btn btn-primary">Hodim qilgan ishlari</a>
    </div>


  </main>

@endsection
