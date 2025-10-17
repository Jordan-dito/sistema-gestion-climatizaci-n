<?php
include('../app/config.php');
include('../layout/sesion.php');

include('../layout/parte1.php');


include('../app/controllers/categorias/listado_de_categoria.php');

// Incluye el archivo de configuración y define las constantes necesarias

// Consulta para obtener los clientes



?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->


    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-10">
                    <div class="card card-outline card-primary mb-3">
                        <div class="card-header">
                            <h3 class="card-title">Filtros de Fecha</h3>
                        </div>
                        <div class="card-body">
                            <form class="row g-3 align-items-center">
                                <!-- Fecha Inicio -->
                                <div class="col-md-3">
                                    <label for="fechaInicio" class="form-label">Fecha Inicio:</label>
                                    <input type="date" id="fechaInicio" class="form-control">
                                </div>

                                <!-- Fecha Fin -->
                                <div class="col-md-3">
                                    <label for="fechaFin" class="form-label">Fecha Fin:</label>
                                    <input type="date" id="fechaFin" class="form-control">
                                </div>

                                <!-- NIT/Cédula del Cliente -->
                                <div class="col-md-3">
                                    <label for="nit_cliente" class="form-label">Cédula/NIT del cliente:</label>
                                    <input type="text" id="nit_cliente" class="form-control" placeholder="Ingrese cédula o NIT">
                                </div>

                                <!-- Botón Filtrar -->
                                <div class="col-md-3">
                                    <label class="form-label invisible">Filtrar</label> <!-- Ocupa altura pero no se muestra -->
                                    <button type="button" onclick="filtrarPorFecha()" class="btn btn-primary w-100">Filtrar</button>
                                </div>

                            </form>
                        </div>
                    </div>





                    <!-- Tabla de Distribuidores -->
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Historial Clientes </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>

                        <div class="card-body" style="display: block;">
                            <div id="tablaResultados">
                                <div class="table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Nombre Cliente</th>
                                                <th>Cédula</th>
                                                <th>Celular</th>
                                                <th>Estado</th>
                                                <th>Nro Venta</th>
                                                <th>Total Pagado</th>
                                                <th>Cantidad</th>
                                                <th>Producto</th>
                                                <th>Fecha Venta</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Aquí se cargarán los datos filtrados -->
                                        </tbody>
                                    </table>

                                </div>

                            </div>


                        </div>
                    </div>
                </div>
            </div>




            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!-- Modal para Editar Técnico -->

<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.1.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.print.min.js"></script>
<script>
    $(document).ready(function() {
        // Inicializar DataTable
        $('#example1').DataTable({
            responsive: true,
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'copy',
                    text: 'Copiar',
                    exportOptions: {
                        columns: ':not(:last-child)' // Excluir la columna de acciones
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
                url: "//cdn.datatables.net/plug-ins/1.11.3/i18n/es_es.json" // Traducción al español
            }
        });
    });

    function filtrarPorFecha() {
        const fechaInicio = document.getElementById("fechaInicio").value;
        const fechaFin = document.getElementById("fechaFin").value;
        const nitCliente = document.getElementById("nit_cliente").value;

        if (fechaInicio && fechaFin && nitCliente) {
            if (new Date(fechaInicio) > new Date(fechaFin)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error en fechas',
                    text: 'La fecha de inicio no puede ser posterior a la fecha de fin.',
                    confirmButtonText: 'Entendido',
                    confirmButtonColor: '#3085d6'
                });
                return;
            }

            console.log("Datos enviados:");
            console.log("Fecha Inicio:", fechaInicio);
            console.log("Fecha Fin:", fechaFin);
            console.log("NIT Cliente:", nitCliente);

            $.ajax({
                url: '../app/controllers/reportes/controlador_historial_cliente.php',
                method: 'GET',
                data: {
                    fechaInicio: fechaInicio,
                    fechaFin: fechaFin,
                    nit_cliente: nitCliente
                },
                dataType: 'json',
                success: function(response) {
                    let tbody = $('#example1 tbody');
                    tbody.empty();

                    if (response.error) {
                        Swal.fire({
                            icon: 'info',
                            title: 'Información',
                            text: response.error,
                            confirmButtonText: 'Entendido',
                            confirmButtonColor: '#3085d6'
                        });
                        return;
                    }

                    if (Array.isArray(response)) {
                        response.forEach(function(cliente) {
                            tbody.append(`
                             <tr>
            <td>${cliente.nombre_cliente}</td>
            <td>${cliente.nit_ci_cliente}</td>
            <td>${cliente.celular_cliente}</td>
            <td>${cliente.estado}</td>
            <td>${cliente.nro_venta}</td>
            <td>${cliente.total_pagado}</td>
            <td>${cliente.cantidad}</td>
            <td>${cliente.descripcion}</td>
            <td>${cliente.fyh_creacion}</td>
        </tr>
                        `);
                        });

                        $('#example1').DataTable().clear().rows.add(tbody.find('tr')).draw();
                    } else {
                        Swal.fire({
                            icon: 'info',
                            title: 'Sin resultados',
                            text: 'No se encontraron clientes para las fechas seleccionadas.',
                            confirmButtonText: 'Entendido',
                            confirmButtonColor: '#3085d6'
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudieron cargar los datos. Intenta nuevamente.',
                        confirmButtonText: 'Entendido',
                        confirmButtonColor: '#3085d6'
                    });
                }
            });
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Campos requeridos',
                text: 'Por favor, completa todos los filtros.',
                confirmButtonText: 'Entendido',
                confirmButtonColor: '#3085d6'
            });
        }
    }
</script>

<?php include('../layout/mensajes.php'); ?>
<?php include('../layout/parte2.php'); ?>

<script>





</script>

















<!-- /.modal -->


<div id="respuesta"></div>