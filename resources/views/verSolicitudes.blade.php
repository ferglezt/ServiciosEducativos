@extends('dashboard')

@section('title', 'Ver Solicitudes')

@section('content')

	<script type="text/javascript" src="{{ URL::to('/') }}/js/verSolicitudes.js"></script>

	<div class="container-fluid">

      <div class="page-header">
        <h3>Solicitudes</h3>      
      </div>

      <div class="row">
        <div class="col-sm-2">
          <div class="form-group">
            <label for="search">Periodo:</label>
            <select class="form-control" id="periodo" name="periodo">
              @foreach($periodos as $p)
                <option value="{{ $p->id }}"

                  @if(($p->anio == date('Y') + 1 && date('n') > 6 && $p->periodo == 1) ||
                      ($p->anio == date('Y') && date('n') <= 6 && $p->periodo == 2))
                      selected
                  @endif

                  >{{ $p->anio . ' - ' . $p->periodo }}</option>
              @endforeach
            </select>
          </div>
        </div>
      	<div class="col-md-8">
      	  <div class="form-group">
      			<label for="search">Buscar:</label>
            <div class="row">
              <div class="col-sm-6">
                <input type="text" class="form-control" id="search" placeholder="Nombre, Boleta o Folio">
              </div>
              <div class="col-sm-2">
                <button class="btn btn-default btn-md form-control" id="btnBuscar">Buscar</button>
              </div>
              
            </div>
      			
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

          @for($i = 0; $i < count($columnas); $i++)
            <label class="checkbox-inline"><input class="toggle-column" type="checkbox" data-column="{{ $i }}" checked>{{ $columnas[$i] }}</label>
          @endfor
        
        </div>
      </div>

      <br>

      <div class="row">
        <div class="col-md-12">
          <table id="becasTable" class="cell-border" width="100%" style="font-size: 12px;">
          	<thead>
          	  @foreach($columnas as $c)
                <th>{{ $c }}</th>
              @endforeach
          	</thead>
          	<tbody>
          	  
          	</tbody>
          </table>	
        </div>
      </div>

      <div id="hiddenDiv">
        <button id="hiddenButton"></button>
        <button id="editarHiddenButton"></button>
        <div id="hiddenMessage"></div>
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
              <input type="hidden" id="_token" value="{{ csrf_token() }}">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
              <button id="btnCambioEstatus" type="button" class="btn btn-default">Aceptar</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal Cambio estatus-->
      <div id="modalEliminar" class="modal fade" role="dialog">
        <div class="modal-dialog">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Eliminar Solicitud</h4>
            </div>
            <div class="modal-body">
              <p>¿Desea eliminar la solicitud con folio <span id="folio"></span> y etiqueta <span id="etiqueta"></span>?</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
              <button id="btnEliminar" type="button" class="btn btn-danger">Aceptar</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal Éxito-->
      <div id="modalMessage" class="modal fade" role="dialog">
        <div class="modal-dialog">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Éxito</h4>
            </div>
            <div id="message" class="modal-body alert">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-info" data-dismiss="modal">Aceptar</button>
            </div>
          </div>
        </div>
      </div>

  	</div>

@stop