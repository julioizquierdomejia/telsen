<style type="text/css">
  .comments {
    width: 100%;
    max-width: 280px;
    position: fixed;
    right: 0;
    bottom: 0;
    max-height: 80%;
    z-index: 99999;
  }
  .comments .btn {
    text-transform: none;
  }
  #collapseComments {
    background-color: #e5ddd5;
    /*max-height: calc(100% - 32px);*/
    height: 100%;
  }
  .comments .collapse.show {
    min-height: 250px;
  }
  table.comments_dt {
    background-color: transparent;
    /*border-radius: 7px;*/
    box-sizing: border-box;
    font-size: 12px;
    padding: 15px 1rem;
    width: 100% !important;
  }
    table.comments_dt,
    table.comments_dt tbody,
    table.comments_dt tr,
    table.comments_dt td {
      display: block;
  }

  /*--[  This does the job of making the table rows appear as comments_dt ]----------------*/
  .dataTable.comments_dt tbody tr {
    background-color: white;
    border-radius: 7px;
    box-shadow: 0 1px 0.5px #b9b9b9;
    margin: 5px 0;
    padding: 6px 10px;
    width: 90%;
  }
  .dataTable.comments_dt tbody td {
    border: 0;
      width: 100%;
      overflow: hidden;
      padding: 0;
      text-align: left;
  }
  .comments_dt .c-date {
    font-size: 10px;
    margin-top: -3px;
  }
  .dataTable.comments_dt tbody tr:before {
    content: '';
    font-family: "Font Awesome 5 Pro";
    font-weight: 900;
    font-size: 22px;
    line-height: 20px;
    position: absolute;
    top: 0;
  }
  .dataTable.comments_dt tbody .row-me {
    background-color: #dcf8c6;
    border-top-right-radius: 0;
    margin-left: auto;
  }
  .dataTable.comments_dt tbody .row-me:before {
    color: #dcf8c6;
    right: -4px;
    top: -7px;
    content: "\F0DA";
    transform: rotate(-135deg);
  }
  .dataTable.comments_dt tbody .row-me + .row-me:before {
    display: none;
  }
  .dataTable.comments_dt tbody .row-other {
    border-top-left-radius: 0;
  }
  .dataTable.comments_dt tbody .row-other:before {
    color: #fff;
    left: -4px;
    top: -8px;
    content: "\F0D9";
    transform: rotate(135deg);
  }
  .comments .table-responsive {
    max-height: 300px;
    max-height: 73%;
    max-height: calc(100% - 32px - 86px);
    height: 100%;
  }

  #frmComment {
    position: relative;
  }
  #ot_comment {
    resize: none;
  }
  #btnComment {
    box-shadow: none;
    font-size: 18px;
    position: absolute;
    right: 5px;
    top: 50%;
    margin-top: -22px !important;
  }

  /*---[ The remaining is just more dressing to fit my preferances ]-----------------*/
  .table {
      background-color: #fff;
  }
  .table tbody label {
      display: none;
      margin-right: 5px;
      width: 50px;
  }

  .comments_dt tbody label {
      display: inline;
      position: relative;
      font-size: 85%;
      font-weight: normal;
      top: -5px;
      left: -3px;
      float: left;
      color: #808080;
  }
  .comments_dt tbody td:nth-child(1) {
      text-align: center;
  }
</style>
<div class="comments border">
    <button class="py-2 px-3 btn btn-block btn-dark m-0 collapsed" data-toggle="collapse" data-target="#collapseComments" type="button"><i class="far fa-comments pr-2"></i> Comentarios de OT-{{$ot->code}}</button>
    <div class="collapse" id="collapseComments">
    <div class="table-responsive pb-0">
      <table class="table comments_dt" id="commentsTD">
      <thead class="d-none">
        <tr>
          <th>ID</th>
          <th>Usuario</th>
          <th>UD</th>
          <th>Comentario</th>
          <th>Fecha</th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>
    </div>
    <div class="comment p-3 bg-light">
      <form class="frm" id="frmComment" method="POST" action="{{ route('ordenes.comment.store', ['orden' => $ot->id]) }}">
        @csrf
        <textarea class="form-control mt-0 rounded-pill pr-4 pl-3" id="ot_comment" placeholder="Comentario" name="comment"></textarea>
        <button class="btn m-0" id="btnComment" type="submit" style="min-width: 0"><i class="far fa-paper-plane"></i></button>
      </form>
    </div>
    </div>
</div>
<script type="text/javascript">
  function toElement(focus) {
    var element = $(".comments .table-responsive");
    setTimeout(function () {
      element.animate({ scrollTop: element[0].scrollHeight }, 50);
      if(focus) {
        $('#ot_comment').focus()
      }
    }, 100)
  }
  $(document).ready(function () {
    dLanguage.sEmptyTable = "No hay comentarios aún.";
    var commentsTD = $('#commentsTD').DataTable({
      processing: true,
      serverSide: true,
      ajax: "{{route('ordenes.comments', ['orden'=>$ot->id])}}",
      pageLength: 5000,
      lengthMenu: [ 5, 25, 50 ],
      'sDom': 't',
      searching: false,
      columns: [
            { data: 'id', class: 'd-none' },
            { data: 'user', class: 'text-primary' },
            { data: 'user_id', class: 'd-none' },
            { data: 'comment', class: 'text-left comment' },
            { data: 'created_at', class: 'text-right c-date text-muted' },
        ],
        "createdRow": function( row, data, dataIndex){
          //console.log(data)
            if( data.user_id == {{auth()->id()}}){
              $(row).addClass('row-me');
            } else {
              $(row).addClass('row-other');
            }
          },
         columnDefs: [
          { orderable: false, targets: 2 },
        ],
        order: [[ 0, "desc" ]],
        language: dLanguage
      });

    $(document).on("submit", "#frmComment", function(event) {
      event.preventDefault();
      var form = $(this);
        var url = form.attr('action');
      $.ajax({
            type: "post",
            url: url,
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function (data) {
              $('#ot_comment').val('');
              commentsTD.ajax.reload(toElement(), false);
            },
            complete: function (event) {
              
            },
            error: function (request, status, error) {
              
            }
        });
    })

    /*setInterval(function (event) {
      commentsTD.ajax.reload(toElement(), false);
      toElement()
    }, 2000)*/

    $('#collapseComments').on('shown.bs.collapse', function () {
      $('.comments').addClass('h-100');
      toElement(true)
    })
    $('#collapseComments').on('hidden.bs.collapse', function () {
      $('.comments').removeClass('h-100');
    })
  })
</script>