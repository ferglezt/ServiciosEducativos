@extends('dashboard')

@section('title', 'Editar Solicitud')

@section('content')

  <script type="text/javascript">
    $(document).ready(function() {
      $('#fecha_recibido').datepicker({
        dateFormat: 'dd/mm/yy'
      });

    });
  </script>

  <div class="container-fluid">

      <div class="page-header">
        <h1>Editar Solicitud</h1>      
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

          <form class="form-horizontal" action="{{ action('SolicitudController@attemptEdicionSolicitud') }}" method="post">
              
              <div id="datos-estudiante">
                <div class="form-group">
                  <label class="control-label col-sm-2" for="boleta">Boleta:</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="boleta" value="{{ $estudiante->boleta }}" placeholder="Boleta" name="boleta">
                  </div>
                  <div id="warningBoleta"></div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" for="nombre">Nombre:</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="nombre" value="{{ $estudiante->nombre }}" placeholder="Nombre" name="nombre">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" for="carrera">Carrera:</label>
                  <div class="col-sm-6">
                    <select class="form-control" id="carrera" name="carrera">
                      @foreach($carreras as $carrera)
                        <option value="{{ $carrera->id }}"
                          @if($estudiante->carrera_id == $carrera->id)
                            selected
                          @endif
                          >{{ $carrera->nombre }}</option>
                      @endforeach  
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" for="curp">CURP:</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="curp" value="{{ $estudiante->curp }}" placeholder="CURP" name="curp">
                  </div>
                  <div id="warningCurp"></div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" for="email">E-mail:</label>
                  <div class="col-sm-6">
                    <input type="email" class="form-control" id="email" value="{{ $estudiante->email }}" placeholder="E-mail" name="email">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" for="telefono">Teléfono:</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="telefono" value="{{ $estudiante->telefono }}" placeholder="Teléfono" name="telefono">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" for="Género">Género:</label>
                  <div class="col-sm-6">
                    <select class="form-control" id="genero" name="genero">
                        <option value="M" 
                          @if(strcasecmp($estudiante->genero, 'M') == 0)
                            selected
                          @endif 
                        >Masculino</option>
                        <option value="F" 
                          @if(strcasecmp($estudiante->genero, 'F') == 0)
                            selected
                          @endif 
                        >Femenino</option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" for="Oriundo">Oriundo:</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="oriundo" value="{{ $estudiante->oriundo }}" placeholder="Oriundo" name="oriundo">
                  </div>
                </div>
              </div>

              <hr />

              <div class="form-group">
                <label class="control-label col-sm-2" for="folio">Año:</label>
                <div class="col-sm-6">
                  <select class="form-control" id="anio" name="anio">
                    @for($i = 2010; $i < 2030; $i++)
                      <option value="{{ $i }}" 
                        @if($solicitud->anio == $i)
                          selected
                        @endif 
                      >{{ $i }}</option>
                    @endfor
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2" for="periodo_id">Periodo:</label>
                <div class="col-sm-6">
                  <select class="form-control" id="periodo_id" name="periodo_id">
                    @foreach($periodos as $p)
                      <option value="{{ $p->id }}"

                        @if($solicitud->periodo_id == $p->id)
                            selected
                        @endif

                        >{{ $p->anio . ' - ' . $p->periodo }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2" for="folio">Folio:</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" name="folio" value="{{ $solicitud->folio }}" id="folio" placeholder="Folio">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2" for="etiqueta">Etiqueta:</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" name="etiqueta" value="{{ $solicitud->etiqueta }}" id="etiqueta" placeholder="Etiqueta">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2" for="semestre">Semestre:</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" name="semestre" value="{{ $solicitud->semestre }}" id="semestre" placeholder="Semestre">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2" for="promedio">Promedio:</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" name="promedio" value="{{ number_format((float)$solicitud->promedio, 2, '.', '') }}" id="promedio" placeholder="Promedio">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2" for="estatus_estudiante">Estatus Académico:</label>
                <div class="col-sm-6">
                  <select id="estatus_estudiante" name="estatus_estudiante" class="form-control">
                    <option value="REGULAR" 
                      @if(strcasecmp($solicitud->estatus_estudiante, 'REGULAR') == 0)
                        selected
                      @endif 
                    >REGULAR</option>
                    <option value="IRREGULAR" 
                       @if(strcasecmp($solicitud->estatus_estudiante, 'IRREGULAR') == 0)
                        selected
                      @endif 
                    >IRREGULAR</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2" for="carga">Carga:</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" name="carga" value="{{ $solicitud->carga }}" id="carga" placeholder="Carga">
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-6 col-sm-offset-1">
                  <div id="warningCarga">
                
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2" for="estatus_becario">Estatus Becario:</label>
                <div class="col-sm-6">
                  <select id="estatus_becario" name="estatus_becario" class="form-control">
                    <option value="ASPIRANTE" 
                      @if(strcasecmp($solicitud->estatus_becario, 'ASPIRANTE') == 0)
                        selected
                      @endif 
                    >ASPIRANTE</option>
                    <option value="REVALIDANTE" 
                      @if(strcasecmp($solicitud->estatus_becario, 'REVALIDANTE') == 0)
                        selected
                      @endif 
                    >REVALIDANTE</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2" for="beca_anterior">Beca Anterior:</label>
                <div class="col-sm-6">
                  <input type="text" id="beca_anterior" name="beca_anterior" value="{{ $solicitud->beca_anterior }}" placeholder="Beca Anterior" class="form-control"> 
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2" for="beca_solicitada">Beca Solicitada</label>
                <div class="col-sm-6">
                  <input type="text" name="beca_solicitada" value="{{ $solicitud->beca_solicitada }}" id="beca_solicitada" class="form-control" placeholder="Beca Solicitada">
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-6 col-sm-offset-1">
                  <div id="warningBeca">
                
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2" for="folio_manutencion">Folio Manutención:</label>
                <div class="col-sm-6">
                  <input type="text" id="folio_manutencion" value="{{ $solicitud->folio_manutencion }}" name="folio_manutencion" placeholder="Folio Manutención" class="form-control"> 
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2" for="folio_transporte">Folio Transporte:</label>
                <div class="col-sm-6">
                  <input type="text" id="folio_manutencion" value="{{ $solicitud->folio_transporte }}" name="folio_transporte" placeholder="Folio Transporte" class="form-control"> 
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2" for="comprobante_ingresos">Tipo de Comprobante de Ingresos:</label>
                <div class="col-sm-6">
                  <input type="text" id="comprobante_ingresos" value="{{ $solicitud->comprobante_ingresos }}" name="comprobante_ingresos" placeholder="Comprobante de Ingresos" class="form-control"> 
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2" for="mapa">Mapa:</label>
                <div class="col-sm-6">
                  <input type="text" id="mapa" name="mapa" value="{{ $solicitud->mapa }}" placeholder="Mapa" class="form-control"> 
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2" for="fecha_recibido">Fecha Recibido:</label>
                <div class="col-sm-6">
                  <input type="text" id="fecha_recibido" value="{{ $solicitud->fecha_recibido }}" name="fecha_recibido" placeholder="Fecha Recibido" class="form-control"> 
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2" for="ingresos">Ingresos:</label>
                <div class="col-sm-6">
                  <input type="text" id="ingresos" value="{{ number_format((float)$solicitud->ingresos, 2, '.', '') }}" name="ingresos" placeholder="Ingresos" class="form-control"> 
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2" for="dependientes">Dependientes:</label>
                <div class="col-sm-6">
                  <input type="text" id="dependientes" value="{{ $solicitud->dependientes }}" name="dependientes" placeholder="Dependientes" class="form-control"> 
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-6 col-sm-offset-1">
                  <div id="warningIngresos">
                
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2" for="observaciones">Observaciones:</label>
                <div class="col-sm-6">
                  <input type="text" id="observaciones" value="{{ $solicitud->observaciones }}" name="observaciones" placeholder="Observaciones" class="form-control"> 
                </div>
              </div>
              <input type="hidden" name="estudiante_id" id="estudiante_id" value="{{ $estudiante->id }}">
              <input type="hidden" name="solicitud_id" id="solicitud_id" value="{{ $solicitud->id }}">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <div class="form-group">        
                <div class="col-sm-offset-2 col-sm-10">
                  <button id="submit" type="submit" class="btn btn-default">Guardar</button>
                </div>
              </div>
          </form>

      </div>
  </div>

@stop
