<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Gestión de Mantenimientos</title>
</head>

<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        Mantenimientos Programados
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Factura</th>
                                    <th>Fecha Mantenimiento</th>
                                    <th>Próximo Mantenimiento</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tabla-mantenimientos">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        Actualizar Mantenimiento
                    </div>
                    <div class="card-body">
                        <form id="formActualizar">
                            <input type="hidden" id="id_mantenimiento">
                            <div class="form-group">
                                <label for="fecha_mantenimiento">Fecha de Mantenimiento:</label>
                                <input type="datetime-local" id="fecha_mantenimiento" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="fecha_proximo_mantenimiento">Próximo Mantenimiento:</label>
                                <input type="datetime-local" id="fecha_proximo_mantenimiento" class="form-control" readonly>
                            </div>
                            <button type="button" class="btn btn-success mt-3" onclick="actualizarMantenimiento()">
                                Guardar Cambios
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function cargarMantenimientos() {
            fetch('../app/controllers/ordenes_trabajo/listar_mantenimientos.php')
                .then(response => response.json())
                .then(data => {
                    const tbody = document.getElementById('tabla-mantenimientos');
                    tbody.innerHTML = "";

                    data.forEach(mantenimiento => {
                        const estado = (new Date(mantenimiento.fecha_mantenimiento) < new Date()) ? "<span class='badge bg-danger'>Pendiente</span>" :
                            (new Date(mantenimiento.fecha_mantenimiento).toDateString() === new Date().toDateString()) ? "<span class='badge bg-warning'>Hoy</span>" :
                            "<span class='badge bg-success'>Programado</span>";

                        const fila = `
                            <tr>
                                <td>${mantenimiento.numero_factura}</td>
                                <td>${mantenimiento.fecha_mantenimiento}</td>
                                <td>${mantenimiento.fecha_proximo_mantenimiento ?? 'No programado'}</td>
                                <td>${estado}</td>
                                <td>
                                    <button class="btn btn-success btn-sm" onclick="abrirModal('${mantenimiento.id_mantenimiento}', '${mantenimiento.fecha_mantenimiento}', '${mantenimiento.fecha_proximo_mantenimiento}')">
                                        Editar
                                    </button>
                                </td>
                            </tr>
                        `;
                        tbody.innerHTML += fila;
                    });
                })
                .catch(error => console.error("Error al cargar mantenimientos:", error));
        }

        function abrirModal(id, fechaMantenimiento, fechaProximo) {
            document.getElementById('id_mantenimiento').value = id;
            document.getElementById('fecha_mantenimiento').value = fechaMantenimiento;

            // Si la fecha está en null, se asigna hoy
            if (fechaProximo === "No programado" || fechaProximo === null) {
                const hoy = new Date().toISOString().slice(0, 16); // Formato correcto para el input
                document.getElementById('fecha_proximo_mantenimiento').value = hoy;
            } else {
                document.getElementById('fecha_proximo_mantenimiento').value = fechaProximo;
            }
        }

        function actualizarMantenimiento() {
            const datos = {
                id_mantenimiento: document.getElementById('id_mantenimiento').value,
                fecha_mantenimiento: document.getElementById('fecha_mantenimiento').value
            };

            fetch('../app/controllers/ordenes_trabajo/actualizar_mantenimiento.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(datos)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire("Éxito", "Próximo mantenimiento programado para: " + data.proximo_mantenimiento, "success");
                        document.getElementById('fecha_proximo_mantenimiento').value = data.proximo_mantenimiento;
                        cargarMantenimientos();
                    } else {
                        Swal.fire("Error", data.message, "error");
                    }
                })
                .catch(error => {
                    console.error("Error en AJAX:", error);
                    Swal.fire("Error", "No se pudo actualizar el mantenimiento", "error");
                });
        }

        // Cargar los mantenimientos al iniciar la página
        cargarMantenimientos();
    </script>
</body>

</html>