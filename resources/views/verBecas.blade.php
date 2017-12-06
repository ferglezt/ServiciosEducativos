@extends('dashboard')

@section('title', 'Ver Capturistas')

@section('content')

	<script src="{{ URL::to('/') }}/js/verBecas.js"></script>

	<div class="container-fluid">

      <div class="page-header">
        <h1>Becas</h1>      
      </div>

      <div class="row">
        <div class="col-md-10">
          <table id="becasTable" class="table-bordered">
            <thead>
              <tr>
                <th>Beca</th>
                <th>Activa</th>
                <th>Eliminar</th>
              </tr>
            </thead>
            <tbody>
              @foreach($becas as $beca)
                <tr>
                  <td>{{ $beca->nombre }}</td>
                  <td>
                    <select class="becaActiva">
                      <option value="1" 
                        @if ($beca->activa == 1)
                          selected
                        @endif
                      >Activa</option>
                      <option value="0" 
                        @if ($beca->activa == 0)
                          selected
                        @endif
                      >Inactiva</option>
                    </select>
                  </td>
                  <td><button class="btn btn-xs btn-link" data-toggle="modal" data-target="#modalBorrar" data-idbeca="{{ $beca->id }}" data-nombrebeca="{{ $beca->nombre }}">Eliminar</button></td>
                </tr>
              @endforeach
            </tbody>
            <tfoot>
              <tr>
                <td></td>
                <td></td>
                <td><button class="btn btn-sm btn-success" id="nuevaBeca">Nueva Beca</button></td>
              </tr>
            </tfoot>
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
              <h4 class="modal-title">¿Seguro que desea borrar a esta beca?</h4>
            </div>
            <div class="modal-body">
              <p id="nombreBeca"></p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-info" data-dismiss="modal">Cancelar</button>
              <button id="borrarBeca" type="button" class="btn btn-danger">Borrar</button>
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

      <input type="hidden" id="_token" value="{{ csrf_token() }}">

  </div>

@stop
