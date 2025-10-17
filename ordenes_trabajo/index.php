<?php

include('../app/config.php');
include('../layout/sesion.php');

include('../layout/parte1.php');


include('../app/controllers/clientes/listado_de_clientes.php');
// Consulta SQL para obtener los técnicos y sus horarios
$query = "SELECT ht.ID_HorarioTecnico, ht.ID_Usuario, ht.Dia_Inicio_Semana, ht.Dia_Fin_Semana, ht.Horario_Inicio, ht.Horario_Fin, u.nombres, u.apellidos 
          FROM horariostecnicos ht 
          INNER JOIN tb_usuarios u ON ht.ID_Usuario = u.ID_Usuario";

try {
    // Ejecutar la consulta y obtener los resultados
    $resultadoConsulta = $pdo->query($query);
    $tecnicos = $resultadoConsulta->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error en la consulta: " . $e->getMessage();
    exit();
}



// Consulta para obtener el último número de factura
$sql = "SELECT numero_factura FROM ordenes_instalacion ORDER BY numero_factura DESC LIMIT 1";
$stmt = $pdo->query($sql);
$ultima_factura = $stmt->fetch(PDO::FETCH_ASSOC);

// Determinar el siguiente número de factura
if ($ultima_factura) {
    // Incrementar el último número de factura y agregar ceros a la izquierda
    $nuevo_numero_factura = str_pad((int)$ultima_factura['numero_factura'] + 1, 3, '0', STR_PAD_LEFT);
} else {
    // Si no hay facturas, empezar desde 001
    $nuevo_numero_factura = '001';
}




// Consulta para obtener productos activos de la categoría "repuestos"
$sqlProductos = "SELECT a.id_producto, a.codigo, a.nombre, a.id_categoria, a.imagen, a.precio_venta, a.estado, a.descripcion, c.nombre_categoria
                 FROM tb_almacen a
                 INNER JOIN tb_categorias c ON a.id_categoria = c.id_categoria
                 WHERE LOWER(c.nombre_categoria) = 'repuestos'
                   AND a.estado = 'activo'";
