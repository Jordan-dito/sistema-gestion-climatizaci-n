<?php
include ('../../config.php');

// Verificar si se recibieron las fechas a través de la solicitud GET
if (isset($_GET['fechaInicio']) && isset($_GET['fechaFin'])) {
    $fechaInicio = $_GET['fechaInicio'];
    $fechaFin = $_GET['fechaFin'];

    // Consulta a la base de datos usando el procedimiento almacenado
    $query = "CALL compras_registradas(:fechaInicio, :fechaFin)";

    try {
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':fechaInicio', $fechaInicio);
        $stmt->bindParam(':fechaFin', $fechaFin);
        $stmt->execute();

        // Recupera todos los resultados en forma de arreglo asociativo
        $compras = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Agregar campo 'nro' a cada registro para la numeración
        $contador = 0;
        foreach ($compras as &$compra) {
            $contador++;
            $compra['nro'] = $contador;
        }

        // Retornar los resultados como JSON
        echo json_encode($compras);
    } catch (PDOException $e) {
        // Manejo de errores en caso de que falle la consulta
        http_response_code(500); // Establece el código de respuesta HTTP a 500 (Error interno del servidor)
        echo json_encode(['error' => 'Error en la consulta: ' . $e->getMessage()]);
    }
} else {
    // Si no se reciben las fechas, devuelve un error
    http_response_code(400); // Establece el código de respuesta HTTP a 400 (Solicitud incorrecta)
    echo json_encode(['error' => 'Fechas requeridas']);
}
