@extends('dashboard')

@section('title', 'Ver Capturistas')

@section('content')

	<script src="{{ URL::to('/') }}/js/verCapturistas.js"></script>

	<div class="container-fluid">

      <div class="page-header">
        <h1>Capturistas</h1>      
      </div>

      <div class="row">
        <div class="col-md-10">
          <table id="capturistasTable" class="table-bordered">
            <thead>
              <tr>
                <th>Nombre</th>
                <th>E-mail</th>
                <th>Rol</th>
                <th></th>
                <th></th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @foreach($capturistas as $capturista)
                <tr id="{{'tr-id-'.$capturista->id}}">
                  <td>{{ $capturista->nombre }}</td>
                  <td>{{ $capturista->email }}</td>
                  <td>{{ $capturista->rol->nombre}}</td>
                  <td><button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalEditar" data-nombrecapturista="{{ $capturista->nombre }}" data-idcapturista={{ $capturista->id }} data-rolid="{{ $capturista->rol_id }}" data-emailcapturista="{{ $capturista->email }}">Editar</button></td>
                  <td><button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalBorrar" data-nombrecapturista="{{ $capturista->nombre }}" data-idcapturista={{ $capturista->id }}>Borrar</button></td>
                  <td><button type="button" class="btn btn-link btn-sm" data-toggle="modal" data-target="#modalNuevaContrasena" data-emailcapturista="{{ $capturista->email }}" data-idcapturista={{ $capturista->id }}>Generar Nueva Contraseña</button></td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>

      <!-- Modal Borrar-->
      <div id="modalBorrar" class="modal fade" role="dialog">
        <div class="modal-dialog">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">¿Seguro que desea borrar a este capturista?</h4>
            </div>
            <div class="modal-body">
              <p id="nombreCapturista"></p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-info" data-dismiss="modal">Cancelar</button>
              <button id="borrarCapturista" type="button" class="btn btn-danger">Borrar</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal Editar-->
      <div id="modalEditar" class="modal fade" role="dialog">
        <div class="modal-dialog">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Editar Capturista</h4>
            </div>
            <div class="modal-body">
              <label>Nombre:</label>
              <input type="text" id="nombreCapturista" class="form-control" placeholder="Nombre">
              <br>
              <label>E-mail:</label>
              <input type="text" id="emailCapturista" class="form-control" placeholder="E-mail">
              <br>
              <label>Rol</label>
              <select class="form-control" id="rol" name="rol">
                 @foreach($roles as $rol)
                    <option value="{{ $rol->id }}">{{ $rol->nombre }}</option>
                  @endforeach 
              </select>
              <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-info" data-dismiss="modal">Cancelar</button>
              <button id="guardarCapturista" type="button" class="btn btn-success">Guardar</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal Nueva Contraseña-->
      <div id="modalNuevaContrasena" class="modal fade" role="dialog">
        <div class="modal-dialog">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Generar Nueva Contraseña</h4>
            </div>
            <div class="modal-body">
              <label>Nuevo password para: <span id="emailCapturista"></span></label>
              <input type="password" id="password" class="form-control" placeholder="Password">
              <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-info" data-dismiss="modal">Cancelar</button>
              <button id="guardarContrasena" type="button" class="btn btn-success">Guardar</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal Éxito-->
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
