<?php
include('../../config.php');

$id_proveedor = $_POST['id_proveedor'] ?? null;

if ($id_proveedor) {
    try {
        $sql = "UPDATE tb_proveedores SET estado = 'Activo' WHERE id_proveedor = :id_proveedor";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_proveedor', $id_proveedor, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo '<div class="alert alert-success">Proveedor activado correctamente.</div>';
        } else {
            echo '<div class="alert alert-danger">No se pudo activar el proveedor.</div>';
        }
    } catch (PDOException $e) {
        echo '<div class="alert alert-danger">Error en la base de datos: ' . $e->getMessage() . '</div>';
    }
} else {
    echo '<div class="alert alert-warning">ID de proveedor no recibido.</div>';
}
