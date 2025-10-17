<?php
include '../../config.php';

header('Content-Type: application/json');

// Validar parámetros GET
$fechaInicio = $_GET['fechaInicio'] ?? null;
$fechaFin = $_GET['fechaFin'] ?? null;
$tipoServicio = $_GET['tipoServicio'] ?? null;

if (!$fechaInicio || !$fechaFin || !$tipoServicio) {
    echo json_encode(['error' => 'Todos los parámetros son obligatorios']);
    exit;
}

try {
    // Llamada al procedimiento almacenado
    $stmt = $pdo->prepare("CALL sp_ordenes_mantenimiento_y_reparacion(:inicio, :fin, :tipo)");
    $stmt->bindParam(':inicio', $fechaInicio);
    $stmt->bindParam(':fin', $fechaFin);
    $stmt->bindParam(':tipo', $tipoServicio);
    $stmt->execute();

    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($resultados);

} catch (PDOException $e) {
    echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
}
