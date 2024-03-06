@extends('layouts.home')
@section('title',"Profel")
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
      <h1>Ish haqi to'lovlari</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahifa</a></li>
          <li class="breadcrumb-item"><a href="{{ route('profel.index') }}">Kabinet</a></li>
          <li class="breadcrumb-item active">Ish haqi</li>
        </ol>
      </nav>
    </div>
    
    <div class="card">
        <div class="card-body pt-4 text-center">
            <h5>Ish haqi to'lovlari</h5>
            <table class="table">
                <thead>
                    <tr>
                        <td>#</td>
                        <td>OY</td>
                        <td>Naqt</td>
                        <td>Plastik</td>
                        <td>Jami to'lov</td>
                    </tr>
                </thead>
            </table>
            
        </div>
    </div>
            

  </main>

@endsection
