@extends('layouts.home')
@section('title',"Tashriflar")
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
      <h1>Yangi tashrif</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahifa</a></li>
          <li class="breadcrumb-item"><a href="{{ route('user.index') }}">Tashriflar</a></li>
          <li class="breadcrumb-item active">Yangi tashrif</li>
        </ol>
      </nav>
    </div>
    @if (Session::has('error'))
        <div class="alert alert-danger">{{ Session::get('error') }}</div>
    @endif

    @foreach($errors->all() as $messege)
        <div class="alert alert-danger">{{ $messege }}</div>
    @endforeach
    <div class="card">
      <div class="card-body">
        <div class="row py-2">
          <div class="col-lg-3 mt-1 col-6 text-center">
              <a href="{{ route('user.index') }}" class="btn btn-Secondary text-primary w-100"><i class="bi bi-people"></i> Barcha tashriflar</a>
          </div>
          <div class="col-lg-3 mt-1 col-6 text-center">
              <a href="{{ route('userDebet') }}" class="btn btn-Secondary text-primary w-100"><i class="bi bi-cash-coin"></i> Qarzdorlar</a>
          </div>
          <div class="col-lg-3 mt-1 col-6 text-center">
              <a href="{{ route('userPay') }}" class="btn btn-Secondary text-primary w-100"><i class="bi bi-cart-check"></i> To'lovlar</a>
          </div>
          <div class="col-lg-3 mt-1 col-6 text-center">
              <a href="{{ route('user.create') }}" class="btn btn-primary w-100"><i class="bi bi-person-plus"></i> Yangi tashrif</a>
          </div>
        </div><hr class="p-0 m-0">
        <form action="{{ route('user.store') }}" method="post">
            @csrf
            <div class="row">
                <div class="col-lg-6">
                    <label for="name" class="mt-2">FIO</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
                    <label for="address" class="mt-2">Manzil</label>
                    <select name="address" required class="form-select">
                      <option value="">Tanlang</option>
                      <option value="G'uzor Tumani">G'uzor Tumani</option>
                      <option value="Dexqonobod Tumani">Dexqonobod Tumani</option>
                      <option value="Qamashi Tumani">Qamashi Tumani</option>
                      <option value="Qarshi Tumani">Qarshi Tumani</option>
                      <option value="Koson Tumani">Koson Tumani</option>
                      <option value="Mirishkor Tumani">Mirishkor Tumani</option>
                      <option value="Kitob Tumani">Kitob Tumani</option>
                      <option value="Muborak Tumani">Muborak Tumani</option>
                      <option value="Nishon Tumani">Nishon Tumani</option>
                      <option value="Kasbi Tumani">Kasbi Tumani</option>
                      <option value="Chiroqchi Tumani">Chiroqchi Tumani</option>
                      <option value="Ko'kdala Tumani">Ko'kdala Tumani</option>
                      <option value="Shaxrisabz Tumani">Shaxrisabz Tumani</option>
                      <option value="Shaxrisabz Shaxar">Shaxrisabz Shaxar</option>
                      <option value="Yakkabog' Tumani">Yakkabog' Tumani</option>
                      <option value="Qarshi Shaxar">Qarshi Shaxar</option>
                    </select>
                    <label for="phone" class="mt-2">Telefon raqam</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="form-control phone" required>
                    <label for="tkun" class="mt-2">Tug'ilgan kun</label>
                    <input type="date" name="tkun" value="{{ old('tkun') }}" class="form-control" required>
                </div>
                <div class="col-lg-6">
                    <label for="Tanish" class="mt-2">Yaqin tanishi</label>
                    <input type="text" name="Tanish" value="{{ old('Tanish') }}" class="form-control" required>
                    <label for="TanishPhone" class="mt-2">Tanish telefon raqami</label>
                    <input type="text" name="TanishPhone" value="{{ old('TanishPhone') }}" class="form-control phone" required>
                    <label for="BizHaqimizda" class="mt-2">Biz haqimizda</label>
                    <select name="BizHaqimizda" class="form-select" required>
                        <option value="">Tanlang</option>
                        <option value="Telegram">Telegram</option>
                        <option value="Instagram">Instagram</option>
                        <option value="Facebook">Facebook</option>
                        <option value="Bannerlar">Bannerlar</option>
                        <option value="Boshqa">Boshqa</option>
                    </select>
                    <label for="TalabaHaqida" class="mt-2">Talaba haqida</label>
                    <input type="text" value="{{ old('TalabaHaqida') }}" name="TalabaHaqida" class="form-control" required>
                </div>
                <script>
                    function button(){
                        document.getElementById('buttons').style.display='none';
                    }
                </script>
                <div class="col-12 text-center">
                    <button class="btn btn-primary mt-3" type="submit" id="buttons" ondblclick="button()"> Tashrifni saqlash</button>
                </div>
            </div>
        </form>
      </div>
    </div>

  </main>

@endsection
