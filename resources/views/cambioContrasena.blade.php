@extends('dashboard')

@section('title', 'Cambio de contraseña')

@section('content')

	<div class="container-fluid">
		<div class="page-header">
	       <h1>Cambio de contraseña</h1>      
	    </div>
        <div class="row">
            <form class="form-horizontal" action="{{ action('UsuarioController@attemptCambioContrasena') }}" method="post">
                <div class="form-group">
                  <label class="control-label col-sm-2" for="nombre">Nombre:</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="nombre" value=" {{ $nombre or ''}} " placeholder="Nombre" name="nombre" readonly>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" for="email">Email:</label>
                  <div class="col-sm-6">
                    <input type="email" class="form-control" id="email" value="{{ $email or '' }}" placeholder="Email" name="email" readonly>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" for="password_actual">Password actual:</label>
                  <div class="col-sm-6">          
                    <input type="password" class="form-control" id="password_actual" placeholder="Password Actual" name="password_actual">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" for="password_nuevo">Password nuevo:</label>
                  <div class="col-sm-6">          
                    <input type="password" class="form-control" id="password_nuevo" placeholder="Password Nuevo" name="password_nuevo">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" for="password_confirmar">Confirmar password:</label>
                  <div class="col-sm-6">          
                    <input type="password" class="form-control" id="password_confirmar" placeholder="Confirmar Password" name="password_confirmar">
                  </div>
                </div>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">        
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default">Enviar</button>
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