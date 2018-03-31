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