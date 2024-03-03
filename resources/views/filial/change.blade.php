<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Filial tanlang</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <link href="https://atko.tech/crm/img/favicon.png" rel="icon">
  <link href="https://atko.tech/crm/img/apple-touch-icon.png" rel="apple-touch-icon">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link href="https://atko.tech/crm/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://atko.tech/crm/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="https://atko.tech/crm/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="https://atko.tech/crm/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="https://atko.tech/crm/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="https://atko.tech/crm/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="https://atko.tech/crm/vendor/simple-datatables/style.css" rel="stylesheet">
  <link href="https://atko.tech/crm/css/style.css" rel="stylesheet">
</head>
<body>
@auth

<div class="container py-5 text-center">
    <div class="card" style="width: 100%;">
    <div class="card-body">
        <h4 class="mt-3">Filiallardan birini tanlang</h4>
        <div class="row p-3">
            @foreach($Filial as $item)
            <div class="col-lg-4 text-white">
                <div class="bg-secondary m-2">
                    <h5 class="card-title text-white">{{ $item->filial_name}}</h5>
                    <p class="card-text">{{ $item->filial_addres}}</p>
                    <a href="{{ route('changeFilialEdit',['id'=>$item->id,'name'=>$item->filial_name]) }}" class="card-link text-white btn btn-success">Davom etish</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    </div>
    
</div>

@endauth
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  
  <script src="https://atko.tech/crm/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="https://atko.tech/crm/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="https://atko.tech/crm/vendor/chart.js/chart.umd.js"></script>
  <script src="https://atko.tech/crm/vendor/echarts/echarts.min.js"></script>
  <script src="https://atko.tech/crm/vendor/quill/quill.min.js"></script>
  <script src="https://atko.tech/crm/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="https://atko.tech/crm/vendor/tinymce/tinymce.min.js"></script>
  <script src="https://atko.tech/crm/vendor/php-email-form/validate.js"></script>
  <script src="https://atko.tech/crm/js/main.js"></script>
</body>
</html>