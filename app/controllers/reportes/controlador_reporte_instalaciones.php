<?php
include('../../config.php');

// Verificar que se recibieron las fechas
if (isset($_GET['fechaInicio']) && isset($_GET['fechaFin'])) {
    $fechaInicio = $_GET['fechaInicio'];
    $fechaFin = $_GET['fechaFin'];

    $query = "CALL reporte_ordenes_instalacion(:fechaInicio, :fechaFin)";

    try {
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':fechaInicio', $fechaInicio);
        $stmt->bindParam(':fechaFin', $fechaFin);
        $stmt->execute();

        $ordenes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($ordenes);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Error en la consulta: ' . $e->getMessage()]);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Fechas requeridas']);
}
