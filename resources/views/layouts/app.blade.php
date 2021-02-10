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
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>
    {{isset($title) ? $title . ' | ' : ''}} Telsen Ingenieros
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />

  <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css"> -->

  <!--     Fonts and icons     -->
  <link rel="preconnect" href="https://fonts.gstatic.com">
  {{-- <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@500;600;700;900&display=swap" rel="stylesheet"> --}}
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;700&display=swap" rel="stylesheet">
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
  <div class="modal fade" tabindex="-1" id="modalOTSPriority">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">OTS de Prioridad</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body text-center">
          <div class="table-responsive">
          <table class="table table-separate data-table" id="tbpriority">
            <thead class=" text-primary">
              <th class="text-nowrap">Fecha OT</th>
              <th class="text-nowrap">N° de OT</th>
              <th>Estado</th>
              <th>Cliente</th>
              {{-- <th>Potencia</th>
              <th>Código <br>motor</th> --}}
              <th class="text-center">Fecha de entrega</th>
              <th class="text-center">Acciones</th>
            </thead>
          </table>
          </div>
        </div>
        <div class="modal-footer justify-content-center">
          <button class="btn btn-secondary" data-dismiss="modal" type="button">OK</button>
        </div>
      </div>
    </div>
  </div>
  <!--   Core JS Files   -->
  <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
  {{-- <script src="{{ asset('assets/js/plugins/perfect-scrollbar.jquery.min.js') }}"></script> --}}
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
    var dLanguage = {
          "sProcessing":     "Procesando...",
          "sLengthMenu":     "Mostrar _MENU_ registros",
          "sZeroRecords":    "No se encontraron resultados",
          "sEmptyTable":     "Ningún dato disponible en esta tabla",
          "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
          "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
          "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
          "sInfoPostFix":    "",
          "sSearch":         "Buscar:",
          "sUrl":            "",
          "sInfoThousands":  ",",
          "sLoadingRecords": "Cargando...",
          "oPaginate": {
            "sFirst":    "Primero",
            "sLast":     "Último",
            "sNext":     "Siguiente",
            "sPrevious": "Anterior"
          },
          "oAria": {
            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
          }
        }
    $(document).ready(function() {
        $('#tablas').DataTable({
          language: dLanguage
        });
        $('.dropdown2').select2({
          placeholder: {
            text: 'Selecciona una opción'
          },
          allowClear: true
        });
        var priority_ots;

        priority_ots = $('#tbpriority').DataTable({
         processing: true,
         serverSide: true,
         ajax: "{{route('ordenes.priority.list')}}",
         pageLength: 5,
         lengthMenu: [ 5, 25, 50 ],
         columns: [
            { data: 'created_at', class: 'text-nowrap' },
            { data: 'id', class: 'otid' },
            { data: 'status', class: 'text-center' },
            { data: 'razon_social' },
            //{ data: 'numero_potencia', class: 'text-left' },
            //{ data: 'codigo_motor', class: 'text-left' },
            { data: 'fecha_entrega', class: 'text-center bg-light' },
            { data: 'tools', class: 'text-left text-nowrap'}
        ],
         columnDefs: [
          { orderable: false, targets: 2 },
          //{ orderable: false, targets: 6 }
        ],
        order: [[ 0, "desc" ]],
        language: dLanguage
      }).on( 'init.dt', function () {
        if(priority_ots.data().length && location.pathname != '/ordenes/prioridad') {
          $('#modalOTSPriority').modal('show');
        }
    } );
    });
  </script>
  @yield('javascript')

</body>

</html>
