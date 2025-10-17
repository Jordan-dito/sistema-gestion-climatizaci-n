<?php
include('../../config.php');

$id_usuario = $_POST['id'] ?? null;
$nuevo_estado = $_POST['nuevo_estado'] ?? null;

if (!$id_usuario || $nuevo_estado === null) {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
    exit;
}

try {
    $query = "UPDATE tb_usuarios SET estado = :nuevo_estado WHERE id_usuario = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':nuevo_estado', $nuevo_estado, PDO::PARAM_INT);
    $stmt->bindParam(':id', $id_usuario, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No se pudo cambiar el estado']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
