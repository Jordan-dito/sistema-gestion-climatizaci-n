<?php
include('../app/config.php');
include('../layout/sesion.php');

include('../layout/parte1.php');






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
                            <h3 class="card-title">Usuarios Registrados</h3>
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
                                                <th>Nro</th>
                                                <th>Cédula</th>
                                                <th>Nombre Cliente</th>
                                                <th>Apellido</th>
                                                <th>Rol del usuario</th>
                                                <th>Celular</th>
                                                <th>Email</th>
                                                <th>Fecha de Creación</th>
                                                <th>Dirección</th>
                                                <th>Estado</th> <!-- NUEVA COLUMNA -->
                                                <th>Acciones</th>
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

            // Realizar la solicitud AJAX
            $.ajax({
                url: '../app/controllers/reportes/controlador_reporte_usuarios.php',
                method: 'GET',
                data: {
                    fechaInicio: fechaInicio,
                    fechaFin: fechaFin
                },
                dataType: 'json',
                success: function(response) {
                    let tbody = $('#example1 tbody');
                    tbody.empty(); // Limpiar el cuerpo de la tabla

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

                    // Verificar si 'response' es un arreglo
                    if (Array.isArray(response) && response.length > 0) {
                        // Iterar sobre los datos recibidos y agregar filas a la tabla
                        response.forEach((usuario, index) => {
                            const estado = usuario.estado == 1 ?
                                '<span class="badge badge-success">Activo</span>' :
                                '<span class="badge badge-danger">Inactivo</span>';

                            const acciones = usuario.estado == 1 ?
                                `
                            <button class="btn btn-warning btn-sm btn-edit" 
                                data-id="${usuario.id_usuario}" 
                                data-cedula="${usuario.cedula}" 
                                data-nombres="${usuario.nombres}" 
                                data-apellidos="${usuario.apellidos}" 
                                data-rol="${usuario.rol}" 
                                data-telefono="${usuario.telefono_empl}" 
                                data-email="${usuario.email}" 
                                data-direccion="${usuario.direccion_emple}">
                                <i class="fas fa-edit"></i> Editar
                            </button>
                            <button class="btn btn-danger btn-sm btn-estado" 
                                data-id="${usuario.id_usuario}" 
                                data-estado="0">
                                <i class="fas fa-user-slash"></i> Desactivar
                            </button>
                            ` :
                                                    `
                            <button class="btn btn-success btn-sm btn-estado" 
                                data-id="${usuario.id_usuario}" 
                                data-estado="1">
                                <i class="fas fa-user-check"></i> Activar
                            </button>
                            `;

                                                const fila = `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${usuario.cedula}</td>
                                <td>${usuario.nombres}</td>
                                <td>${usuario.apellidos}</td>
                                <td>${usuario.rol}</td>
                                <td>${usuario.telefono_empl}</td>
                                <td>${usuario.email}</td>
                                <td>${usuario.fecha_creacion}</td>
                                <td>${usuario.direccion_emple}</td>
                                <td>${estado}</td>
                                <td>${acciones}</td>
                            </tr>
                        `;
                                                $('#example1 tbody').append(fila);
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


    $(document).ready(function() {
        // Evento para abrir el modal y rellenar los campos
        $(document).on('click', '.btn-edit', function() {
            const button = $(this); // Botón que dispara el evento

            // Obtener datos del atributo data
            const id = button.data('id');
            const cedula = button.data('cedula');
            const nombres = button.data('nombres');
            const apellidos = button.data('apellidos');
            const rol = button.data('rol');
            const telefono = button.data('telefono');
            const email = button.data('email');
            const direccion = button.data('direccion');

            // Rellenar el formulario del modal
            $('#editUserForm #userId').val(id);
            $('#editUserForm #cedula').val(cedula);
            $('#editUserForm #nombres').val(nombres);
            $('#editUserForm #apellidos').val(apellidos);
            $('#editUserForm #rol').val(rol);
            $('#editUserForm #telefono').val(telefono);
            $('#editUserForm #email').val(email);
            $('#editUserForm #direccion').val(direccion);

            // Abrir el modal
            $('#editUserModal').modal('show');
        });

        // Evento para manejar la sumisión del formulario
        $('#editUserForm').on('submit', function(event) {
            event.preventDefault();

            // Recoger datos del formulario
            const formData = $(this).serializeArray();

            console.log('Datos del formulario:', formData);

            // Aquí puedes manejar los datos del formulario, por ejemplo:
            // Actualizar la tabla o enviar los datos a un backend.
            Swal.fire({
                icon: 'success',
                title: 'Cambios guardados',
                text: 'El usuario ha sido actualizado correctamente.',
                confirmButtonText: 'Entendido',
                confirmButtonColor: '#3085d6'
            });

            // Cerrar el modal
            $('#editUserModal').modal('hide');
        });
    });


    function guardarFormularioUsuario() {
        // Evento para manejar la sumisión del formulario
        $('#editUserForm').on('submit', function(event) {
            event.preventDefault();

            // Recoger datos del formulario
            const formData = $(this).serializeArray();

            // Eliminar el campo 'rol' del arreglo para no enviarlo en la actualización
            const filteredData = formData.filter(item => item.name !== 'rol');

            console.log('Datos del formulario (sin rol):', filteredData);

            // Enviar los datos a un backend mediante AJAX
            $.ajax({
                url: '../app/controllers/reportes/controlador_actualizar_usuario.php', // Cambia esta URL según tu lógica
                method: 'POST',
                data: filteredData,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: 'Los cambios se guardaron correctamente.',
                        confirmButtonText: 'Ok',
                        confirmButtonColor: '#3085d6'
                    }).then(() => {
                        // Recargar la página después de que el usuario cierre el SweetAlert
                        location.reload();
                    });

                    // Cerrar el modal
                    $('#editUserModal').modal('hide');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("Error en la actualización:", textStatus, errorThrown);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudieron guardar los cambios. Intenta nuevamente.',
                        confirmButtonText: 'Entendido',
                        confirmButtonColor: '#3085d6'
                    });
                }
            });
        });
    }


    // Llamar a la función al cargar la página
    $(document).ready(function() {
        guardarFormularioUsuario();
    });

    $(document).on('click', '.btn-estado', function() {
    const usuarioId = $(this).data('id');
    const nuevoEstado = $(this).data('estado');

    const accion = nuevoEstado == 1 ? 'activar' : 'desactivar';

    Swal.fire({
        title: `¿Seguro de ${accion} este usuario?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: `Sí, ${accion}`,
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '../app/controllers/reportes/controlador_cambiar_estado_usuario.php', // <- tu ruta al controlador
                method: 'POST',
                data: {
                    id: usuarioId,
                    nuevo_estado: nuevoEstado
                },
                success: function(response) {
                    console.log('Respuesta servidor:', response);
                    Swal.fire({
                        icon: 'success',
                        title: 'Listo',
                        text: `Usuario ${accion} correctamente`,
                        confirmButtonText: 'Ok'
                    }).then(() => {
                        filtrarPorFecha(); // <-- Vuelve a ejecutar el filtro AJAX
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Error:', textStatus, errorThrown);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo cambiar el estado del usuario. Intenta nuevamente.',
                        confirmButtonText: 'Entendido'
                    });
                }
            });
        }
    });
});

</script>

<?php include('../layout/mensajes.php'); ?>
<?php include('../layout/parte2.php'); ?>







<!-- Modal para Editar Usuario -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Editar Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
            <div class="modal-body">
                <form id="editUserForm">
                    <input type="hidden" id="userId" name="userId">
                    <div class="form-group">
                        <label for="cedula">Cédula</label>
                        <input type="text" class="form-control" id="cedula" name="cedula" required>
                    </div>
                    <div class="form-group">
                        <label for="nombres">Nombres</label>
                        <input type="text" class="form-control" id="nombres" name="nombres" required>
                    </div>
                    <div class="form-group">
                        <label for="apellidos">Apellidos</label>
                        <input type="text" class="form-control" id="apellidos" name="apellidos" required>
                    </div>
                    <div class="form-group">
                        <label for="rol">Rol</label>
                        <input type="text" class="form-control" id="rol" name="rol" required readonly>
                    </div>

                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input type="text" class="form-control" id="telefono" name="telefono" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="direccion">Dirección</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" required>
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










<!-- /.modal -->


<div id="respuesta"></div>



