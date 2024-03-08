@extends('layouts.home')
@section('title',"Sozlamalar")
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
      <h1>Sozlamalar</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahifa</a></li>
          <li class="breadcrumb-item active">Sozlamalar</li>
        </ol>
      </nav>
    </div>

    @if(session()->has('success'))
      <div class="alert alert-success">
        {{ session()->get('success') }}
      </div>
    @endif
    <div class="card">
      <div class="card-body">
        <ul class="nav nav-tabs nav-tabs-bordered d-flex" id="borderedTabJustified" role="tablist">
          <li class="nav-item flex-fill" role="presentation">
            <button class="nav-link w-100 active" id="Tulov_Chegirma"
             data-bs-toggle="tab" data-bs-target="#bordered-justified-tulov" 
             type="button" role="tab" aria-controls="tulov" aria-selected="true">To'lov chegirmalari</button>
          </li>
          <li class="nav-item flex-fill" role="presentation">
            <button class="nav-link w-100" id="Testlar"
             data-bs-toggle="tab" data-bs-target="#bordered-justified-testlar" 
             type="button" role="tab" aria-controls="testlar" aria-selected="false">Testlar</button>
          </li>
        </ul>
        <div class="tab-content pt-2" id="borderedTabJustifiedContent">
          <div class="tab-pane fade show active" id="bordered-justified-tulov" role="tabpanel" aria-labelledby="Tulov_Chegirma">
            <div class="table-responsive">
                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Guruh summasi</th>
                            <th>Chegirma summasi</th>
                            <th>Chegirma uchun kun</th>
                            <th>Admin uchun chegirma</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($Setting as $item)
                        <tr>
                            <td>{{ $loop->index+1 }}</td>
                            <td>{{ $item->summa }}</td>
                            <td>{{ $item->chegirma }}</td>
                            <td>{{ $item->days }}</td>
                            <td>{{ $item->admin_chegirma }}</td>
                            <td>
                                <form action="{{ route('setting.destroy',$item->id ) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger py-0 px-1"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan=6 class='text-center'>Tulov summalari mavjud emas</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <form action="{{ route('setting.store') }}" method="post" id="form" style="border:1px solid #000;" class="p-3">
                @csrf
                <h5 class="w-100 text-center">Yangi to'lov summasini kiritish</h5>
                <div class="row">
                    <div class="col-lg-6">
                        <label for="summa" class="mt-2">Guruh Summasi</label>
                        <input type="text" id="summa3" name="summa" required class="form-control">
                        <label for="days" class="mt-2">Chegirma uchun kun</label>
                        <input type="number" name="days" required class="form-control">
                    </div>
                    <div class="col-lg-6">
                        <label for="chegirma" class="mt-2">Chegirma Summasi</label>
                        <input type="text" name="chegirma" id="summa" required class="form-control">
                        <label for="admin_chegirma" class="mt-2">Meneger uchun maksima chegirma</label>
                        <input type="text" name="admin_chegirma" id="summa2" required class="form-control">
                    </div>
                    <div class="col-12 text-center">
                        <button class="btn btn-primary mt-3" type="submit">To'lovni saqlash</button>
                    </div>
                </div>
            </form>
          </div>
          <div class="tab-pane fade" id="bordered-justified-testlar" role="tabpanel" aria-labelledby="Testlar">
            <div class="table-responsive">
                Testlar
            </div>
          </div>
          
        </div>
        

      </div>
    </div>

  </main>

@endsection
