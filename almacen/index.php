<?php
include('../app/config.php');
include('../layout/sesion.php');

include('../layout/parte1.php');


include('../app/controllers/almacen/listado_de_productos.php');


?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Listado de productos</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Productos registrados</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                </button>
                            </div>

                        </div>

                        <div class="card-body" style="display: block;">
                            <div class="table table-responsive">
                                <table id="example1" class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>
                                                <center>Nro</center>
                                            </th>
                                            <th>
                                                <center>Código</center>
                                            </th>
                                            <th>
                                                <center>Categoría</center>
                                            </th>
                                            <th>
                                                <center>Imagen</center>
                                            </th>
                                            <th>
                                                <center>Nombre</center>
                                            </th>
                                            <th>
                                                <center>Descripción</center>
                                            </th>
                                            <th>
                                                <center>Stock</center>
                                            </th>
                                            <th>
                                                <center>Precio compra</center>
                                            </th>
                                            <th>
                                                <center>Precio venta</center>
                                            </th>
                                            <th>
                                                <center>Fecha compra</center>
                                            </th>
                                            <th>
                                                <center>Usuario</center>
                                            </th>
                                            <th>
                                                <center>Estado</center>
                                            </th>

                                            <th>
                                                <center>Acciones</center>
                                            </th>

                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $contador = 0;
                                        foreach ($productos_datos as $productos_dato) {
                                            $id_producto = $productos_dato['id_producto']; ?>
                                            <tr>
                                                <td><?php echo $contador = $contador + 1; ?></td>
                                                <td><?php echo $productos_dato['codigo']; ?></td>
                                                <td><?php echo $productos_dato['categoria']; ?></td>
                                                <td>
                                                    <img src="<?php echo $URL . "/almacen/img_productos/" . $productos_dato['imagen']; ?>" width="50px" alt="asdf">
                                                </td>
                                                <td><?php echo $productos_dato['nombre']; ?></td>
                                                <td><?php echo $productos_dato['descripcion']; ?></td>
                                                <?php
                                                $stock_actual = $productos_dato['stock'];
                                                $stock_maximo = $productos_dato['stock_maximo'];
                                                $stock_minimo = $productos_dato['stock_minimo'];
                                                if ($stock_actual < $stock_minimo) { ?>
                                                    <td style="background-color: #ee868b">
                                                        <center><?php echo $productos_dato['stock']; ?></center>
                                                    </td>
                                                <?php
                                                } else if ($stock_actual > $stock_maximo) { ?>
                                                    <td style="background-color: #8ac68d">
                                                        <center><?php echo $productos_dato['stock']; ?></center>
                                                    </td>
                                                <?php
                                                } else { ?>
                                                    <td>
                                                        <center><?php echo $productos_dato['stock']; ?></center>
                                                    </td>
                                                <?php
                                                }
                                                ?>

                                                <td><?php echo $productos_dato['precio_compra']; ?></td>
                                                <td><?php echo $productos_dato['precio_venta']; ?></td>
                                                <td><?php echo $productos_dato['fecha_ingreso']; ?></td>
                                                <td><?php echo $productos_dato['email']; ?></td>
                                                <td><?php echo $productos_dato['estado']; ?></td>
                                                <td>
                                                    <center>
                                                    <div class="btn-group">
    <a href="show.php?id=<?php echo $id_producto; ?>" class="btn btn-info btn-sm">
        <i class="fa fa-eye"></i> Ver
    </a>

    <?php if ($productos_dato['estado'] === 'inactivo'): ?>
        <a href="#" class="btn btn-success btn-sm disabled">
            <i class="fa fa-pencil-alt"></i> Editar
        </a>
    <?php else: ?>
        <a href="update.php?id=<?php echo $id_producto; ?>" class="btn btn-success btn-sm">
            <i class="fa fa-pencil-alt"></i> Editar
        </a>
    <?php endif; ?>

    <?php if ($productos_dato['estado'] === 'inactivo'): ?>
        <a href="#" class="btn btn-danger btn-sm disabled">
            <i class="fa fa-trash"></i>
        </a>
    <?php else: ?>
        <a href="delete.php?id=<?php echo $id_producto; ?>" class="btn btn-danger btn-sm">
            <i class="fa fa-trash"></i> Borrar
        </a>
    <?php endif; ?>

    <!-- Activar si está inactivo -->
    <?php if ($productos_dato['estado'] === 'inactivo'): ?>
        <button class="btn btn-primary btn-sm btn-activar-producto" data-id="<?php echo $id_producto; ?>">
    <i class="fa fa-check"></i> Activar
</button>


<script>
    $(document).ready(function () {
        $('.btn-activar-producto').click(function () {
            var id_producto = $(this).data('id');
            console.log("Activando producto con ID:", id_producto); // debug

            $.ajax({
                url: "../app/controllers/almacen/activar_producto.php",
                type: "POST",
                data: { id_producto: id_producto },
                success: function (response) {
                    console.log("Respuesta del servidor:", response); // debug
                    let res = JSON.parse(response);
                    if (res.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Producto activado',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: res.message || 'Error al activar producto'
                        });
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error AJAX:", error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo activar el producto.'
                    });
                }
            });
        });
    });
</script>

    <?php endif; ?>
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

            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<?php include('../layout/mensajes.php'); ?>
<?php include('../layout/parte2.php'); ?>


<script>
    $(function() {
        $("#example1").DataTable({
            "pageLength": 5,
            "language": {
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Roles",
                "infoEmpty": "Mostrando 0 a 0 de 0 Roles",
                "infoFiltered": "(Filtrado de _MAX_ total Roles)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Roles",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscador:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": "Primero",
                    "last": "Ultimo",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            },
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            buttons: [{
                    extend: 'collection',
                    text: 'Reportes',
                    orientation: 'landscape',
                    buttons: [{
                        text: 'Copiar',
                        extend: 'copy',
                    }, {
                        extend: 'pdf'
                    }, {
                        extend: 'csv'
                    }, {
                        extend: 'excel'
                    }, {
                        text: 'Imprimir',
                        extend: 'print'
                    }]
                },
                {
                    extend: 'colvis',
                    text: 'Visor de columnas',
                    collectionLayout: 'fixed three-column'
                }
            ],
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
</script>