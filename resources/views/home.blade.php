@extends('layouts.app', ['body_class' => 'page_home'])

@section('content')
{{-- <ul class="list list-unstyled">
@php
  foreach ($areas as $key => $area) {
 echo "<h2 class='h6'>$area->name</h2>";
 echo "<ul>";
   foreach ($area->services as $service) {
     echo "<li>".$service->name."</li>";
   }
 echo "</ul>";
}
@endphp --}}
</ul>
<div class="welcome px-3 px-md-4 py-4 py-md-5 text-center">
  <h3 class="title pb-md-3">¡Buenas tardes, {{user_data()->name}}!</h3>
</div>
<div class="row card-list row-medium">
  <div class="col-lg col-md-6 col-6 item created-ot">
    <div class="card card-stats">
      <div class="card-body">
        <div class="row align-items-center mb-3">
          <div class="col-7 col-md-8">
            <p class="card-subtitle text-left">Hoy</p>
          </div>
          <div class="text-right col-5 col-md-4 icon-small">
            <button class="btn my-0 p-1 text-muted"><i class="far fa-sync"></i></button>
          </div>
        </div>
        <div class="row">
          <div class="col-12 text-center">
            <p class="card-title numbers">{{$ots->count()}}</p>
            <p class="card-category"><br>OT Creadas</p>
          </div>
        </div>
      </div>
      <div class="card-footer text-center px-0">
        <hr>
        <div class="stats px-3">
          <i class="fa fa-clock-o"></i>
          Actualizado
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg col-md-6 col-6 item pending-ot">
    <div class="card card-stats">
      <div class="card-body">
        <div class="row align-items-center mb-3">
          <div class="col-7 col-md-8">
            <p class="card-subtitle text-left">Hoy</p>
          </div>
          <div class="text-right col-5 col-md-4 icon-small">
            <button class="btn my-0 p-1 text-muted"><i class="far fa-sync"></i></button>
          </div>
        </div>
        <div class="row">
          <div class="col-12 text-center">
            <p class="card-title numbers">8</p>
            <p class="card-category"><br>OT Pendientes</p>
          </div>
        </div>
      </div>
      <div class="card-footer text-center px-0">
        <hr>
        <div class="stats px-3">
          <i class="fa fa-clock-o"></i>
          Actualizado
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg col-md-6 col-6 item atended-ot">
    <div class="card card-stats">
      <div class="card-body">
        <div class="row align-items-center mb-3">
          <div class="col-7 col-md-8">
            <p class="card-subtitle text-left">Hoy</p>
          </div>
          <div class="text-right col-5 col-md-4 icon-small">
            <button class="btn my-0 p-1 text-muted"><i class="far fa-sync"></i></button>
          </div>
        </div>
        <div class="row">
          <div class="col-12 text-center">
            <p class="card-title numbers">12</p>
            <p class="card-category"><br>OT Atendidas</p>
          </div>
        </div>
      </div>
      <div class="card-footer text-center px-0">
        <hr>
        <div class="stats px-3">
          <i class="fa fa-clock-o"></i>
          Actualizado
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg col-md-6 col-6 item prom-ot">
    <div class="card card-stats">
      <div class="card-body">
        <div class="row align-items-center mb-3">
          <div class="col-7 col-md-8">
            <p class="card-subtitle text-left">Hoy</p>
          </div>
          <div class="text-right col-5 col-md-4 icon-small">
            <button class="btn my-0 p-1 text-muted"><i class="far fa-sync"></i></button>
          </div>
        </div>
        <div class="row">
          <div class="col-12 text-center">
            <p class="card-title numbers">68</p>
            <p class="card-category">OT <br>Promedio al Mes</p>
          </div>
        </div>
      </div>
      <div class="card-footer text-center px-0">
        <hr>
        <div class="stats px-3">
          <i class="fa fa-clock-o"></i>
          Actualizado
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg col-md-6 col-6 item personal-ot">
    <div class="card card-stats">
      <div class="card-body">
        <div class="row align-items-center mb-3">
          <div class="col-7 col-md-8">
            <p class="card-subtitle text-left">Hoy</p>
          </div>
          <div class="text-right col-5 col-md-4 icon-small">
            <button class="btn my-0 p-1 text-muted"><i class="far fa-sync"></i></button>
          </div>
        </div>
        <div class="row">
          <div class="col-12 text-center">
            <p class="card-title numbers">35</p>
            <p class="card-category">Personal <br>en Planta</p>
          </div>
        </div>
      </div>
      <div class="card-footer text-center px-0">
        <hr>
        <div class="stats px-3">
          <i class="fa fa-clock-o"></i>
          Actualizado
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-7">
    <div class="card card-ot-progress text-white">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title">Progreso de Órdenes de Trabajo</h5>
        <span class="buttons">
          <button class="btn p-2 text-muted m-0"><i class="fa fa-refresh align-middle"></i></button>
          <button class="btn p-2 text-muted m-0"><i class="fa fa-ellipsis-v align-middle"></i></button>
        </span>
      </div>
      <div class="card-body">
        <?php
        $ots = array(
          array(
            "title" => "Buenaventura",
            "number" => "09",
            "progress" => 2
          ),
          array(
            "title" => "Antamina",
            "number" => "05",
            "progress" => 1
          ),
          array(
            "title" => "Marcona",
            "number" => "09",
            "progress" => 3
          ),
          array(
            "title" => "Campo Verde",
            "number" => "09",
            "progress" => 4
          ),
          array(
            "title" => "Minsur",
            "number" => "14",
            "progress" => 4
          )
        )
        ?>
        <table class="table table-separate">
          <thead class="text-uppercase">
            <tr>
              <th>Empresa</th>
              <th class="text-center">N° O.T.</th>
              <th class="text-center">Progreso</th>
            </tr>
          </thead>
          <tbody>
            @foreach($ots as $ot)
            <tr>
              <td>{{$ot['title']}}</td>
              <td class="text-center">{{$ot['number']}}</td>
              <td class="text-center">
                <ul class="list-steps list-unstyled mb-0 step-{{$ot['progress']}}">
                  @for($i=1;$i<=4;$i++)
                  <li class="step step-{{$i}} {{$i <= $ot['progress'] ? 'step-active' : ''}}"></li>
                  @endfor
                </ul>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="col-md-5">
    <div class="card card-chart">
      <div class="card-header">
        <h5 class="card-title">Resumen de Progreso O.T.</h5>
      </div>
      <div class="card-body">
        <canvas id="chartjs" class="chartjs" width="770" height="385"></canvas>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="card resumen-card text-white">
      <div class="card-header">
        <h5 class="card-title mb-0 mt-1">Órdenes de Trabajo</h5>
        <p class="text-white">Resumen de los últimos meses</p>
      </div>
      <div class="card-body">
        <canvas id="chart-resumen" width="392" height="256" class="chartjs-render-monitor"></canvas>
      </div>
    </div>
  </div>
