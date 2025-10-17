<?php
// almacen/kardex_fifo.php
include('../app/config.php');      // debe exponer $pdo (PDO)
include('../layout/sesion.php');
include('../layout/parte1.php');

// Leer filtros (opcionales)
$desde = isset($_GET['desde']) && $_GET['desde'] !== '' ? $_GET['desde'] . ' 00:00:00' : null;
$hasta = isset($_GET['hasta']) && $_GET['hasta'] !== '' ? $_GET['hasta'] . ' 23:59:59' : null;

$rows = [];
$error = null;

try {
    // Llamar al SP con parámetros (NULL si no se envían)
    $stmt = $pdo->prepare("CALL sp_kardex_movimientos(:desde, :hasta)");
    if ($desde === null) {
        $stmt->bindValue(':desde', null, PDO::PARAM_NULL);
    } else {
        $stmt->bindValue(':desde', $desde, PDO::PARAM_STR);
    }
    if ($hasta === null) {
        $stmt->bindValue(':hasta', null, PDO::PARAM_NULL);
    } else {
        $stmt->bindValue(':hasta', $hasta, PDO::PARAM_STR);
    }

    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor(); // importante tras CALL
} catch (Exception $e) {
    $error = $e->getMessage();
}
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Kardex (Entradas / Salidas / Saldo)</h1>
                    <p class="text-muted mb-0">Resumen por producto en el rango seleccionado.</p>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
      <div class="container-fluid">

        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <!-- Filtro por fechas -->
        <div class="card mb-3">
            <div class="card-body">
                <form class="row g-3" method="get" action="">
                    <div class="col-md-3">
                        <label class="form-label">Desde</label>
                        <input type="date" name="desde" class="form-control"
                               value="<?php echo isset($_GET['desde']) ? htmlspecialchars($_GET['desde']) : ''; ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Hasta</label>
                        <input type="date" name="hasta" class="form-control"
                               value="<?php echo isset($_GET['hasta']) ? htmlspecialchars($_GET['hasta']) : ''; ?>">
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button class="btn btn-primary me-2" type="submit"><i class="fas fa-search"></i> Filtrar</button>
                        <a href="<?php echo $URL; ?>/almacen/kardex_fifo.php" class="btn btn-secondary">
                            <i class="fas fa-broom"></i> Limpiar
                        </a>
                    </div>
                </form>
                <?php if ($desde || $hasta): ?>
                    <p class="mt-2 text-muted">
                        Rango aplicado:
                        <strong><?php echo htmlspecialchars($desde ?? 'inicio'); ?></strong>
                        &nbsp;→&nbsp;
                        <strong><?php echo htmlspecialchars($hasta ?? 'fin'); ?></strong>
                    </p>
                <?php endif; ?>
            </div>
        </div>

        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Resumen por producto</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table id="tablaKardex" class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Código</th>
                                <th>Producto</th>
                                <th class="text-end">Entradas</th>
                                <th class="text-end">Salidas</th>
                                <th class="text-end">Saldo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($rows)): ?>
                                <?php foreach ($rows as $r): ?>
                                    <tr>
                                        <td><?php echo (int)$r['id_producto']; ?></td>
                                        <td><?php echo htmlspecialchars($r['codigo']); ?></td>
                                        <td><?php echo htmlspecialchars($r['nombre']); ?></td>
                                        <td class="text-end"><?php echo number_format((float)$r['total_entradas'], 2); ?></td>
                                        <td class="text-end"><?php echo number_format((float)$r['total_salidas'], 2); ?></td>
                                        <td class="text-end"><?php echo number_format((float)$r['saldo_final'], 2); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Código</th>
                                <th>Producto</th>
                                <th class="text-end">Entradas</th>
                                <th class="text-end">Salidas</th>
                                <th class="text-end">Saldo</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <a href="<?php echo $URL; ?>/almacen/index.php" class="btn btn-secondary btn-sm mt-3">
                    <i class="fas fa-arrow-left"></i> Volver al listado
                </a>
            </div>
        </div>
      </div>
    </section>
</div>

<?php include('../layout/parte2.php'); ?>

<script>
$(function () {
    $("#tablaKardex").DataTable({
        "pageLength": 10,
        "order": [[1, "asc"]], // orden por código
        "language": {
            "emptyTable": "No hay movimientos en el rango seleccionado",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ productos",
            "infoEmpty": "Mostrando 0 a 0 de 0 productos",
            "infoFiltered": "(filtrado de _MAX_ total)",
            "lengthMenu": "Mostrar _MENU_",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
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
        buttons: [
            {
                extend: 'collection',
                text: 'Reportes',
                orientation: 'landscape',
                buttons: [
                    { text: 'Copiar', extend: 'copy' },
                    { extend: 'pdf', title: 'Kardex_Resumen' },
                    { extend: 'csv', title: 'Kardex_Resumen' },
                    { extend: 'excel', title: 'Kardex_Resumen' },
                    { text: 'Imprimir', extend: 'print', title: 'Kardex - Resumen por producto' }
                ]
            },
            { extend: 'colvis', text: 'Visor de columnas', collectionLayout: 'fixed three-column' }
        ]
    }).buttons().container().appendTo('#tablaKardex_wrapper .col-md-6:eq(0)');
});
</script>