$stmtProductos = $pdo->query($sqlProductos);
$productos = $stmtProductos->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Instalación</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-8">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Ordenes de trabajo Instalación </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                </button>
                            </div>

                        </div>

                        <div class="card-body" style="display: block;">
                            <!-- Campo Fecha de Orden -->
                            <div class="form-group">
                                <label for="fecha_orden">Fecha de Orden:</label>
                                <input type="date" id="fecha_orden" name="fecha_orden" class="form-control" required value="<?= date('Y-m-d') ?>">
                            </div>

                            <!-- Botón para Seleccionar Factura y Modal -->
                            <!-- Botón para Seleccionar Factura y Modal -->
                            <div class="form-group">
                                <label for="numero_factura">Número de Factura:</label>
                                <div class="input-group">
                                    <!-- El valor del número de factura se obtiene de PHP -->
                                    <input type="text" id="numero_factura" name="numero_factura" class="form-control" value="<?php echo $nuevo_numero_factura; ?>" readonly>

                                </div>
                            </div>

                            <!-- Campos de Cliente -->
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

                            <!-- Input del técnico fuera del modal (donde se mostrará el nombre y se guarda el ID) -->
                            <div class="form-group">
                                <label for="tecnico">Técnico:</label>
                                <div class="input-group">
                                    <!-- Asegúrate de incluir el atributo data-idtecnico -->
                                    <input type="text" id="tecnico" name="tecnico" class="form-control" readonly data-id-tecnico="">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTecnico">
                                            Seleccionar Técnico
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal para seleccionar técnico -->
                            <div class="modal fade" id="modalTecnico" tabindex="-1" role="dialog" aria-labelledby="modalTecnicoLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalTecnicoLabel">Seleccionar Técnico</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Lista de técnicos generada dinámicamente con PHP -->
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>ID Técnico</th>
                                                        <th>Nombre</th>
                                                        <th>Horario</th>
                                                        <th>Seleccionar</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    foreach ($tecnicos as $tecnico) {
                                                        $nombreCompleto = $tecnico['nombres'] . " " . $tecnico['apellidos'];
                                                        $horario = "{$tecnico['Dia_Inicio_Semana']} a {$tecnico['Dia_Fin_Semana']}, de {$tecnico['Horario_Inicio']} a {$tecnico['Horario_Fin']}";
                                                        echo "<tr>
                                    <td>{$tecnico['ID_HorarioTecnico']}</td>
                                    <td>{$nombreCompleto}</td>
                                    <td>{$horario}</td>
                                    <td>
                                        <button type='button' class='btn btn-success'
                                            onclick='seleccionarTecnico(\"{$nombreCompleto}\", \"{$tecnico['ID_HorarioTecnico']}\")'>
                                            Seleccionar
                                        </button>
                                    </td>
                                  </tr>";
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <script>
                                function seleccionarTecnico(nombre, id) {
                                    const input = document.getElementById('tecnico');
                                    input.value = nombre;
                                    input.setAttribute('data-id-tecnico', id);
                                        $('#modalTecnico').modal('hide');
                                }
                            </script>

                            <!-- Campo de Fecha y Hora -->
                            <div class="form-group">
                                <label for="fecha_hora">Fecha y Hora de Instalación:</label>
                                <input type="datetime-local" id="fecha_hora" name="fecha_hora" class="form-control" required min="<?php echo date('Y-m-d\TH:i'); ?>">
                            </div>
                                <!-- Nodo oculto para pasar el resumen y carrito al backend -->
                                <pre id="datos_extra" class="d-none"></pre>
<input type="hidden" id="items_json" value="[]">

                            <!-- Campo Instalación o Mantenimiento -->
                            <div class="form-group">
                                <label for="servicio">Servicio:</label>
                                <!-- Select deshabilitado para mostrar solo "Instalación" -->
                                <select id="servicio" class="form-control" disabled>
                                    <option value="instalacion" selected>Instalación</option>
                                </select>
                                <!-- Input oculto para enviar el valor en el formulario -->
                                <input type="hidden" name="servicio" value="instalacion">
                            </div>


                            <!-- Separador -->
                            <hr>

                            <!-- Botón para seleccionar Repuesto y Modal -->
                            <div class="form-group">
                                <label for="repuesto">Repuesto:</label>
                                <div class="input-group">
                                    <input type="text" id="repuesto" name="repuesto" class="form-control" readonly>

                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalRepuesto">
                                            Seleccionar Repuesto
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal para seleccionar repuesto -->
                            <!-- Modal para seleccionar repuesto -->
                            <!-- Modal para seleccionar repuesto -->
                            <div class="modal fade" id="modalRepuesto" tabindex="-1" role="dialog" aria-labelledby="modalRepuestoLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document"> <!-- Modal grande -->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalRepuestoLabel">Seleccionar Repuesto</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Lista de repuestos en una tabla -->
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Código</th>
                                                        <th>Nombre</th>
                                                        <th>Descripción</th>
                                                        <th>Imagen</th>
                                                        <th>Precio Venta</th>
                                                        <th>Seleccionar</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                         <?php foreach ($productos as $producto): ?>
  <tr>
    <td><?= htmlspecialchars($producto['codigo']); ?></td>
    <td><?= htmlspecialchars($producto['nombre']); ?></td>
    <td><?= htmlspecialchars($producto['descripcion']); ?></td>
    <td><img src="<?= $URL . '/almacen/img_productos/' . $producto['imagen']; ?>" alt="Imagen" width="50"></td>
    <td><?= htmlspecialchars($producto['precio_venta']); ?></td>
    <td>
      <button type="button" class="btn btn-success btn-sm"
        onclick="agregarAlCarrito(
          '<?= $producto['id_producto']; ?>',
          '<?= addslashes($producto['codigo']); ?>',
          '<?= addslashes($producto['nombre']); ?>',
          '<?= addslashes($producto['descripcion']); ?>',
          '<?= addslashes($producto['precio_venta']); ?>'
        )">
        Agregar
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




                            <!-- Espacio en blanco para mostrar datos -->
                            <!-- Área para mostrar el resumen (precio venta, adicional y total) -->
                            <!-- 🔁 Carrito de repuestos -->
                            <div class="form-group">
                                <label>Repuestos seleccionados</label>

                                <!-- IVA por defecto para nuevos ítems -->
                                <div class="mb-2">
                                    <label for="iva_repuesto">IVA por defecto (%)</label>
                                    <input type="number" id="iva_repuesto" class="form-control" value="15" min="0" max="100" step="0.01">
                                    <small class="text-muted">Este IVA se usará como valor inicial al añadir repuestos (podrás editarlo por ítem).</small>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm" id="tablaCarrito">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Código</th>
                                                <th>Nombre</th>
                                                <th class="text-center" style="width: 100px;">Cant.</th>
                                                <th class="text-right">Precio</th>
                                                <th class="text-center" style="width: 110px;">IVA %</th>
                                                <th class="text-right">IVA $</th>
                                                <th class="text-right">Total $</th>
                                                <th class="text-center">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody id="carritoBody">
                                            <!-- filas dinámicas -->
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="6" class="text-right">Total General:</th>
                                                <th class="text-right" id="totalGeneral">$0.00</th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>


                        </div>

                        <div class="card-footer">
                            <button type="button" class="btn btn-primary" onclick="guardarOrden()">Guardar Orden</button>


                        </div>
                    </div>
                </div>

                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
