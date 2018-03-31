$(document).ready(function() {
  $('#item-alta-servicio-social').addClass('active');
  $('#item-alta-servicio-social').click(function(e) {
    e.preventDefault();
  });
  $('#submenu-servicio-social').addClass('in');

  $('#fecha_recepcion').datepicker({
    dateFormat: 'dd/mm/yy'
  });

  $('#consecutivo').val('IPN/O2M503/3S.8/');

  $('#consecutivo').keyup(function() {

    var current = $(this).val().replace('IPN/O2M503/3S.8/', '');

    if(!current.includes('IPN'))
      $(this).val('IPN/O2M503/3S.8/' + current);
    else
      $(this).val('IPN/O2M503/3S.8/');
  });
});