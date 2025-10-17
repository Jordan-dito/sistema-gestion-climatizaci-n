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
                            <h3 class="card-title">Reporte Ordenes de Instalacion </h3>
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
                                                <th>Fecha Instalación</th>
                                                <th>Fecha Orden</th>
                                                <th>Factura</th>
                                                <th>Cédula</th>
                                                <th>Cliente</th>
                                                <th>Total con IVA</th>
                                                <th>Observaciones</th>
                                                <th>Técnico</th>
                                                <th>Producto</th>
                                                <th>Imagen</th>
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
            buttons: [
                { extend: 'copy', text: 'Copiar', exportOptions: { columns: ':not(:last-child)' } },
                { extend: 'excel', text: 'Exportar a Excel', exportOptions: { columns: ':not(:last-child)' } },
                { extend: 'csv', text: 'Exportar a CSV', exportOptions: { columns: ':not(:last-child)' } },
                { extend: 'pdf', text: 'Exportar a PDF', exportOptions: { columns: ':not(:last-child)' } },
                { extend: 'print', text: 'Imprimir', exportOptions: { columns: ':not(:last-child)' } }
            ],
            language: {
                url: "//cdn.datatables.net/plug-ins/1.11.3/i18n/es_es.json"
            }
        });
    });

    function filtrarPorFecha() {
        const fechaInicio = document.getElementById("fechaInicio").value;
        const fechaFin = document.getElementById("fechaFin").value;

        if (fechaInicio && fechaFin) {
            if (new Date(fechaInicio) > new Date(fechaFin)) {
                Swal.fire({ icon: 'error', title: 'Error en fechas', text: 'La fecha de inicio no puede ser posterior a la fecha de fin.', confirmButtonText: 'Entendido', confirmButtonColor: '#3085d6' });
                return;
            }

            $.ajax({
                url: '../app/controllers/reportes/controlador_reporte_instalaciones.php',
                method: 'GET',
                data: { fechaInicio: fechaInicio, fechaFin: fechaFin },
                dataType: 'json',
                success: function(response) {
                    let tbody = $('#example1 tbody');
                    tbody.empty();

                    if (response.error) {
                        Swal.fire({ icon: 'info', title: 'Información', text: response.error, confirmButtonText: 'Entendido', confirmButtonColor: '#3085d6' });
                        return;
                    }

                    if (Array.isArray(response) && response.length > 0) {
                        response.forEach(function(instalacion) {
                            tbody.append(`
                                <tr>
                                    <td>${instalacion.fecha_instalacion}</td>
                                    <td>${instalacion.fecha_orden}</td>
                                    <td>${instalacion.numero_factura}</td>
                                    <td>${instalacion.cedula}</td>
                                    <td>${instalacion.nombre_cliente}</td>
                                    <td>$${parseFloat(instalacion.total_con_iva).toFixed(2)}</td>
                                    <td>${instalacion.datos_extras || ''}</td>
                                    <td>${instalacion.nombre_tecnico} ${instalacion.apellido_tecnico}</td>
                                    <td>${instalacion.producto}</td>
                                    <td>
                                        <img src="${URL}/almacen/img_productos/${instalacion.imagen_producto}" 
                                             alt="producto" 
                                             style="width: 60px; height: 60px; object-fit: cover;">
                                    </td>
                                </tr>
                            `);
                        });

                        $('#example1').DataTable().clear().rows.add(tbody.find('tr')).draw();
                    } else {
                        Swal.fire({ icon: 'info', title: 'Sin resultados', text: 'No se encontraron órdenes de instalación en el rango indicado.', confirmButtonText: 'Entendido', confirmButtonColor: '#3085d6' });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
                    Swal.fire({ icon: 'error', title: 'Error', text: 'No se pudieron cargar los datos. Intenta nuevamente.', confirmButtonText: 'Entendido', confirmButtonColor: '#3085d6' });
                }
            });
        } else {
            Swal.fire({ icon: 'warning', title: 'Campos requeridos', text: 'Por favor, selecciona ambas fechas.', confirmButtonText: 'Entendido', confirmButtonColor: '#3085d6' });
        }
    }
</script>

<?php include('../layout/mensajes.php'); ?>
<?php include('../layout/parte2.php'); ?>


















<!-- /.modal -->


<div id="respuesta"></div>