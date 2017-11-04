@extends('dashboard')

@section('title', 'Ver Capturistas')

@section('content')

	<script type="text/javascript">
    $(document).ready(function() {

      $('#menucapturistas, #item-ver-capturistas').addClass('active');

      $('#item-ver-capturistas').click(function(e) {
        e.preventDefault();
      });

      var capturistasTable = $('#capturistasTable').DataTable({
        "language": {
            "lengthMenu": "Mostrando _MENU_ registros por página",
            "zeroRecords": "No se encontraron registros",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(de _MAX_ registros totales)",
            "search": "Buscar",
            "paginate": {
              "previous": "Anterior",
              "next": "Siguiente"
            }
        }
      });


      $('#modalBorrar').on('show.bs.modal', function(e) {
        var nombreCapturista = e.relatedTarget.dataset.nombrecapturista;
        var idCapturista = e.relatedTarget.dataset.idcapturista;
        $('#modalBorrar #nombreCapturista').text(nombreCapturista);
        
        $('#borrarCapturista').unbind('click').click(function(e) { 
          $.ajax({
            url: '/borrarCapturista/' + idCapturista,
            success: function() {
              $('#modalBorrar').modal('hide');
              capturistasTable.row($('#tr-id-' + idCapturista)).remove().draw();
            },
            error: function() {
              $('#modalBorrar').modal('hide');
              alert("Error: capturista no encontrado");
            } 
          });
        });
      });
    });
	
	</script>

	<div class="container-fluid">

      <div class="page-header">
        <h1>Capturistas</h1>      
      </div>

      <div class="row">
        <div class="col-md-10">
          <table id="capturistasTable" class="table-bordered">
            <thead>
              <tr>
                <th>Nombre</th>
                <th>E-mail</th>
                <th>Rol</th>
                <th></th>
                <th></th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @foreach($capturistas as $capturista)
                <tr id="{{'tr-id-'.$capturista->id}}">
                  <td>{{ $capturista->nombre }}</td>
                  <td>{{ $capturista->email }}</td>
                  <td>{{ $capturista->rol->nombre}}</td>
                  <td><button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalEditar">Editar</button></td>
                  <td><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalBorrar" data-nombrecapturista="{{ $capturista->nombre }}" data-idcapturista={{ $capturista->id }}>Borrar</button></td>
                  <td><button type="button" class="btn btn-link" data-toggle="modal" data-target="#modalNuevaContrasena">Generar Nueva Contraseña</button></td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>

      <!-- Modal Borrar-->
      <div id="modalBorrar" class="modal fade" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">¿Seguro que desea borrar a este capturista?</h4>
            </div>
            <div class="modal-body">
              <p id="nombreCapturista"></p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-info" data-dismiss="modal">Cancelar</button>
              <button id="borrarCapturista" type="button" class="btn btn-danger">Borrar</button>
            </div>
          </div>

        </div>
      </div>

  </div>

@stop
