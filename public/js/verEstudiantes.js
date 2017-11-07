$(document).ready(function() {
	$('#item-ver-estudiantes').addClass('active');

    $('#item-ver-estudiantes').click(function(e) {
    	e.preventDefault();
    });

  	$('#submenu-estudiantes').addClass('in');


    var table = $('#estudiantesTable').DataTable({
    	"searching": false,
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

    $('#search').keyup(function() {
    	$.ajax({
    		url: '/searchEstudiante?q=' + $(this).val(),
    		success: function(result,status,xhr) {
    			var arr = result.map(function(obj) {
    				return[
    					obj.boleta,
    					obj.nombre,
    					obj.carrera
    				];
    			});
    			table.clear();
    			table.rows.add(arr).draw();

    		}
    	});
    });
	
});