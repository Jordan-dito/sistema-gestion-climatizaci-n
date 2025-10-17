<?php
include ('../../config.php');

// Verificar si se recibieron los tres parámetros
if (isset($_GET['fechaInicio']) && isset($_GET['fechaFin']) && isset($_GET['nit_cliente'])) {
    $fechaInicio = $_GET['fechaInicio'];
    $fechaFin = $_GET['fechaFin'];
    $nitCliente = $_GET['nit_cliente'];

    // Usar el procedimiento almacenado historial_cliente
    $query = "CALL historial_cliente(:fechaInicio, :fechaFin, :nitCliente)";

    try {
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':fechaInicio', $fechaInicio);
        $stmt->bindParam(':fechaFin', $fechaFin);
        $stmt->bindParam(':nitCliente', $nitCliente);
        $stmt->execute();

        // Obtener resultados
        $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($clientes);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Error en la consulta: ' . $e->getMessage()]);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Se requieren fechaInicio, fechaFin y nit_cliente.']);
}
