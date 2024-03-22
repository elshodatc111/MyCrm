<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Kurs haqida</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <link href="https://atko.tech/crm/user/img/favicon.png" rel="icon">
  <link href="https://atko.tech/crm/user/img/apple-touch-icon.png" rel="apple-touch-icon">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  <link href="https://atko.tech/crm/user/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://atko.tech/crm/user/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="https://atko.tech/crm/user/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="https://atko.tech/crm/user/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="https://atko.tech/crm/user/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="https://atko.tech/crm/user/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link href="https://atko.tech/crm/user/css/style.css" rel="stylesheet">
</head>

<body>

  <main id="main">
    <div id="portfolio-details" class="portfolio-details">
      <div class="container">
        <div class="row text-center">
          <div class="col-lg-12 text-center">
            <h4>{{ $Guruh_about['guruh_name'] }}</h4>
            <hr>
          </div>
          <div class="col-lg-4">
            <ul>
              <li class="my-3">
                <i class="bi bi-chevron-right"></i> 
                <strong>Kursning narix:</strong> <span>{{ $Guruh_about['guruh_price'] }} so'm</span>
              </li>
            </ul>
          </div>
          <div class="col-lg-4">
            <ul>
              <li class="my-3">
                <i class="bi bi-chevron-right"></i> 
                <strong>O'qituvchi:</strong> <span>{{ $Guruh_about['techer'] }}</span>
              </li>
            </ul>
          </div>
          <div class="col-lg-4">
            <ul>
              <li class="my-3">
                <i class="bi bi-chevron-right"></i> 
                <strong>Dars xonasi:</strong> <span>{{ $Guruh_about['Room'] }}</span>
              </li>
            </ul>
          </div>
          <div class="col-12">
            <hr>
            <h5>Dars jadvali</h5>
            <table class="table">
              <tr>
                <th style="text-align:right">{{ $Guruh_about['jadval'][0] }}</th>
                <td style="text-align:left">{{ $Guruh_about['guruh_dars_vaqt'] }}</td>
                <th style="text-align:right">{{ $Guruh_about['jadval'][6] }}</th>
                <td style="text-align:left">{{ $Guruh_about['guruh_dars_vaqt'] }}</td>
              </tr>
              <tr>
                <th style="text-align:right">{{ $Guruh_about['jadval'][1] }}</th>
                <td style="text-align:left">{{ $Guruh_about['guruh_dars_vaqt'] }}</td>
                <th style="text-align:right">{{ $Guruh_about['jadval'][7] }}</th>
                <td style="text-align:left">{{ $Guruh_about['guruh_dars_vaqt'] }}</td>
              </tr>
              <tr>
                <th style="text-align:right">{{ $Guruh_about['jadval'][2] }}</th>
                <td style="text-align:left">{{ $Guruh_about['guruh_dars_vaqt'] }}</td>
                <th style="text-align:right">{{ $Guruh_about['jadval'][8] }}</th>
                <td style="text-align:left">{{ $Guruh_about['guruh_dars_vaqt'] }}</td>
              </tr>
              <tr>
                <th style="text-align:right">{{ $Guruh_about['jadval'][3] }}</th>
                <td style="text-align:left">{{ $Guruh_about['guruh_dars_vaqt'] }}</td>
                <th style="text-align:right">{{ $Guruh_about['jadval'][9] }}</th>
                <td style="text-align:left">{{ $Guruh_about['guruh_dars_vaqt'] }}</td>
              </tr>
              <tr>
                <th style="text-align:right">{{ $Guruh_about['jadval'][4] }}</th>
                <td style="text-align:left">{{ $Guruh_about['guruh_dars_vaqt'] }}</td>
                <th style="text-align:right">{{ $Guruh_about['jadval'][10] }}</th>
                <td style="text-align:left">{{ $Guruh_about['guruh_dars_vaqt'] }}</td>
              </tr>
              <tr>
                <th style="text-align:right">{{ $Guruh_about['jadval'][5] }}</th>
                <td style="text-align:left">{{ $Guruh_about['guruh_dars_vaqt'] }}</td>
                <th style="text-align:right">{{ $Guruh_about['jadval'][11] }}</th>
                <td style="text-align:left">{{ $Guruh_about['guruh_dars_vaqt'] }}</td>
              </tr>
            </table>
          </div>
          <div class="col-lg-12 text-center">
            <a href="{{ route('home') }}" class="btn btn-danger"><i class="bi bi-reply-all"></i> Orqaga</a>
          </div>
        </div> 
      </div>
    </div>
  </main>
  
  <div class="credits">
    <a>ATKO o'quv markazi</a>
  </div>
  
  <script src="https://atko.tech/crm/user/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="https://atko.tech/crm/user/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="https://atko.tech/crm/user/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="https://atko.tech/crm/user/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="https://atko.tech/crm/user/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="https://atko.tech/crm/user/vendor/waypoints/noframework.waypoints.js"></script>
  <script src="https://atko.tech/crm/user/vendor/php-email-form/validate.js"></script>
  <script src="https://atko.tech/crm/user/js/main.js"></script>
</body>
</html>