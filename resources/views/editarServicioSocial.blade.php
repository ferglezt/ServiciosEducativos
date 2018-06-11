@extends('dashboard')

@section('title', 'Editar Servicio Social')

@section('content')

<div class="container-fluid">

  <div class="page-header">
    <h1>Editar Registro</h1>      
  </div>

  <div class="row">
    @if(isset($error))
    <div class="row">
      <div class="alert alert-danger col-md-4 col-md-offset-1">
        <strong>Error:</strong> {{ $error }}
      </div>
    </div>
    @endif

    @if(isset($successMessage))
    <div class="row">
      <div class="alert alert-success col-md-4 col-md-offset-1">
        <strong>Operación exitosa</strong> {{ $successMessage }}
      </div>
    </div>
    @endif

    <form class="form-horizontal" action="{{ action('ServicioSocialController@attemptEdit') }}" method="post">

      <input type="hidden" name="id" value="{{ $solicitud->id }}">

      <div class="form-group">
        <label class="control-label col-sm-2" for="registro">Registro:</label>
        <div class="col-sm-6">
          <input type="text" id="registro" name="registro" placeholder="Registro" class="form-control" value="{{ $solicitud->registro }}">
        </div>
      </div>
      <div id="warningRegistro"></div>
      <div class="form-group">
        <label class="control-label col-sm-2" for="consecutivo">Consecutivo:</label>
        <div class="col-sm-6">
          <input type="text" name="consecutivo" id="consecutivo" placeholder="Consecutivo" class="form-control" value="{{ $solicitud->consecutivo }}">
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-2" for="boleta">Boleta:</label>
        <div class="col-sm-6">
          <input type="text" name="boleta" placeholder="Boleta" class="form-control" value="{{ $solicitud->boleta }}">
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-2" for="nombre">Nombre:</label>
        <div class="col-sm-6">
          <input type="text" name="nombre" placeholder="Nombre" class="form-control" value="{{ $solicitud->nombre }}">
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-2" for="carrera">Carrera:</label>
        <div class="col-sm-3">
          <select class="form-control" id="carrera" name="carrera">
            @foreach($carreras as $carrera)
              <option value="{{ $carrera->id }}" 
                @if($solicitud->carrera_id == $carrera->id)
                  selected
                @endif
                >{{ $carrera->nombre }}</option>
            @endforeach  
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-2" for="genero">Género:</label>
        <div class="col-sm-2">
          <select class="form-control" id="genero" name="genero">
            <option value="M" 
              @if(strcasecmp($solicitud->genero, 'M') == 0)
                selected
              @endif
            >Masculino</option>
            <option value="F"
              @if(strcasecmp($solicitud->genero, 'F') == 0)
                selected
              @endif
            >Femenino</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-2" for="prestatario">Prestatario:</label>
        <div class="col-sm-6">
          <input type="text" name="prestatario" placeholder="Prestatario" class="form-control" value="{{ $solicitud->prestatario }}">
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-2" for="programa">Programa:</label>
        <div class="col-sm-6">
          <input type="text" name="programa" placeholder="Programa" class="form-control" value="{{ $solicitud->programa }}">
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-2" for="profesor">Profesor:</label>
        <div class="col-sm-6">
          <input type="text" name="profesor" placeholder="Profesor" class="form-control" value="{{ $solicitud->profesor }}">
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-2" for="periodo">Periodo:</label>
        <div class="col-sm-4">
          <input type="text" name="periodo" placeholder="Periodo" class="form-control" value="{{ $solicitud->periodo }}">
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-2" for="tipo_ss">Tipo Servicio Social:</label>
        <div class="col-sm-2">
          <input type="text" name="tipo_ss" value="{{ $solicitud->tipo_ss }}" class="form-control">
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-2" for="creditos">Créditos:</label>
        <div class="col-sm-3">
          <input type="number" name="creditos" placeholder="Créditos" class="form-control" value="{{ $solicitud->creditos }}">
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-2" for="horario">Horario:</label>
        <div class="col-sm-2">
          <input type="text" name="horario" placeholder="Horario" class="form-control" value="{{ $solicitud->horario }}">
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-2" for="fecha_recepcion">Fecha Recepción:</label>
        <div class="col-sm-6">
          <input type="text" id="fecha_recepcion" name="fecha_recepcion" placeholder="Fecha Recepción" class="form-control" value="{{ $solicitud->fecha_recepcion }}"> 
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-2" for="observaciones">Observaciones:</label>
        <div class="col-sm-6">
          <input type="text" id="observaciones" name="observaciones" placeholder="Observaciones" class="form-control" value="{{ $solicitud->observaciones }}"> 
        </div>
      </div>
      <div class="form-group">        
        <div class="col-sm-offset-2 col-sm-10">
          <button id="submit" type="submit" class="btn btn-default">Guardar</button>
        </div>
      </div>
      <input type="hidden" name="_token" value="{{ csrf_token() }}">

    </form>

  </div>
</div>

@stop
