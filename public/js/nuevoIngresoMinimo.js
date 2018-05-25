$(document).ready(function() {
	$('#item-nuevo-ingreso-minimo').addClass('active');
    $('#item-nuevo-ingreso-minimo').click(function(e) {
    	e.preventDefault();
    });
  	$('#submenu-becas').addClass('in');

  	$('#dependientesMaximos').val(4);

	var calcularIngresoMinimo = function() {
		var ingresoPerCapita = parseFloat($('#ingresoPerCapita').val());
		var dependientesMaximos = parseInt($('#dependientesMaximos').val());
		var ingresoMinimoPorPersona = ingresoPerCapita / dependientesMaximos;
		if(!isNaN(ingresoMinimoPorPersona)) {
			$('#ingresoMinimoPorPersona').val(ingresoMinimoPorPersona);
		}
	};

	$('#ingresoPerCapita').keyup(calcularIngresoMinimo);
	$('#dependientesMaximos').keyup(calcularIngresoMinimo);

	$('#modalConfirmar').on('show.bs.modal', function(e) {
    	$('#modIpc').text($('#ingresoPerCapita').val());
    	$('#modDepMax').text($('#dependientesMaximos').val());
    	$('#modImp').text($('#ingresoMinimoPorPersona').val());

        $('#btnAceptar').unbind('click').click(function (e) {
            $.ajax({
 			    url: '/ingresoMinimo/insert',	
                type: 'POST',
                data : {
                	ingreso_minimo_por_persona: $('#ingresoMinimoPorPersona').val(),
                	dependientes_maximos: $('#dependientesMaximos').val(),
                	_token: $('#_token').val()
                },
                success: function() {
                	$('#modalConfirmar').modal('hide');
                	$('#modalMessage #message').removeClass('alert-danger');
                    $('#modalMessage #message').addClass('alert-success');
                    $('#modalMessage #message').html('Se ha agregado correctamente el nuevo Ingreso Mínimo');
                    $('#modalMessage').modal('show');
                },
                error: function() {
                	$('#modalConfirmar').modal('hide');
                	$('#modalMessage #message').removeClass('alert-success');
                    $('#modalMessage #message').addClass('alert-danger');
                    $('#modalMessage #message').html('No fue posible ingresar el nuevo Ingreso Mínimo');
                    $('#modalMessage').modal('show');
                }
            });
        });
    });

});