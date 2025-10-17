<?php
// Incluye la conexión a la base de datos
include '../../config.php'; // Asegúrate de que la ruta sea correcta

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibe los datos del formulario
    $id_distribuidora = $_POST['id_distribuidora'] ?? null; // Asegúrate de que este campo esté en el formulario
    $compania = $_POST['compania'] ?? null;
    $ruc = $_POST['ruc'] ?? null;
    $ciudad = $_POST['ciudad'] ?? null;
    $provincia = $_POST['provincia'] ?? null;
    $direccion = $_POST['direccion'] ?? null;
    $telefono = $_POST['telefono'] ?? null;
    $correo = $_POST['correo'] ?? null;
    $estado = $_POST['estado'] ?? 'Activo'; // Por defecto se pone como 'Activo'

    // Verifica que los campos obligatorios estén presentes
    if ($id_distribuidora && $compania && $ruc && $telefono && $correo) {
        try {
            // Prepara la consulta SQL para actualizar la distribuidora
            $sql = "UPDATE distribuidora 
                    SET compania = :compania, ruc = :ruc, ciudad = :ciudad, 
                        provincia = :provincia, direccion = :direccion, 
                        telefono = :telefono, correo = :correo, estado = :estado 
                    WHERE id_distribuidora = :id_distribuidora";
            
            $stmt = $pdo->prepare($sql);

            // Ejecuta la consulta
            $stmt->execute([
                ':id_distribuidora' => $id_distribuidora,
                ':compania' => $compania,
                ':ruc' => $ruc,
                ':ciudad' => $ciudad,
                ':provincia' => $provincia,
                ':direccion' => $direccion,
                ':telefono' => $telefono,
                ':correo' => $correo,
                ':estado' => $estado
            ]);

            // Responde con un mensaje de éxito
            echo json_encode(['success' => true, 'message' => 'Distribuidora actualizada correctamente.']);
        } catch (PDOException $e) {
            // En caso de error, responde con el mensaje de error
            echo json_encode(['success' => false, 'message' => 'Error al actualizar distribuidora: ' . $e->getMessage()]);
        }
    } else {
        // Si faltan campos obligatorios
        echo json_encode(['success' => false, 'message' => 'Por favor, completa todos los campos obligatorios.']);
    }
} else {
    // Si la solicitud no es POST, envía un error
    echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
}
