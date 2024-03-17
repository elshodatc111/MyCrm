@extends('layouts.home')
@section('title',"Guruhlar")
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
      <h1>Guruhlar</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahifa</a></li>
          <li class="breadcrumb-item active">Guruhlar</li>
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
    @if(session()->has('success'))
      <div class="alert alert-success">
        {{ session()->get('success') }}
      </div>
    @endif
                
        <div class="card">
            <div class="card-body pt-4 text-center">
                <h5>Barcha guruhlar</h5>
                <div class="table-responsive">
                    <table class="table datatable table-bordered table-striped text-center" style="font-size:14px;">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Guruh nomi</th>
                                <th class="text-center">Boshlanish vaqti</th>
                                <th class="text-center">Tugash vaqti</th>
                                <th class="text-center">Talabalar</th>
                                <th class="text-center">Guruh summasi</th>
                                <th class="text-center">Guruh holati</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($items as $item)
                            <tr>
                                <td>{{ $loop->index+1 }}</td>
                                <td style="text-align:left">{{ $item['guruh_name'] }}</td>
                                <td>{{ $item['start'] }}</td>
                                <td>{{ $item['end'] }}</td>
                                <td>{{ $item['student'] }}</td>
                                <td>{{ $item['summa'] }}</td>
                                <td>
                                    @if($item['status']=='new')
                                        <span class="text-primary">Yangi guruh</span>
                                    @elseif($item['status']=='activ')
                                        <span class="text-success">Aktiv guruh</span>
                                    @else
                                        <span class="text-danger">Yakunlangan</span>                                    
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('guruh.show', $item['id'] ) }}" class="btn btn-primary px-1 py-0"><i class="bi bi-eye"></i></a>
                                    @if(Auth::user()->type!='Operator')
                                    <a href="{{ route('guruh.edit',$item['id']) }}" class="btn btn-primary px-1 py-0"><i class="bi bi-pencil"></i></a>
                                    <form action="{{ route('distroy2',$item['id'] ) }}" method="post" style='display:inline'>
                                        @csrf
                                        @method('delete')
                                        <button type="sublit" class="btn btn-danger px-1 py-0"><i class="bi bi-trash"></i></button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan=8 class="text-center">Guruhlar mavjud emas</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
   

  </main>

@endsection
