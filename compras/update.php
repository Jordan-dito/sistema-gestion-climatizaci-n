<?php
include('../app/config.php');
include('../layout/sesion.php');

include('../layout/parte1.php');

include('../app/controllers/almacen/listado_de_productos.php');
include('../app/controllers/proveedores/listado_de_proveedores.php');
include('../app/controllers/compras/cargar_compra.php');

$id_usuario_sesion = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : null;
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Actualización de la compra</h1>
                    <div class="col-sm-12 d-flex justify-content-between align-items-center">
                        <h1 class="m-0">Compra nro <?php echo $nro_compra; ?></h1>
                        <a href="index.php" class="btn btn-primary">
                            <i class="fa fa-arrow-left"></i> Volver a compras
                        </a>
                    </div>

                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-success">
                                <div class="card-header">
                                    <h3 class="card-title">Llene los datos con cuidado</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                        </button>
                                    </div>

                                </div>

                                <div class="card-body" style="display: block;">
                                    <div style="display: flex">
                                        <h5>Datos del producto </h5>
                                        <div style="width: 20px"></div>

                                        <!-- modal para visualizar datos de los proveedor -->

                                        <!-- /.modal -->
                                    </div>

                                    <hr>
                                    <div class="row" style="font-size: 12px">
                                        <div class="col-md-9">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <input type="text" value="<?= $id_producto; ?>" id="id_producto" hidden>
                                                        <label for="">Código:</label>
                                                        <input type="text" value="<?= $codigo; ?>" class="form-control" id="codigo" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="">Categoría:</label>
                                                        <div style="display: flex">
                                                            <input type="text" value="<?= $nombre_categoria; ?>" class="form-control" id="categoria" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="">Nombre del producto:</label>
                                                        <input type="text" value="<?= $nombre_producto; ?>" name="nombre" id="nombre_producto" class="form-control" disabled>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="">Usuario</label>
                                                        <input type="text" value="<?= $nombres_usuario; ?>" class="form-control" id="usuario_producto" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label for="">Descripción del producto:</label>
                                                        <textarea name="descripcion" id="descripcio_producto" cols="30" rows="2" class="form-control" disabled><?= $descripcion; ?></textarea>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="">Stock:</label>
                                                        <input type="number" value="<?= $stock; ?>" name="stock" id="stock" class="form-control" style="background-color: #fff819" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="">Stock mínimo:</label>
                                                        <input type="number" value="<?= $stock_minimo; ?>" name="stock_minimo" id="stock_minimo" class="form-control" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="">Stock máximo:</label>
                                                        <input type="number" value="<?= $stock_maximo; ?>" name="stock_maximo" id="stock_maximo" class="form-control" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="">Precio compra:</label>
                                                        <input type="number" value="<?= $precio_compra_producto; ?>" name="precio_compra" id="precio_compra" class="form-control" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="">Precio venta:</label>
                                                        <input type="number" value="<?= $precio_venta_producto; ?>" name="precio_venta" id="precio_venta" class="form-control" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="">Fecha de ingreso:</label>
                                                        <input type="date" style="font-size: 12px" value="<?= $fecha_ingreso; ?>" name="fecha_ingreso" id="fecha_ingreso" class="form-control" disabled>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Imagen del producto</label>
                                                <center>
                                                    <img src="<?php echo $URL . "/almacen/img_productos/" . $imagen; ?>" id="img_producto" width="50%" alt="">
                                                </center>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>
                                    <div style="display: flex">
                                        <h5>Datos del proveedor </h5>
                                        <div style="width: 20px"></div>

                                        <!-- modal para visualizar datos de los proveedor -->

                                        <!-- /.modal -->
                                    </div>

                                    <hr>

                                    <div class="container-fluid" style="font-size: 12px">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <input type="text" value="<?= $id_proveedor_tabla; ?>" id="id_proveedor" hidden>
                                                    <label for="">Nombre del proveedor </label>
                                                    <input type="text" value="<?= $nombre_proveedor_tabla; ?>" id="nombre_proveedor" class="form-control" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">Celular</label>
                                                    <input type="number" value="<?= $celular_proveedor; ?>" id="celular" class="form-control" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">Teléfono</label>
                                                    <input type="number" value="<?= $telefono_proveedor; ?>" id="telefono" class="form-control" disabled>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">Empresa </label>
                                                    <input type="text" value="<?= $empresa_proveedor; ?>" id="empresa" class="form-control" disabled>

                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">Email</label>
                                                    <input type="email" value="<?= $email_proveedor; ?>" id="email" class="form-control" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">Dirección</label>
                                                    <textarea name="" id="direccion" cols="30" rows="3" class="form-control" disabled><?= $direccion_proveedor; ?></textarea>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-outline card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Detalle de la compra</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>

                                </div>

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Número de la compra</label>
                                                <input type="text" value="<?php echo $nro_compra; ?>" style="text-align: center" class="form-control" disabled>
                                                <input type="text" value="<?php echo $nro_compra; ?>" id="nro_compra" hidden>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Fecha de la compra</label>
                                                <input type="date" value="<?= $fecha_compra; ?>" class="form-control" id="fecha_compra">
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Comprobante de la compra</label>
                                                <input type="text" value="<?= $comprobante; ?>" class="form-control" id="comprobante">
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Precio de la compra</label>
                                                <input type="text" value="<?= $precio_compra; ?>" class="form-control" id="precio_compra_controlador">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Stock actual</label>
                                                <input type="text" value="<?= $stock = $stock - $cantidad; ?>" style="background-color: #fff819;text-align: center" id="stock_actual" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Stock Total</label>
                                                <input type="text" style="text-align: center" id="stock_total" class="form-control" disabled>
                                            </div>
                                        </div>





                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Cantidad de la compra</label>
                                                <input type="number" value="<?= $cantidad; ?>" id="cantidad_compra" style="text-align: center" class="form-control">
                                            </div>
                                            <script>
                                                $('#cantidad_compra').keyup(function() {
                                                    sumacantidades();
                                                });
                                                sumacantidades();

                                                function sumacantidades() {
                                                    //alert('estamos presionando el input');
                                                    var stock_actual = $('#stock_actual').val();
                                                    var stock_compra = $('#cantidad_compra').val();

                                                    var total = parseInt(stock_actual) + parseInt(stock_compra);
                                                    $('#stock_total').val(total);
                                                }
                                            </script>
                                        </div>


                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">IVA (%)</label>
                                                <input type="number" id="iva" class="form-control" min="0" max="100" step="0.01" value="<?= $iva; ?>">
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Precio total con IVA</label>
                                                <input type="text" id="precio_total" class="form-control" value="<?= $precio_total; ?>" disabled>
                                            </div>
                                        </div>




                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Usuario</label>
                                                <input type="text" class="form-control" value="<?php echo $nombres_usuario; ?>" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <button class="btn btn-success btn-block" id="btn_actualizar_compra">Actualizar compra</button>
                                        </div>
                                    </div>



                                    <script>
                                        function calcularTotal() {
                                            var precioCompra = parseFloat($('#precio_compra_controlador').val()) || 0;
                                            var cantidadCompra = parseInt($('#cantidad_compra').val()) || 1;
                                            var iva = parseFloat($('#iva').val()) || 0;

                                            if (iva < 0) {
                                                $('#iva').val(0);
                                                iva = 0;
                                            } else if (iva > 100) {
                                                $('#iva').val(100);
                                                iva = 100;
                                            }

                                            if (cantidadCompra < 1) {
                                                $('#cantidad_compra').val(1);
                                                cantidadCompra = 1;
                                            }

                                            var subtotal = precioCompra * cantidadCompra;
                                            var precioConIva = subtotal + (subtotal * iva / 100);

                                            $('#precio_total').val(precioConIva.toFixed(2));
                                        }

                                        $('#precio_compra_controlador, #cantidad_compra, #iva').on('input change', function() {
                                            calcularTotal();
                                        });

                                        calcularTotal();
                                    </script>

                                    <script>
                                        $('#btn_actualizar_compra').click(function() {

                                            var id_compra = '<?php echo $id_compra; ?>';
                                            var id_producto = $('#id_producto').val();
                                            var nro_compra = $('#nro_compra').val();
                                            var fecha_compra = $('#fecha_compra').val();
                                            var id_proveedor = $('#id_proveedor').val();
                                            var comprobante = $('#comprobante').val();
                                            var id_usuario = '<?php echo $id_usuario_sesion; ?>';
                                            var precio_compra = $('#precio_compra_controlador').val();
                                            var cantidad_compra = $('#cantidad_compra').val();

                                            var stock_total = $('#stock_total').val();

                                            var iva = $('#iva').val();
                                            var precio_total = $('#precio_total').val();


                                            if (id_producto == "") {
                                                $('#id_producto').focus();
                                                alert("Debe llenar todos los campos productos");
                                            } else if (fecha_compra == "") {
                                                $('#fecha_compra').focus();
                                                alert("Debe llenar todos los campos fecha compra");
                                            } else if (comprobante == "") {
                                                $('#comprobante').focus();
                                                alert("Debe llenar todos los campos comprobante");
                                            } else if (precio_compra == "") {
                                                $('#precio_compra_controlador').focus();
                                                alert("Debe llenar todos los campos precio compra");
                                            } else if (cantidad_compra == "") {
                                                $('#cantidad_compra').focus();
                                                alert("Debe llenar todos los campos cantidades");
                                            } else {
                                                var url = "../app/controllers/compras/update.php";
                                                $.get(url, {
                                                    id_compra: id_compra,
                                                    id_producto: id_producto,
                                                    nro_compra: nro_compra,
                                                    fecha_compra: fecha_compra,
                                                    id_proveedor: id_proveedor,
                                                    comprobante: comprobante,
                                                    id_usuario: id_usuario,
                                                    precio_compra: precio_compra,
                                                    cantidad_compra: cantidad_compra,
                                                    iva: iva,
                                                    precio_total: precio_total,

                                                    stock_total: stock_total
                                                }, function(datos) {
                                                    $('#respuesta_update').html(datos);
                                                });
                                            }

                                        });
                                    </script>









                                </div>

                            </div>

                        </div>

                        <div id="respuesta_update"></div>

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
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Productos",
                "infoEmpty": "Mostrando 0 a 0 de 0 Productos",
                "infoFiltered": "(Filtrado de _MAX_ total Productos)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Productos",
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

        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });


    $(function() {
        $("#example2").DataTable({
            "pageLength": 5,
            "language": {
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Proveedores",
                "infoEmpty": "Mostrando 0 a 0 de 0 Proveedores",
                "infoFiltered": "(Filtrado de _MAX_ total Proveedores)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Proveedores",
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

        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
</script>