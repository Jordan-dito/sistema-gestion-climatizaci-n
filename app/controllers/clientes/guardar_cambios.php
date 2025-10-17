<?php
include ('../../config.php');

try {
    $id_cliente = $_POST['id_cliente']; // Obtén el ID del cliente
    $nombre_cliente = $_POST['nombre_cliente'];
    $nit_ci_cliente = $_POST['nit_ci_cliente'];
    $celular_cliente = $_POST['celular_cliente'];
    $email_cliente = $_POST['email_cliente'];

    // Preparar la sentencia para actualizar los datos del cliente
    $sentencia = $pdo->prepare("UPDATE tb_clientes SET nombre_cliente = :nombre, nit_ci_cliente = :nit_ci, celular_cliente = :celular, email_cliente = :email WHERE id_cliente = :id_cliente");
    $sentencia->bindParam(':nombre', $nombre_cliente);
    $sentencia->bindParam(':nit_ci', $nit_ci_cliente);
    $sentencia->bindParam(':celular', $celular_cliente);
    $sentencia->bindParam(':email', $email_cliente);
    $sentencia->bindParam(':id_cliente', $id_cliente);

    if ($sentencia->execute()) {
        echo json_encode(['success' => true, 'message' => 'Datos actualizados correctamente.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar los datos.']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
?>
