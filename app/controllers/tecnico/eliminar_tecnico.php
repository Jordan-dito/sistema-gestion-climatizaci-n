<?php
// cambiar_estado/en vez_de_borrar: Actualiza el Estado del horario técnico
// Incluir el archivo de conexión a la base de datos
include '../../config.php'; // Asegúrate de que la ruta sea correcta

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idHorarioTecnico = isset($_POST['ID_HorarioTecnico']) ? intval($_POST['ID_HorarioTecnico']) : 0;
    // Si se envía Estado, lo usamos; si no, por defecto 'Inactivo'
    $estado = isset($_POST['Estado']) ? trim($_POST['Estado']) : 'Inactivo';
    // Si se solicita borrado forzado (por compatibilidad), eliminar
    $forceDelete = isset($_POST['force_delete']) && $_POST['force_delete'] == '1';

    if ($idHorarioTecnico <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'ID inválido']);
        exit;
    }

    try {
        if ($forceDelete) {
            $stmt = $pdo->prepare("DELETE FROM horariostecnicos WHERE ID_HorarioTecnico = :idHorarioTecnico");
            $stmt->bindParam(':idHorarioTecnico', $idHorarioTecnico, PDO::PARAM_INT);
            $stmt->execute();
            echo json_encode(['status' => 'success', 'message' => 'Técnico eliminado correctamente (borrado forzado)']);
            exit;
        }

        // Actualizar solo el estado
        $stmt = $pdo->prepare("UPDATE horariostecnicos SET Estado = :estado WHERE ID_HorarioTecnico = :idHorarioTecnico");
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':idHorarioTecnico', $idHorarioTecnico, PDO::PARAM_INT);
        $updated = $stmt->execute();

        if ($updated) {
            echo json_encode(['status' => 'success', 'message' => 'Estado actualizado a "' . $estado . '"']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No se pudo actualizar el estado']);
        }
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Error en la base de datos: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Método de solicitud no válido']);
}
