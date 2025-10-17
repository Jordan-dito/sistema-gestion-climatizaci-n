<?php
include('../app/config.php');
include('../layout/sesion.php');

include('../layout/parte1.php');


include('../app/controllers/categorias/listado_de_categoria.php');

// Incluye el archivo de configuración y define las constantes necesarias
// Consulta para obtener las cotizaciones
// Consulta para obtener las cotizaciones
$query = "SELECT * FROM distribuidora  ";

try {
    // Ejecutar la consulta y obtener los resultados
    $resultadoConsulta = $pdo->query($query);
    $distribuidoras = $resultadoConsulta->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error en la consulta: " . $e->getMessage();
    exit();
}




?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>



    <style>
        .form-select {
            background-color: #f8f9fa;
            /* Color de fondo claro */
            border: 1px solid #ced4da;
            /* Bordes claros */
            border-radius: .375rem;
            /* Bordes redondeados */
            padding: 0.5rem;
            /* Espaciado interno */
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
            /* Transiciones suaves */
            font-size: 1rem;
            /* Tamaño de fuente */
            color: #495057;
            /* Color de texto */
        }

        .form-select:focus {
            border-color: #80bdff;
            /* Color de borde al hacer foco */
            outline: 0;
            /* Sin contorno */
            box-shadow: 0 0 0 .2rem rgba(0, 123, 255, .25);
            /* Sombra al enfocar */
        }

        .form-label {
            font-weight: bold;
            /* Etiquetas en negrita */
            color: #212529;
            /* Color del texto de la etiqueta */
        }
    </style>

    <!-- Botón dentro del encabezado -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Distribuidor
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addModal">
                            <i class="fas fa-plus"></i> Agregar Distribuidora
                        </button>
                    </h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para agregar distribuidora -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Agregar Nueva Distribuidora</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addDistribuidoraForm">
                        <div class="form-group">
                            <label for="compania">Compañía</label>
                            <input type="text" class="form-control" id="compania" name="compania" placeholder="Nombre de la compañía" required>
                        </div>
                        <div class="form-group">
                            <label for="ruc">RUC</label>
                            <input type="text" class="form-control" id="ruc" name="ruc" placeholder="RUC de la distribuidora" required>
                        </div>
                        <div class="mb-3">
                            <label for="provincia" class="form-label">Provincia</label>
                            <select class="form-select" id="provincia" name="provincia" aria-label="Seleccione una provincia">
                                <option value="" disabled selected>Seleccione una provincia</option>
                                <!-- Opciones de provincia se llenarán aquí -->
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="ciudad" class="form-label">Ciudad</label>
                            <select class="form-select" id="ciudad" name="ciudad" aria-label="Seleccione una ciudad">
                                <option value="" disabled selected>Seleccione una ciudad</option>
                                <!-- Opciones de ciudad se llenarán aquí -->
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="direccion">Dirección</label>
                            <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Dirección" required>
                        </div>
                        <div class="form-group">
                            <label for="telefono">Teléfono</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Teléfono" required>
                        </div>
                        <div class="form-group">
                            <label for="correo">Correo Electrónico</label>
                            <input type="email" class="form-control" id="correo" name="correo" placeholder="Correo Electrónico" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="agregarDistribuidora()">Agregar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Script para enviar datos -->
    <script>
        function agregarDistribuidora() {
            const form = document.getElementById('addDistribuidoraForm');
            const datos = new FormData(form);

            fetch('../app/controllers/distribuidor/agregar_distribuidora.php', {
                    method: 'POST',
                    body: datos,
                })
                .then(response => response.json())
                .then(resultado => {
                    console.log('Respuesta del servidor:', resultado);
                    if (resultado.success) {
                        Swal.fire(
                            'Agregado!',
                            'La distribuidora se agregó correctamente.',
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: resultado.message || 'No se pudo agregar la distribuidora.',
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Ocurrió un error inesperado. Inténtalo de nuevo.',
                    });
                });
        }
    </script>

    <!-- /.content-header -->


    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-10">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Distribuidores Registrados</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                </button>
                            </div>

                        </div>

                        <div class="card-body" style="display: block;">
                            <table id="example1" class="table table-bordered table-striped">
                                <!-- <table id="datatablesSimple" class="table table-bordered table-hover mb-0"> -->
                                <thead>
                                    <tr>
                                        <th data-priority="1">Compañía</th>
                                        <th data-priority="2">RUC</th>
                                        <th data-priority="3">Ciudad</th>
                                        <th data-priority="4">Provincia</th>
                                        <th data-priority="5">Dirección</th>
                                        <th data-priority="6">Teléfono</th>
                                        <th data-priority="7">Correo</th>
                                        <th data-priority="8">Estado</th>
                                        <th data-priority="9">Acciones</th>
                                    </tr>
                                </thead>

                                <tbody>



                                    <?php foreach ($distribuidoras as $distribuidora) : ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($distribuidora['compania'] ?? ''); ?></td>
                                            <td><?php echo htmlspecialchars($distribuidora['ruc'] ?? ''); ?></td>
                                            <td><?php echo htmlspecialchars($distribuidora['ciudad'] ?? ''); ?></td>
                                            <td><?php echo htmlspecialchars($distribuidora['provincia'] ?? ''); ?></td>
                                            <td><?php echo htmlspecialchars($distribuidora['direccion'] ?? ''); ?></td>
                                            <td><?php echo htmlspecialchars($distribuidora['telefono'] ?? ''); ?></td>
                                            <td><?php echo htmlspecialchars($distribuidora['correo'] ?? ''); ?></td>
                                            <td><?php echo htmlspecialchars($distribuidora['estado'] ?? ''); ?></td>


                                            <td>
                                                <a href="#" class="btn btn-primary" onclick="llenarModal(<?php echo htmlspecialchars(json_encode($distribuidora)); ?>)">
                                                    <i class="fas fa-edit"></i>
                                                </a>





                                                <a href="#" class="btn btn-danger" onclick="eliminarDistribuidora(<?php echo $distribuidora['id_distribuidora']; ?>)">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>


                                                <a href="#" class="btn btn-success" onclick="activarDistribuidora(<?php echo $distribuidora['id_distribuidora']; ?>)">
                                                    <i class="fas fa-toggle-on"></i>
                                                </a>





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



