$(document).ready(function () {
    $('#table-employees').DataTable({
        dom: 'QBfrtip',  // 'Q' habilita el SearchBuilder
        searchBuilder: true, // Activa el filtrado avanzado
        buttons: [
            {
                extend: 'excel',
                text: 'Exportar a Excel',
                filename: 'Empleados_Filtrados',
                title: 'Lista de Empleados',
                exportOptions: {
                    modifier: {
                        search: 'applied' // Exporta solo filas filtradas
                    },
                    columns: ':visible' // Exporta solo las columnas visibles
                }
            }
        ],
        language: {
            url: '//cdn.datatables.net/plug-ins/2.2.1/i18n/es-ES.json',
            searchBuilder: {
                button: "Filtro avanzado",
                title: "Filtro avanzado"
            }
        },
        order: []
    });
});
