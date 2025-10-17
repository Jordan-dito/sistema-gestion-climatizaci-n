<?php
include('../../config.php'); // Ruta a tu archivo de conexión
header('Content-Type: application/json');

// Obtener el JSON enviado
$input = json_decode(file_get_contents("php://input"), true);

// Validar campos
if (!$input || empty($input['id_mantenimiento']) || empty($input['fecha_mantenimiento'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Faltan datos obligatorios.']);
    exit;
}

$id = $input['id_mantenimiento'];
$fechaMantenimientoRaw = $input['fecha_mantenimiento'];

try {
    // 1) Normaliza la fecha (acepta "YYYY-MM-DDTHH:MM" o "YYYY-MM-DD HH:MM[:SS]")
    $fmNorm = str_replace('T', ' ', trim($fechaMantenimientoRaw));
    $dt = DateTime::createFromFormat('Y-m-d H:i', $fmNorm)
       ?: DateTime::createFromFormat('Y-m-d H:i:s', $fmNorm)
       ?: new DateTime($fmNorm); // fallback
    if (!$dt) {
        throw new Exception('Formato de fecha_mantenimiento inválido');
    }
    // Guarda con segundos (consistente en BD)
    $fechaMantenimiento = $dt->format('Y-m-d H:i:00');

    // 2) Calcula +6 meses
    $fechaProximo = (clone $dt)->add(new DateInterval('P6M'))->format('Y-m-d H:i:00');

    // 3) Actualiza en base de datos
    $stmt = $pdo->prepare("
        UPDATE ordenes_mantenimiento
        SET fecha_mantenimiento = :fecha_mantenimiento,
            fecha_proximo_mantenimiento = :fecha_proximo
        WHERE id_mantenimiento = :id
    ");
    $stmt->execute([
        ':fecha_mantenimiento' => $fechaMantenimiento,
        ':fecha_proximo'       => $fechaProximo,
        ':id'                  => $id
    ]);

    // 4) Confirma que sí hubo cambio
    if ($stmt->rowCount() === 0) {
        // Puede ser que el ID no exista o que la fecha sea igual a la ya guardada
        echo json_encode([
            'success' => true,
            'proximo_mantenimiento' => $fechaProximo,
            'warning' => 'No se modificó ninguna fila (verifique el ID o si los valores son iguales).'
        ]);
        exit;
    }

    echo json_encode(['success' => true, 'proximo_mantenimiento' => $fechaProximo]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error en BD: ' . $e->getMessage()]);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
