<?php
include('../../config.php');
header('Content-Type: application/json');

$input = json_decode(file_get_contents("php://input"), true);

if (!$input) {
    echo json_encode(['success' => false, 'message' => 'Datos no recibidos correctamente']);
    exit;
}

try {
    // --- Normalizar fecha y calcular próximo mantenimiento (+6 meses) ---
    // fecha_mantenimiento puede venir como "YYYY-MM-DDTHH:MM" desde <input type="datetime-local">
    if (empty($input['fecha_mantenimiento'])) {
        throw new Exception('Falta fecha_mantenimiento');
    }
    $fmNorm = str_replace('T', ' ', $input['fecha_mantenimiento']); // "YYYY-MM-DD HH:MM"
    $dt = DateTime::createFromFormat('Y-m-d H:i', $fmNorm) ?: DateTime::createFromFormat('Y-m-d H:i:s', $fmNorm);
    if (!$dt) {
        // último intento: que PHP lo parsee directo
        $dt = new DateTime($fmNorm);
    }
    if (!$dt) {
        throw new Exception('Formato de fecha_mantenimiento inválido');
    }

    $fecha_mantenimiento_sql = $dt->format('Y-m-d H:i:00');

    $dtProx = clone $dt;
    $dtProx->modify('+6 months');
    $fecha_proximo_mantenimiento = $dtProx->format('Y-m-d H:i:00');

    // --- Transacción: insertar orden + actualizar estado técnico ---
    $pdo->beginTransaction();

    $stmt = $pdo->prepare("
        INSERT INTO ordenes_mantenimiento (
            fecha_orden,
            numero_factura,
            cedula,
            nombre_cliente,
            correo_cliente,
            id_horario_tecnico,
            fecha_mantenimiento,
            fecha_proximo_mantenimiento,
            id_producto,
            cantidad,
            costo_servicio,
            iva_porcentaje,
            valor_iva,
            total_con_iva,
            datos_extras,
            tipo_servicio
        ) VALUES (
            :fecha_orden,
            :numero_factura,
            :cedula,
            :nombre_cliente,
            :correo_cliente,
            :id_horario_tecnico,
            :fecha_mantenimiento,
            :fecha_proximo_mantenimiento,
            :id_producto,
            :cantidad,
            :costo_servicio,
            :iva_porcentaje,
            :valor_iva,
            :total_con_iva,
            :datos_extras,
            :tipo_servicio
        )
    ");

    $stmt->execute([
        ':fecha_orden'                 => $input['fecha_orden'] ?? null,
        ':numero_factura'              => $input['numero_factura'] ?? null,
        ':cedula'                      => $input['cedula'] ?? null,
        ':nombre_cliente'              => $input['nombre_cliente'] ?? null,
        ':correo_cliente'              => $input['correo_cliente'] ?? null,
        ':id_horario_tecnico'          => $input['id_horario_tecnico'] ?? null,
        ':fecha_mantenimiento'         => $fecha_mantenimiento_sql,
        ':fecha_proximo_mantenimiento' => $fecha_proximo_mantenimiento,
        ':id_producto'                 => $input['id_producto'] ?? null,
        ':cantidad'                    => $input['cantidad'] ?? 0,
        ':costo_servicio'              => $input['costo_servicio'] ?? 0,
        ':iva_porcentaje'              => $input['iva_porcentaje'] ?? 0,
        ':valor_iva'                   => $input['valor_iva'] ?? 0,
        ':total_con_iva'               => $input['total_con_iva'] ?? 0,
        ':datos_extras'                => $input['datos_extras'] ?? null,
        ':tipo_servicio'               => $input['tipo_servicio'] ?? 'mantenimiento'
    ]);

    // Actualizar estado del técnico a 'Ocupado' (si viene)
    if (!empty($input['id_horario_tecnico'])) {
        $update = $pdo->prepare("
            UPDATE horariostecnicos
            SET Estado = :estado
            WHERE ID_HorarioTecnico = :idHorario
        ");
        $update->execute([
            ':estado'    => 'Ocupado',
            ':idHorario' => $input['id_horario_tecnico']
        ]);
    }

    $pdo->commit();

    echo json_encode([
        'success' => true,
        'proximo_mantenimiento' => $fecha_proximo_mantenimiento
    ]);

} catch (PDOException $e) {
    if ($pdo->inTransaction()) { $pdo->rollBack(); }
    echo json_encode(['success' => false, 'message' => 'Error al guardar: ' . $e->getMessage()]);
} catch (Exception $e) {
    if ($pdo->inTransaction()) { $pdo->rollBack(); }
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
