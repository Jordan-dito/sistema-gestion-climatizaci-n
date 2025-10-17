<?php
include('../../config.php');

header('Content-Type: application/json');

// Obtener y decodificar datos JSON
$input = json_decode(file_get_contents("php://input"), true);

if (!$input) {
    echo json_encode(['success' => false, 'message' => 'Datos no recibidos correctamente']);
    exit;
}

try {
    // Preparar consulta
    $stmt = $pdo->prepare("INSERT INTO ordenes_mantenimiento (
        fecha_orden,
        numero_factura,
        cedula,
        nombre_cliente,
        correo_cliente,
        id_horario_tecnico,
        fecha_mantenimiento,
        id_producto,
        cantidad,
        costo_servicio,
        iva_porcentaje,
        valor_iva,
        total_con_iva,
        datos_extras
    ) VALUES (
        :fecha_orden,
        :numero_factura,
        :cedula,
        :nombre_cliente,
        :correo_cliente,
        :id_horario_tecnico,
        :fecha_mantenimiento,
        :id_producto,
        :cantidad,
        :costo_servicio,
        :iva_porcentaje,
        :valor_iva,
        :total_con_iva,
        :datos_extras
    )");

    $stmt->execute([
        ':fecha_orden'         => $input['fecha_orden'],
        ':numero_factura'      => $input['numero_factura'],
        ':cedula'              => $input['cedula'],
        ':nombre_cliente'      => $input['nombre_cliente'],
        ':correo_cliente'      => $input['correo_cliente'],
        ':id_horario_tecnico'  => $input['id_horario_tecnico'],
        ':fecha_mantenimiento' => $input['fecha_mantenimiento'],
        ':id_producto'         => $input['id_producto'],
        ':cantidad'            => $input['cantidad'],
        ':costo_servicio'      => $input['costo_servicio'],
        ':iva_porcentaje'      => $input['iva_porcentaje'],
        ':valor_iva'           => $input['valor_iva'],
        ':total_con_iva'       => $input['total_con_iva'],
        ':datos_extras'        => $input['datos_extras']
    ]);

    echo json_encode(['success' => true]);

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error al guardar: ' . $e->getMessage()]);
}
