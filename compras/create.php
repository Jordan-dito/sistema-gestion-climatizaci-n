<?php
include('../app/config.php');
include('../layout/sesion.php');

include('../layout/parte1.php');

include('../app/controllers/almacen/listado_de_productos.php');
include('../app/controllers/proveedores/listado_de_proveedores.php');
include('../app/controllers/compras/listado_de_compras.php');


$id_usuario_sesion = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : null;
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Registro nueva compra</h1>
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
                            <div class="card card-primary">
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
                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#modal-buscar_producto">
                                            <i class="fa fa-search"></i>
                                            Buscar producto
                                        </button>
                                        <!-- modal para visualizar datos de los proveedor -->
                                        <div class="modal fade" id="modal-buscar_producto">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header" style="background-color: #1d36b6;color: white">
                                                        <h4 class="modal-title">Busqueda del producto</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="table table-responsive">
                                                            <table id="example1" class="table table-bordered table-striped table-sm">
                                                                <thead>
                                                                    <tr>
                                                                        <th>
                                                                            <center>Nro</center>
                                                                        </th>
                                                                        <th>
                                                                            <center>Selecionar</center>
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
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    $contador = 0;
                                                                    foreach ($productos_datos as $productos_dato) {
                                                                        $id_producto = $productos_dato['id_producto']; ?>
                                                                        <tr>
                                                                            <td><?php echo $contador = $contador + 1; ?></td>
                                                                            <td>
                                                                                <button class="btn btn-info" id="btn_selecionar<?php echo $id_producto; ?>">
                                                                                    Selecionar
                                                                                </button>
                                                                                <script>
                                                                                    $('#btn_selecionar<?php echo $id_producto; ?>').click(function() {


                                                                                        var id_producto = "<?php echo $productos_dato['id_producto']; ?>";
                                                                                        $('#id_producto').val(id_producto);

                                                                                        var codigo = "<?php echo $productos_dato['codigo']; ?>";
                                                                                        $('#codigo').val(codigo);

                                                                                        var categoria = "<?php echo $productos_dato['categoria']; ?>";
                                                                                        $('#categoria').val(categoria);

                                                                                        var nombre = "<?php echo $productos_dato['nombre']; ?>";
                                                                                        $('#nombre_producto').val(nombre);

                                                                                        var email = "<?php echo $productos_dato['email']; ?>";
                                                                                        $('#usuario_producto').val(email);

                                                                                        var descripcion = "<?php echo $productos_dato['descripcion']; ?>";
                                                                                        $('#descripcio_producto').val(descripcion);

                                                                                        var stock = "<?php echo $productos_dato['stock']; ?>";
                                                                                        $('#stock').val(stock);
                                                                                        $('#stock_actual').val(stock);

                                                                                        var stock_minimo = "<?php echo $productos_dato['stock_minimo']; ?>";
                                                                                        $('#stock_minimo').val(stock_minimo);

                                                                                        var stock_maximo = "<?php echo $productos_dato['stock_maximo']; ?>";
                                                                                        $('#stock_maximo').val(stock_maximo);

                                                                                        var precio_compra = "<?php echo $productos_dato['precio_compra']; ?>";
                                                                                        $('#precio_compra').val(precio_compra);

                                                                                        var precio_venta = "<?php echo $productos_dato['precio_venta']; ?>";
                                                                                        $('#precio_venta').val(precio_venta);

                                                                                        var fecha_ingreso = "<?php echo $productos_dato['fecha_ingreso']; ?>";
                                                                                        $('#fecha_ingreso').val(fecha_ingreso);

                                                                                        var ruta_img = "<?php echo $URL . '/almacen/img_productos/' . $productos_dato['imagen']; ?>";
                                                                                        $('#img_producto').attr({
                                                                                            src: ruta_img
                                                                                        });

                                                                                        $('#modal-buscar_producto').modal('toggle');

                                                                                    });
                                                                                </script>
                                                                            </td>
                                                                            <td><?php echo $productos_dato['codigo']; ?></td>
                                                                            <td><?php echo $productos_dato['categoria']; ?></td>
                                                                            <td>
                                                                                <img src="<?php echo $URL . "/almacen/img_productos/" . $productos_dato['imagen']; ?>" width="50px" alt="asdf">
                                                                            </td>
                                                                            <td><?php echo $productos_dato['nombre']; ?></td>
                                                                            <td><?php echo $productos_dato['descripcion']; ?></td>
                                                                            <td><?php echo $productos_dato['stock']; ?></td>
                                                                            <td><?php echo $productos_dato['precio_compra']; ?></td>
                                                                            <td><?php echo $productos_dato['precio_venta']; ?></td>
                                                                            <td><?php echo $productos_dato['fecha_ingreso']; ?></td>
                                                                            <td><?php echo $productos_dato['email']; ?></td>
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
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                        <!-- /.modal -->
                                    </div>

                                    <hr>
                                    <div class="row" style="font-size: 12px">
                                        <div class="col-md-9">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <input type="text" id="id_producto" hidden>
                                                        <label for="">Código:</label>
                                                        <input type="text" class="form-control" id="codigo" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="">Categoría:</label>
                                                        <div style="display: flex">
                                                            <input type="text" class="form-control" id="categoria" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="">Nombre del producto:</label>
                                                        <input type="text" name="nombre" id="nombre_producto" class="form-control" disabled>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="">Usuario</label>
                                                        <input type="text" class="form-control" id="usuario_producto" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label for="">Descripción del producto:</label>
                                                        <textarea name="descripcion" id="descripcio_producto" cols="30" rows="2" class="form-control" disabled></textarea>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="">Stock:</label>
                                                        <input type="number" name="stock" id="stock" class="form-control" style="background-color: #fff819" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="">Stock mínimo:</label>
                                                        <input type="number" name="stock_minimo" id="stock_minimo" class="form-control" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="">Stock máximo:</label>
                                                        <input type="number" name="stock_maximo" id="stock_maximo" class="form-control" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="">Precio compra:</label>
                                                        <input type="number" name="precio_compra" id="precio_compra" class="form-control" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="">Precio venta:</label>
                                                        <input type="number" name="precio_venta" id="precio_venta" class="form-control" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="">Fecha de ingreso:</label>
                                                        <input type="date" name="fecha_ingreso" id="fecha_ingreso" class="form-control" disabled>
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
                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#modal-buscar_proveedor">
                                            <i class="fa fa-search"></i>
                                            Buscar proveedor
                                        </button>
                                        <!-- modal para visualizar datos de los proveedor -->
                                        <div class="modal fade" id="modal-buscar_proveedor">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header" style="background-color: #1d36b6;color: white">
                                                        <h4 class="modal-title">Busqueda de proveedor</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="table table-responsive">
                                                            <table id="example2" class="table table-bordered table-striped table-sm">
                                                                <thead>
                                                                    <tr>
                                                                        <th>
                                                                            <center>Nro</center>
                                                                        </th>
                                                                        <th>
                                                                            <center>Selecionar</center>
                                                                        </th>
                                                                        <th>
                                                                            <center>Nombre del proveedor</center>
                                                                        </th>
                                                                        <th>
                                                                            <center>Celular</center>
                                                                        </th>
                                                                        <th>
                                                                            <center>Teléfono</center>
                                                                        </th>
                                                                  
                                                                        <th>
                                                                            <center>Email</center>
                                                                        </th>
                                                                        <th>
                                                                            <center>Dirección</center>
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    $contador = 0;
                                                                    foreach ($proveedores_datos as $proveedores_dato) {
                                                                        $id_proveedor = $proveedores_dato['id_proveedor'];
                                                                        $nombre_proveedor = $proveedores_dato['nombre_proveedor']; ?>
                                                                        <tr>
                                                                            <td>
                                                                                <center><?php echo $contador = $contador + 1; ?></center>
                                                                            </td>
                                                                            <td>
                                                                                <button class="btn btn-info" id="btn_selecionar_proveedor<?php echo $id_proveedor; ?>">
                                                                                    Selecionar
                                                                                </button>
                                                                                <script>
                                                                                    $('#btn_selecionar_proveedor<?php echo $id_proveedor; ?>').click(function() {

                                                                                        var id_proveedor = '<?php echo $id_proveedor; ?>';
                                                                                        $('#id_proveedor').val(id_proveedor);

                                                                                        var nombre_proveedor = '<?php echo $nombre_proveedor; ?>';
                                                                                        $('#nombre_proveedor').val(nombre_proveedor);

                                                                                        var celular_proveedor = '<?php echo $proveedores_dato['celular']; ?>';
                                                                                        $('#celular').val(celular_proveedor);

                                                                                        var telefono_proveedor = '<?php echo $proveedores_dato['telefono']; ?>';
                                                                                        $('#telefono').val(telefono_proveedor);

                                                                                        

                                                                                        var email_proveedor = '<?php echo $proveedores_dato['email']; ?>';
                                                                                        $('#email').val(email_proveedor);

                                                                                        var direccion_proveedor = '<?php echo $proveedores_dato['direccion']; ?>';
                                                                                        $('#direccion').val(direccion_proveedor);

                                                                                        $('#modal-buscar_proveedor').modal('toggle');

                                                                                    });
                                                                                </script>
                                                                            </td>
                                                                            <td><?php echo $nombre_proveedor; ?></td>
                                                                            <td>
                                                                                <a href="https://wa.me/593<?php echo $proveedores_dato['celular']; ?>" target="_blank" class="btn btn-success">
                                                                                    <i class="fa fa-phone"></i>
                                                                                    <?php echo $proveedores_dato['celular']; ?>
                                                                                </a>
                                                                            </td>
                                                                            <td><?php echo $proveedores_dato['telefono']; ?></td>
                                                                      
                                                                            <td><?php echo $proveedores_dato['email']; ?></td>
                                                                            <td><?php echo $proveedores_dato['direccion']; ?></td>
                                                                        </tr>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                        <!-- /.modal -->
                                    </div>

                                    <hr>

                                    <div class="container-fluid" style="font-size: 12px">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <input type="text" id="id_proveedor" hidden>
                                                    <label for="">Nombre del proveedor </label>
                                                    <input type="text" id="nombre_proveedor" class="form-control" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">Celular</label>
                                                    <input type="number" id="celular" class="form-control" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">Teléfono</label>
                                                    <input type="number" id="telefono" class="form-control" disabled>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                        
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">Email</label>
                                                    <input type="email" id="email" class="form-control" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">Dirección</label>
                                                    <textarea name="" id="direccion" cols="30" rows="3" class="form-control" disabled></textarea>
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
                                                <?php
                                                $contador_de_compras = 1;
                                                foreach ($compras_datos as $compras_dato) {
                                                    $contador_de_compras = $contador_de_compras + 1;
                                                }
                                                ?>
                                                <label for="">Número de la compra</label>
                                                <input type="text" value="<?php echo $contador_de_compras; ?>" style="text-align: center" class="form-control" disabled>
                                                <input type="text" value="<?php echo $contador_de_compras; ?>" id="nro_compra" hidden>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Fecha de la compra</label>
                                                <input type="date" class="form-control" id="fecha_compra">
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Comprobante de la compra</label>
                                                <input type="text" class="form-control" id="comprobante">
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Cantidad de la compra</label>
                                                <input type="number" id="cantidad_compra" style="text-align: center" class="form-control">
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="">Precio Compra</label>
                                                    <input type="text" class="form-control" id="precio_compra_controlador">
                                                </div>
                                            </div>



                                            <!-- NUEVO CAMPO PARA SELECCIONAR EL IVA -->
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="iva">IVA (%)</label>
                                                    <input type="number" id="iva" class="form-control" min="0" max="100" step="0.01" value="0">
                                                </div>
                                            </div>


                                            <!-- NUEVO CAMPO PARA MOSTRAR EL PRECIO TOTAL CON IVA -->
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="precio_total">Precio Total con IVA</label>
                                                    <input type="text" id="precio_total" class="form-control" disabled>
                                                </div>
                                            </div>


                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Stock actual</label>
                                                    <input type="text" style="background-color: #fff819;text-align: center" id="stock_actual" class="form-control" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Stock Total</label>
                                                    <input type="text" style="text-align: center" id="stock_total" class="form-control" disabled>
                                                </div>
                                            </div>

                                            <script>
                                                $('#cantidad_compra').keyup(function() {
                                                    //alert('estamos presionando el input');
                                                    var stock_actual = $('#stock_actual').val();
                                                    var stock_compra = $('#cantidad_compra').val();

                                                    var total = parseInt(stock_actual) + parseInt(stock_compra);
                                                    $('#stock_total').val(total);

                                                });
                                            </script>
                                        </div>


                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Usuario</label>
                                                <input type="text" class="form-control" value="<?php echo $email_sesion; ?>" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <button class="btn btn-primary btn-block" id="btn_guardar_compra">Guardar compra</button>
                                        </div>
                                    </div>
                                    <script>
                                        $(document).ready(function() {

                                            // Función para calcular el total con IVA y cantidad
                                            function calcularTotal() {
                                                var precioCompra = parseFloat($('#precio_compra_controlador').val()) || 0;
                                                var cantidadCompra = parseInt($('#cantidad_compra').val()) || 1; // Si el usuario no ingresa nada, mínimo 1
                                                var iva = parseFloat($('#iva').val()) || 0;

                                                // Validar que el IVA no sea menor que 0 ni mayor a 100
                                                if (iva < 0) {
                                                    $('#iva').val(0);
                                                    iva = 0;
                                                } else if (iva > 100) {
                                                    $('#iva').val(100);
                                                    iva = 100;
                                                }

                                                // Validar que la cantidad no sea menor a 1
                                                if (cantidadCompra < 1) {
                                                    $('#cantidad_compra').val(1);
                                                    cantidadCompra = 1;
                                                }

                                                // Cálculo del precio total considerando cantidad y el IVA
                                                var subtotal = precioCompra * cantidadCompra;
                                                var precioConIva = subtotal + (subtotal * iva / 100);

                                                $('#precio_total').val(precioConIva.toFixed(2));
                                            }

                                            // Actualizar total cuando cambie el precio de compra, la cantidad o el IVA
                                            $('#precio_compra_controlador, #cantidad_compra, #iva').on('input change', function() {
                                                calcularTotal();
                                            });

                                            // Evento para guardar la compra con validaciones mejoradas
                                            $('#btn_guardar_compra').off('click').on('click', function() {
                                                console.log('Evento click detectado');

                                                var id_producto = $('#id_producto').val();
                                                var nro_compra = $('#nro_compra').val();
                                                var fecha_compra = $('#fecha_compra').val();
                                                var id_proveedor = $('#id_proveedor').val();
                                                var comprobante = $('#comprobante').val();
                                                var id_usuario = "<?php echo $id_usuario_sesion; ?>";
                                                var precio_compra = $('#precio_compra_controlador').val();
                                                var cantidad_compra = $('#cantidad_compra').val();
                                                var stock_total = $('#stock_total').val();
                                                var ivaSeleccionado = $('#iva').val();
                                                var precioTotalConIva = $('#precio_total').val();


                                                console.log("Datos enviados a create.php:");
                                                console.log({
                                                    
                                                    precio_compra: precio_compra,
                                                    cantidad_compra: cantidad_compra,
                                                    precio_total: precioTotalConIva
                                                });

                                                // Validación de campos obligatorios
                                                if (!id_producto || !fecha_compra || !comprobante || !precio_compra || !cantidad_compra || cantidad_compra <= 0) {
                                                    alert("Debe llenar todos los campos y la cantidad debe ser mayor a 0");
                                                    return; // Detiene la ejecución si falta algún campo
                                                }

                                                console.log('Todos los campos están llenos, enviando solicitud...');

                                                // Deshabilita el botón para evitar múltiples envíos
                                                $('#btn_guardar_compra').prop('disabled', true).text("Guardando...");

                                                $.ajax({
                                                    url: "../app/controllers/compras/create.php",
                                                    type: "GET",
                                                    data: {
                                                        id_producto: id_producto,
                                                        nro_compra: nro_compra,
                                                        fecha_compra: fecha_compra,
                                                        id_proveedor: id_proveedor,
                                                        comprobante: comprobante,
                                                        id_usuario: id_usuario,
                                                        precio_compra: precio_compra,
                                                        cantidad_compra: cantidad_compra,
                                                        stock_total: stock_total,
                                                        iva: ivaSeleccionado,
                                                        precio_total: precioTotalConIva
                                                    },
                                                    success: function(datos) {
                                                        console.log('Respuesta recibida:', datos);
                                                        $('#respuesta_create').html(datos);

                                                        alert("Compra guardada correctamente.");

                                                        // Rehabilita el botón y lo devuelve a su estado original
                                                        $('#btn_guardar_compra').prop('disabled', false).text("Guardar compra");
                                                    },
                                                    error: function(jqXHR, textStatus, errorThrown) {
                                                        console.error('Error en la solicitud:', textStatus, errorThrown);
                                                        alert('Hubo un error al guardar la compra.');

                                                        // Rehabilita el botón en caso de error
                                                        $('#btn_guardar_compra').prop('disabled', false).text("Guardar compra");
                                                    }
                                                });
                                            });
                                        });
                                    </script>



                                </div>

                            </div>

                        </div>

                        <div id="respuesta_create"></div>

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