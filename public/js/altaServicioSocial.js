$(document).ready(function() {
  $('#item-alta-servicio-social').addClass('active');
  $('#item-alta-servicio-social').click(function(e) {
    e.preventDefault();
  });
  $('#submenu-servicio-social').addClass('in');

  $('#fecha_recepcion').datepicker({
    dateFormat: 'dd/mm/yy'
  });

  $('#periodo_inicio').datepicker({
    dateFormat: 'dd/mm/yy'
  });

  $('#periodo_fin').datepicker({
    dateFormat: 'dd/mm/yy'
  });

  $('#registro').keyup(function() {
    $('#warningRegistro').empty();
    $('#warningRegistro').removeClass();
  });

  $('#registro').focusout(function() {
    $.ajax({
      url: '/servicioSocial/findByRegistro/' + $('#registro').val(),
      success: function(result,status,xhr) {
        $('#warningRegistro').addClass('alert alert-danger');
        $('#warningRegistro').html('Este registro ya existe a nombre de ' + result.nombre);
      }
    });
  });

});