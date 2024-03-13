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
                        <table class="table table-bordered">
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
                        <table class="table table-bordered">
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
                <h4><b>Balans:</b> 144 000 so'm</h4>
                <table class="table table-bordered">
                    <tr>
                        <th style="text-align:left">To'lovlar:</th>
                        <td style="text-align:right">sd</td>
                    </tr>
                    <tr>
                        <th style="text-align:left">Chegirmalar:</th>
                        <td style="text-align:right">sd</td>
                    </tr>
                    <tr>
                        <th style="text-align:left">Qaytarildi:</th>
                        <td style="text-align:right">sd</td>
                    </tr>
                    <tr>
                        <th style="text-align:left">Aktiv guruhlar:</th>
                        <td style="text-align:right">sd</td>
                    </tr>
                    <tr>
                        <th style="text-align:left">Guruhdan o'chirildi:</th>
                        <td style="text-align:right">sd</td>
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
                                            <button type="submit" class="btn btn-primary" style="width:48%;">Guruhga qo'shish</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-3 pb-2">
                    <button class="btn btn-info text-white w-100" data-bs-toggle="modal" data-bs-target="#send_messege">SMS yuborish</button>                    
                </div>
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
                @if(Auth::user()->type!='Operator')
                <div class="col-lg-3 pb-2">
                    <button class="btn btn-info text-white w-100">Chegirma kiritish</button>                    
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
                            <input type="text" name="commit" class="form-control" required>
                        </div>
                        <div class="col-12 text-center mt-3">
                            <button class="btn btn-primary w-50">To'lovni saqlash</button>
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
                    talaba_tarixi Sunt est soluta temporibus accusantium neque nam maiores cumque temporibus. Tempora libero non est unde veniam est qui dolor. Ut sunt iure rerum quae quisquam autem eveniet perspiciatis odit. Fuga sequi sed ea saepe at unde.
                </div>
                <div class="tab-pane fade" id="talaba_tulovlari" role="tabpanel" aria-labelledby="profile-tab">
                    talaba_tulovlariNesciunt totam et. Consequuntur magnam aliquid eos nulla dolor iure eos quia. Accusantium distinctio omnis et atque fugiat. Itaque doloremque aliquid sint quasi quia distinctio similique. Voluptate nihil recusandae mollitia dolores. Ut laboriosam voluptatum dicta.
                </div>
                <div class="tab-pane fade" id="activ_guruhlar" role="tabpanel" aria-labelledby="contact-tab">
                    <table class="table bordered text-center">
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
                <div class="tab-pane fade" id="delete_guruhlar" role="tabpanel" aria-labelledby="contact-tab">
                    <table class="table bordered text-center">
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
                <div class="tab-pane fade" id="eslatmalar" role="tabpanel" aria-labelledby="contact-tab">
                    <table class="table bordered text-center">
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


  </main>

@endsection
