$(document).ready(function() {

  $('#item-ver-becas').addClass('active');

  $('#item-ver-becas').click(function(e) {
    e.preventDefault();
  });

  $('#submenu-becas').addClass('in');

  var becasTable = $('#becasTable').DataTable({
    "language": {
        "lengthMenu": "Mostrando _MENU_ registros por página",
        "zeroRecords": "No se encontraron registros",
        "info": "Mostrando página _PAGE_ de _PAGES_",
        "infoEmpty": "No hay registros disponibles",
        "infoFiltered": "(de _MAX_ registros totales)",
        "search": "Buscar",
        "paginate": {
          "previous": "Anterior",
          "next": "Siguiente"
        }
    }
  });

  $('.becaActiva').change(function() {
    //TODO
  });

  $('#modalNuevaBeca').on('show.bs.modal', function(e) {
    $('#modalNuevaBeca #nombreBeca').val('');

    $('#modalNuevaBeca #btnAceptar').unbind('click').click(function(e) {

      if($('#modalNuevaBeca #nombreBeca').val() == '') {
        $('#modalNuevaBeca').modal('hide');
        $('#modalMessage #message').removeClass('alert-success');
        $('#modalMessage #message').addClass('alert-danger');
        $('#modalMessage #message').html('Debe seleccionar un nombre para la beca');
        $('#modalMessage').modal('show');
        return;
      }

      $.ajax({
          url: '/attemptAltaBeca',
          type: 'POST',
          data: {
            'nombre': $('#modalNuevaBeca #nombreBeca').val(),
            '_token': $('#_token').val()
          },
          success: function(result,status,xhr) {
            window.location.reload(true);
          },
          statusCode: {
            404: function() {
              $('#modalNuevaBeca').modal('hide');
              $('#modalMessage #message').removeClass('alert-success');
              $('#modalMessage #message').addClass('alert-danger');
              $('#modalMessage #message').html('Dirección no encontrada');
              $('#modalMessage').modal('show');
            },
            500: function() {
              $('#modalNuevaBeca').modal('hide');
              $('#modalMessage #message').removeClass('alert-success');
              $('#modalMessage #message').addClass('alert-danger');
              $('#modalMessage #message').html('No pudo darse de alta la beca por un error de servidor:');
              $('#modalMessage').modal('show');
            },
            401: function() {
              $('#modalNuevaBeca').modal('hide');
              $('#modalMessage #message').removeClass('alert-success');
              $('#modalMessage #message').addClass('alert-danger');
              $('#modalMessage #message').html('No tiene permisos para realizar esta acción. Contacte al administrador');
              $('#modalMessage').modal('show');
            }
          }
      });
    });
  });

  $('#modalBorrar').on('show.bs.modal', function(e) {
    var id = e.relatedTarget.dataset.idbeca;
    var nombre = e.relatedTarget.dataset.nombrebeca;

    $('#modalBorrar #nombreBeca').text(nombre);
    
    $('#borrarBeca').unbind('click').click(function(e) { 
      $(this).attr('disabled', 'disabled');
      $.ajax({
          url: '/eliminarBeca/' + id,
          type: 'POST',
          data: {
            '_token': $('#_token').val()
          },
          success: function(result,status,xhr) {
            window.location.reload(true);
          },
          statusCode: {
            404: function() {
              $('#modalBorrar').modal('hide');
              $('#modalMessage #message').removeClass('alert-success');
              $('#modalMessage #message').addClass('alert-danger');
              $('#modalMessage #message').html('No pudo eliminarse la beca porque no fue encontrada');
              $('#modalMessage').modal('show');
            },
            500: function() {
              $('#modalBorrar').modal('hide');
              $('#modalMessage #message').removeClass('alert-success');
              $('#modalMessage #message').addClass('alert-danger');
              $('#modalMessage #message').html('No pudo eliminarse la beca por un error de servidor:');
              $('#modalMessage').modal('show');
            },
            401: function() {
              $('#modalBorrar').modal('hide');
              $('#modalMessage #message').removeClass('alert-success');
              $('#modalMessage #message').addClass('alert-danger');
              $('#modalMessage #message').html('No tiene permisos para realizar esta acción. Contacte al administrador');
              $('#modalMessage').modal('show');
            }
          }
      });
    });
  });

});