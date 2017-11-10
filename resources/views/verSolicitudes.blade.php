@extends('dashboard')

@section('title', 'Ver Solicitudes')

@section('content')

	<script type="text/javascript" src="{{ URL::to('/') }}/js/verSolicitudes.js"></script>

	<div class="container-fluid">

      <div class="page-header">
        <h1>Solicitudes</h1>      
      </div>

      <div class="row">
      	<div class="col-md-4">
      	  <div class="form-group">
      			<label for="search">Buscar:</label>
      			<input type="text" class="form-control" id="search" placeholder="Nombre, Boleta o Folio">
      		</div>
      	</div>
      </div>

      <div class="row">
        <div class="col-md-1">
          <label>Columnas:</label>
        </div>
        <div class="col-sm-2">
          <button id="selectAll" type="button" class="btn btn-success btn-xs">Seleccionar todo</button>
        </div>
        <div class="col-sm-2">
          <button id="deselectAll" type="button" class="btn btn-danger btn-xs">Deseleccionar todo</button>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="col-md-12">
          @foreach($columnas as $c)
            <label class="checkbox-inline"><input class="toggle-column" type="checkbox" data-column="{{ $c->data_column }}" checked>{{ $c->nombre }}</label>
          @endforeach
        </div>
        </div>
      </div>

      <br>

      <div class="row">
        <div class="col-md-12">
          <table id="becasTable" class="cell-border" width="100%">
          	<thead>
          	  @foreach($columnas as $c)
                <th>{{ $c->nombre }}</th>
              @endforeach
          	</thead>
          	<tbody>
          	  
          	</tbody>
          </table>	
        </div>
      </div>

      <div id="hiddenButtonDiv">
        <button id="hiddenButton"></button>
      </div>

      <!-- Modal Cambio estatus-->
      <div id="modalCambioEstatus" class="modal fade" role="dialog">
        <div class="modal-dialog">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Cambiar el estatus de esta solicitud</h4>
            </div>
            <div class="modal-body">
              <p><strong>Estudiante: </strong><span id="nombre"></span></p>
              <select id="estatus" class="form-control">
                <option value='PENDIENTE'>PENDIENTE</option>
                <option value='ACEPTADO'>ACEPTADO</option>
                <option value='RECHAZADO'>RECHAZADO</option>
                <option value='LISTA DE ESPERA'>LISTA DE ESPERA</option>
              </select>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
              <button id="btnCambioEstatus" type="button" class="btn btn-default">Aceptar</button>
            </div>
          </div>
        </div>
      </div>

  	</div>

@stop