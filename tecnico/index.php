<?php
include('../app/config.php');
include('../layout/sesion.php');

include('../layout/parte1.php');


include('../app/controllers/categorias/listado_de_categoria.php');

// Incluye el archivo de configuración y define las constantes necesarias
// Consulta para obtener las cotizaciones
// Consulta para obtener las cotizaciones
$query = "SELECT ht.ID_HorarioTecnico, ht.ID_Usuario, ht.Dia_Inicio_Semana,ht.Estado, ht.Dia_Fin_Semana, ht.Horario_Inicio, ht.Horario_Fin, u.nombres, u.apellidos FROM horariostecnicos ht INNER JOIN tb_usuarios u ON ht.ID_Usuario = u.ID_Usuario";
try {
    // Ejecutar la consulta y obtener los resultados
    $resultadoConsulta = $pdo->query($query);
    $tecnicos = $resultadoConsulta->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error en la consulta: " . $e->getMessage();
    exit();
}

// Consulta SQL para obtener los nombres, apellidos y correos de los técnicos que no están en la tabla de horarios técnicos
$sql = " SELECT tu.id_usuario, tu.nombres, tu.apellidos FROM tb_usuarios tu INNER JOIN tb_roles tr ON tu.id_rol=tr.id_rol where tr.id_rol=3;";

$result = $pdo->query($sql);

if ($result->rowCount() > 0) {
    // Mostrar los nombres de los técnicos en formato JSON
    $nombre_tecnicos = array();
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $nombre_tecnicos[] = $row;
    }
}


?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Horario Tecnico
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-create">
                            <i class="fa fa-plus"></i> Agregar Nuevo Horario
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
                <div class="col-md-10">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Horario de Tecnicos Registrados</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                </button>
                            </div>

                        </div>

                        <div class="card-body" style="display: block;">
                            <table id="example1" class="table table-bordered table-striped">
                                <!-- <table id="datatablesSimple" class="table table-bordered table-hover mb-0"> -->
                                <tbody>
                                    <?php foreach ($tecnicos as $tecnico) : ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($tecnico['nombres']); ?></td>
                                            <td><?php echo htmlspecialchars($tecnico['apellidos']); ?></td>
                                            <td><?php echo htmlspecialchars($tecnico['Dia_Inicio_Semana']); ?></td>
                                            <td><?php echo htmlspecialchars($tecnico['Dia_Fin_Semana']); ?></td>
                                            <td><?php echo htmlspecialchars($tecnico['Horario_Inicio']); ?></td>
                                            <td><?php echo htmlspecialchars($tecnico['Horario_Fin']); ?></td>
                                            <td><?php echo htmlspecialchars($tecnico['Estado']); ?></td>
                                            <td>
                                                <a href="#" class="btn btn-primary" onclick='llenarModal(<?php echo json_encode($tecnico, JSON_HEX_APOS | JSON_HEX_QUOT); ?>)'>
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <?php
                                                    $estado = $tecnico['Estado'];
                                                    // Mostrar botón para cambiar entre Activo e Inactivo
                                                    if (strtolower($estado) === 'inactivo') {
                                                        echo '<a href="#" class="btn btn-success" onclick="cambiarEstadoTecnico(' . $tecnico['ID_HorarioTecnico'] . ', \'' . 'Activo' . '\')">'
                                                             . '<i class="fas fa-check"></i> Activar</a>';
                                                    } elseif (strtolower($estado) === 'activo') {
                                                        echo '<a href="#" class="btn btn-warning" onclick="cambiarEstadoTecnico(' . $tecnico['ID_HorarioTecnico'] . ', \'' . 'Inactivo' . '\')">'
                                                             . '<i class="fas fa-ban"></i> Desactivar</a>';
                                                    } else {
                                                        // Si el estado no corresponde, permitir cambiar a Inactivo por defecto
                                                        echo '<a href="#" class="btn btn-secondary" onclick="cambiarEstadoTecnico(' . $tecnico['ID_HorarioTecnico'] . ', \'' . 'Inactivo' . '\')">'
                                                             . '<i class="fas fa-exchange-alt"></i> Cambiar Estado</a>';
                                                    }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <!-- Aquí se llenarán los datos automáticamente con JavaScript -->
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
<!-- Modal para Editar Técnico -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #1d36b6; color: white;">
                <h5 class="modal-title" id="editModalLabel">Editar Técnico</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formEditarTecnico">
                    <input type="hidden" id="editIdUsuario" name="id_usuario" required>
                    <input type="hidden" id="editIdHorarioTecnico" name="id_horario_tecnico" required>
                    <div class="mb-3">
                        <label for="editNombres" class="form-label">Nombres</label>
                        <input type="text" class="form-control" id="editNombres" name="nombres" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="editApellidos" class="form-label">Apellidos</label>
                        <input type="text" class="form-control" id="editApellidos" name="apellidos" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="editDiaInicioSemana" class="form-label">Día Inicio Semana</label>
                        <select class="form-control" id="editDiaInicioSemana" name="dia_inicio_semana" required>
                            <!-- Las opciones se llenarán dinámicamente con JavaScript -->
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="editDiaFinSemana" class="form-label">Día Fin Semana</label>
                        <select class="form-control" id="editDiaFinSemana" name="dia_fin_semana" required>
                            <!-- Las opciones se llenarán dinámicamente con JavaScript -->
                        </select>
                    </div>


                    <div class="mb-3">
                        <label for="editHorarioInicio" class="form-label">Horario Inicio</label>
                        <input type="time" class="form-control" id="editHorarioInicio" name="horario_inicio" required>
                    </div>

                    <div class="mb-3">
                        <label for="editHorarioFin" class="form-label">Horario Fin</label>
                        <input type="time" class="form-control" id="editHorarioFin" name="horario_fin" required>
                    </div>

                    <!-- Nuevo campo Estado -->
                    <div class="mb-3">
                        <label for="editEstado" class="form-label">Estado</label>
                        <!-- Select que enviará directamente los estados requeridos por la aplicación -->
                        <select class="form-control" id="editEstado" name="estado" required>
                            <option value="Disponible">Disponible</option>
                            <option value="Ocupado">Ocupado</option>
                            <option value="Inactivo">Inactivo</option>
                        </select>
                    </div>

                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnGuardarCambios" onclick="guardarCambios()">Guardar Cambios</button>

            </div>
        </div>
    </div>
