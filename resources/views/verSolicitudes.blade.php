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
        <div class="col-md-1">
          <label>Filtros:</label>
        </div>
        <div class="col-md-11">
          @foreach($columnas as $c)
            <label class="checkbox-inline"><input class="toggle-column" type="checkbox" data-column="{{ $c->data_column }}" checked>{{ $c->nombre }}</label>
          @endforeach
        </div>
      </div>

      <br>

      <div class="row">
        <div class="col-md-12">
          <table id="becasTable" class="table-bordered">
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

  	</div>

@stop