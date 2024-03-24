@extends('layouts.home')
@section('title',"Profel")
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
      <h1>Statistika</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahifa</a></li>
          <li class="breadcrumb-item"><a href="{{ route('profel.index') }}">Kabinet</a></li>
          <li class="breadcrumb-item active">Statistika</li>
        </ol>
      </nav>
    </div>
    
    <div class="row">
      <div class="col-lg-6">
        <div class="card">
          <div class="card-body pt-4 text-center">
            <h5>Joriy oy statistikasi</h5>
            <table class="table table-bordered" style="font-size:12px">
              <tr>
                <th style="text-align:left">Tashriflar:</th>
                <td style="text-align:right">{{ $Summa['ThisTashrif'] }}</td>
              </tr>
              <tr>
                <th style="text-align:left">Naqt to'lovlar:(Tasdiqlangan)</th>
                <td style="text-align:right">{{ $Summa['Naqt'] }}</td>
              </tr>
              <tr>
                <th style="text-align:left">Plastik to'lovlar:(Tasdiqlangan)</th>
                <td style="text-align:right">{{ $Summa['Plastik'] }}</td>
              </tr>
              <tr>
                <th style="text-align:left">Qaytarilgan to'lovlar:(Tasdiqlangan)</th>
                <td style="text-align:right">{{ $Summa['Qaytar'] }}</td>
              </tr>
              <tr>
                <th style="text-align:left">Xarajatlar:(Tasdiqlangan)</th>
                <td style="text-align:right">{{ $Summa['Xarajat'] }}</td>
              </tr>
            </table>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="card">
          <div class="card-body pt-4 text-center">
            <h5>O'tgan oy statistikasi</h5>
            <table class="table table-bordered" style="font-size:12px">
              <tr>
                <th style="text-align:left">Tashriflar:</th>
                <td style="text-align:right">{{ $OldSumma['OldTashrif'] }}</td>
              </tr>
              <tr>
                <th style="text-align:left">Naqt to'lovlar:(Tasdiqlangan)</th>
                <td style="text-align:right">{{ $OldSumma['OldNaqt'] }}</td>
              </tr>
              <tr>
                <th style="text-align:left">Plastik to'lovlar:(Tasdiqlangan)</th>
                <td style="text-align:right">{{ $OldSumma['OldPlastik'] }}</td>
              </tr>
              <tr>
                <th style="text-align:left">Qaytarilgan to'lovlar:(Tasdiqlangan)</th>
                <td style="text-align:right">{{ $OldSumma['OldQaytar'] }}</td>
              </tr>
              <tr>
                <th style="text-align:left">Xarajatlar:(Tasdiqlangan)</th>
                <td style="text-align:right">{{ $OldSumma['OldXarajat'] }}</td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
            

  </main>

@endsection
