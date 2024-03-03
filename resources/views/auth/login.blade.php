@extends('layouts.login')
@section('title',"Kirish")
@section('content')
    <div class="container">
        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                        <div class="d-flex justify-content-center py-4">
                            <a class="logo d-flex align-items-center w-auto"><img src="https://atko.tech/crm/img/logo.png" alt=""></a>
                        </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title text-center pb-0 fs-4">Kirish</h5>
                            <form class="row g-3 needs-validation" novalidate method="POST" action="{{ route('login') }}">
                                @csrf
                                <label for="yourLogin" class="form-label">Login</label>
                                <input type="text" name="email" value="{{ old('email') }}" class="form-control mt-0" id="yourLogin" required>
                                <label for="yourPassword" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control mt-0" id="yourPassword" required>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe" {{ old('remember') ? 'checked' : '' }} >
                                    <label class="form-check-label" for="rememberMe">Parolni eslab qolish</label>
                                </div>
                                <button class="btn btn-primary w-100" type="submit">Kirish</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
