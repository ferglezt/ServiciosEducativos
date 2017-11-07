@extends('dashboard')

@section('title', 'Alta Estudiante')

@section('content')

  <script type="text/javascript" src="{{ URL::to('/') }}/js/altaEstudiante.js"></script>

	<div class="container-fluid">

      <div class="page-header">
        <h1>Alta estudiante</h1>      
      </div>

      <div class="row">
          <form class="form-horizontal" action="{{ action('EstudianteController@attemptAltaEstudiante') }}" method="post">
              <div class="form-group">
                <label class="control-label col-sm-2" for="boleta">Boleta:</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="boleta" placeholder="Boleta" name="boleta">
                </div>
                <div id="warningBoleta"></div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2" for="nombre">Nombre:</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="nombre" placeholder="Nombre" name="nombre">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2" for="carrera">Carrera:</label>
                <div class="col-sm-6">
                  <select class="form-control" id="carrera" name="carrera">
                    @foreach($carreras as $carrera)
                      <option value="{{ $carrera->id }}">{{ $carrera->nombre }}</option>
                    @endforeach  
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2" for="curp">CURP:</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="curp" placeholder="CURP" name="curp">
                </div>
                <div id="warningCurp"></div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2" for="email">E-mail:</label>
                <div class="col-sm-6">
                  <input type="email" class="form-control" id="email" placeholder="E-mail" name="email">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2" for="telefono">Teléfono:</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="telefono" placeholder="Teléfono" name="telefono">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2" for="Género">Género:</label>
                <div class="col-sm-6">
                  <select class="form-control" id="genero" name="genero">
                      <option value="M">Masculino</option>
                      <option value="F">Femenino</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2" for="Oriundo">Oriundo:</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="oriundo" placeholder="Oriundo" name="oriundo">
                </div>
              </div>
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <div class="form-group">        
                <div class="col-sm-offset-2 col-sm-10">
                  <button id="submit" type="submit" class="btn btn-default">Registrar</button>
                </div>
              </div>
          </form>

          @if(isset($error))
              <div class="alert alert-danger col-md-4">
                <strong>Error:</strong> {{ $error }}
              </div>
          @endif

          @if(isset($successMessage))
              <div class="alert alert-success col-md-4">
                <strong>Operación exitosa</strong> {{ $successMessage }}
              </div>
          @endif

      </div>
  </div>

@stop
