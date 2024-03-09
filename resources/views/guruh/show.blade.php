@extends('layouts.home')
@section('title',"Guruh")
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
      <h1>Guruh</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahifa</a></li>
          <li class="breadcrumb-item"><a href="{{ route('guruh.index') }}">Guruhlar</a></li>
          <li class="breadcrumb-item active">Yangi guruh</li>
        </ol>
      </nav>
    </div>
    @if(session()->has('error'))
      <div class="alert alert-danger">
        {{ session()->get('error') }}
      </div>
    @endif
                
                
        <div class="card">
            <div class="card-body pt-4 text-center">
                <h5 class="w-100 text-center">{{ $Guruh['guruh_about']['guruh_name'] }}</h5>
                <hr>
                <div class="row">
                    <div class="col-lg-4">
                        <table class="table">
                            <tr>
                                <th style="text-align:left">Guruh summasi:</th>
                                <td style="text-align:right">{{ $Guruh['guruh_about']['guruh_price'] }}</td>
                            </tr>
                            <tr>
                                <th style="text-align:left">O'qituvchi:</th>
                                <td style="text-align:right">{{ $Guruh['guruh_about']['guruh_name'] }}</td>
                            </tr>
                            <tr>
                                <th style="text-align:left">O'qituvchiga to'lov:</th>
                                <td style="text-align:right">{{ $Guruh['guruh_about']['techer_tulov'] }}</td>
                            </tr>
                            <tr>
                                <th style="text-align:left">O'qituvchiga bonus:</th>
                                <td style="text-align:right">{{ $Guruh['guruh_about']['techer_bonus'] }}</td>
                            </tr>
                            <tr>
                                <th style="text-align:left">Meneger:</th>
                                <td style="text-align:right">{{ $Guruh['guruh_about']['guruh_admin'] }}</td>
                            </tr>
                            <tr>
                                <th style="text-align:left">Guruh holati:</th>
                                <td style="text-align:right">{{ $Guruh['guruh_about']['guruh_xolati'] }}</td>
                            </tr>
                            <tr>
                                <th style="text-align:left">Guruh ochildi:</th>
                                <td style="text-align:right">{{ $Guruh['guruh_about']['created_at'] }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-lg-4">
                        <table class="table">
                            <tr>
                                <th style="text-align:left">Darslar xonasi:</th>
                                <td style="text-align:right">{{ $Guruh['guruh_about']['room_name'] }}</td>
                            </tr>
                            <tr>
                                <th style="text-align:left">Boshlanish vaqti:</th>
                                <td style="text-align:right">{{ $Guruh['guruh_about']['guruh_start'] }}</td>
                            </tr>
                            <tr>
                                <th style="text-align:left">Tugash vaqti:</th>
                                <td style="text-align:right">{{ $Guruh['guruh_about']['guruh_end'] }}</td>
                            </tr>
                            <tr>
                                <th style="text-align:left">Dars vaqti:</th>
                                <td style="text-align:right">{{ $Guruh['guruh_about']['guruh_dars_vaqt'] }}</td>
                            </tr>
                            <tr>
                                <th style="text-align:left">Aktiv talabalar:</th>
                                <td style="text-align:right">{{ $Guruh['guruh_about']['activ_student'] }}</td>
                            </tr>
                            <tr>
                                <th style="text-align:left">Guruhdan o'chirilgan:</th>
                                <td style="text-align:right">{{ $Guruh['guruh_about']['end_student'] }}</td>
                            </tr>
                            <tr>
                                <th style="text-align:left">Guruh yangilandi:</th>
                                <td style="text-align:right">{{ $Guruh['guruh_about']['updated_at'] }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-lg-4">
                        <table class="table">
                            <tr>
                                <th style="text-align:left">1-dars.{{ $Guruh['guruh_about']['guruh_dars_kun'][0] }}</th>
                                <th style="text-align:right">2-dars.{{ $Guruh['guruh_about']['guruh_dars_kun'][1] }}</th>
                            </tr>
                            <tr>
                                <th style="text-align:left">3-dars.{{ $Guruh['guruh_about']['guruh_dars_kun'][2] }}</th>
                                <th style="text-align:right">4-dars.{{ $Guruh['guruh_about']['guruh_dars_kun'][3] }}</th>
                            </tr>
                            <tr>
                                <th style="text-align:left">5-dars.{{ $Guruh['guruh_about']['guruh_dars_kun'][4] }}</th>
                                <th style="text-align:right">6-dars.{{ $Guruh['guruh_about']['guruh_dars_kun'][5] }}</th>
                            </tr>
                            <tr>
                                <th style="text-align:left">7-dars.{{ $Guruh['guruh_about']['guruh_dars_kun'][6] }}</th>
                                <th style="text-align:right">8-dars.{{ $Guruh['guruh_about']['guruh_dars_kun'][7] }}</th>
                            </tr>
                            <tr>
                                <th style="text-align:left">9-dars.{{ $Guruh['guruh_about']['guruh_dars_kun'][8] }}</th>
                                <th style="text-align:right">10-dars.{{ $Guruh['guruh_about']['guruh_dars_kun'][9] }}</th>
                            </tr>
                            <tr>
                                <th style="text-align:left">11-dars.{{ $Guruh['guruh_about']['guruh_dars_kun'][10] }}</th>
                                <th style="text-align:right">12-dars.{{ $Guruh['guruh_about']['guruh_dars_kun'][11] }}</th>
                            </tr>
                            <tr>
                                <th style="text-align:left">13-dars.{{ $Guruh['guruh_about']['guruh_dars_kun'][12] }}</th>
                                <th style="text-align:right"></th>
                            </tr>
                        </table>
                    </div>
                    <div class="col-12">
                        <table class="table">
                            <tr>
                                <th style="width:33.33333%;"><button class="btn btn-primary text-white w-100" data-bs-toggle="modal" data-bs-target="#sendmessege">SMS yuborish</button></th>
                                <th style="width:33.33333%;"><button class="btn btn-primary text-white w-100">Qarzdorlarga SMS yuborish</button></th>
                                <th style="width:33.33333%;"><button class="btn btn-danger text-white w-100" data-bs-toggle="modal" data-bs-target="#guruh_next">Guruhni davom ettirish</button></th>
                            </tr>
                        </table>
                        <div class="modal fade" id="sendmessege" tabindex="-1">
                            <form action="" method="post">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">SMS yuborish</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <table class="table text-center">
                                                <thead>
                                                    <tr>
                                                        <th>Tanlang</th>
                                                        <th>Talaba</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" name="">
                                                        </td>
                                                        <td style="text-align:left">Elshod Musurmonov</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" name="">
                                                        </td>
                                                        <td style="text-align:left">Elshod Musurmonov</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" name="">
                                                        </td>
                                                        <td style="text-align:left">Elshod Musurmonov</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan='2'>
                                                            <textarea name="" class="form-control" required placeholder="SMS matni..."></textarea>
                                                        </td>
                                                    </tr>
                                                    <table class="table">
                                                        <tr>
                                                            <td>
                                                                <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">Bekor qilish</button>
                                                            </td>
                                                            <td style="text-align:right">
                                                                <button type="submit" class="btn btn-primary w-100">SMS Yuborish</button>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        
                        <div class="modal fade" id="guruh_next" tabindex="-1">
                            <form action="" method="post" id="form">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Guruhni davom ettirish</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body row">
                                            <div class="col-lg-8">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label for="guruh_name">Yangi guruh nomi</label>
                                                        <input type="text" name="guruh_name" class="form-control" required>
                                                    </div>
                                                    <div class="col-6">
                                                        <label for="test_id" class="mt-2">Guruh uchun test</label>
                                                        <select name="test_id" class="form-select">
                                                            <option value="">Tanlang ...</option>
                                                            <option value="1">A1</option>
                                                            <option value="2">A2</option>
                                                            <option value="3">B1</option>
                                                            <option value="4">B2</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-6">
                                                        <label for="room_id" class="mt-2">Darslar xonasi</label>
                                                        <select name="room_id" class="form-select">
                                                            <option value="">Tanlang ...</option>
                                                            <option value="2">1-xona Sig'imi: 15</option>
                                                            <option value="3">2-xona Sig'imi: 17</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-6">
                                                        <label for="guruh_start" class="mt-2">Dars boshlanish vaqti</label>
                                                        <input type="date" name="guruh_start" value="" class="form-control" required>
                                                    </div>
                                                    <div class="col-6">
                                                        <label for="guruh_juft_toq" class="mt-2">Dars kunlari</label>
                                                        <select name="guruh_juft_toq" class="form-select">
                                                            <option value="">Tanlang</option>
                                                            <option value="toq">Toq kunlar</option>
                                                            <option value="juft">Juft kunlar</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-6">
                                                        <label for="guruh_price" class="mt-2">Kurs narxi</label>
                                                        <select name="guruh_price" class="form-select">
                                                            <option value="">Tanlang ...</option>
                                                            <option value="5">400000 so'm</option>
                                                            <option value="6">1000000 so'm</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-6">
                                                        <label for="techer_id" class="mt-2">O'qituvchi</label>
                                                        <select name="techer_id" class="form-select">
                                                            <option value="">Tanlang ...</option>
                                                            <option value="16">Test Techer so'm</option>
                                                            <option value="18">Test Techers so'm</option>
                                                            <option value="19">Uchuinchi Oqituvchi so'm</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-6">
                                                        <label for="techer_tulov" class="mt-2">O'qituvchiga to'lov</label>
                                                        <input type="text" id="summa2" value="0" name="techer_tulov" class="form-control" required>
                                                    </div>
                                                    <div class="col-6">
                                                        <label for="techer_bonus" class="mt-2">O'qituvchiga bonus</label>
                                                        <input type="text" id="summa" value="0" name="techer_bonus" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <h5>Yangi guruhga o'tadigan talabalar.</h5>
                                                <div class="input-group-text p-0 px-2 mb-2">
                                                    <input type="checkbox" class="p-0 mr-2"> 
                                                    <p class="p-0 m-0 pl-3 ml-3">Elshod Musurmonov</p>
                                                </div>
                                                <div class="input-group-text p-0 px-2 mb-2">
                                                    <input type="checkbox" class="p-0 mr-2"> 
                                                    <p class="p-0 m-0 pl-3 ml-3">Elshod Musurmonov</p>
                                                </div>
                                                <div class="input-group-text p-0 px-2 mb-2">
                                                    <input type="checkbox" class="p-0 mr-2"> 
                                                    <p class="p-0 m-0 pl-3 ml-3">Elshod Musurmonov</p>
                                                </div>
                                                <div class="input-group-text p-0 px-2 mb-2">
                                                    <input type="checkbox" class="p-0"> 
                                                    <p class="p-0 m-0 pl-3 ml-3">Elshod Musurmonov</p>
                                                </div>  
                                            </div>
                                            <div class="col-12 mb-2 pt-3">
                                                <button type="button" class="btn btn-secondary" style="width:48.5%" 
                                                data-bs-dismiss="modal">Bekor qilish</button>
                                                <button type="submit" class="btn btn-primary" style="width:48.5%">Davom etish</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body mt-3">
              <ul class="nav nav-tabs d-flex" id="myTabjustified" role="tablist">
                <li class="nav-item flex-fill" role="presentation">
                  <button class="nav-link w-100 active" id="home-tab" 
                  data-bs-toggle="tab" data-bs-target="#home-justified" 
                  type="button" role="tab" aria-controls="home" aria-selected="true">Guruh talabalari</button>
                </li>
                <li class="nav-item flex-fill" role="presentation">
                  <button class="nav-link w-100" id="profile-tab" 
                  data-bs-toggle="tab" data-bs-target="#profile-justified" 
                  type="button" role="tab" aria-controls="profile" aria-selected="false">Guruhdan o'chirilganlar</button>
                </li>
                <li class="nav-item flex-fill" role="presentation">
                  <button class="nav-link w-100" id="contact-tab" data-bs-toggle="tab" 
                  data-bs-target="#contact-justified" type="button" role="tab" 
                  aria-controls="contact" aria-selected="false">Davomad</button>
                </li>
                <li class="nav-item flex-fill" role="presentation">
                  <button class="nav-link w-100" id="contact-tab" data-bs-toggle="tab" 
                  data-bs-target="#contact-eslatma" type="button" role="tab" 
                  aria-controls="contact" aria-selected="false">Eslatmalar</button>
                </li>
              </ul>

                <div class="tab-content pt-2" id="myTabjustifiedContent">
                    <div class="tab-pane fade show active" id="home-justified" role="tabpanel" aria-labelledby="home-tab">
                        <div class="table-responsive">
                            <table class="table table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Talaba</th>
                                        <th>Guruhga qo'shildi</th>
                                        <th>Izoh</th>
                                        <th>Meneger</th>
                                        <th>Talaba balans</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($Guruh['activTalaba']==0)
                                        <tr>
                                            <td class="text-center" colspan=6>Talabalar mavjud emas.</td>
                                        </tr>
                                    @else
                                        @foreach( $Guruh['activTalaba'] as $key => $item)
                                            <tr>
                                                <td>{{ $loop->index+1 }}</td>
                                                <td style="text-align:left">
                                                    <a href="{{ route('user.show', $item['user_id'] ) }}">
                                                        {{ $item['user_name'] }}</a></td>
                                                <td>{{ $item['start_data'] }}</td>
                                                <td>{{ $item['start_commit'] }}</td>
                                                <td>{{ $item['admin_email'] }}</td>
                                                <td>{{ $item['balans'] }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <hr>
                    </div>
                    <div class="tab-pane fade" id="profile-justified" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="table-responsive">
                            <table class="table table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Talaba</th>
                                        <th>Guruhga qo'shildi</th>
                                        <th>Izoh</th>
                                        <th>Meneger</th>
                                        <th>Guruhdan o'chirildi</th>
                                        <th>Izoh</th>
                                        <th>Meneger</th>
                                        <th>Jarima</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if($Guruh['endTalaba']==0)
                                    <tr>
                                        <td class="text-center" colspan=9>Guruhdan o'chirilgan talabalar mavjud emas.</td>
                                    </tr>
                                @else
                                    @foreach( $Guruh['endTalaba'] as $key => $item)
                                        <tr>
                                            <td>{{ $loop->index+1 }}</td>
                                            <td style="text-align:left">
                                                <a href="{{ route('user.show', $item['user_id'] ) }}">
                                                    {{ $item['user_name'] }}</a></td>
                                            <td>{{ $item['start_data'] }}</td>
                                            <td>{{ $item['start_commit'] }}</td>
                                            <td>{{ $item['admin_email'] }}</td>
                                            <td>{{ $item['balans'] }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                        <hr>
                        @if(Auth::user()->type!='Operator')
                        @if($Guruh['guruh_about']['guruh_xolati']!='Guruh yakunlangan')
                        <form action="" method="post" id="form">
                            <h5 class="text-center mt-3">Guruhdan talabani o'chirish</h5>
                            <div class="row text-center">
                                <div class="col-lg-6">
                                    <label for="" class="mb-1 mt-2">Talabani tanlang</label>
                                    <select name="" class="form-select" required>
                                        <option value="">Tanlang</option>
                                        @if($Guruh['activTalaba']!=0)
                                            @foreach( $Guruh['activTalaba'] as $key => $item)
                                                <option value="{{ $item['user_id'] }}">{{ $item['user_name'] }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-lg-6">
                                    <label for="" class="mb-1 mt-2">Guruhdan o'chirishga sabab</label>
                                    <input type="text" class="form-control" required>
                                </div>
                                <div class="col-lg-6">
                                    <label for="" class="mb-1 mt-2">Jarima summasi(Guruh narxidan baland bo'lmasin.)</label>
                                    <input type="number" id="summa3" class="form-control" required>
                                </div>
                                <div class="col-lg-6">
                                    <label for="" class="mb-1 mt-2">.</label>
                                    <button class="btn btn-primary w-100">Guruhdan o'chirish</button>
                                </div>
                            </div>
                        </form>
                        @endif
                        @endif
                    </div>
                    <div class="tab-pane fade" id="contact-justified" role="tabpanel" aria-labelledby="contact-tab">
                        <div class="table-responsive">
                            <table class="table table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Talaba</th>
                                        <th>Guruhga qo'shildi</th>
                                        <th>Izoh</th>
                                        <th>Meneger</th>
                                        <th>Talaba balans</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="contact-eslatma" role="tabpanel" aria-labelledby="contact-tab">
                    <div class="table-responsive">
                            <table class="table table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Talaba</th>
                                        <th>Guruhga qo'shildi</th>
                                        <th>Izoh</th>
                                        <th>Meneger</th>
                                        <th>Guruhdan o'chirildi</th>
                                        <th>Izoh</th>
                                        <th>Meneger</th>
                                        <th>Jarima</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <hr>
                        <form action="" method="post">
                            <h5 class="text-center mt-3">Eslatma qoldirish</h5>
                            <div class="row text-center">
                                <div class="col-lg-8">
                                    <label for="" class="mb-1 mt-2">Eslatma izohi</label>
                                    <input type="text" class="form-control" required>
                                </div>
                                <div class="col-lg-4">
                                    <label for="" class="mb-1 mt-2">.</label>
                                    <button class="btn btn-primary w-100">Eslatma qoldirish</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
              
            </div>
          </div>
        
   

  </main>

@endsection
