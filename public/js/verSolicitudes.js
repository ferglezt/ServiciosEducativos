$(document).ready(function() {
    $('#item-ver-solicitudes').addClass('active');

    $('#item-ver-solicitudes').click(function(e) {
        e.preventDefault();
    });

    $('#submenu-becas').addClass('in');

    $('#hiddenDiv').hide();

    var table = $('#becasTable').DataTable({
        "searching": false,
        "scrollX": true,
        "scrollY": "200px",
        "scrollCollapse": true,
        "order": [[ 8, "asc" ]], //por nombre
        "fixedColumns": {
            "leftColumns": 3
        },
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
                    hiddenButton.removeAttr('id');
                    hiddenButton.attr('data-toggle', 'modal');
                    hiddenButton.attr('data-target', '#modalCambioEstatus');
                    hiddenButton.attr('data-id', obj.id);
                    hiddenButton.attr('data-nombre', obj.nombre);
                    hiddenButton.attr('data-estatus', obj.estatus_solicitud);

                    var promedio = parseFloat(obj.promedio).toFixed(2);
                    var ingresos = parseFloat(obj.ingresos).toFixed(2);
                    var ingresoMinimo = parseFloat(obj.ingreso_minimo).toFixed(2);
                    var dependientes = parseInt(obj.dependientes);
                    var relacionIngresosDependientes = (ingresos / dependientes / ingresoMinimo).toFixed(2); 

                    if(isNaN(promedio)) promedio = null;
                    if(isNaN(ingresos)) ingresos = null;
                    if(isNaN(ingresoMinimo)) ingresoMinimo = null;
                    if(isNaN(dependientes)) dependientes = null;

                    var hiddenMessage = $('#hiddenMessage').clone();
                    hiddenMessage.removeClass();

                    if(isNaN(relacionIngresosDependientes)) {
                        relacionIngresosDependientes = null;
                    } else if(relacionIngresosDependientes > 4.0) {
                        hiddenMessage.addClass('alert alert-danger text-center');
                    } else if(relacionIngresosDependientes > 0 && relacionIngresosDependientes <= 4.0) {
                        hiddenMessage.addClass('alert alert-success text-center');
                    }

                    hiddenMessage.html(relacionIngresosDependientes);

                    var eliminar = $('#hiddenButton').clone();
                    eliminar.empty();
                    eliminar.removeClass();
                    eliminar.addClass('btn btn-xs btn-link');
                    eliminar.html('Eliminar');
                    eliminar.removeAttr('id');
                    eliminar.attr('data-toggle', 'modal');
                    eliminar.attr('data-target', '#modalEliminar');
                    eliminar.attr('data-id', obj.id);
                    eliminar.attr('data-etiqueta', obj.etiqueta);
                    eliminar.attr('data-folio', obj.folio);

                    var transporteInstCheckbox = $('#hiddenCheckbox').clone(true);
                    transporteInstCheckbox.removeAttr('id');
                    transporteInstCheckbox.addClass('transporteInstitucionalCheckbox');
                    transporteInstCheckbox.attr('solicitud_id', obj.id);

                    if(obj.transporte_institucional == 1) {
                        transporteInstCheckbox.attr('checked', 'checked');
                    }

                    var transporteManCheckbox = $('#hiddenCheckbox').clone(true);
                    transporteManCheckbox.removeAttr('id');
                    transporteManCheckbox.addClass('transporteManutencionCheckbox');
                    transporteManCheckbox.attr('solicitud_id', obj.id);

                    if(obj.transporte_manutencion == 1) {
                        transporteManCheckbox.attr('checked', 'checked');
                    }
                   
                    return[
                        hiddenButton.get(0).outerHTML,
                        '<a href="editarSolicitud/' + obj.id + '" target="_blank">Editar</a>',
                        eliminar.get(0).outerHTML,
                        obj.anio.toString() + ' - ' + obj.periodo.toString(),
                        transporteInstCheckbox.get(0).outerHTML,
                        transporteManCheckbox.get(0).outerHTML,
                        obj.folio,
                        obj.etiqueta,
                        obj.boleta,
                        obj.curp,
                        obj.genero,
                        obj.nombre,
                        obj.carrera,
                        obj.semestre,
                        promedio,
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
                        ingresos,
                        dependientes,
                        ingresoMinimo,
                        hiddenMessage.get(0).outerHTML,
                        obj.oriundo,
                        obj.email,
                        obj.telefono,
                        obj.observaciones,
                        obj.numero_caja,
                        obj.usuario,
                        obj.fecha_cierre
                    ];
                });
                table.clear();
                table.rows.add(arr).draw();
            }
        });
    };

    $('#modalEliminar').on('show.bs.modal', function(e) {
        var etiqueta = e.relatedTarget.dataset.etiqueta;
        var folio = e.relatedTarget.dataset.folio;
        var id = e.relatedTarget.dataset.id;

        $('#modalEliminar #etiqueta').text(etiqueta);
        $('#modalEliminar #folio').text(folio);
        $('#btnEliminar').removeAttr('disabled');

        $('#btnEliminar').unbind('click').click(function (e) {
            $(this).attr('disabled', 'disabled');
            $.ajax({
                url: '/eliminarSolicitud/' + id,
                type: 'POST',
                data: {
                    '_token': $('#modalCambioEstatus #_token').val()
                },
                success: function(result,status,xhr) {
                    $('#modalEliminar').modal('hide');
                    $('#modalMessage #message').removeClass('alert-danger');
                    $('#modalMessage #message').addClass('alert-success');
                    $('#modalMessage #message').html(
                        'Se ha eliminado la solicitud con folio ' + folio +
                        ' y etiqueta ' + etiqueta
                    );
                    $('#modalMessage').modal('show');
                    search($('#search').val(), $('#periodo').val());
                },
                statusCode: commonErrorStatusCodes
            });
        });
    });

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

    $('#btnBuscar').click(function() {
        search($('#search').val(), $('#periodo').val());
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

    $('#btnDescargarExcelPeriodo').click(function() {
        window.open('/excel/descargarBecas?periodo=' + $('#periodo').val(), '_blank');
    });

    $('#btnDescargarExcelAnio').click(function() {
        var anio = $('#periodo').find('option:selected').data('anio');
        window.open('/excel/descargarBecas?anio=' + anio, '_blank');
    });

    var changeBecaTransporte = function(url, checkbox) {
        var checked = checkbox.is(':checked');
        checkbox.prop('checked', !checked);
        checkbox.prop('disabled', true);

        var solicitud_id = checkbox.attr('solicitud_id');
        var value = checked ? 1 : 0;

        $.ajax({
            url: url + '/' + solicitud_id + '/' + value,
            success: function(result,status,xhr) {
                checkbox.prop('checked', checked);
            },
            complete: function(xhr,status) {
                checkbox.prop('disabled', false);
            },
            statusCode: commonErrorStatusCodes    
        });
    };

    $('#becasTable').on('click', '.transporteInstitucionalCheckbox', function() {
        changeBecaTransporte('/aceptarTransporteInstitucional', $(this));
    });

    $('#becasTable').on('click', '.transporteManutencionCheckbox', function() {
        changeBecaTransporte('/aceptarTransporteManutencion', $(this));
    });
    
});