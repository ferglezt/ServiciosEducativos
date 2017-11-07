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
			<input type="text" class="form-control" id="search" placeholder="Nombre o Boleta">
		  </div>
      	</div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <table id="becasTable" class="table-bordered">
          	<thead>
          	  <th>Folio</th>
          	  <th>Etiqueta</th>
              <th>Boleta</th>
              <th>Curp</th>
              <th>Género</th>
              <th>Nombre</th>
              <th>Carrera</th>
              <th>Semestre</th>
              <th>Promedio</th>
              <th>Estatus Académico</th>
              <th>Carga</th>
              <th>Tipo Becario</th>
              <th>Beca Anterior</th>
              <th>Beca Solicitada</th>
              <th>Folio Manutención</th>
              <th>Folio Transporte</th>
              <th>Mapa</th>
              <th>Fecha Recibido</th>
              <th>Comprobante Oficial</th>
              <th>Ingresos</th>
              <th>Dependientes</th>
              <th>Oriundo</th>
              <th>Email</th>
              <th>Teléfono</th>
              <th>Observaciones</th>
          	</thead>
          	<tbody>
          	  
          	</tbody>
          </table>	
        </div>
      </div>

  	</div>

@stop