@extends('layouts.home')
@section('title',"Murojatlar")
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
      <h1>Murojatlar</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahifa</a></li>
          <li class="breadcrumb-item active">Murojatlar</li>
        </ol>
      </nav>
    </div>
    
    
    <div class="card">
      <div class="card-body pt-4">
        <div class="row">
            @forelse($Contact as $item)
            <div class="col-lg-4">
                <a href="{{ route('contact.show', $item['user_id'] ) }}">
                    <table class="table">
                        <div class="row m-2 p-2" 
                            style="background-color:#EEF1F7;padding:5px;color:#012970;border-radius:5px">
                            <div class="col-12">
                                <h6 class="p-0 m-0">{{ $item['name'] }} 
                                    @if($item['comment']!=0)
                                    <span class="badge bg-primary p-1 m-0" style="font-size:10px">{{ $item['comment'] }}</span>
                                    @endif
                                </h6>
                                <p class="p-0 m-0" style="font-size:14px;">{{ $item['text'] }} </p>
                            </div>
                            <div class="col-10" style="font-size:10px">{{ $item['created_at'] }} </div>
                            @if($item['status']=='admin')
                            <div class="col-2" style="text-align:right;font-size:10px">
                                @if($item['user_type']=='false')
                                <i class="bi bi-check"></i>
                                @else
                                <i class="bi bi-check-all"></i>
                                @endif
                            </div>
                            @endif
                        </div>
                    </table>
                </a>
            </div>
            @empty

            @endforelse
            
            
        </div>
      </div>
    </div>
            

  </main>

@endsection
