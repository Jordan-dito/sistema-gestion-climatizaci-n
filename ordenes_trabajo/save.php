<?php
include('../../config.php');

// === Helpers para normalizar fechas ===
function normalize_date_or_null($s) {
    $s = trim((string)$s);
    if ($s === '') return null;
    $dt = DateTime::createFromFormat('Y-m-d', $s);
    return $dt ? $dt->format('Y-m-d') : null;
}

function normalize_datetime_or_null($s) {
    $s = trim((string)$s);
    if ($s === '') return null;
    // Acepta 'YYYY-MM-DDTHH:MM' o 'YYYY-MM-DD HH:MM[:SS]'
    if (strpos($s, 'T') !== false) $s = str_replace('T',' ', $s);
    if (preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}$/', $s)) $s .= ':00';
    $dt = DateTime::createFromFormat('Y-m-d H:i:s', $s);
    return $dt ? $dt->format('Y-m-d H:i:s') : null;
}

// === Captura y saneo de datos ===
$fecha_orden_raw      = $_POST['fecha_orden']      ?? '';
$numero_factura       = trim($_POST['numero_factura'] ?? '');
$cedula               = trim($_POST['cedula'] ?? '');
$nombre               = trim($_POST['nombre'] ?? '');
$correo               = trim($_POST['correo'] ?? '');
$id_horario_tecnico   = trim($_POST['tecnico_id'] ?? '');  // puede venir vacío si no seleccionan
$fecha_instal_raw     = $_POST['fecha_instalacion'] ?? ''; // datetime-local

$id_producto          = $_POST['id_producto'] ?? null;     // en tu flujo puede quedar NULL
$iva_porcentaje       = is_numeric($_POST['iva_porcentaje'] ?? null) ? (float)$_POST['iva_porcentaje'] : 0.00;
$precio_venta         = is_numeric($_POST['precio_venta'] ?? null)    ? (float)$_POST['precio_venta']    : 0.00;
$valor_iva            = is_numeric($_POST['valor_iva'] ?? null)       ? (float)$_POST['valor_iva']       : 0.00;
$total_con_iva        = is_numeric($_POST['total_con_iva'] ?? null)   ? (float)$_POST['total_con_iva']   : 0.00;
$datos_extras         = $_POST['datos_extras'] ?? null;

$fyh_creacion         = date('Y-m-d H:i:s');

// === Normalización de fechas ===
$fecha_orden       = normalize_date_or_null($fecha_orden_raw);
if ($fecha_orden === null) {
    // si quieres forzar hoy por defecto:
    $fecha_orden = date('Y-m-d');
}

$fecha_instalacion = normalize_datetime_or_null($fecha_instal_raw);

// === Validaciones duras (evita 1292) ===
if ($fecha_orden === null) {
    http_response_code(400);
    echo "Error: fecha_orden vacía o inválida (formato requerido YYYY-MM-DD).";
    exit;
}
if ($fecha_instalacion === null) {
    http_response_code(400);
    echo "Error: fecha_instalacion vacía o inválida (formato requerido YYYY-MM-DD HH:MM:SS).";
    exit;
}

try {
    $sql = "INSERT INTO ordenes_instalacion (
        fecha_orden, numero_factura, cedula, nombre_cliente, correo_cliente, id_horario_tecnico,
        fecha_instalacion, id_producto, iva_porcentaje, precio_venta, valor_iva, total_con_iva, datos_extras, fyh_creacion
    ) VALUES (
        :fecha_orden, :numero_factura, :cedula, :nombre_cliente, :correo_cliente, :id_horario_tecnico,
        :fecha_instalacion, :id_producto, :iva_porcentaje, :precio_venta, :valor_iva, :total_con_iva, :datos_extras, :fyh_creacion
    )";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':fecha_orden',       $fecha_orden);                     // 'YYYY-MM-DD'
    $stmt->bindValue(':numero_factura',    $numero_factura);
    $stmt->bindValue(':cedula',            $cedula);
    $stmt->bindValue(':nombre_cliente',    $nombre);
    $stmt->bindValue(':correo_cliente',    $correo);
    // si viene vacío, guarda NULL (la columna debe permitir NULL)
    if ($id_horario_tecnico === '') {
        $stmt->bindValue(':id_horario_tecnico', null, PDO::PARAM_NULL);
    } else {
        $stmt->bindValue(':id_horario_tecnico', $id_horario_tecnico);
    }
    $stmt->bindValue(':fecha_instalacion', $fecha_instalacion);               // 'YYYY-MM-DD HH:MM:SS'

    // id_producto puede ser null
    if ($id_producto === '' || $id_producto === null) {
        $stmt->bindValue(':id_producto', null, PDO::PARAM_NULL);
    } else {
        $stmt->bindValue(':id_producto', $id_producto);
    }

    $stmt->bindValue(':iva_porcentaje',    $iva_porcentaje);
    $stmt->bindValue(':precio_venta',      $precio_venta);
    $stmt->bindValue(':valor_iva',         $valor_iva);
    $stmt->bindValue(':total_con_iva',     $total_con_iva);
    $stmt->bindValue(':datos_extras',      $datos_extras);
    $stmt->bindValue(':fyh_creacion',      $fyh_creacion);

    $stmt->execute();

    echo "Guardado correctamente";
} catch (PDOException $e) {
    http_response_code(500);
    echo "Error al guardar: " . $e->getMessage();
} catch (Exception $e) {
    http_response_code(500);
    echo "Error inesperado: " . $e->getMessage();
} catch (Error $e) {
    http_response_code(500);
    echo "Error fatal: " . $e->getMessage();
}
