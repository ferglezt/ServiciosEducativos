$(document).ready(function() {

  $('#item-ver-capturistas').addClass('active');

  $('#item-ver-capturistas').click(function(e) {
    e.preventDefault();
  });

  $('#submenu-capturistas').addClass('in');

  var capturistasTable = $('#capturistasTable').DataTable({
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

  $('#modalEditar').on('show.bs.modal', function(e) {
    var nombreCapturista = e.relatedTarget.dataset.nombrecapturista;
    var emailCapturista = e.relatedTarget.dataset.emailcapturista;
    var idCapturista = e.relatedTarget.dataset.idcapturista;
    var rolId = e.relatedTarget.dataset.rolid;

    $('#modalEditar #nombreCapturista').val(nombreCapturista);
    $('#modalEditar #emailCapturista').val(emailCapturista);
    $('#modalEditar #rol').val(rolId);
    $('#guardarCapturista').removeAttr('disabled');

    $('#guardarCapturista').unbind('click').click(function(e) {
      $(this).attr('disabled', 'disabled');
      $.ajax({
        url: '/editarCapturista/' + idCapturista,
        type: 'POST',
        data: {
          nombre: $('#modalEditar #nombreCapturista').val(),
          email: $('#modalEditar #emailCapturista').val(),
          rol_id: $('#modalEditar #rol option:selected').val(),
          _token: $('#modalEditar #_token').val()
        },
        success: function() {
          location.reload();
        },
        error: function() {
          $('#modalEditar').modal('hide');
          $('#message').removeClass('alert-success');
          $('#message').addClass('alert-danger');
          $('#message').html('No fue posible actualizar la información del capturista');
          $('#modalMessage').modal('show');
        }
      });
    });

  });

  $('#modalNuevaContrasena').on('show.bs.modal', function(e) {
    var emailCapturista = e.relatedTarget.dataset.emailcapturista;
    var idCapturista = e.relatedTarget.dataset.idcapturista;

    $('#modalNuevaContrasena #emailCapturista').text(emailCapturista);
    $('#modalNuevaContrasena #password').val('');

    $('#guardarContrasena').unbind('click').click(function(e) {
      $.ajax({
        url: '/cambiarContrasenaCapturista/' + idCapturista,
        type: 'POST',
        data: {
          '_token' : $('#modalNuevaContrasena #_token').val(),
          'password': $('#modalNuevaContrasena #password').val()
        },
        success: function() {
          $('#modalNuevaContrasena').modal('hide');
          $('#message').removeClass('alert-danger');
          $('#message').addClass('alert-success');
          $('#message').html('Se actualizó correctamente la contraseña de ' + emailCapturista);
          $('#modalMessage').modal('show');
        },
        error: function(xhr,status,error) {
          $('#modalNuevaContrasena').modal('hide');
          $('#message').removeClass('alert-success');
          $('#message').addClass('alert-danger');
          $('#message').html('La contraseña no pudo actualizarse correctamente');
          $('#modalMessage').modal('show');
        }
      });   
    });
  });

  $('#modalBorrar').on('show.bs.modal', function(e) {
    var nombreCapturista = e.relatedTarget.dataset.nombrecapturista;
    var idCapturista = e.relatedTarget.dataset.idcapturista;
    $('#modalBorrar #nombreCapturista').text(nombreCapturista);
    
    $('#borrarCapturista').unbind('click').click(function(e) { 
      $.ajax({
        url: '/borrarCapturista/' + idCapturista,
        type: 'GET',
        success: function() {
          $('#modalBorrar').modal('hide');
          capturistasTable.row($('#tr-id-' + idCapturista)).remove().draw();
          $('#message').removeClass('alert-danger');
          $('#message').addClass('alert-success');
          $('#message').html('Se ha borrado al capturista ' + nombreCapturista);
          $('#modalMessage').modal('show');
        },
        error: function() {
          $('#modalBorrar').modal('hide');
          $('#message').removeClass('alert-success');
          $('#message').addClass('alert-danger');
          $('#message').html('No fue posible borrar al capturista ' + nombreCapturista);
          $('#modalMessage').modal('show');
        } 
      });
    });
  });

});