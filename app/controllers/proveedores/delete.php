<?php
include('../../config.php'); // Asegurate de que esta ruta esté bien

$id_proveedor = $_GET['id_proveedor'] ?? null;

if ($id_proveedor) {
    try {
        $sql = "UPDATE tb_proveedores SET estado = 'Inactivo' WHERE id_proveedor = :id_proveedor";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_proveedor', $id_proveedor, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo '<div class="alert alert-success">Proveedor marcado como inactivo.</div>';
        } else {
            echo '<div class="alert alert-danger">No se pudo actualizar el estado del proveedor.</div>';
        }
    } catch (PDOException $e) {
        echo '<div class="alert alert-danger">Error en la base de datos: ' . $e->getMessage() . '</div>';
    }
} else {
    echo '<div class="alert alert-warning">ID de proveedor no recibido.</div>';
}