</div><!-- /.content -->
</div><!-- /.content-wrapper -->
<!-- Script para seleccionar Factura, Técnico, Repuesto -->
<script>
    function seleccionarFactura(numero) {
        document.getElementById('numero_factura').value = numero;
        $('#modalFactura').modal('hide');
    }

    // 🧺 Carrito
    const carrito = []; // {id, codigo, nombre, descripcion, precio, cantidad, ivaPorcentaje}
    const toMoney = n => `$${(Number(n) || 0).toFixed(2)}`;

    function idxById(id) {
        return carrito.findIndex(it => String(it.id) === String(id));
    }

    function agregarAlCarrito(id, codigo, nombre, descripcion, precioStr) {
        const precio = parseFloat(precioStr) || 0;
        const ivaDefault = parseFloat(document.getElementById('iva_repuesto').value) || 0;
        const i = idxById(id);
        if (i >= 0) carrito[i].cantidad += 1;
        else carrito.push({
            id,
            codigo,
            nombre,
            descripcion,
            precio,
            cantidad: 1,
            ivaPorcentaje: ivaDefault
        });
        renderCarrito();
        // Si quieres cerrar el modal al agregar el primero:
        // $('#modalRepuesto').modal('hide');
    }

    function calcularFila(item) {
        const subtotal = item.precio * item.cantidad;
        const valorIva = subtotal * (item.ivaPorcentaje / 100);
        const total = subtotal + valorIva;
        return {
            subtotal,
            valorIva,
            total
        };
    }

