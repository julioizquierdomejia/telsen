@extends('layouts.app', ['body_class' => 'users', 'title' => 'Usuarios'])
@section('content')
<div class="row">
  <div class="col">
    <a href="{{route('users.create')}}" class="btn btn-primary">Crear Usuario</a>
  </div>
  <div class="col-md-12">
    <div class="card form-card">
      <div class="card-header">
        <h4 class="card-title">Usuarios</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-separate data-table">
            <thead class=" text-primary">
              <th class="text-nowrap">#</th>
              <th class="text-nowrap">Nombre</th>
              <th class="text-nowrap">Apellidos</th>
              <th class="text-center">Rol</th>
              <th class="text-center">Area</th>
              <th class="text-center">Email</th>
              <th class="text-center">Estado</th>
              <th class="text-center">Acciones</th>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" tabindex="-1" id="modalUser">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Activar usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <p class="body-title mb-0 py-3">¿Seguro desea <span class="user-state">activar</span> el usuario "<strong></strong>"?</p>
      </div>
      <div class="modal-footer justify-content-center">
        <button class="btn btn-secondary" data-dismiss="modal" type="button">Cancelar</button>
        <button class="btn btn-primary btn-delete-confirm" type="button" data-userid="" data-status="1">Confirmar</button>
      </div>
    </div>
  </div>
</div>
@endsection
@section('javascript')
<script>
$(document).ready(function() {
    var dtable = $('.data-table').DataTable({
         processing: true,
         serverSide: true,
         ajax: "{{route('users.list')}}",
         pageLength: 5,
         lengthMenu: [ 5, 25, 50 ],
         //ordering: true,
         columns: [
            { data: 'id' },
            { data: 'name', class: 'user_name' },
            { data: 'lastname' },
            { data: 'role', orderable: false },
            { data: 'area' },
            { data: 'email' },
            { data: 'enabled' },
            { data: 'tools', class: 'text-nowrap', orderable: false}
        ],
        language: dLanguage
      });
    $(document).on("click", ".btn-mdelete", function(event) {
      var $this = $(this), state = $this.data('state');
      if(state == 0) {
        $('.modal-title').text('Desactivar usuario');
        $('.user-state').text('desactivar usuario');
      } else {
        $('.modal-title').text('Activar usuario');
        $('.user-state').text('activar usuario');
      }
        $('#modalUser .body-title strong').text($this.parents('tr').find('.user_name').text());
        $('.btn-delete-confirm').data('userid', $this.data('userid'));
        $('.btn-delete-confirm').data('status', state);
    })

    $('.btn-delete-confirm').click(function(event) {
        event.preventDefault();
        var btn = $(this);
        if (btn.data('userid').length == 0) {
            return;
        }
        $.ajax({
            type: "post",
            url: "/users/" + btn.data('userid') + "/cambiarstatus",
            data: {
                _token: '{{csrf_token()}}',
                status: btn.data('status')
            },
            beforeSend: function(data) {

            },
            success: function(response) {
                if (response.success) {
                    var data = $.parseJSON(response.data);
                    $('#modalUser').modal('hide');
                    dtable.ajax.reload();
                }
            },
            error: function(request, status, error) {
                var data = jQuery.parseJSON(request.responseText);
                console.log(data);
            }
        });
    })
});
</script>
@endsection