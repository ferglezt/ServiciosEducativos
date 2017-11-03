@extends('dashboard')

@section('title', 'Alta Capturista')

@section('content')

	<script type="text/javascript">
    $(document).ready(function() {
      $('#menucapturistas, #item-ver-capturistas').addClass('active');
      $('#item-ver-capturistas').click(function(e) {
        e.preventDefault();
      });
      $('#capturistasTable').DataTable({
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
                <th></th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @foreach($capturistas as $capturista)
                <tr>
                  <td>{{ $capturista->nombre }}</td>
                  <td>{{ $capturista->email }}</td>
                  <td>Editar</td>
                  <td>Borrar</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      
      </div>
      
  </div>

@stop
