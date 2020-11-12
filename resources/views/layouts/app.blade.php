<!--
=========================================================
* Paper Dashboard 2 - v2.0.1
=========================================================

* Product Page: https://www.creative-tim.com/product/paper-dashboard-2
* Copyright 2020 Creative Tim (https://www.creative-tim.com)

Coded by www.creative-tim.com

 =========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="/assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="/assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    {{isset($title) ? $title . ' | ' : ''}} Telsen Ingenieros
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />

  <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css"> -->

  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@500;600;700;900&display=swap" rel="stylesheet">
  <!-- CSS Files -->
  <link href="{{ asset('assets/css/paper-dashboard.css?v=2.0.1') }}" rel="stylesheet" />

  <!-- CSS Just for demo purpose, don't include it in your project -->
  <!-- <link href="{{ asset('assets/demo/demo.css') }}" rel="stylesheet" /> -->

  @yield('css')
  <link href="{{ asset('css/app.css') }}" rel="stylesheet" />

</head>
<body class="page {{isset($body_class) ? $body_class : ''}}">
  <div class="wrapper ">
    @include('layouts.sidebar')
    <div class="main-panel">
      <!-- Navbar -->
        @include('layouts.headernav')
      <!-- End Navbar -->
      <div class="content container">
        @yield('content')
      </div>
      <footer class="footer footer-black  footer-white ">
        @include('layouts.footer')
      </footer>
    </div>
  </div>
  <!--   Core JS Files   -->
  
  <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
  <script src="{{ asset('assets/js/plugins/perfect-scrollbar.jquery.min.js') }}"></script>
  <!--  Google Maps Plugin    -->
  <!--script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script-->
  <!-- Chart JS -->
  <script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>
  <!--  Notifications Plugin    -->
  <script src="{{ asset('assets/js/plugins/bootstrap-notify.js') }}"></script>
  <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="{{ asset('assets/js/paper-dashboard.min.js?v=2.0.1') }}" type="text/javascript"></script><!-- Paper Dashboard DEMO methods, don't include it in your project! -->
  <!--script src="../assets/demo/demo.js"></script-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

  <script type="text/javascript">
    $(document).ready(function() {
        $('#tablas').DataTable();
        $('.dropdown2').select2();
    } );
  </script>
  @yield('javascript')

</body>

</html>
