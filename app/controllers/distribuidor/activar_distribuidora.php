<?php
include('../../config.php'); // Ajusta la ruta si es necesario

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;

    if ($id === null) {
        echo json_encode([
            'success' => false,
            'message' => 'ID no recibido'
        ]);
        exit;
    }

    try {
        $query = "UPDATE distribuidora SET estado = 'Activo' WHERE id_distribuidora = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo json_encode([
                'success' => true,
                'message' => 'Distribuidora activada correctamente'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Error al activar distribuidora'
            ]);
        }

    } catch (PDOException $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Error de base de datos: ' . $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Método no permitido'
    ]);
}
