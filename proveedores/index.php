<?php
include('../app/config.php');
include('../layout/sesion.php');

include('../layout/parte1.php');


include('../app/controllers/proveedores/listado_de_proveedores.php');


?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Listado de Proveedores
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-create">
                            <i class="fa fa-plus"></i> Agregar Nuevo Proveedor
                        </button>
                    </h1>
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
                            <h3 class="card-title">Proveedores registrados</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                </button>
                            </div>

                        </div>

                        <div class="card-body" style="display: block;">
                            <table id="example1" class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>
                                            <center>Nro</center>
                                        </th>
                                        <th>
                                            <center>Nombre del proveedor</center>
                                        </th>
                                        <th>
                                            <center>Celular</center>
                                        </th>
                                        <th>
                                            <center>Cedula</center>
                                        </th>
                                        <th>
                                            <center>Distribuidora</center>
                                        </th>
                                        <th>
                                            <center>Email</center>
                                        </th>
                                        <th>
                                            <center>Dirección</center>
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
                                    foreach ($proveedores_datos as $proveedores_dato) {
                                        $id_proveedor = $proveedores_dato['id_proveedor'];
                                        $nombre_proveedor = $proveedores_dato['nombre_proveedor']; ?>
                                        <tr>
                                            <td>
                                                <center><?php echo $contador = $contador + 1; ?></center>
                                            </td>
                                            <td><?php echo $nombre_proveedor; ?></td>
                                            <td>
                                                <a href="https://wa.me/591<?php echo $proveedores_dato['celular']; ?>" target="_blank" class="btn btn-success">
                                                    <i class="fa fa-phone"></i>
                                                    <?php echo $proveedores_dato['celular']; ?>
                                                </a>
                                            </td>
                                            <td><?php echo $proveedores_dato['telefono']; ?></td>
                                            <td><?php echo $proveedores_dato['nombre_distribuidora']; ?></td>

                                            <td><?php echo $proveedores_dato['email']; ?></td>
                                            <td><?php echo $proveedores_dato['direccion']; ?></td>



                                            <td>
                                                <center>
                                                    <?php
                                                    $estado = $proveedores_dato['estado'] ?? 'Activo';
                                                    if ($estado === 'Inactivo') {
                                                        echo "<span class='badge bg-danger'>Inactivo</span>";
                                                    } else {
                                                        echo "<span class='badge bg-success'>Activo</span>";
                                                    }
                                                    ?>
                                                </center>
                                            </td>


                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-success" data-toggle="modal"
                                                        data-target="#modal-update<?php echo $id_proveedor; ?>">
                                                        <i class="fa fa-pencil-alt"></i> Editar
                                                    </button>




                                                    <!-- modal para actualizar proveedor -->
                                                    <div class="modal fade" id="modal-update<?php echo $id_proveedor; ?>">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header" style="background-color: #116f4a;color: white">
                                                                    <h4 class="modal-title">Actualización del proveedor</h4>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>

                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="">Nombre del proveedor <b>*</b></label>
                                                                                <input type="text" id="nombre_proveedor<?php echo $id_proveedor; ?>" value="<?php echo $nombre_proveedor; ?>" class="form-control">
                                                                                <small style="color: red;display: none" id="lbl_nombre<?php echo $id_proveedor; ?>">* Este campo es requerido</small>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="">Celular <b>*</b></label>
                                                                                <input type="number" id="celular<?php echo $id_proveedor; ?>" value="<?php echo $proveedores_dato['celular']; ?>" class="form-control">
                                                                                <small style="color: red;display: none" id="lbl_celular<?php echo $id_proveedor; ?>">* Este campo es requerido</small>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="">Cédula</label>
                                                                                <input type="number" id="telefono<?php echo $id_proveedor; ?>" value="<?php echo $proveedores_dato['telefono']; ?>" class="form-control">
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Ahora el select también en un row -->
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="form-group">
                                                                                <label for="">Distribuidora <b>*</b></label>
                                                                                <select id="id_distribuidora<?php echo $id_proveedor; ?>" class="form-control">
                                                                                    <option value="">Seleccione una distribuidora</option>
                                                                                    <?php
                                                                                    $query = $pdo->prepare("SELECT id_distribuidora, compania FROM distribuidora WHERE estado = 'Activo'");
                                                                                    $query->execute();
                                                                                    $distribuidoras = $query->fetchAll(PDO::FETCH_ASSOC);
                                                                                    foreach ($distribuidoras as $distribuidora) {
                                                                                        $selected = ($proveedores_dato['id_distribuidora'] == $distribuidora['id_distribuidora']) ? 'selected' : '';
                                                                                        echo "<option value='" . $distribuidora['id_distribuidora'] . "' $selected>" . $distribuidora['compania'] . "</option>";
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                                <small style="color: red;display: none" id="lbl_distribuidora<?php echo $id_proveedor; ?>">* Este campo es requerido</small>

                                                                                <small class="form-text text-muted">
                                                                                    Distribuidora asignada: <strong><?php echo $proveedores_dato['nombre_distribuidora']; ?></strong>
                                                                                </small>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="">Email</label>
                                                                                <input type="email" id="email<?php echo $id_proveedor; ?>" value="<?php echo $proveedores_dato['email']; ?>" class="form-control">
                                                                                <small style="color: red;display: none" id="lbl_email<?php echo $id_proveedor; ?>">* Este campo es requerido</small>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="">Dirección <b>*</b></label>
                                                                                <textarea name="" id="direccion<?php echo $id_proveedor; ?>" cols="30" rows="3" class="form-control"><?php echo $proveedores_dato['direccion']; ?></textarea>
                                                                                <small style="color: red;display: none" id="lbl_direccion<?php echo $id_proveedor; ?>">* Este campo es requerido</small>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                                <div class="modal-footer justify-content-between">
                                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                                                    <button type="button" class="btn btn-success" id="btn_update<?php echo $id_proveedor; ?>">Actualizar</button>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- /.modal -->

                                                    <!-- /.modal -->
                                                    <script>
                                                        $('#btn_update<?php echo $id_proveedor; ?>').click(function() {
                                                            var id_proveedor = '<?php echo $id_proveedor; ?>';
                                                            var nombre_proveedor = $('#nombre_proveedor<?php echo $id_proveedor; ?>').val();
                                                            var celular = $('#celular<?php echo $id_proveedor; ?>').val();
                                                            var telefono = $('#telefono<?php echo $id_proveedor; ?>').val();
                                                            var email = $('#email<?php echo $id_proveedor; ?>').val();
                                                            var direccion = $('#direccion<?php echo $id_proveedor; ?>').val();
                                                            var id_distribuidora = $('#id_distribuidora<?php echo $id_proveedor; ?>').val();

                                                            if (nombre_proveedor == "") {
                                                                $('#nombre_proveedor<?php echo $id_proveedor; ?>').focus();
                                                                $('#lbl_nombre<?php echo $id_proveedor; ?>').css('display', 'block');
                                                            } else if (celular == "") {
                                                                $('#celular<?php echo $id_proveedor; ?>').focus();
                                                                $('#lbl_celular<?php echo $id_proveedor; ?>').css('display', 'block');
                                                            } else if (direccion == "") {
                                                                $('#direccion<?php echo $id_proveedor; ?>').focus();
                                                                $('#lbl_direccion<?php echo $id_proveedor; ?>').css('display', 'block');
                                                            } else if (id_distribuidora == "") {
                                                                $('#id_distribuidora<?php echo $id_proveedor; ?>').focus();
                                                                $('#lbl_distribuidora<?php echo $id_proveedor; ?>').css('display', 'block');
                                                            } else {
                                                                var url = "../app/controllers/proveedores/update.php";

                                                                $.get(url, {
                                                                    id_proveedor: id_proveedor,
                                                                    nombre_proveedor: nombre_proveedor,
                                                                    celular: celular,
                                                                    telefono: telefono,
                                                                    email: email,
                                                                    direccion: direccion,
                                                                    id_distribuidora: id_distribuidora
                                                                }, function(response) {
                                                                    if (response.trim() === 'success') {
                                                                        Swal.fire({
                                                                            icon: 'success',
                                                                            title: 'Actualizado',
                                                                            text: 'El proveedor fue actualizado correctamente',
                                                                            confirmButtonText: 'Aceptar',
                                                                            confirmButtonColor: '#3085d6'
                                                                        }).then((result) => {
                                                                            if (result.isConfirmed) {
                                                                                location.reload(); // ✅ Recargar solo si realmente se actualizó
                                                                            }
                                                                        });
                                                                    } else {
                                                                        Swal.fire({
                                                                            icon: 'error',
                                                                            title: 'Error',
                                                                            text: 'No se pudo actualizar el proveedor. Intenta nuevamente',
                                                                            confirmButtonText: 'Aceptar'
                                                                        });
                                                                    }
                                                                }).fail(function() {
                                                                    Swal.fire({
                                                                        icon: 'error',
                                                                        title: 'Error',
                                                                        text: 'No se pudo comunicar con el servidor. Intenta nuevamente',
                                                                        confirmButtonText: 'Aceptar'
                                                                    });
                                                                });

                                                            }
                                                        });
                                                    </script>


                                                    <div id="respuesta_update<?php echo $id_proveedor; ?>"></div>
                                                </div>



                                                <div class="btn-group">
                                                    <?php
                                                    $estado = $proveedores_dato['estado'] ?? 'Activo';
                                                    $deshabilitar = ($estado === 'Inactivo') ? 'disabled' : '';
                                                    ?>

                                                    <button type="button" class="btn btn-danger" data-toggle="modal"
                                                        data-target="#modal-delete<?php echo $id_proveedor; ?>" <?php echo $deshabilitar; ?>>
                                                        <i class="fa fa-trash"></i> Borrar
                                                    </button>

                                                    <!-- modal para borrar proveedore -->
                                                    <div class="modal fade" id="modal-delete<?php echo $id_proveedor; ?>">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header" style="background-color: #ca0a0b;color: white">
                                                                    <h4 class="modal-title">¿Esta seguro de eliminar al proveedor?</h4>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>

                                                                <div class="modal-footer justify-content-between">
                                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                                                    <button type="button" class="btn btn-danger" id="btn_delete<?php echo $id_proveedor; ?>">Eliminar</button>
                                                                </div>
                                                                <div id="respuesta_delete<?php echo $id_proveedor; ?>"></div>
                                                            </div>
                                                            <!-- /.modal-content -->
                                                        </div>
                                                        <!-- /.modal-dialog -->
                                                    </div>
                                                    <!-- /.modal -->
                                                    <script>
                                                        $('#btn_delete<?php echo $id_proveedor; ?>').click(function() {
                                                            var id_proveedor = '<?php echo $id_proveedor; ?>';

                                                            var url2 = "../app/controllers/proveedores/delete.php";
                                                            $.get(url2, {
                                                                id_proveedor: id_proveedor
                                                            }, function(datos) {
                                                                $('#respuesta_delete<?php echo $id_proveedor; ?>').html(datos);

                                                                // Opcional: Recargar luego de 1.5 segundos
                                                                setTimeout(function() {
                                                                    location.reload();
                                                                }, 1500);
                                                            });
                                                        });
                                                    </script>

                                                    <?php if ($estado === 'Inactivo') : ?>
                                                        <button type="button" class="btn btn-success" id="btn_activar<?php echo $id_proveedor; ?>">
                                                            <i class="fa fa-check"></i> Activar
                                                        </button>

                                                        <script>
                                                            $('#btn_activar<?php echo $id_proveedor; ?>').click(function() {
                                                                var id_proveedor = '<?php echo $id_proveedor; ?>';

                                                                $.ajax({
                                                                    url: "../app/controllers/proveedores/activar.php",
                                                                    type: "POST",
                                                                    data: {
                                                                        id_proveedor: id_proveedor
                                                                    },
                                                                    success: function(respuesta) {
                                                                        $('#respuesta_delete<?php echo $id_proveedor; ?>').html(respuesta);
                                                                        setTimeout(() => location.reload(), 1500);
                                                                    },
                                                                    error: function() {
                                                                        Swal.fire({
                                                                            icon: 'error',
                                                                            title: 'Error',
                                                                            text: 'No se pudo activar el proveedor.'
                                                                        });
                                                                    }
                                                                });
                                                            });
                                                        </script>
                                                    <?php endif; ?>



                                                </div>

                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
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





<!-- modal para registrar proveedores -->
<div class="modal fade" id="modal-create">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #1d36b6;color: white">
                <h4 class="modal-title">Creación de un nuevo proveedor</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Nombre del proveedor <b>*</b></label>
                            <input type="text" id="nombre_proveedor" class="form-control">
                            <small style="color: red;display: none" id="lbl_nombre">* Este campo es requerido</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Celular <b>*</b></label>
                            <input type="number" id="celular" class="form-control">
                            <small style="color: red;display: none" id="lbl_celular">* Este campo es requerido</small>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Cédula</label>
                            <input type="number" id="telefono" class="form-control">
                        </div>
                    </div>

                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Distribuidora <b>*</b></label>
                        <select id="id_distribuidora" class="form-control">
                            <option value="">Seleccione una distribuidora</option>
                            <?php
                            $query = $pdo->prepare("SELECT id_distribuidora, compania FROM distribuidora WHERE estado = 'Activo'");
                            $query->execute();
                            $distribuidoras = $query->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($distribuidoras as $distribuidora) {
                                echo "<option value='" . $distribuidora['id_distribuidora'] . "'>" . $distribuidora['compania'] . "</option>";
                            }
                            ?>
                        </select>
                        <small style="color: red;display: none" id="lbl_distribuidora">* Este campo es requerido</small>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="email" id="email" class="form-control">
                            <small style="color: red;display: none" id="lbl_email">* Este campo es requerido</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Dirección <b>*</b></label>
                            <textarea name="" id="direccion" cols="30" rows="3" class="form-control"></textarea>
                            <small style="color: red;display: none" id="lbl_direccion">* Este campo es requerido</small>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btn_create">Guardar proveedor</button>
            </div>
            <div id="respuesta"></div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script>
    $('#btn_create').click(function() {
        var nombre_proveedor = $('#nombre_proveedor').val();
        var celular = $('#celular').val();
        var telefono = $('#telefono').val();

        var email = $('#email').val();
        var direccion = $('#direccion').val();
        var id_distribuidora = $('#id_distribuidora').val(); // 👈 Obtenemos el valor del select

        // Validaciones
        if (nombre_proveedor == "") {
            $('#nombre_proveedor').focus();
            $('#lbl_nombre').css('display', 'block');
        } else if (celular == "") {
            $('#celular').focus();
            $('#lbl_celular').css('display', 'block');
        } else if (direccion == "") {
            $('#direccion').focus();
            $('#lbl_direccion').css('display', 'block');
        } else if (id_distribuidora == "") {
            $('#id_distribuidora').focus();
            $('#lbl_distribuidora').css('display', 'block'); // 👈 Mostramos mensaje de error
        } else {
            var url = "../app/controllers/proveedores/create.php";
            $.get(url, {
                nombre_proveedor: nombre_proveedor,
                celular: celular,
                telefono: telefono,
                email: email,
                direccion: direccion,
                id_distribuidora: id_distribuidora // 👈 Enviamos el valor al servidor
            }, function(datos) {
                $('#respuesta').html(datos);
            });
        }
    });
</script>