</div>





<?php include('../layout/mensajes.php'); ?>
<?php include('../layout/parte2.php'); ?>

<script>
    $(function() {
        var table = $("#example1").DataTable({
            "pageLength": 5,
            "language": {
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Categorías",
                "infoEmpty": "Mostrando 0 a 0 de 0 Categorías",
                "infoFiltered": "(Filtrado de _MAX_ total Categorías)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Categorías",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscador:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
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
                            exportOptions: {
                                columns: ':visible:not(:last-child)' // Excluye la última columna
                            }
                        },
                        {
                            extend: 'pdf',
                            exportOptions: {
                                columns: ':visible:not(:last-child)' // Excluye la última columna
                            }
                        },
                        {
                            extend: 'csv',
                            exportOptions: {
                                columns: ':visible:not(:last-child)' // Excluye la última columna
                            }
                        },
                        {
                            extend: 'excel',
                            exportOptions: {
                                columns: ':visible:not(:last-child)' // Excluye la última columna
                            }
                        },
                        {
                            text: 'Imprimir',
                            extend: 'print',
                            exportOptions: {
                                columns: ':visible:not(:last-child)' // Excluye la última columna
                            }
                        }
                    ]
                },
                {
                    extend: 'colvis',
                    text: 'Visor de columnas',
                    collectionLayout: 'fixed three-column'
                }
            ],
        });

        // Añadir los botones al contenedor específico
        table.buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });


    function llenarModal(tecnico) {
        console.log(tecnico); // Verificar que el objeto tenga los datos correctos

        // Opciones para los días de la semana
        var diasSemana = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo"];

        // Obtener los elementos select
        var selectDiaInicio = document.getElementById('editDiaInicioSemana');
        var selectDiaFin = document.getElementById('editDiaFinSemana');

        // Vaciar los elementos select antes de llenarlos
        selectDiaInicio.innerHTML = '';
        selectDiaFin.innerHTML = '';

        // Crear las opciones para el día de inicio de semana
        diasSemana.forEach(function(dia) {
            if (dia !== tecnico.Dia_Fin_Semana) {
                var optionInicio = document.createElement('option');
                optionInicio.value = dia;
                optionInicio.textContent = dia;
                if (dia === tecnico.Dia_Inicio_Semana) {
                    optionInicio.selected = true;
                }
                selectDiaInicio.appendChild(optionInicio);
            }
        });

        // Crear las opciones para el día de fin de semana
        diasSemana.forEach(function(dia) {
            if (dia !== tecnico.Dia_Inicio_Semana) {
                var optionFin = document.createElement('option');
                optionFin.value = dia;
                optionFin.textContent = dia;
                if (dia === tecnico.Dia_Fin_Semana) {
                    optionFin.selected = true;
                }
                selectDiaFin.appendChild(optionFin);
            }
        });

        // Rellenar los campos ocultos y demás
        document.getElementById('editIdHorarioTecnico').value = tecnico.ID_HorarioTecnico;
        document.getElementById('editIdUsuario').value = tecnico.ID_Usuario; // <-- Cambia aquí
        document.getElementById('editNombres').value = tecnico.nombres;
        document.getElementById('editApellidos').value = tecnico.apellidos;
        document.getElementById('editHorarioInicio').value = tecnico.Horario_Inicio;
        document.getElementById('editHorarioFin').value = tecnico.Horario_Fin;

        // Mapear el valor que viene de la BD a uno de: 'Disponible','Ocupado','Inactivo'
        if (document.getElementById('editEstado')) {
            const selectEstado = document.getElementById('editEstado');
            const estadoRaw = (tecnico.Estado || '').toString().trim();
            console.log('Estado raw del técnico:', estadoRaw);

            const mapToThree = {
                'activo': 'Disponible',
                'inactivo': 'Inactivo',
                'disponible': 'Disponible',
                'no disponible': 'Inactivo',
                'ocupado': 'Ocupado',
                'available': 'Disponible',
                'busy': 'Ocupado'
            };

            const key = estadoRaw.toLowerCase();
            const mapped = mapToThree[key] || 'Disponible';

            // Asignar el valor mapeado (si existe en las opciones)
            if ([].slice.call(selectEstado.options).some(o => o.value === mapped)) {
                selectEstado.value = mapped;
            } else {
                selectEstado.selectedIndex = 0;
            }
        }

        // Mostrar el modal
        $('#editModal').modal('show');
    }



    function guardarCambios() {
        // Obtener los datos del formulario (ahora el select 'estado' envía 'Disponible'|'Ocupado'|'Inactivo')
        var formData = $('#formEditarTecnico').serialize();
        console.log("Datos enviados: ", formData);

        // Realizar la petición AJAX para guardar los cambios
        $.ajax({
            url: '../app/controllers/tecnico/guardar_tecnico.php', // Asegúrate de que la ruta sea correcta
            type: 'POST',
            data: formData,
            dataType: 'json', // Asegurarse de que la respuesta sea interpretada como JSON
            success: function(response) {
                console.log("Respuesta del servidor: ", response); // Mostrar la respuesta en la consola

                if (response.status === "success") {
                    // Mostrar mensaje de éxito con SweetAlert
                    Swal.fire({
                        title: '¡Éxito!',
                        text: response.message || 'Datos guardados correctamente',
                        icon: 'success',
                        confirmButtonText: 'Aceptar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Actualizar la tabla dinámicamente, si lo deseas, o recargar la página
                            location.reload(); // Recargar la página para ver los cambios
                        }
                    });

                    // Cerrar el modal
                    $('#editModal').modal('hide');
                } else {
                    // Manejo de errores en caso de que la respuesta sea diferente de "success"
                    Swal.fire({
                        title: 'Error',
                        text: response.message || 'No se pudo guardar los datos.',
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                }
            },
            error: function(xhr, status, error) {
                // Manejo de errores en la solicitud
                console.error('Error en la solicitud AJAX:', status, error);
                Swal.fire({
                    title: 'Error en la solicitud',
                    text: error,
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            }
        });
    }



    function eliminarTecnico(idHorarioTecnico) {
        // Mostrar el cuadro de confirmación usando SweetAlert
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Esta acción eliminará el técnico permanentemente.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Si el usuario confirma, realizar la solicitud AJAX para eliminar el técnico
                $.ajax({
                    url: '../app/controllers/tecnico/eliminar_tecnico.php', // Asegúrate de que la ruta sea correcta
                    type: 'POST',
                    data: {
                        ID_HorarioTecnico: idHorarioTecnico
                    },
                    dataType: 'json', // Asegurarse de que la respuesta sea interpretada como JSON
                    success: function(response) {
                        console.log("Respuesta del servidor: ", response); // Mostrar la respuesta en la consola

                        if (response.status === "success") {
                            // Mostrar mensaje de éxito
                            Swal.fire({
                                icon: 'success',
                                title: 'Eliminado',
                                text: response.message || 'El técnico ha sido eliminado correctamente',
                            }).then(() => {
                                // Aquí puedes actualizar dinámicamente la tabla o la lista, si lo deseas
                                location.reload(); // Recargar la página para ver los cambios
                            });
                        } else {
                            // Manejo de errores en caso de que la respuesta sea diferente de "success"
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message || 'No se pudo eliminar el técnico',
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        // Manejo de errores en la solicitud
                        console.error('Error en la solicitud AJAX:', status, error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error en la solicitud: ' + error,
                        });
                    }
                });
            }
        });
    }


    function registrarNuevoHorario() {
        $('#formNuevoHorario').on('submit', function(e) {
            e.preventDefault(); // Evita el envío normal del formulario

            // Serializar los datos del formulario
            var formData = $(this).serialize();

            // Mostrar los datos en la consola
            console.log("Datos enviados: ", formData);

            // Realizar la solicitud AJAX
            $.ajax({
                url: '../app/controllers/tecnico/crear_horariotecnico.php', // Cambia la URL según sea necesario
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    console.log("Respuesta del servidor: ", response);

                    if (response.status === "success") {
                        Swal.fire({
                            title: '¡Éxito!',
                            text: response.message || 'Horario guardado correctamente',
                            icon: 'success',
                            confirmButtonText: 'Aceptar'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload(); // Recargar la página para ver los cambios
                            }
                        });

                        // Cerrar el modal
                        $('#modal-create').modal('hide');
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: response.message || 'No se pudo guardar el horario.',
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error en la solicitud AJAX:', status, error);
                    Swal.fire({
                        title: 'Error en la solicitud',
                        text: error,
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                }
            });
        });
    }


    // Nueva función para cambiar el estado del técnico (activar/desactivar u otros estados)
    window.cambiarEstadoTecnico = function(idHorarioTecnico, nuevoEstado) {
        // Confirmación para el usuario
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Se cambiará el estado del técnico.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, cambiar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    // Llamar al archivo que ya existe y fue adaptado para actualizar estado
                    url: '../app/controllers/tecnico/eliminar_tecnico.php',
                    type: 'POST',
                    data: {
                        ID_HorarioTecnico: idHorarioTecnico,
                        Estado: nuevoEstado
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Estado actualizado',
                                text: response.message || 'El estado se actualizó correctamente'
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message || 'No se pudo cambiar el estado'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error en la solicitud AJAX:', status, error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error en la solicitud',
                            text: error
                        });
                    }
                });
            }
        });
    }