</div>
@endsection
@section('javascript')
<script>
  Chart.pluginService.register({
  beforeRender: function (chart) {
    if (chart.config.options.showAllTooltips) {
        // create an array of tooltips
        // we can't use the chart tooltip because there is only one tooltip per chart
        chart.pluginTooltips = [];
        chart.config.data.datasets.forEach(function (dataset, i) {
            chart.getDatasetMeta(i).data.forEach(function (sector, j) {
                chart.pluginTooltips.push(new Chart.Tooltip({
                    _chart: chart.chart,
                    _chartInstance: chart,
                    _data: chart.data,
                    _options: chart.options.tooltips,
                    _active: [sector]
                }, chart));
            });
        });

        // turn off normal tooltips
        chart.options.tooltips.enabled = false;
    }
},
  afterDraw: function (chart, easing) {
    if (chart.config.options.showAllTooltips) {
        // we don't want the permanent tooltips to animate, so don't do anything till the animation runs atleast once
        if (!chart.allTooltipsOnce) {
            if (easing !== 1)
                return;
            chart.allTooltipsOnce = true;
        }

        // turn on tooltips
        chart.options.tooltips.enabled = true;
        Chart.helpers.each(chart.pluginTooltips, function (tooltip) {
            tooltip.initialize();
            tooltip.update();
            // we don't actually need this since we are not animating tooltips
            tooltip.pivot();
            tooltip.transition(easing).draw();
        });
        chart.options.tooltips.enabled = false;
    }
  }
});

  new Chart(document.getElementById("chartjs"), {
    "type":"doughnut",
    "data":{
      "labels": [
        "O.T. Pendientes",
        "O.T. Atendidas",
        "O.T. Creadas",
        "O.T."
      ],
      "datasets":[{
        "label":"Resumen de Progreso",
        "data":[
          100,
          150,
          120,
          50
        ],
        "backgroundColor":[
          "#e96115",
          "#10d428",
          "#417bff",
          "#ffb701"
        ]
      }]
    },
    options: {
      "legend": {
        "position": 'bottom',
        horizontalAlign: "left",
      },
      title: {
        //display: true,
        text: "Resumen",
      },
    }
  });
  var resumen = document.getElementById("chart-resumen");
  new Chart(resumen, {
    type: 'line',
    data: {
      labels: ["ENE","FEB","MAR","ABR","MAY","JUN","JUL","AGO","SEP","OCT","NOV","DIC"],
      datasets: [{
        label: "OT",
        backgroundColor: '#6ae6fe',
        borderColor: '#01416f',
        fill: "start",  //no fill here
        data: [65, 35, 45, 50, 15, 35, 42, 38, 33, 39, 25, 27],
        display: true,
      }]
    },
    options: {
      showAllTooltips: true,
      tooltips: {
        backgroundColor: 'transparent',
        enabled: true,
        bodyFontColor: '#6ae6fe',
        //displayColors: false,
        //titleFontSize: 0
        yAlign: 'bottom' 
      },
      title: {
        //display: true,
        fontColor: '#6ae6fe',
        text: 'Resumen',
      },
      legend: {
        labels: {
          // This more specific font property overrides the global property
          fontColor: '#6ae6fe'
        }
      },
        maintainAspectRatio: false,
        spanGaps: false,
        elements: {
            line: {
                tension: 0.000001
            }
        },
        plugins: {
            filler: {
                propagate: false
            }
        },
        scales: {
            xAxes: [{
                ticks: {
                    autoSkip: false,
                    fontColor: '#6ae6fe'
                }
            }],
            yAxes: [{
                ticks: {
                  display: false,
                  autoSkip: false,
                  fontColor: '#6ae6fe'
                }
            }]
        }
    }
});
</script>
@endsection