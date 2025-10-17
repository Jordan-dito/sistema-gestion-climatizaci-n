<?php
include('../app/config.php');
include('../layout/sesion.php');

include('../layout/parte1.php');


include('../app/controllers/categorias/listado_de_categoria.php');



$query = $pdo->prepare("
    SELECT
        m.nombre AS modulo,
        r.rol AS rol,
        p.estado AS estado
    FROM
        tb_roles r
        JOIN tb_permisos p ON r.id_rol = p.id_rol
        JOIN tb_modulos m ON p.id_modulo = m.id_modulo
    WHERE
        p.estado = 'activo' or p.estado = 'inactivo'
    ORDER BY
        m.nombre, r.rol
");
$query->execute();

$permisos = $query->fetchAll(PDO::FETCH_ASSOC);

// Agrupar los permisos por módulo
$modulos = [];
foreach ($permisos as $permiso) {
    $modulos[$permiso['modulo']][] = $permiso;
}





?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">

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
                            <h3 class="card-title">Permisos del sistema </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                </button>
                            </div>

                        </div>

                        <div class="card-body" style="display: block;">
                           
                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Módulo</th>
            <th>Perfil</th>
            <th>Status</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody id="permissions-table">
        <?php foreach ($modulos as $modulo => $permisos): ?>
            <tr>
                <td rowspan="<?php echo count($permisos); ?>"><?php echo htmlspecialchars($modulo); ?></td>
                <td><?php echo htmlspecialchars($permisos[0]['rol']); ?></td>
                <td class="status">
                    <span class="badge badge-<?php echo $permisos[0]['estado'] == 'activo' ? 'success' : 'danger'; ?>">
                        <?php echo ucfirst($permisos[0]['estado']); ?>
                    </span>
                </td>
                <td>
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input toggle-permission" 
                               id="switch-<?php echo htmlspecialchars($modulo . '-' . $permisos[0]['rol']); ?>" 
                               data-modulo="<?php echo htmlspecialchars($modulo); ?>" 
                               data-rol="<?php echo htmlspecialchars($permisos[0]['rol']); ?>" 
                               <?php echo $permisos[0]['estado'] == 'activo' ? 'checked' : ''; ?>>
                        <label class="custom-control-label" for="switch-<?php echo htmlspecialchars($modulo . '-' . $permisos[0]['rol']); ?>"></label>
                    </div>
                </td>
            </tr>
            <?php for ($i = 1; $i < count($permisos); $i++): ?>
            <tr>
                <td><?php echo htmlspecialchars($permisos[$i]['rol']); ?></td>
                <td class="status">
                    <span class="badge badge-<?php echo $permisos[$i]['estado'] == 'activo' ? 'success' : 'danger'; ?>">
                        <?php echo ucfirst($permisos[$i]['estado']); ?>
                    </span>
                </td>
                <td>
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input toggle-permission" 
                               id="switch-<?php echo htmlspecialchars($modulo . '-' . $permisos[$i]['rol']); ?>" 
                               data-modulo="<?php echo htmlspecialchars($modulo); ?>" 
                               data-rol="<?php echo htmlspecialchars($permisos[$i]['rol']); ?>" 
                               <?php echo $permisos[$i]['estado'] == 'activo' ? 'checked' : ''; ?>>
                        <label class="custom-control-label" for="switch-<?php echo htmlspecialchars($modulo . '-' . $permisos[$i]['rol']); ?>"></label>
                    </div>
                </td>
            </tr>
            <?php endfor; ?>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
$(document).ready(function() {
    $('.toggle-permission').change(function() {
        var modulo = $(this).data('modulo');
        var rol = $(this).data('rol');
        var estado = $(this).is(':checked') ? 'activo' : 'inactivo';

        $.ajax({
            url: '../app/controllers/privilegios/index.php',
            method: 'POST',
            data: {
                modulo: modulo,
                rol: rol,
                estado: estado
            },
            success: function(response) {
                console.log(response);

                // Mostrar alerta de SweetAlert
                Swal.fire({
                    title: 'Cambio de Estado',
                    text: 'El estado del permiso para ' + modulo + ' ha sido actualizado a ' + estado + '.',
                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                }).then(function() {
                    // Recargar la página después de mostrar la alerta
                    location.reload();
                });

            }.bind(this), // Para mantener el contexto de `this`
            error: function(xhr, status, error) {
                console.error('Error al actualizar el permiso:', error);

                // Mostrar alerta de error en caso de fallo
                Swal.fire({
                    title: 'Error',
                    text: 'No se pudo actualizar el estado del permiso.',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            }
        });
    });
});
</script>


                            <!-- /.row -->
                        </div><!-- /.container-fluid -->
                    </div>
                    <!-- /.content -->
                </div>
                <!-- /.content-wrapper -->
                <!-- Modal para Editar Técnico -->




                <?php include('../layout/mensajes.php'); ?>
                <?php include('../layout/parte2.php'); ?>
