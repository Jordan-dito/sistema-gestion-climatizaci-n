// datatable-init.js

/**
 * Función para inicializar un DataTable con opciones de exportación y configuración en español.
 * @param {string} selector - El selector jQuery para el DataTable.
 * @returns {DataTable} - La instancia del DataTable inicializado.
 */
function inicializarDataTable(selector) {
    return $(selector).DataTable({
        responsive: true,
        dom: 'Bfrtip', // Posicionamiento de los elementos del DataTable
        buttons: [
            {
                extend: 'copy',
                text: 'Copiar',
                exportOptions: {
                    columns: ':not(:last-child)' // Excluir la última columna en la exportación
                }
            },
            {
                extend: 'excel',
                text: 'Exportar a Excel',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            },
            {
                extend: 'csv',
                text: 'Exportar a CSV',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            },
            {
                extend: 'pdf',
                text: 'Exportar a PDF',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            },
            {
                extend: 'print',
                text: 'Imprimir',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            }
        ],
        language: {
            url: "//cdn.datatables.net/plug-ins/1.11.3/i18n/es_es.json" // Cargar la traducción al español
        },
        // Agregar opciones de estilo
        pagingType: 'full_numbers', // Estilo de paginación
        pageLength: 10, // Número de filas por página
        lengthMenu: [10, 25, 50, 100], // Opciones para cambiar el número de filas por página
        ordering: true, // Permitir ordenamiento de columnas
        order: [[ 0, "asc" ]] // Ordenar por la primera columna de manera ascendente
    });
}

