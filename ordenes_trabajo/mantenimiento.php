<?php

include('../app/config.php');
include('../layout/sesion.php');

include('../layout/parte1.php');

// =================== TÉCNICOS CON HORARIOS ===================
try {
    $stmtTec = $pdo->prepare("
        SELECT ht.ID_HorarioTecnico, ht.ID_Usuario, ht.Dia_Inicio_Semana, ht.Dia_Fin_Semana,
               ht.Horario_Inicio, ht.Horario_Fin, u.nombres, u.apellidos
        FROM horariostecnicos ht
        INNER JOIN tb_usuarios u ON ht.ID_Usuario = u.ID_Usuario
        WHERE ht.Estado IN ('Disponible', 'Activo')
    ");
    $stmtTec->execute();
    $tecnicos = $stmtTec->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error en la consulta de técnicos: " . $e->getMessage();
    exit();
}

// =================== SIGUIENTE NÚMERO DE FACTURA ===================
// Nota: Idealmente haz esto dentro de una transacción al guardar la orden para evitar condiciones de carrera.
// Aquí solo mostramos el siguiente número sugerido.
try {
    // Si numero_factura es VARCHAR, lo convertimos a entero para MAX y luego left-pad a 3
    $stmtFact = $pdo->query("
        SELECT LPAD(COALESCE(MAX(CAST(numero_factura AS UNSIGNED)), 0) + 1, 3, '0') AS next_num
        FROM ordenes_instalacion
    ");
    $rowFact = $stmtFact->fetch(PDO::FETCH_ASSOC);
    $nuevo_numero_factura = $rowFact && $rowFact['next_num'] ? $rowFact['next_num'] : '001';
} catch (PDOException $e) {
    $nuevo_numero_factura = '001';
}

// =================== PRODUCTOS (NO USADOS DIRECTO EN LA TABLA, SE CARGAN POR CÉDULA) ===================
try {
    $stmtProductos = $pdo->prepare("
        SELECT a.id_producto, a.codigo, a.nombre, a.id_categoria, a.imagen, a.precio_venta, a.estado, a.descripcion, c.nombre_categoria
        FROM tb_almacen a
        INNER JOIN tb_categorias c ON a.id_categoria = c.id_categoria
        WHERE LOWER(c.nombre_categoria) = :cat
          AND a.estado = 'activo'
    ");
    $stmtProductos->execute([':cat' => 'repuestos']);
    $productos = $stmtProductos->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $productos = [];
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1 class="m-0">Mantenimiento</h1>
        </div>
      </div>
    </div>
  </div>

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">

      <div class="row">
        <!-- ====== Columna izquierda ====== -->
        <div class="col-12 col-lg-8"><!-- <- full en móvil, 8/12 en >=992px -->

          <div class="card card-outline card-primary">
            <div class="card-header">
              <h3 class="card-title">Órdenes de trabajo - Mantenimiento</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>

            <div class="card-body">
              <!-- Fecha de Orden -->
              <div class="form-group">
                <label for="fecha_orden">Fecha de Orden:</label>
                <input type="date" id="fecha_orden" name="fecha_orden" class="form-control" required>
              </div>

              <!-- Número de Factura -->
              <div class="form-group">
                <label for="numero_factura">Número de Factura:</label>
                <div class="input-group">
                  <input type="text" id="numero_factura" name="numero_factura" class="form-control" value="<?php echo htmlspecialchars($nuevo_numero_factura); ?>" readonly>
                </div>
              </div>

              <!-- Cliente -->
              <div class="form-group">
                <label for="cedula">Cédula:</label>
                <input type="text" id="cedula" name="cedula" class="form-control" onkeyup="verificarCedula()" required />
              </div>

              <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" class="form-control" required readonly>
              </div>

              <div class="form-group">
                <label for="correo">Correo:</label>
                <input type="email" id="correo" name="correo" class="form-control" required readonly>
              </div>

              <!-- Técnico -->
              <div class="form-group">
                <label for="tecnico">Técnico:</label>
                <div class="input-group">
                  <input type="text" id="tecnico" name="tecnico" class="form-control" readonly data-id-tecnico="">
                  <div class="input-group-append">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTecnico">
                      Seleccionar Técnico
                    </button>
                  </div>
                </div>
              </div>

              <!-- Modal Técnico -->
              <div class="modal fade" id="modalTecnico" tabindex="-1" role="dialog" aria-labelledby="modalTecnicoLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable" role="document"><!-- scrollable para evitar desbordes -->
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="modalTecnicoLabel">Seleccionar Técnico</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div class="table-responsive"><!-- evita scroll horizontal -->
                        <table class="table table-striped table-hover">
                          <thead>
                            <tr>
                              <th>ID Técnico</th>
                              <th>Nombre</th>
                              <th>Horario</th>
                              <th>Seleccionar</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php foreach ($tecnicos as $tecnico):
                              $nombreCompleto = $tecnico['nombres'] . " " . $tecnico['apellidos'];
                              $horario = "{$tecnico['Dia_Inicio_Semana']} a {$tecnico['Dia_Fin_Semana']}, de {$tecnico['Horario_Inicio']} a {$tecnico['Horario_Fin']}";
                            ?>
                            <tr>
                              <td><?php echo htmlspecialchars($tecnico['ID_HorarioTecnico']); ?></td>
                              <td class="text-nowrap"><?php echo htmlspecialchars($nombreCompleto); ?></td>
                              <td class="text-nowrap"><?php echo htmlspecialchars($horario); ?></td>
                              <td>
                                <button type="button" class="btn btn-success btn-sm"
                                  onclick="seleccionarTecnico(<?php echo json_encode($nombreCompleto); ?>, <?php echo json_encode($tecnico['ID_HorarioTecnico']); ?>)">
                                  Seleccionar
                                </button>
                              </td>
                            </tr>
                            <?php endforeach; ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Fecha y Hora de Mantenimiento -->
              <div class="form-group">
                <label for="fecha_hora">Fecha y Hora de Mantenimiento:</label>
                <input type="datetime-local" id="fecha_hora" name="fecha_hora" class="form-control" required min="<?php echo date('Y-m-d\TH:i'); ?>">
              </div>

              <!-- Tipo de servicio -->
              <div class="form-group">
                <label for="tipo_servicio">Tipo de Servicio:</label>
                <select id="tipo_servicio" class="form-control" required>
                  <option value="">Seleccione...</option>
                  <option value="mantenimiento">Mantenimiento</option>
                  <option value="reparacion">Reparación</option>
                </select>
              </div>

              <hr>

              <!-- A/C comprados por el cliente -->
              <div class="form-group">
                <label for="repuesto">A/C COMPRADOS POR EL CLIENTE :</label>
                <div class="input-group">
                  <input type="text" id="repuesto" name="repuesto" class="form-control" readonly data-id-producto="">
                  <input type="hidden" id="cantidad_ac" name="cantidad_ac" value="0">
                  <div class="input-group-append">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalRepuesto">
                      Seleccionar A/C
                    </button>
                  </div>
                </div>
              </div>

              <div class="form-group mb-0">
                <label for="costo_servicio">Costo del servicio ($)</label>
                <input type="number" id="costo_servicio" class="form-control" value="0" step="0.01">
              </div>

              <!-- Modal A/C -->
              <div class="modal fade" id="modalRepuesto" tabindex="-1" role="dialog" aria-labelledby="modalRepuestoLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="modalRepuestoLabel">Seleccionar A/C Comprado</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div class="table-responsive">
                        <table class="table table-bordered table-hover mb-0" id="tabla-productos">
                          <thead>
                            <tr>
                              <th>Nombre</th>
                              <th>Descripción</th>
                              <th>Precio Venta</th>
                              <th>Cantidad</th>
                              <th>Seleccionar</th>
                            </tr>
                          </thead>
                          <tbody></tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Resumen -->
              <div class="form-group mt-3">
                <label for="datos_extra">Resumen del Repuesto:</label>
                <div id="datos_extra" class="card card-body bg-light" style="white-space: pre-wrap; border: 1px solid #ddd;"></div>

                <div class="form-group mt-2 mb-0">
                  <label for="iva_repuesto">IVA (%)</label>
                  <input type="number" id="iva_repuesto" class="form-control" value="15" min="0" max="100" step="0.01">
                </div>
              </div>
            </div>

            <div class="card-footer">
              <button type="button" class="btn btn-primary" id="btn-guardar" onclick="guardarOrden()">Guardar Orden</button>
            </div>
          </div>
        </div>

        <!-- ====== Columna derecha ====== -->
        <div class="col-12 col-lg-4"><!-- <- full en móvil, 4/12 en >=992px -->
          <!-- Programados -->
          <div class="card mb-3">
            <div class="card-header bg-primary text-white">
              Mantenimientos Programados
            </div>
            <div class="card-body">
              <div class="table-responsive"><!-- evita desborde -->
                <table class="table table-bordered table-striped mb-0">
                  <thead>
                    <tr>
                      <th>Factura</th>
                      <th>Tipo Servicio</th>
                      <th>Fecha Mantenimiento</th>
                      <th>Próximo Mantenimiento</th>
                      <th>Estado</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody id="tabla-mantenimientos">
                    <!-- Dinámico -->
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <!-- Actualizar -->
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

                <button type="button" class="btn btn-success mt-1" onclick="actualizarMantenimiento()">
                  Guardar Cambios
                </button>
              </form>
            </div>
          </div>
        </div>

      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div><!-- /.content -->
</div><!-- /.content-wrapper -->


<!-- =================== SCRIPTS =================== -->
<script>
    let ultimoProductoSeleccionado = { nombre: '', descripcion: '', cantidad: 0 };

    // ==== Helpers de fecha ====
    function parseDate(value) {
        if (!value) return null;
        // Acepta "YYYY-MM-DD HH:MM[:SS]" o "YYYY-MM-DDTHH:MM[:SS]"
        const str = String(value).replace(' ', 'T');
        const d = new Date(str);
        return isNaN(d) ? null : d;
    }
    function dateOnly(d) {
        return new Date(d.getFullYear(), d.getMonth(), d.getDate());
    }
    function toInputDatetimeLocal(value) {
        // Convierte "YYYY-MM-DD HH:MM:SS" a "YYYY-MM-DDTHH:MM"
        const d = parseDate(value);
        if (!d) return '';
        const pad = n => String(n).padStart(2, '0');
        return `${d.getFullYear()}-${pad(d.getMonth()+1)}-${pad(d.getDate())}T${pad(d.getHours())}:${pad(d.getMinutes())}`;
    }

    function seleccionarFactura(numero) {
        document.getElementById('numero_factura').value = numero;
        $('#modalFactura').modal('hide');
    }

    function seleccionarTecnico(nombre, id) {
        const inputTec = document.getElementById('tecnico');
        inputTec.value = nombre;
        inputTec.dataset.idTecnico = id;
        $('#modalTecnico').modal('hide');
    }

    function verificarCedula() {
        const cedulaValor = document.getElementById('cedula').value.trim();

        if (cedulaValor.length === 10) {
            const urlCliente = `../app/controllers/ordenes_trabajo/buscar_cliente.php?cedula=${encodeURIComponent(cedulaValor)}`;
            fetch(urlCliente)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('nombre').value = data.nombre || '';
                        document.getElementById('correo').value = data.correo || '';
                        cargarProductosPorCedula(cedulaValor);
                    } else {
                        document.getElementById('nombre').value = "";
                        document.getElementById('correo').value = "";
                        Swal.fire({icon: 'error', title: 'No encontrado', text: 'No se encontró un cliente con esa cédula.'});
                    }
                })
                .catch(error => {
                    console.error("Error al buscar cliente:", error);
                    Swal.fire({icon: 'error', title: 'Error', text: 'Ocurrió un error al buscar el cliente.'});
                });
        } else {
            document.getElementById('nombre').value = "";
            document.getElementById('correo').value = "";
        }
    }

    function cargarProductosPorCedula(cedula) {
        const url = `../app/controllers/ventas/buscar_ventas_por_cedula.php?cedula=${encodeURIComponent(cedula)}`;
        fetch(url)
            .then(res => res.json())
            .then(data => {
                const tbody = document.querySelector("#tabla-productos tbody");
                tbody.innerHTML = "";

                if (data.success && Array.isArray(data.productos) && data.productos.length > 0) {
                    data.productos.forEach(prod => {
                        const nombreJS = JSON.stringify(prod.nombre ?? '');
                        const descJS   = JSON.stringify(prod.descripcion ?? '');
                        const precioJS = JSON.stringify(String(prod.precio_venta ?? '0'));
                        const cantJS   = JSON.stringify(String(prod.cantidad_total ?? '0'));
                        const idProdJS = JSON.stringify(String(prod.id_producto ?? ''));

                        const fila = `
                        <tr>
                            <td>${prod.nombre}</td>
                            <td>${prod.descripcion}</td>
                            <td>$${parseFloat(prod.precio_venta).toFixed(2)}</td>
                            <td>${prod.cantidad_total}</td>
                            <td>
                                <button class="btn btn-success btn-sm"
                                    onclick="seleccionarRepuesto(${nombreJS}, ${descJS}, ${precioJS}, ${cantJS}, ${idProdJS})">
                                    Seleccionar
                                </button>
                            </td>
                        </tr>`;
                        tbody.insertAdjacentHTML('beforeend', fila);
                    });
                    $('#modalRepuesto').modal('show');
                } else {
                    $('#modalRepuesto').modal('hide');
                    Swal.fire("Aviso", "No se encontraron productos comprados para esta cédula", "info");
                }
            })
            .catch(error => {
                console.error("Error al cargar productos:", error);
                Swal.fire("Error", "No se pudo cargar la lista de productos", "error");
            });
    }

    function seleccionarRepuesto(nombre, descripcion, precio_venta, cantidad_total, id_producto) {
        const inputRep = document.getElementById('repuesto');
        inputRep.value = nombre;
        inputRep.dataset.idProducto = id_producto;
        document.getElementById('cantidad_ac').value = cantidad_total;

        ultimoProductoSeleccionado = {
            nombre: nombre,
            descripcion: descripcion,
            cantidad: parseInt(cantidad_total || '0', 10)
        };

        actualizarResumen();
        $('#modalRepuesto').modal('hide');
    }

    document.getElementById('iva_repuesto').addEventListener('input', actualizarResumen);
    document.getElementById('costo_servicio').addEventListener('input', actualizarResumen);

    function actualizarResumen() {
        const { nombre, descripcion, cantidad } = ultimoProductoSeleccionado;
        if (!nombre || (cantidad || 0) <= 0) {
            document.getElementById('datos_extra').textContent = '';
            return;
        }

        const costoServicioUnitario = parseFloat(document.getElementById('costo_servicio').value) || 0;
        const ivaPorcentaje = parseFloat(document.getElementById('iva_repuesto').value) || 0;

        const totalServicio = costoServicioUnitario * cantidad;
        const iva = totalServicio * (ivaPorcentaje / 100);
        const totalFinal = totalServicio + iva;

        const resumen = `
Nombre: ${nombre}
Descripción: ${descripcion}
Cantidad seleccionada: ${cantidad}
Costo Servicio: $${totalServicio.toFixed(2)}
IVA (${ivaPorcentaje}%): $${iva.toFixed(2)}
Total Servicio + IVA: $${totalFinal.toFixed(2)}
        `;
        document.getElementById('datos_extra').textContent = resumen.trim();
    }

    function guardarOrden() {
        const btn = document.getElementById('btn-guardar');
        const fechaHora = document.getElementById('fecha_hora').value;
        const tipoServicio = document.getElementById('tipo_servicio').value;
        const tecnico = document.getElementById('tecnico').dataset.idTecnico || "";
        const repuesto = document.getElementById('repuesto').dataset.idProducto || "";

        if (!fechaHora) return Swal.fire("Campo requerido", "Debes seleccionar la fecha y hora de mantenimiento", "warning");
        if (!tipoServicio) return Swal.fire("Campo requerido", "Debes seleccionar el tipo de servicio", "warning");
        if (!tecnico) return Swal.fire("Campo requerido", "Debes seleccionar un técnico", "warning");
        if (!repuesto) return Swal.fire("Campo requerido", "Debes seleccionar un producto A/C", "warning");

        const cantidad = parseInt(document.getElementById('cantidad_ac').value) || 0;
        const costoUnitario = parseFloat(document.getElementById('costo_servicio').value) || 0;
        const ivaPorcentaje = parseFloat(document.getElementById('iva_repuesto').value) || 0;

        const costoTotal = cantidad * costoUnitario;
        const valorIva = costoTotal * (ivaPorcentaje / 100);
        const totalConIva = costoTotal + valorIva;

        const datos = {
            fecha_orden: document.getElementById('fecha_orden').value,
            numero_factura: document.getElementById('numero_factura').value,
            cedula: document.getElementById('cedula').value,
            nombre_cliente: document.getElementById('nombre').value,
            correo_cliente: document.getElementById('correo').value,
            id_horario_tecnico: tecnico,
            fecha_mantenimiento: fechaHora,
            id_producto: repuesto,
            cantidad: cantidad,
            costo_servicio: costoTotal.toFixed(2),
            iva_porcentaje: ivaPorcentaje,
            valor_iva: valorIva.toFixed(2),
            total_con_iva: totalConIva.toFixed(2),
            datos_extras: document.getElementById('datos_extra').textContent,
            tipo_servicio: tipoServicio
        };

        btn.disabled = true;
        fetch('../app/controllers/ordenes_trabajo/guardar_orden.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify(datos)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire("Éxito", "Orden guardada correctamente", "success").then(() => {
                    window.location.reload();
                });
            } else {
                Swal.fire("Error", data.message || "Ocurrió un error al guardar", "error");
            }
        })
        .catch(error => {
            console.error("Error en AJAX:", error);
            Swal.fire("Error", "No se pudo guardar la orden", "error");
        })
        .finally(() => { btn.disabled = false; });
    }

    function cargarMantenimientos() {
        fetch('../app/controllers/ordenes_trabajo/listar_mantenimientos.php')
            .then(response => response.json())
            .then(data => {
                const tbody = document.getElementById('tabla-mantenimientos');
                tbody.innerHTML = "";

                const hoy = new Date(); hoy.setHours(0,0,0,0);

                data.forEach(m => {
                    // *** COMPARAR CONTRA fecha_proximo_mantenimiento ***
                    const fProx = parseDate(m.fecha_proximo_mantenimiento);
                    let estado = "<span class='badge bg-secondary'>Sin fecha</span>";

                    if (fProx) {
                        const fSolo = dateOnly(fProx);

                        if (fSolo < hoy)       estado = "<span class='badge bg-danger'>Atrasado</span>";
                        else if (fSolo.getTime() === hoy.getTime())
                                                estado = "<span class='badge bg-warning'>Hoy</span>";
                        else                    estado = "<span class='badge bg-success'>Programado</span>";
                    }

                    const fila = `
                        <tr>
                            <td>${m.numero_factura}</td>
                            <td>${m.tipo_servicio}</td>
                            <td>${m.fecha_mantenimiento}</td>
                            <td>${m.fecha_proximo_mantenimiento ?? 'No programado'}</td>
                            <td>${estado}</td>
                            <td>
                                <button class="btn btn-success btn-sm"
                                    onclick="abrirModal('${m.id_mantenimiento}', '${m.fecha_mantenimiento}', '${m.fecha_proximo_mantenimiento ?? ''}')">
                                    Editar
                                </button>
                            </td>
                        </tr>
                    `;
                    tbody.insertAdjacentHTML('beforeend', fila);
                });
            })
            .catch(error => console.error("Error al cargar mantenimientos:", error));
    }

    function abrirModal(id, fechaMantenimiento, fechaProximo) {
        document.getElementById('id_mantenimiento').value = id;
        document.getElementById('fecha_mantenimiento').value = toInputDatetimeLocal(fechaMantenimiento);

        if (!fechaProximo || fechaProximo === "No programado" ) {
            const hoy = new Date();
            document.getElementById('fecha_proximo_mantenimiento').value = toInputDatetimeLocal(hoy.toISOString());
        } else {
            document.getElementById('fecha_proximo_mantenimiento').value = toInputDatetimeLocal(fechaProximo);
        }
    }

    function actualizarMantenimiento() {
        const datos = {
            id_mantenimiento: document.getElementById('id_mantenimiento').value,
            fecha_mantenimiento: document.getElementById('fecha_mantenimiento').value
        };

        fetch('../app/controllers/ordenes_trabajo/actualizar_mantenimiento.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify(datos)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire("Éxito", "Próximo mantenimiento programado para: " + data.proximo_mantenimiento, "success");
                document.getElementById('fecha_proximo_mantenimiento').value = toInputDatetimeLocal(data.proximo_mantenimiento);
                cargarMantenimientos();
            } else {
                Swal.fire("Error", data.message || "No se pudo actualizar", "error");
            }
        })
        .catch(error => {
            console.error("Error en AJAX:", error);
            Swal.fire("Error", "No se pudo actualizar el mantenimiento", "error");
        });
    }

    // Cargar mantenimientos al iniciar
    cargarMantenimientos();
</script>


<?php include('../layout/mensajes.php'); ?>
<?php include('../layout/parte2.php'); ?>
