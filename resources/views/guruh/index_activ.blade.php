@extends('layouts.home')
@section('title',"Aktiv guruhlar")
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
      <h1>Aktiv guruhlar</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahifa</a></li>
          <li class="breadcrumb-item active">Aktiv guruhlar</li>
        </ol>
      </nav>
    </div>
    
    <div class="row mb-2">
        <div class="col-lg-3 col-6 mb-1">
            <a href="{{ route('guruh.index') }}" class="btn btn-primary w-100"><i class="bi bi-list-check"> Barcha guruhlar</i></a>
        </div>
        <div class="col-lg-3 col-6 mb-1">
            <a href="{{ route('indexNew') }}" class="btn btn-primary w-100"><i class="bi bi-list-stars"> Yangi guruhlar</i></a>
        </div>
        <div class="col-lg-3 col-6 mb-1">
            <a href="{{ route('indexActiv') }}" class="btn btn-primary w-100"><i class="bi bi-list-ul"> Aktiv guruhlar</i></a>
        </div>
        <div class="col-lg-3 col-6 mb-1">
            <a href="{{ route('guruh.create') }}" class="btn btn-success w-100"><i class="bi bi-plus"> Yangi guruh</i></a>
        </div>
    </div>
                
                
        <div class="card">
            <div class="card-body pt-4 text-center">
                <h5>Aktiv guruhlar</h5>
                <div class="table-responsive">
                    <table class="table datatable table-bordered table-striped text-center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Guruh nomi</th>
                                <th>Boshlanish vaqti</th>
                                <th>Tugash vaqti</th>
                                <th>Talabalar</th>
                                <th>Guruh summasi</th>
                                <th>Guruh holati</th>
                                <th>Status</th>
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
                            </tr>
                            <tr>
                                <td>2</td>
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
            </div>
        </div>
        
   

  </main>

@endsection