<script>
    function activarDistribuidora(id_distribuidora) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¿Deseas activar esta distribuidora?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, activar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                const datos = new FormData();
                datos.append('id', id_distribuidora);

                fetch('../app/controllers/distribuidor/activar_distribuidora.php', {
                        method: 'POST',
                        body: datos
                    })
                    .then(response => response.json())
                    .then(resultado => {
                        if (resultado.success) {
                            Swal.fire(
                                'Activada!',
                                'La distribuidora ha sido activada correctamente.',
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: resultado.message || 'No se pudo activar la distribuidora.'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error al activar:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error inesperado',
                            text: 'Ocurrió un error al intentar activar la distribuidora.'
                        });
                    });
            }
        });
    }
</script>


<!-- Modal para Editar Distribuidora -->
<!-- Modal para Editar Distribuidora -->
<div class="modal fade" id="modalEditarDistribuidora" tabindex="-1" aria-labelledby="modalEditarDistribuidoraLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditarDistribuidoraLabel">Editar Distribuidora</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formEditarDistribuidoraEdit" class="p-4 border rounded bg-light shadow">
                    <input type="hidden" id="id_distribuidoraEdit" name="id_distribuidora">

                    <div class="mb-3">
                        <label for="companiaEdit" class="form-label">Compañía</label>
                        <input type="text" class="form-control" id="companiaEdit" name="compania" required placeholder="Ingrese el nombre de la compañía">
                    </div>

                    <div class="mb-3">
                        <label for="rucEdit" class="form-label">RUC</label>
                        <input type="text" class="form-control" id="rucEdit" name="ruc" required placeholder="Ingrese el RUC">
                    </div>

                    <div class="mb-3">
                        <label for="provinciaEdit" class="form-label">Provincia</label>
                        <select class="form-select" id="provinciaEdit" name="provincia" aria-label="Seleccione una provincia">
                            <option value="" disabled selected>Seleccione una provincia</option>
                            <!-- Opciones de provincia se llenarán aquí -->
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="ciudadEdit" class="form-label">Ciudad</label>
                        <select class="form-select" id="ciudadEdit" name="ciudad" aria-label="Seleccione una ciudad">
                            <option value="" disabled selected>Seleccione una ciudad</option>
                            <!-- Opciones de ciudad se llenarán aquí -->
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="direccionEdit" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="direccionEdit" name="direccion"
                            pattern="[a-zA-Z\s]{1,20}"
                            placeholder="Ingrese la dirección" required>
                    </div>

                    <div class="mb-3">
                        <label for="telefonoEdit" class="form-label">Teléfono (10 dígitos)</label>
                        <input type="text" class="form-control" id="telefonoEdit" name="telefono"
                            pattern="\d{10}"
                            title="El teléfono debe contener exactamente 10 números."
                            placeholder="Ingrese el teléfono" required maxlength="10">
                    </div>

                    <div class="mb-3">
                        <label for="correoEdit" class="form-label">Correo</label>
                        <input type="email" class="form-control" id="correoEdit" name="correo"
                            placeholder="Ingrese el correo electrónico" required>
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-success" onclick="guardarCambios()">Guardar cambios</button>
                    </div>
                </form>
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

    function eliminarDistribuidora(id_distribuidora) {
        console.log('Desactivar distribuidora con ID:', id_distribuidora); // Esto debería mostrar solo el ID
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡Esta acción cambiará el estado a 'Inactivo'!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, desactivar'
        }).then((result) => {
            if (result.isConfirmed) {
                const datos = new FormData();
                datos.append('id', id_distribuidora); // Asegúrate de que solo estés enviando el ID

                fetch('../app/controllers/distribuidor/eliminar_distribuidor.php', {
                        method: 'POST',
                        body: datos,
                    })
                    .then((response) => response.json())
                    .then((resultado) => {
                        console.log('Respuesta del servidor:', resultado);
                        if (resultado.success) {
                            Swal.fire(
                                'Desactivada!',
                                'La distribuidora ha sido desactivada.',
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: resultado.message || 'Hubo un problema al desactivar la distribuidora.',
                            });
                        }
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Ocurrió un error inesperado. Inténtalo de nuevo.',
                        });
                    });
            }
        });
    }



    function llenarModal(distribuidora) {
        console.log('Distribuidora:', distribuidora); // Imprime el objeto completo para depuración
        console.log('ID Distribuidora:', distribuidora.id_distribuidora); // Verifica el ID

        // Llenamos los campos del formulario del modal con los datos de la distribuidora
        var idDistribuidoraField = document.getElementById('id_distribuidoraEdit');
        var companiaField = document.getElementById('companiaEdit');
        var rucField = document.getElementById('rucEdit');
        var provinciaSelect = document.getElementById('provinciaEdit');
        var ciudadSelect = document.getElementById('ciudadEdit');
        var direccionField = document.getElementById('direccionEdit');
        var telefonoField = document.getElementById('telefonoEdit');
        var correoField = document.getElementById('correoEdit');

        if (idDistribuidoraField) {
            idDistribuidoraField.value = distribuidora.id_distribuidora || '';
        } else {
            console.error('Elemento con ID "id_distribuidoraEdit" no encontrado');
        }

        if (companiaField) {
            companiaField.value = distribuidora.compania || '';
        } else {
            console.error('Elemento con ID "companiaEdit" no encontrado');
        }

        if (rucField) {
            rucField.value = distribuidora.ruc || '';
        } else {
            console.error('Elemento con ID "rucEdit" no encontrado');
        }

        if (provinciaSelect) {
            provinciaSelect.value = distribuidora.provincia || '';
            $(provinciaSelect).trigger('change'); // Disparar evento de cambio para actualizar ciudades
        } else {
            console.error('Elemento con ID "provinciaEdit" no encontrado');
        }

        // Retraso para asegurarnos de que las opciones de ciudad se actualicen
        setTimeout(function() {
            if (ciudadSelect) {
                ciudadSelect.value = distribuidora.ciudad || '';
            } else {
                console.error('Elemento con ID "ciudadEdit" no encontrado');
            }
        }, 100); // Ajusta el tiempo según sea necesario

        if (direccionField) {
            direccionField.value = distribuidora.direccion || '';
        } else {
            console.error('Elemento con ID "direccionEdit" no encontrado');
        }

        if (telefonoField) {
            telefonoField.value = distribuidora.telefono || '';
        } else {
            console.error('Elemento con ID "telefonoEdit" no encontrado');
        }

        if (correoField) {
            correoField.value = distribuidora.correo || '';
        } else {
            console.error('Elemento con ID "correoEdit" no encontrado');
        }

        // Mostramos el modal
        const modal = new bootstrap.Modal(document.getElementById('modalEditarDistribuidora'));
        modal.show();
    }



    function guardarCambios() {
        const form = document.getElementById('formEditarDistribuidoraEdit');
        const datos = new FormData(form);

        // Imprimir los datos que se están enviando para depuración
        console.log('Datos que se envían:');
        datos.forEach((value, key) => {
            console.log(`${key}: ${value}`);
        });

        // Enviar los datos al servidor usando fetch
        fetch('../app/controllers/distribuidor/actualizar_distribuidora.php', {
                method: 'POST',
                body: datos,
            })
            .then((response) => response.json()) // Suponemos que el servidor devuelve un JSON
            .then((resultado) => {
                console.log('Respuesta del servidor:', resultado);

                if (resultado.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: 'Cambios guardados correctamente',
                        timer: 2000,
                        showConfirmButton: false,
                    }).then(() => {
                        location.reload(); // Recargar la página después de cerrar la alerta
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: resultado.message || 'Hubo un problema al guardar los cambios.',
                    });
                }
            })
            .catch((error) => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ocurrió un error inesperado. Inténtalo de nuevo.',
                });
            });
    }


    function validarDocumento() {
        var codigo = document.getElementById("documento").value;
        var numero = codigo;
        var suma = 0;
        var residuo = 0;
        var pri = false;
        var pub = false;
        var nat = false;
        var numeroProvincias = 22;
        var modulo = 11;

        // Verificar que el campo no contenga letras
        var ok = 1;
        for (i = 0; i < numero.length && ok == 1; i++) {
            var n = parseInt(numero.charAt(i));
            if (isNaN(n)) ok = 0;
        }



        if (ok == 0) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No puede ingresar caracteres en el número'
            });
            return false;
        }

        if (numero.length < 10) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'El número ingresado no es válido'
            });
            return false;
        }

        // Los primeros dos digitos corresponden al codigo de la provincia
        provincia = numero.substr(0, 2);
        if (provincia < 1 || provincia > numeroProvincias) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'El código de la provincia (dos primeros dígitos) es inválido'
            });
            return false;
        }


        // Verificar si es un RUC válido utilizando la función validarRuc
        if (!validarRuc(numero)) {
            return false;
        }

        /* El resto de la lógica para validar la cédula o RUC */
        d1 = numero.substr(0, 1);
        d2 = numero.substr(1, 1);
        d3 = numero.substr(2, 1);
        d4 = numero.substr(3, 1);
        d5 = numero.substr(4, 1);
        d6 = numero.substr(5, 1);
        d7 = numero.substr(6, 1);
        d8 = numero.substr(7, 1);
        d9 = numero.substr(8, 1);
        d10 = numero.substr(9, 1);


        // if (d3 == 7 || d3 == 8) {
        //     alert('El tercer dígito ingresado es inválido');
        //     return false;
        // }

        if (d3 == 7 || d3 == 8) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'El tercer dígito ingresado es inválido'
            });
            return false;
        }


        /* Solo para personas naturales (modulo 10) */
        if (d3 < 6) {
            nat = true;
            p1 = d1 * 2;
            if (p1 >= 10) p1 -= 9;
            p2 = d2 * 1;
            if (p2 >= 10) p2 -= 9;
            p3 = d3 * 2;
            if (p3 >= 10) p3 -= 9;
            p4 = d4 * 1;
            if (p4 >= 10) p4 -= 9;
            p5 = d5 * 2;
            if (p5 >= 10) p5 -= 9;
            p6 = d6 * 1;
            if (p6 >= 10) p6 -= 9;
            p7 = d7 * 2;
            if (p7 >= 10) p7 -= 9;
            p8 = d8 * 1;
            if (p8 >= 10) p8 -= 9;
            p9 = d9 * 2;
            if (p9 >= 10) p9 -= 9;
            modulo = 10;
        }
        /* Solo para sociedades publicas (modulo 11) */
        /* Aqui el digito verficador esta en la posicion 9, en las otras 2 en la pos. 10 */
        else if (d3 == 6) {
            pub = true;
            p1 = d1 * 3;
            p2 = d2 * 2;
            p3 = d3 * 7;
            p4 = d4 * 6;
            p5 = d5 * 5;
            p6 = d6 * 4;
            p7 = d7 * 3;
            p8 = d8 * 2;
            p9 = 0;
        }

        /* Solo para entidades privadas (modulo 11) */
        else if (d3 == 9) {
            pri = true;
            p1 = d1 * 4;
            p2 = d2 * 3;
            p3 = d3 * 2;
            p4 = d4 * 7;
            p5 = d5 * 6;
            p6 = d6 * 5;
            p7 = d7 * 4;
            p8 = d8 * 3;
            p9 = d9 * 2;
        }

        suma = p1 + p2 + p3 + p4 + p5 + p6 + p7 + p8 + p9;
        residuo = suma % modulo;
        /* Si residuo=0, dig.ver.=0, caso contrario 10 - residuo*/
        digitoVerificador = residuo == 0 ? 0 : modulo - residuo;
        /* ahora comparamos el elemento de la posicion 10 con el dig. ver.*/



        if (pub == true) {
            if (digitoVerificador != d9) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'El RUC de la empresa del sector público es incorrecto.'
                });
                return false;
            }
            /* El RUC de las empresas del sector público terminan con 0001*/
            if (numero.substr(9, 4) != '0001') {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'El RUC de la empresa del sector público debe terminar con 0001'
                });
                return false;
            }
        } else if (pri == true) {
            if (digitoVerificador != d10) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'El RUC de la empresa del sector privado es incorrecto.'
                });
                return false;
            }
            if (numero.substr(10, 3) != '001') {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'El RUC de la empresa del sector privado debe terminar con 001'
                });
                return false;
            }
        } else if (nat == true) {
            if (digitoVerificador != d10) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'El número de cédula de la persona natural es incorrecto.'
                });
                return false;
            }
        }

        if (numero.length > 10 && numero.substr(10, 3) != '001') {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'El RUC de la persona natural debe terminar con 001'
            });
            return false;
        }



        return true;
    }



    function validarRuc(ruc) {
        // Verificar que tenga 13 dígitos
        if (ruc.length !== 13) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'El RUC debe tener 13 dígitos'
            });
            return false;
        }

        // Verificar que los últimos tres dígitos sean '001'
        var ultimosTres = ruc.substring(10);
        if (ultimosTres !== '001') {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Los últimos tres dígitos del RUC deben ser 001'
            });
            return false;
        }

        // Si pasa todas las validaciones, devuelve true
        return true;
    }



    // Función para validar una cédula ecuatoriana
    function validarCedulaEcuatoriana(cedula) {
        var patronCedula = /^[0-9]{10}$/;

        if (!patronCedula.test(cedula)) {
            return false; // La cédula no tiene el formato adecuado (10 dígitos)
        }

        var provincia = parseInt(cedula.substring(0, 2));
        if (provincia < 1 || provincia > 24) {
            return false; // El código de provincia no es válido
        }

        var digitoVerificador = parseInt(cedula.substring(9, 10));
        var coeficientes = [2, 1, 2, 1, 2, 1, 2, 1, 2];
        var suma = 0;

        for (var i = 0; i < coeficientes.length; i++) {
            var producto = parseInt(cedula.charAt(i)) * coeficientes[i];
            if (producto >= 10) {
                producto -= 9;
            }
            suma += producto;
        }

        var resultado = 10 - (suma % 10);
        if (resultado === 10) {
            resultado = 0;
        }

        if (resultado !== digitoVerificador) {
            return false; // El dígito verificador no coincide
        }

        return true; // La cédula es válida
    }


    // Evento blur para validar el RUC al salir del campo
    $('#ruc').blur(function() {
        var ruc = $(this).val();
        validarRuc(ruc);
    });
