<?php
// Asumiendo que ya tienes la conexión PDO establecida en $pdo

// Recoger las fechas del formulario
$fecha_inicio = isset($_POST['fechaInicio']) ? $_POST['fechaInicio'] : null;
$fecha_fin = isset($_POST['fechaFin']) ? $_POST['fechaFin'] : null;

// Comenzar a construir la consulta SQL
$sql_ventas = "SELECT ve.id_venta,
                ve.nro_venta, 
                ve.id_cliente, 
                ve.total_pagado, 
                ve.fyh_creacion, 
                cli.nombre_cliente AS nombre_cliente, 
                cli.nit_ci_cliente, 
                cli.celular_cliente, 
                cli.email_cliente 
               FROM tb_ventas AS ve 
               INNER JOIN tb_clientes AS cli 
               ON cli.id_cliente = ve.id_cliente";

// Agregar condiciones a la consulta si las fechas están definidas
$conditions = [];
$params = [];

if ($fecha_inicio) {
    $conditions[] = "ve.fyh_creacion >= :fecha_inicio";
    $params[':fecha_inicio'] = $fecha_inicio . ' 00:00:00'; // Agregar hora de inicio del día
}

if ($fecha_fin) {
    $conditions[] = "ve.fyh_creacion <= :fecha_fin";
    $params[':fecha_fin'] = $fecha_fin . ' 23:59:59'; // Agregar hora de fin del día
}

if (!empty($conditions)) {
    $sql_ventas .= " WHERE " . implode(' AND ', $conditions);
}

$query_ventas = $pdo->prepare($sql_ventas);

// Vincular los parámetros si existen
foreach ($params as $param => $value) {
    $query_ventas->bindValue($param, $value);
}

// Ejecutar la consulta
$query_ventas->execute();

// Obtener los datos
$ventas_datos = $query_ventas->fetchAll(PDO::FETCH_ASSOC);
?>

