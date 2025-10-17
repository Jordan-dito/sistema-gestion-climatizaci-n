<?php
include ('../../config.php');

// Habilitar errores solo para desarrollo
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verificar si se recibieron las fechas a través de la solicitud GET
if (isset($_GET['fechaInicio']) && isset($_GET['fechaFin'])) {
    $fechaInicio = $_GET['fechaInicio'];
    $fechaFin = $_GET['fechaFin'];

    // Consulta a la base de datos usando el procedimiento almacenado
    $query = "CALL usuarios_registrados_rol(:fechaInicio, :fechaFin)";

    try {
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':fechaInicio', $fechaInicio);
        $stmt->bindParam(':fechaFin', $fechaFin);
        $stmt->execute();

        $usuario = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($usuario) {
            echo json_encode($usuario);
        } else {
            echo json_encode(['message' => 'No se encontraron usuarios.']);
        }
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Error en la consulta: ' . $e->getMessage()]);
    }
} else {
    // Si no se reciben las fechas, devuelve un error
    http_response_code(400);
    echo json_encode(['error' => 'Fechas requeridas']);
}
?>
