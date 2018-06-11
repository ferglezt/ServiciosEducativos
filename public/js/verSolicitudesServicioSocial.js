$(document).ready(function() {
    $('#item-ver-solicitudes-servicio-social').addClass('active');

    $('#item-ver-solicitudes-servicio-social').click(function(e) {
        e.preventDefault();
    });

    $('#submenu-servicio-social').addClass('in');

    var table = $('#servicioSocialTable').DataTable({
        "searching": false,
        "scrollX": true,
        "scrollY": "200px",
        "scrollCollapse": true,
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

    var commonErrorStatusCodes = {
        404: function() {
            $('#modalMessage #message').removeClass('alert-success');
            $('#modalMessage #message').addClass('alert-danger');
            $('#modalMessage #message').html('Dirección no encontrada');
            $('#modalMessage').modal('show');
        },
        500: function(xhr) {
            $('#modalMessage #message').removeClass('alert-success');
            $('#modalMessage #message').addClass('alert-danger');
            $('#modalMessage #message').html('Error de servidor');
            $('#modalMessage').modal('show');
        },
        401: function() {
            $('#modalMessage #message').removeClass('alert-success');
            $('#modalMessage #message').addClass('alert-danger');
            $('#modalMessage #message').html('No tiene permisos para realizar esta acción');
            $('#modalMessage').modal('show');
        }   
    };

    var search = function(query) {
        $.ajax({
            url: '/servicioSocial/buscar?q=' + query,
            success: function(result,status,xhr) {
                var arr = result.map(function(obj) {
                    var eliminar = $('<button>Eliminar</button>');
                    eliminar.addClass('btn btn-xs btn-link');
                    eliminar.attr('data-toggle', 'modal');
                    eliminar.attr('data-target', '#modalEliminar');
                    eliminar.attr('data-id', obj.id);
                    eliminar.attr('data-registro', obj.registro);

                    return [
                        '<a href="/servicioSocial/editar/' + obj.id + '" target="_blank">Editar</a>',
                        eliminar.get(0).outerHTML,
                        obj.registro,
                        obj.consecutivo,
                        obj.boleta,
                        obj.nombre,
                        obj.carrera,
                        obj.genero,
                        obj.prestatario,
                        obj.programa,
                        obj.profesor,
                        obj.periodo,
                        obj.tipo_ss,
                        obj.creditos,
                        obj.horario,
                        obj.fecha_recepcion,
                        obj.observaciones
                    ];
                });
                table.clear();
                table.rows.add(arr).draw();
            }
        });
    };

    $('#modalEliminar').on('show.bs.modal', function(e) {
        var id = e.relatedTarget.dataset.id;
        var registro = e.relatedTarget.dataset.registro;

        $('#modalEliminar #registro').text(registro);

        $('#btnEliminar').unbind('click').click(function (e) {
            $.ajax({
                url: '/servicioSocial/eliminar/' + id,
                type: 'POST',
                data: {
                    '_token': $('#_token').val()
                },
                success: function(result,status,xhr) {
                    $('#modalEliminar').modal('hide');
                    $('#modalMessage #message').removeClass('alert-danger');
                    $('#modalMessage #message').addClass('alert-success');
                    $('#modalMessage #message').html('Se ha eliminado el registro: ' + registro);
                    $('#modalMessage').modal('show');
                    search($('#search').val());
                },
                statusCode: commonErrorStatusCodes
            });
        });
    });

    $('#btnBuscar').click(function() {
        search($('#search').val());
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

    $('#btnDescargarExcel').click(function() {
        window.open('/excel/descargarBecas?periodo=' + $('#periodo').val(), '_blank');
    }); 
});