function renderCarrito() {
  const tbody = document.getElementById('carritoBody');
  tbody.innerHTML = '';

  let subtotalSum = 0;
  let ivaSum = 0;
  let totalGeneral = 0;

  carrito.forEach((item, idx) => {
    const { subtotal, valorIva, total } = calcularFila(item);
    subtotalSum += subtotal;
    ivaSum += valorIva;
    totalGeneral += total;

    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td>${item.codigo || ''}</td>
      <td>${item.nombre}</td>
      <td class="text-center">
        <input type="number" class="form-control form-control-sm text-center" min="1" value="${item.cantidad}"
               onchange="cambiarCantidad(${idx}, this.value)">
      </td>
      <td class="text-right">${toMoney(item.precio)}</td>
      <td class="text-center">
        <input type="number" class="form-control form-control-sm text-center" min="0" max="100" step="0.01"
               value="${item.ivaPorcentaje}" onchange="cambiarIva(${idx}, this.value)">
      </td>
      <td class="text-right">${toMoney(valorIva)}</td>
      <td class="text-right">${toMoney(total)}</td>
      <td class="text-center">
        <button class="btn btn-danger btn-sm" onclick="eliminarItem(${idx})"><i class="fas fa-trash"></i></button>
      </td>
    `;
    tbody.appendChild(tr);
  });

  // Total general en la tabla
  document.getElementById('totalGeneral').textContent = toMoney(totalGeneral);

  // 🧾 Además, escribe un resumen legible y guarda totales/JSON en data-*
  const resumenNode = document.getElementById('datos_extra');
  if (resumenNode) {
    const lineas = carrito.map(item => {
            const { total } = calcularFila(item);
            return `• ${item.nombre} (x${item.cantidad}) - $${item.precio.toFixed(2)} c/u | IVA ${item.ivaPorcentaje}% -> Total ítem: $${total.toFixed(2)}`;
        });

        const resumenTexto =
`Repuestos seleccionados:
${lineas.join('\n')}

Resumen:
Subtotal: $${subtotalSum.toFixed(2)}
IVA: $${ivaSum.toFixed(2)}
Total con IVA: $${totalGeneral.toFixed(2)}
`;
        resumenNode.textContent = resumenTexto;
    // Guarda datos para guardarOrden()
    resumenNode.dataset.subtotal = subtotalSum.toFixed(2);
    resumenNode.dataset.iva = ivaSum.toFixed(2);
    resumenNode.dataset.total = totalGeneral.toFixed(2);
    resumenNode.dataset.items = JSON.stringify(carrito);
  }

  // Actualiza el input oculto con el JSON del carrito
  const itemsJsonInput = document.getElementById('items_json');
  if (itemsJsonInput) {
    itemsJsonInput.value = JSON.stringify({
      items: carrito,
      subtotal: subtotalSum,
      iva: ivaSum,
      total: totalGeneral
    });
  }
}


    function cambiarCantidad(idx, val) {
        carrito[idx].cantidad = Math.max(1, parseInt(val || 1, 10));
        renderCarrito();
    }

    function cambiarIva(idx, val) {
        carrito[idx].ivaPorcentaje = Math.max(0, parseFloat(val || 0));
        renderCarrito();
    }

    function eliminarItem(idx) {
        carrito.splice(idx, 1);
        renderCarrito();
    }

    function guardarOrden() {
        if (carrito.length === 0) {
            Swal.fire("Carrito vacío", "Agrega al menos un repuesto.", "warning");
            return;
        }

        // Leer totales y JSON desde #datos_extra (los dejó renderCarrito)
        const resumenNode = document.getElementById('datos_extra');
        const subtotal = parseFloat(resumenNode?.dataset.subtotal || '0') || 0;
        const ivaTotal = parseFloat(resumenNode?.dataset.iva || '0') || 0;
        const total = parseFloat(resumenNode?.dataset.total || '0') || 0;
        const itemsJSON = resumenNode?.dataset.items || '[]';

        const iva_porcentaje_orden = parseFloat(document.getElementById('iva_repuesto').value || '0');

        // Campos existentes del form
        const fecha_orden = document.getElementById('fecha_orden').value;
        const numero_factura = document.getElementById('numero_factura').value;
        const cedula = document.getElementById('cedula').value;
        const nombre = document.getElementById('nombre').value;
        const correo = document.getElementById('correo').value;
        const tecnico_id = document.getElementById('tecnico').getAttribute('data-id-tecnico') || '';
        let fecha_instalacion_raw = document.getElementById('fecha_hora').value;
        let fecha_instalacion = '';
        if (fecha_instalacion_raw) {
          fecha_instalacion = fecha_instalacion_raw.replace('T', ' ');
          if (/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}$/.test(fecha_instalacion)) {
            fecha_instalacion += ':00';
          }
        }
        const itemsJsonInput = document.getElementById('items_json');
        const datos_extras = itemsJsonInput ? itemsJsonInput.value : '[]';

        const params = new URLSearchParams({
          fecha_orden,
          numero_factura,
          cedula,
          nombre,
          correo,
          tecnico_id,
          fecha_instalacion,
          precio_venta: subtotal.toFixed(2),
          valor_iva: ivaTotal.toFixed(2),
          total_con_iva: total.toFixed(2),
          datos_extras: datos_extras,
           iva_porcentaje: iva_porcentaje_orden.toFixed(2)
        });

                fetch('../app/controllers/ordenes_trabajo/save.php', {
                    method: 'POST',
                    body: params
                })
                .then(res => res.text())
                .then(msg => {
                    console.log("Respuesta del servidor:", msg);
                    Swal.fire("Guardado", "La orden fue registrada", "success");
                    carrito.length = 0;
                    renderCarrito(); // limpia la tabla/resumen
                })
                .catch(err => {
                    console.error("Error al guardar:", err);
                    Swal.fire("Error", "No se pudo guardar la orden", "error");
                });
            }

    function verificarCedula() {
        // 1. Tomar el valor del input
        const cedulaValor = document.getElementById('cedula').value.trim();

        // 2. Verificar si la longitud es 10
        if (cedulaValor.length === 10) {
            // Mostrar en consola el valor y la URL que se va a enviar
            const url = `../app/controllers/ordenes_trabajo/buscar_cliente.php?cedula=${cedulaValor}`;
            console.log("Enviando petición a:", url);

            // 3. Hacer la petición a tu archivo PHP
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    // 4. Revisar la respuesta
                    if (data.success) {
                        // Llenar los campos de nombre y correo
                        document.getElementById('nombre').value = data.nombre;
                        document.getElementById('correo').value = data.correo;
                        console.log("Respuesta recibida:", data);
                    } else {
                        // Limpiar los campos
                        document.getElementById('nombre').value = "";
                        document.getElementById('correo').value = "";
                        // Mostrar SweetAlert2 de error
                        Swal.fire({
                            icon: 'error',
                            title: 'No encontrado',
                            text: 'No se encontró un cliente con esa cédula.'
                        });
                        console.log("Cliente no encontrado.");
                    }
                })
                .catch(error => {
                    console.error("Error al buscar cliente:", error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Ocurrió un error en la búsqueda.'
                    });
                });
        } else {
            // Si la longitud es menor o mayor a 10, limpiamos los campos
            document.getElementById('nombre').value = "";
            document.getElementById('correo').value = "";
            console.log("La cédula no tiene 10 dígitos. Valor ingresado:", cedulaValor);
        }
    }
</script>
<?php include('../layout/mensajes.php'); ?>
<?php include('../layout/parte2.php'); ?>