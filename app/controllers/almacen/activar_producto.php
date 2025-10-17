<?php
include('../../config.php');

// Verificamos si llega el ID del producto por POST
if (isset($_POST['id_producto'])) {
    $id_producto = $_POST['id_producto'];

    try {
        // Actualizamos el estado a 'activo' en la tabla correcta
        $sql = "UPDATE tb_almacen SET estado = 'activo' WHERE id_producto = :id_producto";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_producto', $id_producto);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Producto activado con éxito.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'No se pudo activar el producto.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error en BD: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'ID de producto no recibido.']);
}
