$(document).ready(function() {

      $('#item-alta-solicitud').addClass('active');
      $('#item-alta-solicitud').click(function(e) {
        e.preventDefault();
      });
      $('#submenu-becas').addClass('in');

      $('#dependientes, #ingresos').keyup(function() {
        $('#warningIngresos').removeClass(); 
        $('#warningIngresos').empty();
      });

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