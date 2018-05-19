$(document).ready(function() {

  $('#item-alta-solicitud').addClass('active');
  $('#item-alta-solicitud').click(function(e) {
    e.preventDefault();
  });
  $('#submenu-becas').addClass('in');

  $('#fecha_recibido').datepicker({
    dateFormat: 'dd/mm/yy'
  });

  $('#fecha_recibido').datepicker('setDate', new Date());

  $('#dependientes, #ingresos').keyup(function() {
    $('#warningIngresos').removeClass(); 
    $('#warningIngresos').empty();
  });

  $('#seccionFolio').hide();

  $('#btnIngresarFolioManual').click(function() {
    var isFolioVisible = $('#seccionFolio').is(':visible');
    if(isFolioVisible) {
      $('#seccionFolio').hide(300);
      $(this).removeClass('btn-success');
      $(this).addClass('btn-info');
      $(this).val('Ingresar Manualmente');
      $('#folio').val('');
      $('#warningFolio').removeClass();
      $('#warningFolio').empty();
    } else {
      $('#seccionFolio').show(300);
      $(this).removeClass('btn-info');
      $(this).addClass('btn-success');
      $(this).val('Regresar a Autoincrementable');
    }
  });

  $('#carga').keyup(function() {
    $('#warningCarga').removeClass(); 
    $('#warningCarga').empty();
  });

  $('#etiqueta').val('IPN/O2M503/3S.8/');

  $('#etiqueta').keyup(function() {
    var current = $(this).val().replace('IPN/O2M503/3S.8/', '');

    if(!current.includes('IPN'))
      $(this).val('IPN/O2M503/3S.8/' + current);
    else
      $(this).val('IPN/O2M503/3S.8/');
  });

  var findSolicitud = function() {
    $('#warningFolio').removeClass();
    $('#warningFolio').empty();

    $.ajax({
      url: '/findSolicitud?periodo=' + $('#periodo_id').val() + '&folio=' + $('#folio').val(),
      success: function(result,status,xhr) {
        $('#warningFolio').addClass('alert alert-danger');
        $('#warningFolio').html('Esta solicitud ya ha sido dada de alta a nombre de ' + result.estudiante.nombre + ' ' + result.estudiante.boleta);
      }
    });
  };

  $('#folio').focusout(function () {
    findSolicitud();
  });

  $('#folio').keyup(function() {
    if($('#folio').val() == '') {
      $('#warningFolio').removeClass();
      $('#warningFolio').empty();
    }
  });

  $('#periodo_id').change(function() {
    findSolicitud();
  });

  var validarBeca = function() {
    $('#warningBeca').removeClass();
    $('#warningBeca').empty();

    var promedio = parseFloat($('#promedio').val());
    var carga = parseInt($('#carga').val());
    var carrera = $('#carrera').val();
    var semestre = parseInt($('#semestre').val());
    var beca = $('#beca_id option:selected').text();
    var estatus = $('#estatus_estudiante').val();

    if(isNaN(promedio) || isNaN(carga) || isNaN(semestre)) {
      $('#warningBeca').addClass('alert alert-danger');
      $('#warningBeca').html('El promedio, la carga y el semestre deben ser datos numéricos');
      return;
    }

    $.ajax({
      url: '/findCarreraConCargas/' + carrera,
      success: function(result,status,xhr) {
        if(beca == 'MANUTENCION') {
          if(estatus == 'IRREGULAR') {
              $('#warningBeca').addClass('alert alert-danger');
              $('#warningBeca').html('Para solicitar Manutención es necesario' +
                          ' ser alumno regular');
          } else if(semestre >= 5) {
            if(carga < result.carga_media) {
              $('#warningBeca').addClass('alert alert-danger');
              $('#warningBeca').html('Para solicitar Manutención es necesario tener' +
                          ' inscrita la carga media de materias después de 5to semestre');
            } else if(promedio < 8.0) {
              $('#warningBeca').addClass('alert alert-danger');
              $('#warningBeca').html('Para solicitar Manutención es necesario tener' +
                          ' promedio mayor a 8.0 después de 5to semestre');
            } 
          }
        }

        if(beca == 'INSTITUCIONAL') {
          if(promedio >= 6.0 && promedio <= 7.99) {
            $('#warningBeca').addClass('alert alert-info');
            $('#warningBeca').html('Promedio: ' + promedio + '. Tipo A');
            $('#tipo_institucional').val('A');
          } else if(promedio >= 8.0 && promedio <= 9.49) {
            $('#warningBeca').addClass('alert alert-info');
            $('#warningBeca').html('Promedio: ' + promedio + '. Tipo B');
            $('#tipo_institucional').val('B');
          } else if(promedio >= 9.5 && promedio <= 10.0) {
            $('#warningBeca').addClass('alert alert-info');
            $('#warningBeca').html('Promedio: ' + promedio + '. Tipo C');
            $('#tipo_institucional').val('C');
          } else {
            $('#warningBeca').addClass('alert alert-danger');
            $('#warningBeca').html('Promedio fuera de rango: ' + promedio);
            $('#tipo_institucional').val('');
          }
        }
      }
    });
  };

  var verificarCargaMedia = function() {
    $('#warningCarga').removeClass(); 
    $('#warningCarga').empty();

    var carrera = $('#carrera').val();
    var carga = parseInt($('#carga').val());

    if(!isNaN(carrera) && !isNaN(carga)) {
      $.ajax({
        url: '/findCarga/' + carrera,
        success: function(result,status,xhr) {
          if(carga < result.carga_media && carga > result.carga_minima && carga < result.carga_maxima) {
            $('#warningCarga').addClass('alert alert-danger');
            $('#warningCarga').html('La carga de materias es menor a la carga media (' + 
              result.carga_media + ') de la carrera');
          } else if(carga < result.carga_minima) {
            $('#warningCarga').addClass('alert alert-danger');
            $('#warningCarga').html('La carga de materias es menor a la carga mínima (' + 
              result.carga_minima + ') de la carrera');
          } else if(carga > result.carga_maxima) {
            $('#warningCarga').addClass('alert alert-danger');
            $('#warningCarga').html('La carga de materias es mayor a la carga máxima (' + 
              result.carga_maxima + ') de la carrera');
          }
        }
      });
    }
  };

  $('#carga').focusout(verificarCargaMedia);
  $('#carrera').change(verificarCargaMedia);

  $('#carga').focusout(validarBeca);
  $('#carrera').change(validarBeca);
  $('#semestre').focusout(validarBeca);
  $('#beca_id').change(validarBeca);
  $('#promedio').focusout(validarBeca);
  $('#estatus_estudiante').change(validarBeca);


  $('#dependientes, #ingresos').focusout(function() {
    $('#warningIngresos').removeClass(); 
    $('#warningIngresos').empty();
    
    var ingresos = parseFloat($('#ingresos').val());
    var dependientes = parseInt($('#dependientes').val());
    var ingresoMinimo = parseFloat($('#ingreso_minimo').val());
    
    var res = ingresos / dependientes / ingresoMinimo;

    if(!isNaN(res)) {
      res = res.toFixed(1);
      if(res > 4.0) {
        $('#warningIngresos').addClass('alert alert-danger');
        $('#warningIngresos').html('Los ingresos sobrepasan el límite establecido: ' + res);
      } else {
        $('#warningIngresos').addClass('alert alert-success');
        $('#warningIngresos').html('Los ingresos están dentro de los límites: ' + res);
      }
    }
  });

  $('#boleta').keyup(function() {
    $('#warningBoleta').removeClass();
    $('#warningBoleta').empty();
    $('#nombre').val(null);
    $('#carrera').val(null);
    $('#curp').val(null);
    $('#email').val(null);
    $('#telefono').val(null);
    $('#oriundo').val(null);
    $('#genero').val(null);
    $('#estudiante_id').val(null);
  });

  $('#boleta').focusout(function() {
    $('#warningBoleta').removeClass();
    $('#warningBoleta').empty();
    $.ajax({
      url: '/findBoleta/' + $(this).val(),
      success: function(result,status,xhr) {
        $('#warningBoleta').addClass('alert alert-success col-sm-3');
        $('#warningBoleta').html('Estudiante encontrado');
        $('#nombre').val(result.nombre);
        $('#carrera').val(result.carrera_id);
        $('#curp').val(result.curp);
        $('#email').val(result.email);
        $('#telefono').val(result.telefono);
        $('#oriundo').val(result.oriundo);
        $('#genero').val(result.genero);
        $('#estudiante_id').val(result.id);

        $('html, body').animate({
          scrollTop: $("#oriundo").offset().top
        }, 1000);
      }
    });
  });

});