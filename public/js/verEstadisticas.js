$(document).ready(function() {
	$('#item-ver-estadisticas').addClass('active');
    $('#item-ver-estadisticas').click(function(e) {
    	e.preventDefault();
    });
  	$('#submenu-becas').addClass('in');

  	var solicitadasTable = $('#solicitadasTable').DataTable({
    	"searching": false,
        "scrollX": true,
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

    var porBecaTable = $('#porBecaTable').DataTable({
    	"searching": false,
        "scrollX": true,
        "order": [[ 5, "desc" ]],
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

    var porGeneroTable = $('#porGeneroTable').DataTable({
    	"searching": false,
        "scrollX": true,
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

    var transporteTable = $('#transporteTable').DataTable({
    	"searching": false,
        "scrollX": true,
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

    $('#periodo').change(function() {
    	$.ajax({
    		url: '/estadisticas/' + $(this).val(),
    		success: function(result,status,xhr) {
    			solicitadasTable.clear().draw();
    			porBecaTable.clear().draw();
    			porGeneroTable.clear().draw();
    			transporteTable.clear().draw();

    			if(result.solicitadas.length != 0 && result.solicitadas[0].total != 0) {
    				var solicitadas = result.solicitadas.map(function(obj) {
	    				return[
	    					obj.pendientes,
	    					obj.aceptados,
	    					obj.lista_de_espera,
	    					obj.rechazados,
	    					obj.total
	    				];
	    			});

	    			solicitadasTable.rows.add(solicitadas).draw();
    			}

    			if(result.porBeca.length != 0) {
    				var porBeca = result.porBeca.map(function(obj) {
	    				return[
	    					obj.beca_solicitada,
	    					obj.pendientes,
	    					obj.aceptados,
	    					obj.lista_de_espera,
	    					obj.rechazados,
	    					obj.total
	    				];
	    			});

	    			porBecaTable.rows.add(porBeca).draw();
    			}

    			if(result.porGenero.length != 0 && result.porGenero[0].total != 0) {
    				var porGenero = result.porGenero.map(function(obj) {
	    				return[
	    					obj.hombres,
	    					obj.mujeres,
	    					obj.total
	    				];
	    			});

	    			porGeneroTable.rows.add(porGenero).draw();
    			}

    			if(result.transporteManutencion.length != 0 && result.transporteInstitucional.length != 0) {
    				var becasTransporte = [
    					result.transporteInstitucional[0].total + '', 
    					result.transporteManutencion[0].total + ''
    				];

    				transporteTable.row.add(becasTransporte).draw();
    			}

    		}
    	});
    });

});