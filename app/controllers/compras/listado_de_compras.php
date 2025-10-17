<?php
// Verificar si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener las fechas desde el formulario
    $fecha_inicio = isset($_POST['fechaInicio']) ? $_POST['fechaInicio'] : '';
    $fecha_fin = isset($_POST['fechaFin']) ? $_POST['fechaFin'] : '';

    // Verificar que las fechas no estén vacías
    if (!empty($fecha_inicio) && !empty($fecha_fin)) {
        try {
            // La conexión a la base de datos ya está establecida (ajusta con tus propios parámetros de conexión)

            // Preparar y ejecutar la llamada al procedimiento almacenado
            $sql_compras = "CALL compras_registradas(:fecha_inicio, :fecha_fin)";
            $query_compras = $pdo->prepare($sql_compras);
            $query_compras->bindParam(':fecha_inicio', $fecha_inicio, PDO::PARAM_STR);
            $query_compras->bindParam(':fecha_fin', $fecha_fin, PDO::PARAM_STR);
            $query_compras->execute();

            // Obtener los resultados
            $compras_datos = $query_compras->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    } else {
        echo 'Por favor, complete ambos campos de fecha.';
    }
} else {
    $compras_datos = []; // Inicializar la variable como un array vacío si no se ha enviado el formulario
}
?>


