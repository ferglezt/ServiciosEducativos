@extends('dashboard')

@section('title', 'Ver Estudiantes')

@section('content')

	<script type="text/javascript" src="{{ URL::to('/') }}/js/verEstudiantes.js"></script>

	<div class="container-fluid">

      <div class="page-header">
        <h1>Estudiantes</h1>      
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
          <table id="estudiantesTable" class="table-bordered">
          	<thead>
          	  <th>Boleta</th>
          	  <th>Nombre</th>
          	  <th>Carrera</th>
          	</thead>
          	<tbody>
          	  
          	</tbody>
          </table>	
        </div>
      </div>

  	</div>

@stop