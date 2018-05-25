@extends('dashboard')

@section('title', 'Nuevo Ingreso Per Cápita')

@section('content')

<script type="text/javascript" src="{{ URL::to('/') }}/js/nuevoIngresoMinimo.js"></script>

<div class="container-fluid">

	<div class="page-header">
		<h1>Nuevo Ingreso Per Cápita</h1>      
	</div>

	<input type="hidden" id="_token" value="{{ csrf_token() }}">

	<form class="form-horizontal">
		<div class="form-group">
			<label class="control-label col-sm-2">Ingreso mínimo mensual per cápita:</label>
			<div class="col-sm-2">
				<input type="number" class="form-control" id="ingresoPerCapita" placeholder="Ingreso Per Cápita">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">Cantidad de salarios por hogar:</label>
			<div class="col-sm-2">
				<input type="number" class="form-control" id="dependientesMaximos" placeholder="Salarios por hogar" value="4">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">Factor de cálculo:</label>
			<div class="col-sm-2">
				<input type="number" class="form-control" id="ingresoMinimoPorPersona" placeholder="Factor de cálculo" disabled>
			</div>
		</div>
	</form>

	<div class="row">
		<div class="col-md-4">
			<button class="btn btn-success" id="guardar" data-toggle="modal" data-target="#modalConfirmar">Guardar</button>
		</div>
	</div>

	<div id="modalConfirmar" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">¿Seguro que desea guardar un nuevo Ingreso Mínimo?</h4>
				</div>
				<div class="modal-body">
					<p>Ingreso Mínimo Mensual Per Cápita: <span id="modIpc"></span></p>
					<p>Salarios Máximos por Hogar: <span id="modDepMax"></span></p>
					<p>Factor de Cáluclo: <span id="modImp"></span></p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
					<button id="btnAceptar" type="button" class="btn btn-default">Aceptar</button>
				</div>
			</div>
		</div>
	</div>

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
