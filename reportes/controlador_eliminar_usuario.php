<?php
include ('../../config.php');

// Habilitar el informe de errores (solo para desarrollo)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verificar si se recibió el ID a través de la solicitud POST
if (isset($_POST['id'])) {
    $usuarioId = $_POST['id'];

    // Cambiar el estado del usuario a 'inactivo'
    $query = "UPDATE tb_usuarios SET estado = 'inactivo' WHERE id_usuario = :id_usuario";

    try {
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id_usuario', $usuarioId);
        $stmt->execute();

        // Verificar si se actualizó algún registro
        if ($stmt->rowCount() > 0) {
            echo json_encode(['message' => 'Usuario inactivado exitosamente.']);
        } else {
            echo json_encode(['message' => 'No se encontró el usuario o el estado ya estaba actualizado.']);
        }
    } catch (PDOException $e) {
        http_response_code(500); // Establece el código de respuesta HTTP a 500 (Error interno del servidor)
        echo json_encode(['error' => 'Error en la actualización: ' . $e->getMessage()]);
    }
} else {
    // Si no se recibe el ID, devuelve un error
    http_response_code(400); // Establece el código de respuesta HTTP a 400 (Solicitud incorrecta)
    echo json_encode(['error' => 'ID requerido']);
}


