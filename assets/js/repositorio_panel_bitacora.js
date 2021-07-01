$(document).ready(function () {
    // iniciar los dataTables
    iniciarDataTables();
});

function iniciarDataTables() {
    // iniciar los dataTables
    $("#tableLibro, #tablePersona").DataTable({
        language: {
            decimal: "",
            emptyTable: "No hay resultados",
            info: "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
            infoEmpty: "Mostrando 0 a 0 de 0 Entradas",
            infoFiltered: "(Filtrado de _MAX_ total entradas)",
            infoPostFix: "",
            thousands: ",",
            lengthMenu: "Límite: _MENU_",
            loadingRecords: "Cargando...",
            processing: "Procesando...",
            search: "Buscar:",
            zeroRecords: "Sin resultados encontrados",
            paginate: {
                first: "Primero",
                last: "Ultimo",
                next: "Siguiente",
                previous: "Anterior",
            },
        },
        responsive: true,
    });

    $("#tableLibro_length select, #tablePersona_length select").formSelect();
}
