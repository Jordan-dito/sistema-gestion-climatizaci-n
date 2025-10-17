<?php
// Incluir el archivo de conexión
include '../../config.php'; // Asegúrate de que la ruta sea correcta

header('Content-Type: application/json'); // Establecer el encabezado correcto

// Limpiar el buffer de salida
ob_clean();

try {
    if (!$pdo) {
        throw new Exception("No se pudo conectar a la base de datos.");
    }

    $cotizacionId = (int) trim($_POST['cotizacionId']);
    $estado = trim($_POST['estado']);
    $observacion = trim($_POST['observacion']);

    if (empty($cotizacionId) || empty($estado) || empty($observacion)) {
        echo json_encode(array('status' => 'error', 'message' => 'Todos los campos son requeridos.'));
        exit;
    }

    $sqlSelect = "SELECT * FROM cotizacion WHERE id_cotizacion = :id";
    $stmtSelect = $pdo->prepare($sqlSelect);
    $stmtSelect->bindParam(':id', $cotizacionId, PDO::PARAM_INT);
    $stmtSelect->execute();

    $registro = $stmtSelect->fetch(PDO::FETCH_ASSOC);
    if (!$registro) {
        echo json_encode(array('status' => 'error', 'message' => 'No se encontró el registro : ' . $cotizacionId));
        exit;
    }

    $sql = "UPDATE cotizacion SET estado_cotizacion = :estado, observacion = :observacion WHERE id_cotizacion = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':estado', $estado);
    $stmt->bindParam(':observacion', $observacion);
    $stmt->bindParam(':id', $cotizacionId, PDO::PARAM_INT);

    if ($stmt->execute()) {
        $affectedRows = $stmt->rowCount();
        if ($affectedRows > 0) {
            echo json_encode(array('status' => 'success', 'message' => '¡Registro actualizado correctamente!'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'No se encontraron filas para actualizar. Verifica que el ID sea correcto.'));
        }
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Error al actualizar la cotización.'));
    }
} catch (PDOException $e) {
    echo json_encode(array('status' => 'error', 'message' => 'Error al ejecutar la consulta: ' . $e->getMessage()));
} catch (Exception $e) {
    echo json_encode(array('status' => 'error', 'message' => 'Error: ' . $e->getMessage()));
}
?>