</script>

<script>
    function llenarProvinciasYCiudades(provinciaSelector, ciudadSelector) {
        var provinciasYCiudades = {
            'AZUAY': ['CUENCA', 'GUALACEO', 'SANTA ISABEL'],
            'BOLIVAR': ['GUARANDA', 'CHILLANES', 'SAN MIGUEL'],
            'CAÑAR': ['AZOGUES', 'BIBLIÁN', 'DÉLEG'],
            'CARCHI': ['TULCÁN', 'MONTÚFAR', 'MIRA'],
            'CHIMBORAZO': ['RIOBAMBA', 'GUANO', 'ALAUSÍ'],
            'COTOPAXI': ['LATACUNGA', 'LA MANA', 'PUJILÍ'],
            'EL ORO': ['MACHALA', 'PASAJE', 'SANTA ROSA'],
            'ESMERALDAS': ['ESMERALDAS', 'ATACAMES', 'MUISNE'],
            'GALÁPAGOS': ['PUERTO BAQUERIZO MORENO', 'PUERTO AYORA', 'PUERTO VILLAMIL'],
            'GUAYAS': ['GUAYAQUIL', 'SAMBORONDÓN', 'DAULE'],
            'IMBABURA': ['IBARRA', 'OTAVALO', 'COTACACHI'],
            'LOJA': ['LOJA', 'CATAMAYO', 'ZAMORA'],
            'LOS RÍOS': ['BABAHOYO', 'QUEVEDO', 'VENTANAS'],
            'MANABÍ': ['PORTOVIEJO', 'MANTA', 'JIPIJAPA'],
            'MORONA-SANTIAGO': ['MACAS', 'SUCÚA', 'LOGROÑO'],
            'NAPO': ['TENA', 'EL CHACO', 'ARCHIDONA'],
            'ORELLANA': ['ORELLANA', 'FRANCISCO DE ORELLANA', 'LA JOYA DE LOS SACHAS'],
            'PASTAZA': ['PUYO', 'MERA', 'SHELL'],
            'PICHINCHA': ['QUITO', 'CAYAMBE', 'SANGOLQUÍ'],
            'SANTA ELENA': ['SANTA ELENA', 'SALINAS', 'LA LIBERTAD'],
            'SANTO DOMINGO DE LOS TSÁCHILAS': ['SANTO DOMINGO', 'LA CONCORDIA', 'VALLE HERMOSO'],
            'SUCUMBÍOS': ['NUEVA LOJA', 'SHUSHUFINDI', 'LAGO AGRIO'],
            'TUNGURAHUA': ['AMBATO', 'BAÑOS', 'PELILEO'],
            'ZAMORA-CHINCHIPE': ['ZAMORA', 'YANTZAZA', 'CENTINELA DEL CÓNDOR']
        };

        var $provinciaSelect = $(provinciaSelector);
        var $ciudadSelect = $(ciudadSelector);

        // Llenar el select de provincias
        Object.keys(provinciasYCiudades).forEach(function(provincia) {
            $provinciaSelect.append($('<option>', {
                value: provincia,
                text: provincia
            }));
        });

        // Evento de cambio en la provincia
        $provinciaSelect.on('change', function() {
            var provinciaSeleccionada = $(this).val();
            actualizarCiudades(provinciaSeleccionada);
        });

        // Función para actualizar el select de ciudades
        function actualizarCiudades(provincia) {
            var ciudades = provinciasYCiudades[provincia] || [];
            $ciudadSelect.empty();

            ciudades.forEach(function(ciudad) {
                $ciudadSelect.append($('<option>', {
                    value: ciudad,
                    text: ciudad
                }));
            });
        }
    }

    // Llamar a la función al cargar el documento para ambos formularios
    $(document).ready(function() {
        // Para el formulario de creación
        llenarProvinciasYCiudades('#provincia', '#ciudad');

        // Para el formulario de edición
        llenarProvinciasYCiudades('#provinciaEdit', '#ciudadEdit');
    });
</script>



<div id="respuesta"></div>