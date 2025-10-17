<?php
// Incluir la conexión a la base de datos
include './config.php'; // Cambia 'ruta/a/tu/archivo_de_conexion.php' por la ruta correcta

// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir los datos del formulario
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $cedula = $_POST['cedula'];
    $orden_trabajo = $_POST['orden_trabajo'];
    $solicitud = $_POST['solicitud'];
    
    // Valor por defecto para estado de cotización y observación
    $estado_cotizacion = 'En proceso';
    $observacion = ''; // Se puede dejar vacío o asignar algún valor si es necesario

    // Insertar los datos en la tabla cotizacion
    $sql = "INSERT INTO cotizacion 
            (nombres, apellidos, correo, telefono, orden_trabajo, solicitud, estado_cotizacion, observacion, id_rol) 
            VALUES 
            (:nombres, :apellidos, :correo, :telefono, :orden_trabajo, :solicitud, :estado_cotizacion, :observacion, 6)";
    
    $stmt = $pdo->prepare($sql);

    // Ejecutar la consulta con los datos proporcionados
    if ($stmt->execute([
        ':nombres' => $nombres,
        ':apellidos' => $apellidos,
        ':correo' => $correo,
        ':telefono' => $telefono,
        ':orden_trabajo' => $orden_trabajo,
        ':solicitud' => $solicitud,
        ':estado_cotizacion' => $estado_cotizacion,
        ':observacion' => $observacion
    ])) {
      
    } else {
        // Redirigir o mostrar mensaje de error
        echo "Error al enviar la cotización.";
    }
}
?>
