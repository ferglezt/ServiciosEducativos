@extends('dashboard')

@section('title', 'Alta Solicitud')

@section('content')

  <script type="text/javascript" src="{{ URL::to('/') }}/js/altaSolicitud.js"></script>

  <div class="container-fluid">

      <div class="page-header">
        <h1>Alta Solicitud</h1>      
      </div>

      <div class="row">
          @if(isset($error))
            <div class="row">
              <div class="alert alert-danger col-md-4">
                <strong>Error:</strong> {{ $error }}
              </div>
            </div>
          @endif

          @if(isset($successMessage))
            <div class="row">
              <div class="alert alert-success col-md-4">
                <strong>Operación exitosa</strong> {{ $successMessage }}
              </div>
            </div>
          @endif

          <form class="form-horizontal" action="{{ action('SolicitudController@attemptAltaSolicitud') }}" method="post">
              
              <div id="datos-estudiante">
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
              </div>

              <hr />

              <div class="form-group">
                <label class="control-label col-sm-2" for="folio">Año:</label>
                <div class="col-sm-6">
                  <select class="form-control" id="anio" name="anio">
                    @for($i = 2010; $i < 2030; $i++)
                      <option value="{{ $i }}" {{ $i == date('Y') ? 'selected' : '' }}>{{ $i }}</option>
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

                        @if(($p->anio == date('Y') + 1 && date('n') > 6 && $p->periodo == 1) ||
                            ($p->anio == date('Y') && date('n') <= 6 && $p->periodo == 2))
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
                  <input type="text" class="form-control" name="folio" id="folio" placeholder="Folio">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2" for="etiqueta">Etiqueta:</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" name="etiqueta" id="etiqueta" placeholder="Etiqueta">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2" for="semestre">Semestre:</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" name="semestre" id="semestre" placeholder="Semestre">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2" for="promedio">Promedio:</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" name="promedio" id="promedio" placeholder="Promedio">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2" for="estatus_estudiante">Estatus Académico:</label>
                <div class="col-sm-6">
                  <select id="estatus_estudiante" name="estatus_estudiante" class="form-control">
                    <option value="REGULAR">REGULAR</option>
                    <option value="IRREGULAR">IRREGULAR</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2" for="carga">Carga:</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" name="carga" id="carga" placeholder="Carga">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2" for="estatus_becario">Estatus Becario:</label>
                <div class="col-sm-6">
                  <select id="estatus_becario" name="estatus_becario" class="form-control">
                    <option value="ASPIRANTE">ASPIRANTE</option>
                    <option value="REVALIDANTE">REVALIDANTE</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2" for="beca_anterior">Beca Anterior:</label>
                <div class="col-sm-6">
                  <input type="text" id="beca_anterior" name="beca_anterior" placeholder="Beca Anterior" class="form-control"> 
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2" for="beca_solicitada">Beca Solicitada</label>
                <div class="col-sm-6">
                  <select id="beca_solicitada" name="beca_solicitada" class="form-control">
                    <option value="MANUTENCION">MANUTENCION</option>
                    <option value="REVALIDANTE">INSTITUCIONAL</option>
                    <option value="TELMEX">TELMEX</option>
                    <option value="BECALOS">BECALOS</option>
                    <option value="TRANSPORTE">TRANSPORTE</option>
                    <option value="MANUTENCION TRANSPORTE">MANUTENCION TRANSPORTE</option>
                    <option value="INCTITUCIONAL TRANSPORTE">INSTITUCIONAL TRANSPORTE</option>
                    <option value="BECALOS TRANSPORTE">BECALOS TRANSPORTE</option>
                    <option value="S/B">S/B</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2" for="folio_manutencion">Folio Manutención:</label>
                <div class="col-sm-6">
                  <input type="text" id="folio_manutencion" name="folio_manutencion" placeholder="Folio Manutención" class="form-control"> 
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2" for="folio_transporte">Folio Transporte:</label>
                <div class="col-sm-6">
                  <input type="text" id="folio_manutencion" name="folio_transporte" placeholder="Folio Transporte" class="form-control"> 
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2" for="comprobante_ingresos">Tipo de Comprobante de Ingresos:</label>
                <div class="col-sm-6">
                  <input type="text" id="comprobante_ingresos" name="comprobante_ingresos" placeholder="Comprobante de Ingresos" class="form-control"> 
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2" for="mapa">Mapa:</label>
                <div class="col-sm-6">
                  <input type="text" id="mapa" name="mapa" placeholder="Mapa" class="form-control"> 
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2" for="fecha_recibido">Fecha Recibido:</label>
                <div class="col-sm-6">
                  <input type="text" id="fecha_recibido" name="fecha_recibido" placeholder="Fecha Recibido" class="form-control"> 
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2" for="ingresos">Ingresos:</label>
                <div class="col-sm-6">
                  <input type="text" id="ingresos" name="ingresos" placeholder="Ingresos" class="form-control"> 
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2" for="dependientes">Dependientes:</label>
                <div class="col-sm-6">
                  <input type="text" id="dependientes" name="dependientes" placeholder="Dependientes" class="form-control"> 
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2" for="observaciones">Observaciones:</label>
                <div class="col-sm-6">
                  <input type="text" id="observaciones" name="observaciones" placeholder="Observaciones" class="form-control"> 
                </div>
              </div>
              <input type="hidden" name="estudiante_id" id="estudiante_id">
              <input type="hidden" name="ingreso_minimo" id="ingreso_minimo" value="{{ $ingreso_minimo->ingreso_minimo_por_persona }}">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <div class="form-group">        
                <div class="col-sm-offset-2 col-sm-10">
                  <button id="submit" type="submit" class="btn btn-default">Registrar</button>
                </div>
              </div>
          </form>

      </div>
  </div>

@stop
