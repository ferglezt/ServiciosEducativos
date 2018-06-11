@extends('dashboard')

@section('title', 'Registros Servicio Social')

@section('content')

<script type="text/javascript" src="{{ URL::to('/') }}/js/verSolicitudesServicioSocial.js"></script>

<div class="container-fluid">

  <input type="hidden" id="_token" value="{{ csrf_token() }}">

  <div class="page-header">
    <h3>Registros Servicio Social</h3>      
  </div>

  <div class="row">
   <div class="col-md-8">
     <div class="form-group">
       <label for="search">Buscar:</label>
       <div class="row">
        <div class="col-sm-6">
          <input type="text" class="form-control" id="search" placeholder="Nombre, Boleta o Registro">
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
    <table id="servicioSocialTable" class="cell-border" width="100%" style="font-size: 12px;">
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

<div id="modalEliminar" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">¿Desea eliminar este registro?</h4>
      </div>
      <div class="modal-body alert">
        <p>Registro: <span id="registro"></span></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" id="btnEliminar">Eliminar</button>
      </div>
    </div>
  </div>
</div>


</div>

@stop