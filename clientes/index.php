<?php

include('../app/config.php');
include('../layout/sesion.php');

include('../layout/parte1.php');


include('../app/controllers/clientes/listado_de_clientes.php');


?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Listado de clientes</h1>
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
                            <h3 class="card-title">Clientes registrados</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body" style="display: block;">
                            <!-- Botón para agregar cliente -->
                            <div class="mb-3">
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalAgregarCliente">
                                    <i class="fas fa-plus"></i> Agregar Cliente
                                </button>
                            </div>

                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>
                                            <center>Nro</center>
                                        </th>
                                        <th>
                                            <center>Nombre del cliente</center>
                                        </th>
                                        <th>
                                            <center>Ruc/C.I del cliente</center>
                                        </th>
                                        <th>
                                            <center>Celular</center>
                                        </th>
                                        <th>
                                            <center>Email</center>
                                        </th>
                                        <th>
                                            <center>Estado</center>
                                        </th> <!-- <-- AÑADIR ESTA COLUMNA -->
                                        <th>
                                            <center>Acciones</center>
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $contador = 0;
                                    foreach ($clientes_datos as $clientes_dato) {
                                        $id_cliente = $clientes_dato['id_cliente'];
                                    ?>
                                        <tr>
                                            <td>
                                                <center><?php echo ++$contador; ?></center>
                                            </td>
                                            <td><?php echo $clientes_dato['nombre_cliente']; ?></td>
                                            <td><?php echo $clientes_dato['nit_ci_cliente']; ?></td>
                                            <td><?php echo $clientes_dato['celular_cliente']; ?></td>
                                            <td><?php echo $clientes_dato['email_cliente']; ?></td>
                                            <td>
                                                <?php
                                                echo $clientes_dato['estado'] == 'activo'
                                                    ? '<span class="badge badge-success">Activo</span>'
                                                    : '<span class="badge badge-danger">Inactivo</span>';
                                                ?>
                                            </td> <!-- <-- AQUÍ estado separado -->
                                            <td>
                                                <center>
                                                    <?php if ($clientes_dato['estado'] == 'activo'): ?>
                                                        <button class="btn btn-warning btn-sm" onclick="editarCliente(<?php echo $id_cliente; ?>, '<?php echo addslashes($clientes_dato['nombre_cliente']); ?>', '<?php echo addslashes($clientes_dato['nit_ci_cliente']); ?>', '<?php echo addslashes($clientes_dato['celular_cliente']); ?>', '<?php echo addslashes($clientes_dato['email_cliente']); ?>')">
                                                            <i class="fas fa-edit"></i> Editar
                                                        </button>
                                                        <button class="btn btn-danger btn-sm" onclick="cambiarEstadoCliente(<?php echo $id_cliente; ?>, 'inactivo')">
                                                            <i class="fas fa-user-slash"></i> Desactivar
                                                        </button>
                                                    <?php else: ?>
                                                        <button class="btn btn-success btn-sm" onclick="cambiarEstadoCliente(<?php echo $id_cliente; ?>, 'activo')">
                                                            <i class="fas fa-user-check"></i> Activar
                                                        </button>
                                                    <?php endif; ?>
                                                </center>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <th>
                                            <center>Nro</center>
                                        </th>
                                        <th>
                                            <center>Nombre del cliente</center>
                                        </th>
                                        <th>
                                            <center>Ruc/C.I del cliente</center>
                                        </th>
                                        <th>
                                            <center>Celular</center>
                                        </th>
                                        <th>
                                            <center>Email</center>
                                        </th>
                                        <th>
                                            <center>Estado</center>
                                        </th> <!-- <-- Igual aquí en el pie -->
                                        <th>
                                            <center>Acciones</center>
                                        </th>
                                    </tr>
                                </tfoot>

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
<!-- Modal para agregar cliente -->
<div class="modal fade" id="modalAgregarCliente" tabindex="-1" role="dialog" aria-labelledby="modalAgregarClienteLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAgregarClienteLabel">Agregar Nuevo Cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formAgregarCliente">
                    <div class="form-group">
                        <label for="nombre_cliente">Nombre del Cliente</label>
                        <input type="text" name="nombre_cliente" class="form-control" placeholder="Escriba el nombre del cliente" required>
                    </div>
                    <div class="form-group">
                        <label for="nit_ci_cliente">RUC/C.I del Cliente</label>
                        <input type="text" name="nit_ci_cliente" class="form-control" placeholder="Escriba el RUC o C.I del cliente" required>
                    </div>
                    <div class="form-group">
                        <label for="celular_cliente">Celular</label>
                        <input type="tel" name="celular_cliente" class="form-control" placeholder="Escriba el número de celular" required>
                    </div>
                    <div class="form-group">
                        <label for="email_cliente">Email</label>
                        <input type="email" name="email_cliente" class="form-control" placeholder="Escriba el correo del cliente" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar Cliente</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<?php include('../layout/mensajes.php'); ?>
<?php include('../layout/parte2.php'); ?>



<!-- Modal para Editar Cliente -->
<!-- Modal para Editar Cliente -->
<div class="modal fade" id="modalEditarCliente" tabindex="-1" role="dialog" aria-labelledby="modalEditarClienteLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditarClienteLabel">Editar Cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formEditarCliente" method="post" onsubmit="guardarCambiosCliente(); return false;">
                    <input type="hidden" name="id_cliente" id="id_cliente">
                    <div class="form-group">
                        <label for="nombre_cliente">Nombre del Cliente (Edit)</label>
                        <input type="text" name="nombre_cliente" id="nombre_cliente" class="form-control" placeholder="Escriba el nombre del cliente" required>
                    </div>
                    <div class="form-group">
                        <label for="nit_ci_cliente">RUC/C.I del Cliente (Edit)</label>
                        <input type="text" name="nit_ci_cliente" id="nit_ci_cliente" class="form-control" placeholder="Escriba el RUC o C.I del cliente" required>
                    </div>
                    <div class="form-group">
                        <label for="celular_cliente">Celular (Edit)</label>
                        <input type="tel" name="celular_cliente" id="celular_cliente" class="form-control" placeholder="Escriba el número de celular" required>
                    </div>
                    <div class="form-group">
                        <label for="email_cliente">Email (Edit)</label>
                        <input type="email" name="email_cliente" id="email_cliente" class="form-control" placeholder="Escriba el correo del cliente" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>





<script>
    $(function() {
        $("#example1").DataTable({
            "pageLength": 5,
            "language": {
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Usuarios",
                "infoEmpty": "Mostrando 0 a 0 de 0 Usuarios",
                "infoFiltered": "(Filtrado de _MAX_ total Usuarios)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Usuarios",
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



    document.getElementById('formAgregarCliente').addEventListener('submit', function(e) {
        e.preventDefault(); // Evitar el envío normal del formulario

        // Crear objeto FormData con los datos del formulario
        const formData = new FormData(this);

        // Enviar la solicitud AJAX
        fetch('../app/controllers/clientes/guardar_clientes.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json()) // Esperar respuesta JSON del servidor
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Cliente agregado',
                        text: 'El cliente fue agregado correctamente.',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload(); // Recargar la página o actualizar la tabla
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'No se pudo registrar el cliente.',
                        confirmButtonText: 'OK'
                    });
                }
            })
            .catch(error => {
                console.error('Error en la solicitud:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un problema al enviar los datos.',
                    confirmButtonText: 'OK'
                });
            });
    });


    function editarCliente(id_cliente, nombre_cliente, nit_ci_cliente, celular_cliente, email_cliente) {
        // Mostrar el modal
        $('#modalEditarCliente').modal('show');

        // Llenar los campos del modal con los datos del cliente
        document.getElementById('id_cliente').value = id_cliente;
        document.getElementById('nombre_cliente').value = nombre_cliente;
        document.getElementById('nit_ci_cliente').value = nit_ci_cliente;
        document.getElementById('celular_cliente').value = celular_cliente;
        document.getElementById('email_cliente').value = email_cliente;
    }

    function guardarCambiosCliente() {
        const id_cliente = document.getElementById('id_cliente').value;
        const nombre_cliente = document.getElementById('nombre_cliente').value;
        const nit_ci_cliente = document.getElementById('nit_ci_cliente').value;
        const celular_cliente = document.getElementById('celular_cliente').value;
        const email_cliente = document.getElementById('email_cliente').value;

        // Crea el objeto de datos a enviar
        const datos = new URLSearchParams();
        datos.append('id_cliente', id_cliente);
        datos.append('nombre_cliente', nombre_cliente);
        datos.append('nit_ci_cliente', nit_ci_cliente);
        datos.append('celular_cliente', celular_cliente);
        datos.append('email_cliente', email_cliente);

        // Realiza la petición AJAX para guardar los cambios
        fetch('../app/controllers/clientes/guardar_cambios.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: datos.toString()
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la respuesta de red');
                }
                return response.json(); // Convierte la respuesta a JSON
            })
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: data.message
                    });
                    $('#modalEditarCliente').modal('hide'); // Cierra el modal
                    location.reload(); // Recarga la página para reflejar los cambios
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ocurrió un error: ' + error.message
                });
            });
    }



    function cambiarEstadoCliente(id_cliente, nuevo_estado) { // <-- recibir el estado como parámetro
    fetch(`../app/controllers/clientes/cambiar_estado.php?id_cliente=${id_cliente}&nuevo_estado=${nuevo_estado}`, {
            method: 'POST', 
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la respuesta de red');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: data.message,
                    confirmButtonText: 'OK'
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message,
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Ocurrió un error: ' + error.message,
                confirmButtonText: 'OK'
            });
        });
}

</script>