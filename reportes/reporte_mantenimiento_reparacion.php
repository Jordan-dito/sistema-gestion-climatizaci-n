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
                            <h3 class="card-title">Filtros de Fecha y Tipo de Servicio</h3>
                        </div>
                        <div class="card-body">
                            <form class="row g-3 align-items-end">
                                <!-- Fecha Inicio -->
                                <div class="col-md-3">
                                    <label for="fechaInicio" class="form-label">Fecha Inicio:</label>
                                    <input type="date" id="fechaInicio" class="form-control" required>
                                </div>

                                <!-- Fecha Fin -->
                                <div class="col-md-3">
                                    <label for="fechaFin" class="form-label">Fecha Fin:</label>
                                    <input type="date" id="fechaFin" class="form-control" required>
                                </div>

                                <!-- Tipo de Servicio -->
                                <div class="col-md-3">
                                    <label for="tipoServicio" class="form-label">Tipo de Servicio:</label>
                                    <select id="tipoServicio" class="form-select" required>
                                        <option value="">Seleccionar</option>
                                        <option value="Mantenimiento">Mantenimiento</option>
                                        <option value="Reparacion">Reparación</option>
                                    </select>
                                </div>

                                <!-- Botón Filtrar -->
                                <div class="col-md-3 d-grid">
                                    <button type="button" onclick="filtrarPorFecha()" class="btn btn-primary">
                                        Filtrar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>








                    <!-- Tabla de Distribuidores -->
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Reporte Ordenes de Mantenimiento y Reparacion </h3>
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
                                                <th>Fecha Instalación</th> <!-- ordi.fecha_mantenimiento -->
                                                <th>Tipo Servicio</th> <!-- ordi.tipo_servicio -->
                                                <th>Fecha Orden</th> <!-- ordi.fecha_orden -->
                                                <th>Factura</th> <!-- ordi.numero_factura -->
                                                <th>Cédula</th> <!-- ordi.cedula -->
                                                <th>Cliente</th> <!-- ordi.nombre_cliente -->
                                                <th>Total con IVA</th> <!-- ordi.total_con_iva -->
                                                <th>Observaciones</th> <!-- ordi.datos_extras -->
                                                <th>Técnico</th> <!-- CONCAT(tu.nombres, ' ', tu.apellidos) -->
                                                <th>Producto</th> <!-- ta.nombre -->
                                                <th>Imagen</th> <!-- ta.imagen -->
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
    const URL = "<?php echo $URL; ?>"; // Inyectar desde PHP
</script>

<script>
    $(document).ready(function() {
        $('#example1').DataTable({
            responsive: true,
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'copy',
                    text: 'Copiar',
                    exportOptions: {
                        columns: ':not(:last-child)'
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
                url: "//cdn.datatables.net/plug-ins/1.11.3/i18n/es_es.json"
            }
        });
    });

    function filtrarPorFecha() {
        const fechaInicio = document.getElementById("fechaInicio").value;
        const fechaFin = document.getElementById("fechaFin").value;
        const tipoServicio = document.getElementById("tipoServicio").value;

        if (!fechaInicio || !fechaFin || !tipoServicio) {
            Swal.fire({
                icon: 'warning',
                title: 'Campos requeridos',
                text: 'Por favor, selecciona ambas fechas y el tipo de servicio.',
                confirmButtonText: 'Entendido',
                confirmButtonColor: '#3085d6'
            });
            return;
        }

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

        $.ajax({
            url: '../app/controllers/reportes/controlador_reporte_mantenimiento.php', // Asegúrate de que este sea el correcto
            method: 'GET',
            data: {
                fechaInicio: fechaInicio,
                fechaFin: fechaFin,
                tipoServicio: tipoServicio
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

                if (Array.isArray(response) && response.length > 0) {
                    response.forEach(function(item) {
                        $('#example1 tbody').append(`
        <tr>
            <td>${item.fecha_mantenimiento}</td>
            <td>${item.tipo_servicio}</td>
            <td>${item.fecha_orden}</td>
            <td>${item.numero_factura}</td>
            <td>${item.cedula}</td>
            <td>${item.nombre_cliente}</td>
            <td>$${parseFloat(item.total_con_iva).toFixed(2)}</td>
            <td>${item.datos_extras || ''}</td>
            <td>${item.nombre_tecnico} ${item.apellido_tecnico}</td>
            <td>${item.producto}</td>
            <td><img src="${URL}/almacen/img_productos/${item.imagen_producto}" style="width: 60px; height: 60px; object-fit: cover;"></td>
        </tr>
    `);
                    });


                    $('#example1').DataTable().clear().rows.add(tbody.find('tr')).draw();
                } else {
                    Swal.fire({
                        icon: 'info',
                        title: 'Sin resultados',
                        text: 'No se encontraron órdenes en el rango indicado.',
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
    }
</script>

<?php include('../layout/mensajes.php'); ?>
<?php include('../layout/parte2.php'); ?>


















<!-- /.modal -->


<div id="respuesta"></div>