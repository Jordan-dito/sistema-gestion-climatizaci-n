<?php
include('../app/config.php');
include('../layout/sesion.php');

include('../layout/parte1.php');


include('../app/controllers/compras/listado_de_compras.php');


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
                            <h3 class="card-title">Listados Compras</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>

                        <div class="card-body" style="display: block;">
                            <div id="tablaResultados">
                                <div class="table-responsive">
                                    <table id="example1" class="table table-bordered table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <center>Nro</center>
                                                </th>
                                                <th>
                                                    <center>Nro de la compra</center>
                                                </th>
                                                <th>
                                                    <center>Producto</center>
                                                </th>
                                                <th>
                                                    <center>Fecha de compra</center>
                                                </th>
                                                <th>
                                                    <center>Proveedor</center>
                                                </th>
                                                <th>
                                                    <center>Comprobante</center>
                                                </th>
                                                <th>
                                                    <center>Usuario</center>
                                                </th>
                                                <th>
                                                    <center>Precio compra</center>
                                                </th>
                                                <th>
                                                    <center>Cantidad</center>
                                                </th>
                                                <th>
                                                    <center>Acciones</center>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $contador = 0;
                                            foreach ($compras_datos as $compras_dato) {
                                                $id_compra = $compras_dato['id_compra']; ?>
                                                <tr>
                                                    <td><?php echo $contador = $contador + 1; ?></td>
                                                    <td><?php echo $compras_dato['nro_compra']; ?></td>
                                                    <td>
                                                        <button type="button" class="btn btn-warning" data-toggle="modal"
                                                            data-target="#modal-producto<?php echo $id_compra; ?>">
                                                            <?php echo $compras_dato['nombre_producto']; ?>
                                                        </button>
                                                        <!-- modal para visualizar datos de los productos -->
                                                        <div class="modal fade" id="modal-producto<?php echo $id_compra; ?>">
                                                            <div class="modal-dialog modal-lg">
                                                                <div class="modal-content">
                                                                    <div class="modal-header" style="background-color: #07b0d6;color: white">
                                                                        <h4 class="modal-title">Datos del producto</h4>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">

                                                                        <div class="row">
                                                                            <div class="col-md-9">
                                                                                <div class="row">
                                                                                    <div class="col-md-2">
                                                                                        <div class="form-group">
                                                                                            <label for="">Código</label>
                                                                                            <input type="text" value="<?php echo $compras_dato['codigo']; ?>" class="form-control" disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-4">
                                                                                        <div class="form-group">
                                                                                            <label for="">Nombre del producto prueba</label>
                                                                                            <input type="text" value="<?php echo $compras_dato['nombre_proveedor']; ?>" class="form-control" disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label for="">Descripción del producto</label>
                                                                                            <input type="text" value="<?php echo $compras_dato['descripcion']; ?>" class="form-control" disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="row">
                                                                                    <div class="col-md-3">
                                                                                        <div class="form-group">
                                                                                            <label for="">Stock</label>
                                                                                            <input type="text" value="<?php echo $compras_dato['stock']; ?>" class="form-control" disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                        <div class="form-group">
                                                                                            <label for="">Stock mínimo</label>
                                                                                            <input type="text" value="<?php echo $compras_dato['stock_minimo']; ?>" class="form-control" disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                        <div class="form-group">
                                                                                            <label for="">Stock máximo</label>
                                                                                            <input type="text" value="<?php echo $compras_dato['stock_maximo']; ?>" class="form-control" disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                        <div class="form-group">
                                                                                            <label for="">Fecha de Ingreso</label>
                                                                                            <input type="text" value="<?php echo $compras_dato['fecha_ingreso']; ?>" class="form-control" disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="row">
                                                                                    <div class="col-md-3">
                                                                                        <div class="form-group">
                                                                                            <label for="">Precio Compra</label>
                                                                                            <input type="text" value="<?php echo $compras_dato['precio_compra_producto']; ?>" class="form-control" disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                        <div class="form-group">
                                                                                            <label for="">Precio Venta</label>
                                                                                            <input type="text" value="<?php echo $compras_dato['precio_venta_producto']; ?>" class="form-control" disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                        <div class="form-group">
                                                                                            <label for="">Categoría</label>
                                                                                            <input type="text" value="<?php echo $compras_dato['nombre_categoria']; ?>" class="form-control" disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                        <div class="form-group">
                                                                                            <label for="">Usuario</label>
                                                                                            <input type="text" value="<?php echo $compras_dato['nombre_usuarios_producto']; ?>" class="form-control" disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                <div class="form-group">
                                                                                    <label for="">Imagen del producto</label>
                                                                                    <img src="<?php echo $URL . "/almacen/img_productos/" . $compras_dato['imagen']; ?>" width="100%" alt="">
                                                                                </div>
                                                                            </div>
                                                                        </div>





                                                                    </div>
                                                                </div>
                                                                <!-- /.modal-content -->
                                                            </div>
                                                            <!-- /.modal-dialog -->
                                                        </div>
                                                        <!-- /.modal -->
                                                    </td>
                                                    <td><?php echo $compras_dato['fecha_compra']; ?></td>
                                                    <td>
                                                        <button type="button" class="btn btn-warning" data-toggle="modal"
                                                            data-target="#modal-proveedor<?php echo $id_compra; ?>">
                                                            <?php echo $compras_dato['nombre_proveedor']; ?>
                                                        </button>

                                                        <!-- modal para visualizar datos de los proveedor -->
                                                        <div class="modal fade" id="modal-proveedor<?php echo $id_compra; ?>">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header" style="background-color: #07b0d6;color: white">
                                                                        <h4 class="modal-title">Datos del proveedor</h4>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label for="">Nombre del proveedor</label>
                                                                                    <input type="text" value="<?php echo $compras_dato['nombre_proveedor']; ?>" class="form-control" disabled>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label for="">Celular del proveedor</label>
                                                                                    <a href="https://wa.me/591<?php echo $compras_dato['celular_proveedor']; ?>" target="_blank" class="btn btn-success">
                                                                                        <i class="fa fa-phone"></i>
                                                                                        <?php echo $compras_dato['celular_proveedor']; ?>
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label for="">Teléfono del proveedor</label>
                                                                                    <input type="text" value="<?php echo $compras_dato['telefono_proveedor']; ?>" class="form-control" disabled>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label for="">Empresa</label>
                                                                                    <input type="text" value="<?php echo $compras_dato['empresa']; ?>" class="form-control" disabled>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label for="">Email del proveedor</label>
                                                                                    <input type="text" value="<?php echo $compras_dato['email_proveedor']; ?>" class="form-control" disabled>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label for="">Dirección</label>
                                                                                    <input type="text" value="<?php echo $compras_dato['direccion_proveedor']; ?>" class="form-control" disabled>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- /.modal-content -->
                                                            </div>
                                                            <!-- /.modal-dialog -->
                                                        </div>
                                                        <!-- /.modal -->

                                                    </td>
                                                    <td><?php echo $compras_dato['comprobante']; ?></td>
                                                    <td><?php echo $compras_dato['nombres_usuario']; ?></td>
                                                    <td><?php echo $compras_dato['precio_compra']; ?></td>
                                                    <td><?php echo $compras_dato['cantidad']; ?></td>
                                                    <td>
                                                        <center>
                                                            <div class="btn-group">
                                                                <a href="../compras/show.php?id=<?php echo $id_compra; ?>" type="button" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> Ver</a>
                                                                <a href="update.php?id=<?php echo $id_compra; ?>" type="button" class="btn btn-success btn-sm"><i class="fa fa-pencil-alt"></i> Editar</a>
                                                                <a href="delete.php?id=<?php echo $id_compra; ?>" type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Borrar</a>
                                                            </div>
                                                        </center>
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                        </tfoot>
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



<?php include('../layout/mensajes.php'); ?>
<?php include('../layout/parte2.php'); ?>

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

        // Realizar la solicitud AJAX
        $.ajax({
            url: '../app/controllers/reportes/controlador_reporte_compras.php',
            method: 'GET',
            data: {
                fechaInicio: fechaInicio,
                fechaFin: fechaFin
            },
            dataType: 'json',
            success: function(response) {
                let tbody = $('#example1 tbody');
                tbody.empty();  // Limpiar la tabla antes de agregar los nuevos resultados

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

                // Verificar si 'compras' es un arreglo y tiene datos
                if (Array.isArray(response) && response.length > 0) {
                    // Destruir el DataTable actual antes de actualizar
                    $('#example1').DataTable().destroy();
                    
                    // Limpiar el tbody
                    tbody.empty();
                    
                    // Iterar sobre los datos recibidos y agregar filas a la tabla
                    response.forEach(function(compra) {
                        tbody.append(`
                          <tr>
                <td>${compra.nro || ''}</td> <!-- Nro - usando el campo nro del servidor -->
                <td>${compra.nro_compra || ''}</td> <!-- Nro de la compra -->
                <td>${compra.nombre_producto || ''}</td> <!-- Producto -->
                <td>${compra.fecha_compra || ''}</td> <!-- Fecha de compra -->
                <td>${compra.nombre_proveedor || ''}</td> <!-- Proveedor -->
                <td>${compra.comprobante || ''}</td> <!-- Comprobante -->
                <td>${compra.nombres_usuario || ''}</td> <!-- Usuario -->
                <td>${compra.precio_compra || ''}</td> <!-- Precio compra -->
                <td>${compra.cantidad || ''}</td> <!-- Cantidad -->
                <td>
                    <div class="btn-group">
                        <a href="../compras/show.php?id=${compra.id_compra || ''}" type="button" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> Ver</a>
                        <a href="../compras/update.php?id=${compra.id_compra || ''}" type="button" class="btn btn-success btn-sm"><i class="fa fa-pencil-alt"></i> Editar</a>
                        <a href="../compras/delete.php?id=${compra.id_compra || ''}" type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Borrar</a>
                    </div>
                </td>
            </tr>
                        `);
                    });
                    
                    // Reinicializar el DataTable con la configuración original
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
                } else {
                    // Destruir el DataTable y mostrar mensaje
                    $('#example1').DataTable().destroy();
                    tbody.empty();
                    
                    // Reinicializar DataTable vacío
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
                    
                    Swal.fire({
                        icon: 'info',
                        title: 'Sin resultados',
                        text: 'No se encontraron compras para las fechas seleccionadas.',
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
            title: 'Fechas requeridas',
            text: 'Por favor, selecciona ambas fechas para filtrar.',
            confirmButtonText: 'Entendido',
            confirmButtonColor: '#3085d6'
        });
    }
}


</script>
















<!-- /.modal -->


<div id="respuesta"></div>