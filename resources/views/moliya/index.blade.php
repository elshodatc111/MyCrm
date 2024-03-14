@extends('layouts.home')
@section('title',"Moliya")
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
      <h1>Moliya</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahifa</a></li>
          <li class="breadcrumb-item active">Moliya</li>
        </ol>
      </nav>
    </div>
    
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body pt-2 text-center">
                    <h4>Xarajatlar uchun chiqim qilish</h4>
                    <p class="p-0 m-0 text-danger">Kassada mavjud: 350 000</p>
                    <hr class="m-0 p-0">
                    <form action="" method="post" id="form1">
                        <label for="chiqim_summas" class="mt-2">Chiqim summasi</label>
                        <input type="text" class="form-control" required id="summa1">
                        <label for="chiqim_summas" class="mt-2">Chiqim haqida izoh</label>
                        <textarea name="chiqim_summas" class="form-control"></textarea>
                    </form>
                    <button type="submit" class="btn btn-primary w-100 mt-3">Chiqim qilish</button>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card">
                <div class="card-body pt-2 text-center">
                    <h4>Xarajatlar uchun tasdiqlanmagan chiqimlar</h4>
                    <p class="p-0 m-0 text-danger">Xarajatlar uchun tasdiqlanmagan chiqimlar: 350 000</p>
                    <hr class="m-0 p-0">
                    <table class="table">
                        <tr>
                            <th>#</th>
                            <th>Chiqim Summasi</th>
                            <th>Chiqim Haqida</th>
                            <th>Chiqim Vaqti</th>
                            <th>Meneger</th>
                            <th>Status</th>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        
        
    </div>

  </main>

@endsection
