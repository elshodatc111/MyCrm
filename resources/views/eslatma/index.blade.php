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
            <div class="card-body pt-4 text-center">
                <h5>Aktiv Eslarmalar</h5>
                <div class="table-responsive">
                    <table class="table datatable table-bordered table-striped text-center">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Eslatma matni</th>
                                <th class="text-center">Eslatma vaqti</th>
                                <th class="text-center">Guruh/Talaba</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ActivEslatma as $item)
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td style="text-align:left;">{{ $item['text'] }}</td>
                                    <td>{{ $item['created_at'] }}</td>
                                    @if($item['type']=='guruh')
                                        <td style="text-align:left;"><a href="{{ route('guruh.show',$item['user_guruh_id']) }}">
                                            {{ $item['userGuruh'] }}
                                        </a></td>
                                    @else
                                        <td style="text-align:left;"><a href="{{ route('user.show',$item['user_guruh_id']) }}">
                                            {{ $item['userGuruh'] }}
                                        </a></td>
                                    @endif
                                    <td>
                                        <form action="{{ route('eslatma.destroy', $item['id'] ) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger px-1 py-0"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan=5 class='text-center'>Aktiv Eslatmalar mavjud emas.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="w-100 text-center"><a href="{{ route('arxivEslatma') }}" class="btn btn-primary">Arxiv Eslatmalar</a></div>
                </div>
            </div>
        </div>
        
   

  </main>

@endsection
