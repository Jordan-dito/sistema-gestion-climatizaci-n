<?php

include '../../config.php'; // Asegúrate de que la ruta sea correcta

header('Content-Type: application/json');

// Limpiar el buffer de salida
ob_clean(); // Limpia cualquier salida previa

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $cotizacionId = (int) $_POST['cotizacionId'];

        if ($cotizacionId) {
            $sql = "DELETE FROM cotizacion WHERE id_cotizacion = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $cotizacionId, PDO::PARAM_INT);

            if ($stmt->execute()) {
                echo json_encode(array('status' => 'success', 'message' => '¡Cotización eliminada correctamente!'));
            } else {
                echo json_encode(array('status' => 'error', 'message' => 'Error al eliminar la cotización.'));
            }
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'ID de cotización no válido.'));
        }
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Solicitud no válida.'));
    }
} catch (PDOException $e) {
    echo json_encode(array('status' => 'error', 'message' => 'Error: ' . $e->getMessage()));
} catch (Exception $e) {
    echo json_encode(array('status' => 'error', 'message' => 'Error inesperado: ' . $e->getMessage()));
}

// Salir del script para asegurarte de que no se envíe más salida
exit;




?>
