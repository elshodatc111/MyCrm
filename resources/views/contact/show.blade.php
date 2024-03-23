@extends('layouts.home')
@section('title',"Murojatlar")
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
      <h1>Murojatlar</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahifa</a></li>
          <li class="breadcrumb-item"><a href="{{ route('contact.index') }}">Murojatlar</a></li>
          <li class="breadcrumb-item active">Murojat</li>
        </ol>
      </nav>
    </div>
    
    
    <div class="card">
      <div class="card-body">
        <div class="row">
            <div class="col-lg-4 pt-2">
                @foreach($Contact as $item)
                <a href="{{ route('contact.show', $item['user_id'] ) }}">
                    <table class="table">
                        <div class="row p-2" 
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
                @endforeach
            </div>
            <div class="col-lg-8">
              <div class="info-box pb-0 mt-2" style="font-size:12px;background-color:#EEF1F7;">
                <div class="my-2 w-100">
                  <div class="p-1" style="width:100%;background-color:#EEF1F7;"><hr class="mt-0 pt-0 mb-1 p-0">
                      <a href="{{ route('user.show',$User->id ) }}"><h6 class='px-0 my-0 w-100 text-center'>{{ $User->name }}</h6></a>
                      <hr class="m-0 p-0">
                  </div>
                </div>
                @forelse($Muroratlar as $item)
                @if($item['status']=='user')
                <div class="my-2 text-dark w-100">
                  <div class="row p-1 mx-2" style="width:70%;background-color:white;">
                      <div class="row">
                        <div class="col-12">{{ $item['text'] }}</div>
                        <div class="col-12" style="text-align:right"><i>{{ $item['created_at'] }}</i></div>
                      </div>
                  </div>
                </div>
                @else
                <div class="my-2 w-100">
                  <div class="p-1 px-2 " style="width:69%;background-color:white;margin-left: 30%;">
                      <div class="row">
                        <div class="col-7"><h6>{{ $item['admin'] }}</h6></div>
                        <div class="col-5" style="text-align:right"><i>{{ $item['created_at'] }}</i></div>
                        <div class="col-12">{{ $item['text'] }}</div>
                        <div class="col-12" style="text-align:right">
                          @if($item['user_type']=='false')
                          <i class="bi bi-check2"></i>
                          @else
                          <i class="bi bi-check2-all"></i>
                          @endif
                        </div>
                      </div>
                  </div>
                </div>
                @endif
                @empty
                @endforelse
                <div class="my-2 text-dark w-100">
                  <form action="{{ route('AdminSendMurojat') }}" method="post">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $User->id }}">
                    <div class="input-group mb-3">
                      <input type="text" class="form-control" name="text" style="border-radius:0;" placeholder="Murojatga javob matni" required>
                      <div class="input-group-append">
                        <button class="btn btn-outline-success" style="border-radius:0;" type="submit">Yuborish</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
        </div>
      </div>
    </div>
            

  </main>

@endsection
