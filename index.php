<?php
include('app/config.php');
include('layout/sesion.php');

include('layout/parte1.php');
include('app/controllers/usuarios/listado_de_usuarios.php');
include('app/controllers/roles/listado_de_roles.php');
include('app/controllers/categorias/listado_de_categoria.php');
include('app/controllers/almacen/listado_de_productos.php');
include('app/controllers/proveedores/listado_de_proveedores.php');

include('app/controllers/compras/listado_de_compras.php');
include('app/controllers/ventas/listado_de_ventas.php');
include('app/controllers/clientes/listado_de_clientes.php');



// Incluye el archivo de configuración y define las constantes necesarias
// Consulta para obtener las cotizaciones
// Consulta para obtener las cotizaciones
$query = "SELECT * FROM cotizacion";
try {
    // Ejecutar la consulta y obtener los resultados
    $resultadoConsulta = $pdo->query($query);
    $cotizaciones = $resultadoConsulta->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error en la consulta: " . $e->getMessage();
    exit();
}


$sql_clientes = "SELECT * FROM tb_clientes";
                
$query_clientes = $pdo->prepare($sql_clientes);
$query_clientes->execute();
$clientes_datos = $query_clientes->fetchAll(PDO::FETCH_ASSOC);


?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                <h1 class="m-0">Bienvenido al SISTEMA de FRIOS - <?php echo $_SESSION['nombre_rol']; ?> </h1>

                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">

            Contenido del sistema
            <br><br>

            <div class="row">


                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <?php
                            $contador_de_usuarios = 0;
                            foreach ($usuarios_datos as $usuarios_dato) {
                                $contador_de_usuarios = $contador_de_usuarios + 1;
                            }
                            ?>
                            <h3><?php echo $contador_de_usuarios; ?></h3>
                            <p>Usuarios Registrados</p>
                        </div>
                        <a href="<?php echo $URL; ?>/usuarios/create.php">
                            <div class="icon">
                                <i class="fas fa-user-plus"></i>
                            </div>
                        </a>
                        <a href="<?php echo $URL; ?>/usuarios" class="small-box-footer">
                            Más detalle <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>


                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <?php
                            $contador_de_roles = 0;
                            foreach ($roles_datos as $roles_dato) {
                                $contador_de_roles = $contador_de_roles + 1;
                            }
                            ?>
                            <h3><?php echo $contador_de_roles; ?></h3>
                            <p>Roles Registrados</p>
                        </div>
                        <a href="<?php echo $URL; ?>/roles/create.php">
                            <div class="icon">
                                <i class="fas fa-address-card"></i>
                            </div>
                        </a>
                        <a href="<?php echo $URL; ?>/roles" class="small-box-footer">
                            Más detalle <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>


                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <?php
                            $contador_de_categorias = 0;
                            foreach ($categorias_datos as $categorias_dato) {
                                $contador_de_categorias = $contador_de_categorias + 1;
                            }
                            ?>
                            <h3><?php echo $contador_de_categorias; ?></h3>
                            <p>Categorías Registrados</p>
                        </div>
                        <a href="<?php echo $URL; ?>/categorias">
                            <div class="icon">
                                <i class="fas fa-tags"></i>
                            </div>
                        </a>
                        <a href="<?php echo $URL; ?>/categorias" class="small-box-footer">
                            Más detalle <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>


                <div class="col-lg-3 col-6">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <?php
                            $contador_de_productos = 0;
                            foreach ($productos_datos as $productos_dato) {
                                $contador_de_productos = $contador_de_productos + 1;
                            }
                            ?>
                            <h3><?php echo $contador_de_productos; ?></h3>
                            <p>Productos Registrados</p>
                        </div>
                        <a href="<?php echo $URL; ?>/almacen/create.php">
                            <div class="icon">
                                <i class="fas fa-list"></i>
                            </div>
                        </a>
                        <a href="<?php echo $URL; ?>/almacen" class="small-box-footer">
                            Más detalle <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>





                <div class="col-lg-3 col-6">
                    <div class="small-box bg-dark">
                        <div class="inner">
                            <?php
                            $contador_de_proveedores = 0;
                            foreach ($proveedores_datos as $proveedores_dato) {
                                $contador_de_proveedores = $contador_de_proveedores + 1;
                            }
                            ?>
                            <h3><?php echo $contador_de_proveedores; ?></h3>
                            <p>Proveedores Registrados</p>
                        </div>
                        <a href="<?php echo $URL; ?>/proveedores">
                            <div class="icon">
                                <i class="fas fa-car"></i>
                            </div>
                        </a>
                        <a href="<?php echo $URL; ?>/proveedores" class="small-box-footer">
                            Más detalle <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>



                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <?php
                            $contador_de_compras = 0;
                            foreach ($compras_datos as $compras_dato) {
                                $contador_de_compras = $contador_de_compras + 1;
                            }
                            ?>
                            <h3><?php echo $contador_de_compras; ?></h3>
                            <p>Compras Registradas</p>
                        </div>
                        <a href="<?php echo $URL; ?>/compras">
                            <div class="icon">
                                <i class="fas fa-cart-plus"></i>
                            </div>
                        </a>
                        <a href="<?php echo $URL; ?>/compras" class="small-box-footer">
                            Más detalle <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>




                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <?php
                            $contador_de_ventas = 0;
                            foreach ($ventas_datos as $ventas_dato) {
                                $contador_de_ventas = $contador_de_ventas + 1;
                            }
                            ?>
                            <h3><?php echo $contador_de_ventas; ?></h3>
                            <p>Ventas Registradas</p>
                        </div>
                        <a href="<?php echo $URL; ?>/ventas">
                            <div class="icon">
                                <i class="fas fa-shopping-basket"></i>
                            </div>
                        </a>
                        <a href="<?php echo $URL; ?>/ventas" class="small-box-footer">
                            Más detalle <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>



                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <?php
                            $contador_de_clientes = 0;
                            foreach ($clientes_datos as $clientes_dato) {
                                $contador_de_clientes = $contador_de_clientes + 1;
                            }
                            ?>
                            <h3><?php echo $contador_de_clientes; ?></h3>
                            <p>Clientes Registradas</p>
                        </div>
                        <a href="<?php echo $URL; ?>/clientes">
                            <div class="icon">
                                <i class="fas fa-shopping-basket"></i>
                            </div>
                        </a>
                        <a href="<?php echo $URL; ?>/clientes" class="small-box-footer">
                            Más detalle <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Cotizaciónes
                    </div>
                    <div class="card-body">
                        <!--<div class="table-responsive">-->
                        <!--<div class="table-responsive">-->
                        <!--<table id="datatablesSimple" class="table table-bordered table-hover mb-0">-->
                        <table id="datatablesSimple" class="display responsive" style="width:100%">
                            <thead>
                                <tr>
                                    <th data-priority="1">Nombre </th>

                                    <th data-priority="1">Apellido </th>
                                    <th data-priority="2">Correo</th>
                                    <th data-priority="3">Teléfono</th>
                                    <th data-priority="4">Orden de trabajo</th>
                                    <th data-priority="5">Solicitud</th>
                                    <th data-priority="6">Estado Cotización</th>
                                    <th data-priority="7" class="d-none d-md-table-cell">Observación</th>
                                    <th data-priority="8">Fecha</th>
                                    <th data-priority="9">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($cotizaciones as $cotizacion) : ?>
                                    <tr>
                                    <td><?php echo htmlspecialchars($cotizacion['nombres'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
<td><?php echo htmlspecialchars($cotizacion['apellidos'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
<td><?php echo htmlspecialchars($cotizacion['correo'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
<td><?php echo htmlspecialchars($cotizacion['telefono'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
<td><?php echo htmlspecialchars($cotizacion['orden_trabajo'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
<td><?php echo htmlspecialchars($cotizacion['solicitud'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
<td><?php echo htmlspecialchars($cotizacion['estado_cotizacion'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
<td class="d-none d-md-table-cell"><?php echo htmlspecialchars($cotizacion['observacion'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
<td><?php echo htmlspecialchars($cotizacion['fecha'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>

                                        <td>
                                            <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#editModal" onclick="llenarModal(<?php echo htmlspecialchars(json_encode($cotizacion)); ?>)">Editar</a>
                                            <a href="#" class="btn btn-danger" onclick="eliminarCotizacion(<?php echo $cotizacion['id_cotizacion']; ?>)">Eliminar</a>
                                            </td>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                            </tbody>
                        </table>


                    </div>
                </div>



            </div>

            <!-- /.row -->






            <!-- Modal -->
            <!-- Modal de Edición -->
            <!-- Modal de Edición -->
            <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Editar Información</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editForm" method="POST">
                    <input type="hidden" id="cotizacionId" name="cotizacionId">

                    <div class="form-group">
                        <label for="estado">Estado Cotización</label>
                        <select class="form-control" id="estado" name="estado" required>
                            <option value="En proceso">En proceso</option>
                            <option value="Atendido">Atendido</option>
                            <option value="Abandono en proceso">Abandono en proceso</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="observacion">Observación</label>
                        <input type="text" class="form-control" id="observacion" name="observacion" required>
                    </div>
                    <button type="submit" class="btn btn-secondary" id="saveChanges">Guardar Cambios</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- Incluir SweetAlert -->

<script>





function llenarModal(cotizacion) {
    console.log('Objeto cotizacion:', cotizacion); // Verifica el objeto completo

    // Configurar el valor del campo oculto del ID
    document.getElementById('cotizacionId').value = cotizacion.id_cotizacion;

    // Configurar el valor del campo 'estado'
    const estadoSelect = document.getElementById('estado');
    const estadoValue = cotizacion.estado_cotizacion.trim();
    estadoSelect.value = estadoValue;

    // Validar si el valor fue asignado correctamente
    if (estadoSelect.value !== estadoValue) {
        console.warn(`El valor "${estadoValue}" no se encontró en las opciones de estado.`);
    }

    // Asignar el valor de observación
    const observacionInput = document.getElementById('observacion');
    observacionInput.value = cotizacion.observacion ? cotizacion.observacion.trim() : '';

    // Verifica el valor del campo 'observacion' después de asignar
    console.log('Valor del campo "observacion" después de asignar:', observacionInput.value);
}

    document.getElementById('editForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Evita el envío del formulario por defecto

        const formData = new FormData(this);

        fetch('./app/controllers/cotizacion/guardar_estado_cotizacion.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            console.log('Respuesta del servidor:', data);

            if (data.status === 'success') {
                Swal.fire({
                    title: '¡Éxito!',
                    text: data.message,
                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload(); // Recargar la página para ver los cambios
                    }
                });
            } else {
                Swal.fire({
                    title: 'Error',
                    text: data.message,
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                title: 'Error',
                text: 'Ocurrió un error al procesar la solicitud.',
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
        });
    });



    function eliminarCotizacion(cotizacionId) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "No podrás revertir esto",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminarlo!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: './app/controllers/cotizacion/eliminar_cotizacion.php',
                type: 'POST',
                data: { cotizacionId: cotizacionId },
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Eliminado!',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            $('tr').has('a[onclick="eliminarCotizacion(' + cotizacionId + ')"]').remove();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Ocurrió un problema al intentar eliminar la cotización. ' +
                              'Detalles: ' + status + ' ' + error + ' ' + xhr.responseText
                    });
                }
            });
        }
    });
}



</script>




        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<script>
    $(document).ready(function() {
        var dataTable = $('#datatablesSimple').DataTable({
            "columnDefs": [{
                "targets": [-1], // Última columna (Acciones)
                "orderable": false,
                "searchable": false
            }]
        });



    });
</script>





<?php include('layout/parte2.php'); ?>