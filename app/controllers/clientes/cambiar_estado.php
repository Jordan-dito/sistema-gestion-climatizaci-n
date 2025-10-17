<?php
include ('../../config.php');

try {
    $id_cliente = $_GET['id_cliente']; // Obtén el ID del cliente
    $nuevo_estado = $_GET['nuevo_estado']; // Obtén el nuevo estado

    // Preparar la sentencia para actualizar el estado del cliente
    $sentencia = $pdo->prepare("UPDATE tb_clientes SET estado = :estado WHERE id_cliente = :id_cliente");
    $sentencia->bindParam(':estado', $nuevo_estado);
    $sentencia->bindParam(':id_cliente', $id_cliente);

    if ($sentencia->execute()) {
        echo json_encode(['success' => true, 'message' => 'Estado actualizado correctamente.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar el estado.']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
?>