</script>






<!-- modal para registrar categorias -->
<div class="modal fade" id="modal-create">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #1d36b6;color: white">
                <h4 class="modal-title">Agregar Nuevo Tecnico</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formNuevoHorario">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="tecnico" class="form-label">Nombre del Técnico <b>*</b></label>
                        <select class="form-select form-control" id="tecnico" name="tecnico">
                            <?php foreach ($nombre_tecnicos as $tecnico) : ?>
                                <option value="<?php echo $tecnico['id_usuario']; ?>">
                                    <?php echo htmlspecialchars($tecnico['nombres'] . ' ' . $tecnico['apellidos']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                    </div>
                    <div class="form-group">
                        <label for="diaInicioSemana" class="form-label">Día Inicio Semana (Lunes - Viernes) <b>*</b></label>
                        <select class="form-select form-control" id="diaInicioSemana" name="diaInicioSemana">
                            <option selected>Lunes</option>
                            <option>Martes</option>
                            <option>Miércoles</option>
                            <option>Jueves</option>
                            <option>Viernes</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="diaFinSemana" class="form-label">Día Fin Semana (Martes - Viernes) <b>*</b></label>
                        <select class="form-select form-control" id="diaFinSemana" name="diaFinSemana">
                            <option selected>Martes</option>
                            <option>Miércoles</option>
                            <option>Jueves</option>
                            <option>Viernes</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="horaInicio" class="form-label">Hora de Inicio <b>*</b></label>
                        <input type="time" class="form-control" id="horaInicio" name="horaInicio">
                    </div>
                    <div class="form-group">
                        <label for="horaFin" class="form-label">Hora de Fin <b>*</b></label>
                        <input type="time" class="form-control" id="horaFin" name="horaFin">
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" onclick="registrarNuevoHorario() " id="btnGuardarHorario">Guardar Horario</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- /.modal -->


<div id="respuesta"></div>