<?php
// Incluye la conexión a la base de datos
include '../../config.php'; // Asegúrate de que la ruta sea correcta

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibe el ID de la distribuidora
    $id_distribuidora = $_POST['id'] ?? null; // Verifica si este es el nombre correcto

    // Verifica que el ID esté presente
    if ($id_distribuidora) {
        try {
            // Prepara la consulta SQL para actualizar el estado
            $sql = "UPDATE distribuidora SET estado = 'Inactivo' WHERE id_distribuidora = :id_distribuidora";
            
            $stmt = $pdo->prepare($sql);

            // Ejecuta la consulta
            $stmt->execute([':id_distribuidora' => $id_distribuidora]);

            // Verifica si se actualizó alguna fila
            if ($stmt->rowCount() > 0) {
                // Responde con un mensaje de éxito
                echo json_encode(['success' => true, 'message' => 'Distribuidora desactivada correctamente.']);
            } else {
                // Si no se actualizó ninguna fila
                echo json_encode(['success' => false, 'message' => 'No se encontró la distribuidora.']);
            }
        } catch (PDOException $e) {
            // En caso de error, responde con el mensaje de error
            echo json_encode(['success' => false, 'message' => 'Error al desactivar la distribuidora: ' . $e->getMessage()]);
        }
    } else {
        // Si falta el ID
        echo json_encode(['success' => false, 'message' => 'Por favor, proporciona el ID de la distribuidora.']);
    }
} else {
    // Si la solicitud no es POST, envía un error
    echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
}
