@extends('layouts.home')
@section('title',"Aktiv Eslatmalar")
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
      <h1>Eslarmalar</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahifa</a></li>
          <li class="breadcrumb-item active">Eslarmalar</li>
        </ol>
      </nav>
    </div>
    
    @if(session()->has('success'))
      <div class="alert alert-success">
        {{ session()->get('success') }}
      </div>
    @endif
                
        <div class="card">
            <div class="card-body text-center">
                <div class="row">
                    <div class="col-6 pt-2">
                        <a href="{{ route('eslatma.index') }}" class="btn btn-primary text-white card-title py-1 w-100">Aktiv Eslatmalar</a>
                    </div>
                    <div class="col-6 pt-2">
                        <a href="{{ route('arxivEslatma') }}" class="btn btn-muted card-title py-1 w-100">Aktiv Eslatmalar</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table datatable table-bordered table-striped text-center" style="font-size:14px;">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Eslatma matni</th>
                                <th class="text-center">Eslatma vaqti</th>
                                <th class="text-center">Guruh/Talaba</th>
                                <th class="text-center">Tasdiqlash</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($Eslatmalar as $key => $value)
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td style="text-align:left">{{ $value['text'] }}</td>
                                    <td>{{ $value['created_at'] }}</td>
                                    <td>
                                        @if($value['type']=='user')
                                            {{ $value['type'] }}:<a href="{{ route('user.show',$value['user_guruh_id'] ) }}">{{ $value['name'] }}</a>
                                        @else
                                            {{ $value['type'] }}:<a href="{{ route('guruh.show',$value['user_guruh_id'] ) }}">{{ $value['name'] }}</a>
                                        @endif
                                    </td>
                                    <td>
                                        @if(Auth::user()->type!='Operator')
                                        <form action="{{ route('eslatma.destroy',$value['id']) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-danger px-1 py-0"><i class="bi bi-check-all"></i></button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class='text-center' colspan=5>Aktiv Eslatmalar mavjud emas</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
   

  </main>

@endsection
