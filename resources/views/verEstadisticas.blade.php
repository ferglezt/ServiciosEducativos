@extends('dashboard')

@section('title', 'Estadísticas')

@section('content')

	<script type="text/javascript" src="{{ URL::to('/') }}/js/verEstadisticas.js"></script>

	<div class="container-fluid">

      <div class="page-header">
        <h1>Estadísticas</h1>      
      </div>

      <div class="row">
      	<div class="col-md-4">
      	  <div class="form-group">
      			<label for="periodo">Periodo:</label>
      			<select class="form-control" id="periodo" name="periodo">
              <option value="0">Seleccionar periodo</option>
              @foreach($periodos as $p)
                <option value="{{ $p->id }}">{{ $p->anio . ' - ' . $p->periodo }}</option>
              @endforeach
            </select>
		      </div>
      	</div>
      </div>

      <div class="row">
        <h4>Solicitadas</h4>
      </div>
      <div class="row">
        <div class="col-md-8">
          <table id="solicitadasTable" class="cell-border" width="100%">
          	<thead>
          	  <th>Pendientes</th>
          	  <th>Aceptados</th>
              <th>Lista de Espera</th>
              <th>Rechazados</th>
              <th>Total</th>
          	</thead>
          	<tbody>
          	</tbody>
          </table>	
        </div>
      </div>

      <div class="row">
        <h4>Por beca</h4>
      </div>
      <div class="row">
        <div class="col-md-12">
          <table id="porBecaTable" class="cell-border" width="100%">
            <thead>
              <th>Beca Solicitada</th>
              <th>Pendientes</th>
              <th>Aceptados</th>
              <th>Lista de Espera</th>
              <th>Rechazados</th>
              <th>Total</th>
            </thead>
            <tbody>
            </tbody>
          </table>  
        </div>
      </div>

      <div class="row">
        <h4>Por Género</h4>
      </div>
      <div class="row">
        <div class="col-md-8">
          <table id="porGeneroTable" class="cell-border" width="100%">
            <thead>
              <th>Hombres</th>
              <th>Mujeres</th>
              <th>Total</th>
            </thead>
            <tbody>
            </tbody>
          </table>  
        </div>
      </div>

      <div class="row">
        <h4>Transporte</h4>
      </div>
      <div class="row">
        <div class="col-md-8">
          <table id="transporteTable" class="cell-border" width="100%">
            <thead>
              <th>Institucional</th>
              <th>Manutención</th>
            </thead>
            <tbody>
            </tbody>
          </table>  
        </div>
      </div>


  	</div>

@stop