$(document).ready(function() {
	$('#item-ver-becas').addClass('active');

    $('#item-ver-becas').click(function(e) {
    	e.preventDefault();
    });

  	$('#submenu-becas').addClass('in');

    $('#hiddenButtonDiv').hide();

    var table = $('#becasTable').DataTable({
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

    var search = function() {
        $.ajax({
            url: '/searchSolicitud?anio=2017&q=' + $(this).val(),
            success: function(result,status,xhr) {
                var arr = result.map(function(obj) {
                    var hiddenButton = $('#hiddenButton').clone();
                    hiddenButton.removeClass();
                    hiddenButton.addClass('estatus-solicitud-btn btn btn-xs');
                    var btnClass = '';

                    switch(obj.estatus_solicitud) {
                        case 'ACEPTADO': btnClass = 'btn-success'; break;
                        case 'RECHAZADO': btnClass = 'btn-danger'; break;
                        case 'LISTA DE ESPERA': btnClass = 'btn-warning'; break;
                        default: btnClass = 'btn-info';
                    }

                    hiddenButton.addClass(btnClass);
                    hiddenButton.html(obj.estatus_solicitud);

                    return[
                        hiddenButton.get(0).outerHTML,
                        obj.folio,
                        obj.etiqueta,
                        obj.boleta,
                        obj.curp,
                        obj.genero,
                        obj.nombre,
                        obj.carrera,
                        obj.semestre,
                        obj.promedio,
                        obj.estatus_estudiante,
                        obj.carga,
                        obj.estatus_becario,
                        obj.beca_anterior,
                        obj.beca_solicitada,
                        obj.folio_manutencion,
                        obj.folio_transporte,
                        obj.mapa,
                        obj.fecha_recibido,
                        obj.comprobante_ingresos,
                        obj.ingresos,
                        obj.dependientes,
                        obj.oriundo,
                        obj.email,
                        obj.telefono,
                        obj.observaciones
                    ];
                });
                table.clear();
                table.rows.add(arr).draw();

            }
        });
    };

    $('#search').keyup(search);

    var toggleColumns = function() {
        $('.toggle-column').each(function() {
            var column = table.column($(this).attr('data-column'));
            column.visible($(this).is(':checked'));
        });
    };

    $('.toggle-column').change(function(e) {
        e.preventDefault();
        var column = table.column($(this).attr('data-column'));
        column.visible($(this).is(':checked'));
    });

    $('#selectAll').click(function(e) {
        e.preventDefault();
        $('.toggle-column').prop('checked', true);
        toggleColumns();
        
    });

    $('#deselectAll').click(function(e) {
        e.preventDefault();
        $('.toggle-column').prop('checked', false);
        toggleColumns();
    });
	
});