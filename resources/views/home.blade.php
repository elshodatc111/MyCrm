@extends('layouts.home')
@section('title',"Bosh sahifa")
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahifa</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div>
    {{ json_decode(request()->cookie('users'))->user_edet  }}
    
    
    <section class="section dashboard">
      <div class="row">
        <div class="col-lg-4">
          <div class="card info-card sales-card">
            <div class="card-body">
              <h5 class="card-title">O'qituvchilar</h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-person-arms-up"></i>
                </div>
                <div class="ps-3">
                  <h6>8</h6>
                  <span class="text-success small pt-1 fw-bold">5</span> <span class="text-muted small pt-2 ps-1">AKTIV O'QITUVCHILAR</span>
                </div>
              </div>
            </div>
          </div>
        </div>
            
        <div class="col-lg-4">
          <div class="card info-card revenue-card">
            <div class="card-body">
              <h5 class="card-title">Tashriflar</h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-person"></i>
                </div>
                <div class="ps-3">
                  <h6>4516</h6>
                  <span class="text-success small pt-1 fw-bold">65</span> <span class="text-muted small pt-2 ps-1">AKTIV TASHRIFLAR</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="card info-card customers-card">
            <div class="card-body">
              <h5 class="card-title">Guruhlar</h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-diagram-3"></i>
                </div>
                <div class="ps-3">
                  <h6>1244</h6>
                  <span class="text-danger small pt-1 fw-bold">10</span> <span class="text-muted small pt-2 ps-1">AKTIV GURUHLAR</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Dars jadvali</h5>

        <!-- Bordered Tabs Justified -->
        <ul class="nav nav-tabs nav-tabs-bordered d-flex" id="borderedTabJustified" role="tablist">
          <li class="nav-item flex-fill" role="presentation">
            <button class="nav-link w-100 active" id="home-tab"
             data-bs-toggle="tab" data-bs-target="#bordered-justified-home" 
             type="button" role="tab" aria-controls="home" aria-selected="true">1-xona</button>
          </li>
          <li class="nav-item flex-fill" role="presentation">
            <button class="nav-link w-100" id="profile-tab"
             data-bs-toggle="tab" data-bs-target="#bordered-justified-profile" 
             type="button" role="tab" aria-controls="profile" aria-selected="false">2-xona</button>
          </li>
        </ul>
        <div class="tab-content pt-2" id="borderedTabJustifiedContent">
          <div class="tab-pane fade show active" id="bordered-justified-home" role="tabpanel" aria-labelledby="home-tab">
            <div class="table-responsive">
              <table class="table table-bordered text-center">
                <thaed>
                  <tr>
                    <th>Soat/Hafta</th>
                    <th>Dushanba</th>
                    <th>Seshanba</th>
                    <th>Chorshanba</th>
                    <th>Payshanba</th>
                    <th>Juma</th>
                    <th>Shanba</th>
                  </tr>
                </thaed>
                <tbody>
                  <tr>
                    <td>08:00-09:30</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td>08:00-09:30</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td>08:00-09:30</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td>08:00-09:30</td>
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
          <div class="tab-pane fade" id="bordered-justified-profile" role="tabpanel" aria-labelledby="profile-tab">
            
            <div class="table-responsive">
              <table class="table table-bordered text-center">
                <thaed>
                  <tr>
                    <th>Soat/Hafta</th>
                    <th>Dushanba</th>
                    <th>Seshanba</th>
                    <th>Chorshanba</th>
                    <th>Payshanba</th>
                    <th>Juma</th>
                    <th>Shanba</th>
                  </tr>
                </thaed>
                <tbody>
                  <tr>
                    <td>08:00-09:30</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td>08:00-09:30</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td>08:00-09:30</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td>08:00-09:30</td>
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
        

      </div>
    </div>

  </main>

@endsection
