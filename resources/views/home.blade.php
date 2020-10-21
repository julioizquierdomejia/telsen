@extends('layouts.app')

@section('content')

    <div class="row">
      <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
          <div class="card-body ">
            <div class="row">
              <div class="col-5 col-md-4">
                <div class="icon-big text-center icon-warning">
                  <i class="fal fa-user-md-chat text-warning"></i>
                </div>
              </div>
              <div class="col-7 col-md-8">
                <div class="numbers">
                  <p class="card-category">Usuarios Gestor</p>
                  <p class="card-title">12<p>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer ">
            <hr>
            <div class="stats">
              <i class="fa fa-refresh"></i>
              Actualizado
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
          <div class="card-body ">
            <div class="row">
              <div class="col-5 col-md-4">
                <div class="icon-big text-center icon-warning">
                  <i class="fal fa-user-graduate text-success"></i>
                </div>
              </div>
              <div class="col-7 col-md-8">
                <div class="numbers">
                  <p class="card-category">Usuarios Moodle</p>
                  <p class="card-title">12<p>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer ">
            <hr>
            <div class="stats">
              <i class="fa fa-calendar-o"></i>
              Actualizado desde Moodle
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
          <div class="card-body ">
            <div class="row">
              <div class="col-5 col-md-4">
                <div class="icon-big text-center icon-warning">
                  <i class="fal fa-journal-whills text-danger"></i>
                </div>
              </div>
              <div class="col-7 col-md-8">
                <div class="numbers">
                  <p class="card-category">Cursos</p>
                  <p class="card-title">12<p>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer ">
            <hr>
            <div class="stats">
              <i class="fa fa-clock-o"></i>
              Actualizado desde Moodle
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
          <div class="card-body ">
            <div class="row">
              <div class="col-5 col-md-4">
                <div class="icon-big text-center icon-warning">
                  <i class="fal fa-file-certificate text-primary"></i>
                </div>
              </div>
              <div class="col-7 col-md-8">
                <div class="numbers">
                  <p class="card-category">Certificados Emitidos</p>
                  <p class="card-title">69<p>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer ">
            <hr>
            <div class="stats">
              <i class="fa fa-refresh"></i>
              Actualizado desde el gestor
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-4">
        <div class="card ">
          <div class="card-header ">
            <h5 class="card-title">Situación Global</h5>
            <p class="card-category">Status de los participantes</p>
          </div>
          <div class="card-body ">
            <canvas id="chartEmail"></canvas>
          </div>
          <div class="card-footer ">
            <div class="legend">
              <i class="fa fa-circle text-primary"></i> Inscritos
              <i class="fa fa-circle text-warning"></i> Estudiantes
              <i class="fa fa-circle text-danger"></i> Aprobados
              <i class="fa fa-circle text-gray"></i> Desaprobados
            </div>
            <hr>
            <div class="stats">
              <i class="fa fa-calendar"></i> Number of emails sent
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-8">
        <div class="card card-chart">
          <div class="card-header">
            <h5 class="card-title">Estudiantes en el tiempo</h5>
            <p class="card-category">Cantidad de añumnos que han llevado cursos con #aspefam</p>
          </div>
          <div class="card-body">
            <canvas id="speedChart" width="400" height="100"></canvas>
          </div>
          <div class="card-footer">
            <div class="chart-legend">
              <i class="fa fa-circle text-info"></i> Programa Tinku
              <i class="fa fa-circle text-warning"></i> Otros Programas
            </div>
            <hr />
            <div class="card-stats">
              <i class="fa fa-check"></i> Información Certificada
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="card ">
          <div class="card-header ">
            <h5 class="card-title">Users Behavior</h5>
            <p class="card-category">24 Hours performance</p>
          </div>
          <div class="card-body ">
            <canvas id=chartHours width="400" height="100"></canvas>
          </div>
          <div class="card-footer ">
            <hr>
            <div class="stats">
              <i class="fa fa-history"></i> Updated 3 minutes ago
            </div>
          </div>
        </div>
      </div>
    </div>

@endsection
