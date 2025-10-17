<?php
include('../app/config.php');
include('../layout/sesion.php');

include('../layout/parte1.php');


include('../app/controllers/categorias/listado_de_categoria.php');

// Incluye el archivo de configuración y define las constantes necesarias

// Consulta para obtener los clientes
$query = "SELECT * FROM tb_clientes";
try {
    // Ejecutar la consulta y obtener los resultados
    $resultadoConsulta = $pdo->query($query);
    $clientes = $resultadoConsulta->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error en la consulta: " . $e->getMessage();
    exit();
}



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
                            <div class="form-group row">
                                <label for="fechaInicio" class="col-sm-2 col-form-label">Fecha Inicio:</label>
                                <div class="col-sm-3">
                                    <input type="date" id="fechaInicio" class="form-control">
                                </div>
                                <label for="fechaFin" class="col-sm-2 col-form-label">Fecha Fin:</label>
                                <div class="col-sm-3">
                                    <input type="date" id="fechaFin" class="form-control">
                                </div>
                                <div class="col-sm-2 d-flex align-items-center">
                                    <button onclick="filtrarPorFecha()" class="btn btn-primary w-100">Filtrar</button>
                                </div>
                            </div>
                        </div>
                    </div>




                    <!-- Tabla de Distribuidores -->
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Clientes Registrados</h3>
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
                                                <th>Cedula</th>
                                                <th>Celular</th>
                                                <th>Email</th>
                                                <th>Fecha de Creación</th>
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

        // Validación de rango de fechas
        if (fechaInicio && fechaFin) {
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

               // Imprimir en consola los datos enviados
        console.log("Datos enviados:");
        console.log("Fecha Inicio:", fechaInicio);
        console.log("Fecha Fin:", fechaFin);

            // Realizar la solicitud AJAX
            $.ajax({
                url: '../app/controllers/reportes/controlador_reporte_clientes.php',
                method: 'GET',
                data: {
                    fechaInicio: fechaInicio,
                    fechaFin: fechaFin
                },
                dataType: 'json',
                success: function(response) {
                    let tbody = $('#example1 tbody');
                    tbody.empty();

                    // Verificar si hay errores en la respuesta
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

                    // Verificar si 'clientes' es un arreglo
                    if (Array.isArray(response)) {
                        // Iterar sobre los datos recibidos y agregar filas a la tabla
                        response.forEach(function(cliente) {
                            tbody.append(`
                                <tr>
                                    <td>${cliente.nombre_cliente}</td>
                                    <td>${cliente.nit_ci_cliente}</td>
                                    <td>${cliente.celular_cliente}</td>
                                    <td>${cliente.email_cliente}</td>
                                    <td>${cliente.fyh_creacion}</td>
                                </tr>
                            `);
                        });
                    } else {
                        Swal.fire({
                            icon: 'info',
                            title: 'Sin resultados',
                            text: 'No se encontraron clientes para las fechas seleccionadas.',
                            confirmButtonText: 'Entendido',
                            confirmButtonColor: '#3085d6'
                        });
                    }

                    // Reinicializar el DataTable después de actualizar los datos
                    $('#example1').DataTable().clear().rows.add(tbody.find('tr')).draw();
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
                title: 'Fechas requeridas',
                text: 'Por favor, selecciona ambas fechas para filtrar.',
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