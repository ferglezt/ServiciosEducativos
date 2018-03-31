@extends('dashboard')

@section('title', 'Alta Servicio Social')

@section('content')

  <script type="text/javascript" src="{{ URL::to('/') }}/js/altaServicioSocial.js"></script>

  <div class="container-fluid">

      <div class="page-header">
        <h1>Alta Servicio Social</h1>      
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

      </div>
  </div>

@stop
