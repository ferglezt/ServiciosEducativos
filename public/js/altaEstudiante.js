$(document).ready(function() {
  $('#item-alta-estudiante').addClass('active');
  $('#item-alta-estudiante').click(function(e) {
    e.preventDefault();
  });
  $('#submenu-estudiantes').addClass('in');

  $('#boleta').keyup(function() {
    $('#warningBoleta').removeClass();
    $('#warningBoleta').empty();
    $('#submit').removeAttr('disabled');
  });

  $('#curp').keyup(function() {
    $('#warningCurp').removeClass();
    $('#warningCurp').empty();
    $(this).val($(this).val().toUpperCase());
  });

  $('#boleta').focusout(function() {
    $('#warningBoleta').removeClass();
    $('#warningBoleta').empty();
    $('#submit').removeAttr('disabled');

    var boleta = $(this).val();

    if(!/^\d+$/.test(boleta)) {
      $('#warningBoleta').addClass('alert alert-danger col-sm-3');
      $('#warningBoleta').html('La boleta debe contener sólo valores numéricos');
      $('#submit').attr('disabled', 'disabled');
      return;
    }

    $.ajax({
      url: '/findBoleta/' + boleta,
      success: function() {
        $('#warningBoleta').addClass('alert alert-danger col-sm-3');
        $('#warningBoleta').html('Este estudiante ya ha sido dado de alta');
      }
    });
  });

  $('#curp').focusout(function() {
    $('#warningCurp').removeClass();
    $('#warningCurp').empty();

    var curp = $(this).val();

    $(this).val(curp.toUpperCase());

    if(curp.length != 18) {
      $('#warningCurp').addClass('alert alert-danger col-sm-3');
      $('#warningCurp').html('El CURP debe contener 18 carácteres');
    }  
  });

  $('#nombre').keyup(function() {
    $(this).val($(this).val().toUpperCase());
  });
});