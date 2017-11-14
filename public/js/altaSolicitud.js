$(document).ready(function() {

      $('#item-alta-solicitud').addClass('active');
      $('#item-alta-solicitud').click(function(e) {
        e.preventDefault();
      });
      $('#submenu-becas').addClass('in');

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