@extends('layouts.home')
@section('title',"Tashrif")
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
      <h1>Tashrif</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahifa</a></li>
          <li class="breadcrumb-item"><a href="{{ route('user.index') }}">Tashriflar</a></li>
          <li class="breadcrumb-item active">Tashrif</li>
        </ol>
      </nav>
    </div>
    @if(session()->has('success'))
      <div class="alert alert-success">
        {{ session()->get('success') }}
      </div>
    @endif
    
    @if(session()->has('error'))
      <div class="alert alert-success">
        {{ session()->get('error') }}
      </div>
    @endif
    
    <div class="card">
      <div class="card-body pt-4">
        <div class="row text-center">
            <div class="col-lg-8">
                <h4>{{ $Guruh_plus['user']->name }}</h4>
                <div class="row">
                    <div class="col-lg-6">
                        <table class="table table-bordered" style="font-size:12px;">
                            <tr>
                                <th style="text-align:left">Yashash manzili:</th>
                                <td style="text-align:right">{{ $Guruh_plus['user']->address }}</td>
                            </tr>
                            <tr>
                                <th style="text-align:left">Telefon raqami:</th>
                                <td style="text-align:right">{{ $Guruh_plus['user']->phone }}</td>
                            </tr>
                            <tr>
                                <th style="text-align:left">Tug'ilgan kuni:</th>
                                <td style="text-align:right">{{ $Guruh_plus['user']->tkun }}</td>
                            </tr>
                            <tr>
                                <th style="text-align:left">Login:</th>
                                <td style="text-align:right">{{ $Guruh_plus['user']->email }}</td>
                            </tr>
                            <tr>
                                <th style="text-align:left">Meneger:</th>
                                <td style="text-align:right">{{ $Guruh_plus['create_admin'] }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-lg-6">
                        <table class="table table-bordered" style="font-size:12px;">
                            <tr>
                                <th style="text-align:left">Yaqin tanishi:</th>
                                <td style="text-align:right">{{ $Guruh_plus['user']->Tanish }}</td>
                            </tr>
                            <tr>
                                <th style="text-align:left">Tanishi telefoni:</th>
                                <td style="text-align:right">{{ $Guruh_plus['user']->TanishPhone }}</td>
                            </tr>
                            <tr>
                                <th style="text-align:left">Biz haqimizda:</th>
                                <td style="text-align:right">{{ $Guruh_plus['user']->BizHaqimizda }}</td>
                            </tr>
                            <tr>
                                <th style="text-align:left">Talaba haqida:</th>
                                <td style="text-align:right">{{ $Guruh_plus['user']->TalabaHaqida }}</td>
                            </tr>
                            <tr>
                                <th style="text-align:left">Tashrif vaqti:</th>
                                <td style="text-align:right">{{ $Guruh_plus['user']->created_at }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div> 
            <div class="col-lg-4">
                <h4><b>Balans:</b>
                    @if($Ballanss['JamiBalans']>=0)
                        <p class='text-success' style="display:inline;">{{ $Ballanss['JamiBalans'] }} so'm</p>
                    @else
                        <p class='text-danger' style="display:inline;">{{ $Ballanss['JamiBalans'] }} so'm</p>
                    @endif
                </h4>
                <table class="table table-bordered" style="font-size:12px;">
                    <tr>
                        <th style="text-align:left">To'lovlar:</th>
                        <td style="text-align:right">{{ $Ballanss['Tulov_tasdiqlandi'] }}</td>
                    </tr>
                    <tr>
                        <th style="text-align:left">Tasdiqlanmagan to'lovlar:</th>
                        <td style="text-align:right">{{ $Ballanss['Tulov_tasdiqlanmadi'] }}</td>
                    </tr>
                    <tr>
                        <th style="text-align:left">Chegirmalar:</th>
                        <td style="text-align:right">{{ $Ballanss['JamiChegirma'] }}</td>
                    </tr>
                    <tr>
                        <th style="text-align:left">Aktiv guruhlar:</th>
                        <td style="text-align:right">{{ $ACTIVNEVguruh }}</td>
                    </tr>
                    <tr>
                        <th style="text-align:left">Guruhdan o'chirildi:</th>
                        <td style="text-align:right">{{ $END_guruh }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-12 row text-center">
                <div class="col-lg-3 pb-2">
                    <button class="btn btn-info text-white w-100" data-bs-toggle="modal" data-bs-target="#guruh_plus">Guruhga qo'shish</button>
                    <div class="modal fade" id="guruh_plus" tabindex="-1">
                        <form action="{{ route('guruh_setting.store') }}" method="post">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $Guruh_plus['user']->id }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Talabani guruhga qo'shish</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <label for="guruh_id" class="mt-2">Guruhni tanlang *</label>
                                        <select name="guruh_id" class="form-control" required>
                                            <option value="">Tanlang...</option>
                                            @foreach($Guruh_plus['guruh_plus'] as $item)
                                                @if(empty($item))

                                                @else
                                                    <option value="{{ $item['guruh_id'] }}">{{ $item['guruh_name'] }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <label for="start_commit" class="mt-2">Guruhga qo'shish uchun izoh *</label>
                                        <textarea name="start_commit" class="form-control" required></textarea>
                                        <div class="div pt-3">
                                            <button type="button" class="btn btn-secondary" style="width:48%;" data-bs-dismiss="modal">Bekor qilish</button>
                                            <button type="submit" class="btn btn-primary" id="guruh_plus" onclick="document.getElementById('guruh_plus').sytle.display='none'" style="width:48%;">Guruhga qo'shish</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-3 pb-2">
                    <button class="btn btn-info text-white w-100" data-bs-toggle="modal" data-bs-target="#send_messege">SMS yuborish</button>                    
                    <div class="modal fade" id="send_messege" tabindex="-1">
                        <form action="{{ route('userSendMessge') }}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{ $Guruh_plus['user']->id }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Talabaga sms yuborish</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <label for="text">SMS matni</label>
                                        <textarea name="text" class="form-control mb-3"></textarea>
                                        <div class="div">
                                            <button type="button" class="btn btn-secondary" style="width:48%;" data-bs-dismiss="modal">Bekor qilish</button>
                                            <button type="submit" class="btn btn-primary" style="width:48%;">SMS yuborish</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @if(Auth::user()->type!='Operator')
                <div class="col-lg-3 pb-2">
                    <button class="btn btn-info text-white w-100" data-bs-toggle="modal" data-bs-target="#admin_chegirma">Chegirma kiritish</button>                    
                    <div class="modal fade" id="admin_chegirma" tabindex="-1">
                        <form action="{{ route('userAdminChegirma') }}" id="form1" method="post">
                            @csrf
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Talabaga chegirma kiritish</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="user_id" value="{{ $Guruh_plus['user']->id }}">
                                        <label for="chegirma_summasi">Chegirma uchun guruhni tanlang</label>
                                        <select name="guruh_id" id="" class="form-select mb-1">
                                            <option value="">Tanlang</option>
                                            @forelse($Admin_chegirma_guruh as $item)
                                                <option value="{{ $item->id }}">{{ $item->guruh_name }}</option>
                                            @empty
    
                                            @endforelse
                                        </select>
                                        <label for="summa">Chegirma summasi</label>
                                        <input type='text' id="summa1" name="summa" class="form-control mb-1"></textarea>
                                        <label for="text">Chegirma haqida izoh</label>
                                        <textarea name="text" required class="form-control mb-1"></textarea>
                                        <div class="div">
                                            <button type="button" class="btn btn-secondary" style="width:48%;" data-bs-dismiss="modal">Bekor qilish</button>
                                            <button type="submit" class="btn btn-primary" style="width:48%;">Chegirmani saqlash</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @endif
                <div class="col-lg-3 pb-2">
                    <form action="{{ route('userPasswordUpdate') }}" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{ $Guruh_plus['user']->id }}">
                        <button class="btn btn-info text-white w-100">Parolini yangish</button>                    
                    </form>
                </div>
                
            </div>
        </div>
      </div>
    </div>
    <div class="row">
        <div class="col-lg-8">
            <div class="card" style="min-height:260px;">
                <div class="card-body pt-4">
                    <h5>To'lov qilish</h5>
                    <form action="{{ route('tulov.store') }}" method="post" id="form" class="row">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $Guruh_plus['user']->id }}">
                        <div class="col-lg-6">
                            <label for="naqtSumma" class="mt-1">Naqt to'lov summasi</label>
                            <input type="text" name="naqtSumma" id="summa" value="0" class="form-control">
                            <label for="guruh_id" class="mt-1">Chegirma uchun guruh</label>
                            <select name="guruh_id" class="form-select">
                                <option value="NULL">Tanlang...</option>
                                @forelse($chegirmaGuruh as $item)
                                    <option value="{{ $item['guruh_id'] }}">{{ $item['name'] }}</option>
                                @empty

                                @endforelse
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <label for="plastikSumma" class="mt-1">Plastik to'lov summasi</label>
                            <input type="text" name="plastikSumma" id="summa2" value="0" class="form-control">
                            <label for="commit" class="mt-1">To'lov haqida izoh</label>
                            <input type="text" name="commit" value="Izoh" class="form-control" required>
                        </div>
                        <div class="col-12 text-center mt-3">
                            <button class="btn btn-primary w-50" id="paybutton" onclick="document.getElementById('paybutton').style.display='none'">To'lovni saqlash</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card" style="min-height:260px;">
                <div class="card-body pt-4">
                    <form action="{{ route('EslatmaUser') }}" method="post">
                        @csrf
                        <h5>Eslatma qoldirish</h5>
                        <input type="hidden" name="user_guruh_id" value="{{ $Guruh_plus['user']->id }}">
                        <label for="text">Eslatma matni</label>
                        <textarea name="text" class="form-control" required></textarea>
                        <button type="submit" class="w-100 btn btn-primary mt-3">Eslatma qoldirish</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
        
    <div class="card">
        <div class="card-body pt-3">
            <ul class="nav nav-tabs d-flex" id="myTabjustified" role="tablist">
                <li class="nav-item flex-fill" role="presentation">
                    <button class="nav-link w-100 active" id="home-tab" data-bs-toggle="tab" 
                    data-bs-target="#talaba_tarixi" type="button" role="tab" aria-controls="home" 
                    aria-selected="true">Talaba tarixi</button>
                </li>
                <li class="nav-item flex-fill" role="presentation">
                    <button class="nav-link w-100" id="profile-tab" data-bs-toggle="tab" 
                    data-bs-target="#talaba_tulovlari" type="button" role="tab" aria-controls="profile" 
                    aria-selected="false">Talaba to'lovlari</button>
                </li>
                <li class="nav-item flex-fill" role="presentation">
                    <button class="nav-link w-100" id="contact-tab" data-bs-toggle="tab" data-bs-target="#activ_guruhlar" type="button" role="tab" aria-controls="contact" aria-selected="false">Aktiv guruhlari</button>
                </li>
                <li class="nav-item flex-fill" role="presentation">
                    <button class="nav-link w-100" id="contact-tab" data-bs-toggle="tab" data-bs-target="#delete_guruhlar" type="button" role="tab" aria-controls="contact" aria-selected="false">O'chirilgan guruhlari</button>
                </li>
                <li class="nav-item flex-fill" role="presentation">
                    <button class="nav-link w-100" id="contact-tab" data-bs-toggle="tab" data-bs-target="#eslatmalar" type="button" role="tab" aria-controls="contact" aria-selected="false">Eslatmalar</button>
                </li>
            </ul>
            <div class="tab-content pt-2" id="myTabjustifiedContent">
                <div class="tab-pane fade show active" id="talaba_tarixi" role="tabpanel" aria-labelledby="home-tab">
                    <div class="table-responsive">
                        <table class="table table-bordered text-center" style="font-size:12px;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Operator</th>
                                    <th>Vaqt</th>
                                    <th>Status</th>
                                    <th>Summa</th>
                                    <th>Xisoblash</th>
                                    <th>Balans</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($History as $item)
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td style="text-align:left">{{ $item['admin'] }}</td>
                                    <td style="text-align:left">{{ $item['data'] }}</td>
                                    <td style="text-align:left">{{ $item['status'] }}</td>
                                    <td>{{ $item['summa'] }}</td>
                                    <td style="text-align:left">( {{ $item['xisob1'] }} ) = {{ $item['xisob2'] }}</td>
                                    <td style="text-align:right;">{{ $item['xisob2'] }}</td>
                                </tr>
                                @empty

                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="talaba_tulovlari" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="table-responsive">
                        <table class="table table-bordered text-center" style="font-size:14px;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Guruh</th>
                                    <th>To'lov Summasi</th>
                                    <th>To'lov turi</th>
                                    <th>To'lov vaqti</th>
                                    <th>To'lov xolati</th>
                                    <th>To'lov haqida</th>
                                    <th>Operator</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($TalabaTulov as $item)
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td style="text-align:left;">{{ $item['guruh'] }}</td>
                                    <td>{{ $item['tulov_summa'] }}</td>
                                    <td>{{ $item['tulov_type'] }}</td>
                                    <td>{{ $item['created_at'] }}</td>
                                    <td>{{ $item['tulov_xolati'] }}</td>
                                    <td>{{ $item['comment'] }}</td>
                                    <td>{{ $item['email'] }}</td>
                                    <td>
                                        @if($item['tulov_type']=='Chegirma')
                                            @if(Auth::user()->type=='Admin' || Auth::user()->type=='SuperAdmin')
                                                <form action="{{ route('chegirmadestroy') }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="tulov_id" value="{{ $item['id'] }}">
                                                    <button class="btn btn-danger px-1 py-0"><i class="bi bi-trash"></i></button>
                                                </form>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan=9 class="text-center">To'lovlar mavjud emas.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="activ_guruhlar" role="tabpanel" aria-labelledby="contact-tab">
                    <div class="table-responsive">
                        <table class="table bordered text-center" style="font-size:14px;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Guruh</th>
                                    <th>Guruhga qoshildi</th>
                                    <th>Izoh</th>
                                    <th>Operator</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($Activ_guruh as $item)
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td style='text-align:left'>
                                        <a href="{{ route('guruh.show', $item['guruh_id'] ) }}">
                                            {{ $item['guruh_name'] }}</a></td>
                                    <td>{{ $item['start_data'] }}</td>
                                    <td style='text-align:left'>{{ $item['start_commit'] }}</td>
                                    <td>{{ $item['start_meneger'] }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan=5 class='text-center'>Talaba guruhlari mavjud emas.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="delete_guruhlar" role="tabpanel" aria-labelledby="contact-tab">
                    <div class="table-responsive">
                        <table class="table bordered text-center" style="font-size:14px;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Guruh</th>
                                    <th>Guruhga qoshildi</th>
                                    <th>Izoh</th>
                                    <th>Operator</th>
                                    <th>Guruhdan o'chirildi</th>
                                    <th>Guruhdan o'chirish haqida</th>
                                    <th>Operator</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($End_guruh as $item)
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td style='text-align:left'>
                                        <a href="{{ route('guruh.show', $item['guruh_id'] ) }}">
                                            {{ $item['guruh_name'] }}</a></td>
                                    <td>{{ $item['start_data'] }}</td>
                                    <td style='text-align:left'>{{ $item['start_commit'] }}</td>
                                    <td>{{ $item['start_meneger'] }}</td>
                                    <td>{{ $item['end_data'] }}</td>
                                    <td>{{ $item['end_commit'] }}</td>
                                    <td>{{ $item['end_meneger'] }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan=8 class='text-center'>Talaba guruhlardan o'chirilmagan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="eslatmalar" role="tabpanel" aria-labelledby="contact-tab">
                    <div class="table-responsive">
                        <table class="table bordered text-center" style="font-size:14px;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Operator</th>
                                    <th>Eslatma matni</th>
                                    <th>Eslatma vaqti</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($Eslatma as $item)
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td style="text-align:left">{{ $item->email }}</td>
                                    <td style="text-align:left">{{ $item->text }}</td>
                                    <td>{{ $item->created_at }}</td>
                                    <td>{{ $item->status }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan=5 class='text-center'>Eslatmalar mavjud emas.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


  </main>

@endsection
