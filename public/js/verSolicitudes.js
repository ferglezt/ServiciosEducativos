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

    var search = function(query, periodo) {
        $.ajax({
            url: '/searchSolicitud?periodo=' + periodo + '&q=' + query,
            success: function(result,status,xhr) {
                var arr = result.map(function(obj) {
                    var hiddenButton = $('#hiddenButton').clone();
                    hiddenButton.removeClass();
                    hiddenButton.addClass('btn btn-xs');
                    var btnClass = '';

                    switch(obj.estatus_solicitud) {
                        case 'ACEPTADO': btnClass = 'btn-success'; break;
                        case 'RECHAZADO': btnClass = 'btn-danger'; break;
                        case 'LISTA DE ESPERA': btnClass = 'btn-warning'; break;
                        default: btnClass = 'btn-info';
                    }

                    hiddenButton.addClass(btnClass);
                    hiddenButton.html(obj.estatus_solicitud);
                    hiddenButton.attr('data-toggle', 'modal');
                    hiddenButton.attr('data-target', '#modalCambioEstatus');
                    hiddenButton.attr('data-id', obj.id);
                    hiddenButton.attr('data-nombre', obj.nombre);
                    hiddenButton.attr('data-estatus', obj.estatus_solicitud);

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

    $('#modalCambioEstatus').on('show.bs.modal', function(e) {
        var nombre = e.relatedTarget.dataset.nombre;
        var id = e.relatedTarget.dataset.id;
        var estatus = e.relatedTarget.dataset.estatus;

        $('#modalCambioEstatus #nombre').text(nombre);
        $('#modalCambioEstatus #estatus').val(estatus);
        $('#btnCambioEstatus').removeAttr('disabled');

        $('#btnCambioEstatus').unbind('click').click(function(e) { 
            $(this).attr('disabled', 'disabled');    
            $.ajax({
                url: '/updateEstatusSolicitud/' + id,
                type: 'POST',
                data: {
                    '_token': $('#modalCambioEstatus #_token').val(),
                    'estatus_solicitud': $('#modalCambioEstatus #estatus').val()
                },
                success: function(result,status,xhr) {
                    $('#modalCambioEstatus').modal('hide');
                    $('#modalMessage #message').removeClass('alert-danger');
                    $('#modalMessage #message').addClass('alert-success');
                    $('#modalMessage #message').html(
                        'Se ha actualizado el estatus de la solicitud con folio ' + result.folio +
                        ' a ' + result.estatus_solicitud
                    );
                    $('#modalMessage').modal('show');
                    search($('#search').val(), $('#periodo').val());

                },
                error: function() {
                    $('#modalCambioEstatus').modal('hide');
                    $('#modalMessage #message').removeClass('alert-success');
                    $('#modalMessage #message').addClass('alert-danger');
                    $('#modalMessage #message').html('No fue posible actualizar el estatus de la solicitud');
                    $('#modalMessage').modal('show');
                }
            });
        });
    });

    $('#search').keyup(function() {
        search($(this).val(), $('#periodo').val());
    });

    $('#periodo').change(function() {
        search($('#search').val(), $(this).val());
    });

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