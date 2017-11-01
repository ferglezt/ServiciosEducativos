@extends('dashboard')

@section('title', 'Alta Capturista')

@section('content')

	<script type="text/javascript">
		$('#menucapturistas, #item-alta-capturista').addClass('active');
		$('#item-alta-capturista').click(function(e) {
			e.preventDefault();
		});
	</script>

	<div class="container-fluid">
        <div class="row">
            <form class="form-horizontal" action="{{ action('CapturistaController@attemptAltaCapturista') }}" method="post">
                <div class="form-group">
                  <label class="control-label col-sm-2" for="nombre">Nombre:</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="nombre" placeholder="Nombre" name="nombre">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" for="email">Email:</label>
                  <div class="col-sm-6">
                    <input type="email" class="form-control" id="email" value="{{ $email or '' }}" placeholder="Email" name="email">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" for="password">Password provisional:</label>
                  <div class="col-sm-6">          
                    <input type="password" class="form-control" id="password" placeholder="Password" name="password">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" for="rol">Rol</label>
                  <div class="col-sm-6">
                    <select class="form-control" id="rol" name="rol">
                      <option value="0"></option>
                      @foreach($roles as $rol)
                        <option value="{{ $rol->id }}">{{ $rol->nombre }}</option>
                      @endforeach  
                    </select>
                  </div>
                </div>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">        
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default">Registrar</button>
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
