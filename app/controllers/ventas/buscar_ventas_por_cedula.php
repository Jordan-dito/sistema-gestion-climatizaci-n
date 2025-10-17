<?php
include('../../config.php');

$cedula = $_GET['cedula'] ?? null;

if (!$cedula) {
    echo json_encode(['success' => false, 'mensaje' => 'Cédula no proporcionada']);
    exit;
}

// Obtener ID del cliente
$sql_cliente = "SELECT id_cliente FROM tb_clientes WHERE nit_ci_cliente = :cedula LIMIT 1";
$stmt_cliente = $pdo->prepare($sql_cliente);
$stmt_cliente->bindParam(':cedula', $cedula);
$stmt_cliente->execute();
$cliente = $stmt_cliente->fetch(PDO::FETCH_ASSOC);

if (!$cliente) {
    echo json_encode(['success' => false, 'mensaje' => 'Cliente no encontrado']);
    exit;
}

$id_cliente = $cliente['id_cliente'];

// Consulta para obtener productos comprados por el cliente
$sql = "SELECT 
            pro.id_producto, 
            pro.nombre AS nombre, 
            pro.descripcion AS descripcion, 
            pro.precio_venta AS precio_venta, 
            SUM(carr.cantidad) AS cantidad_total
        FROM tb_ventas ve
        INNER JOIN tb_carrito carr ON carr.nro_venta = ve.nro_venta
        INNER JOIN tb_almacen pro ON carr.id_producto = pro.id_producto
        INNER JOIN tb_categorias cat ON pro.id_categoria = cat.id_categoria
        WHERE ve.id_cliente = :id_cliente
          AND LOWER(cat.nombre_categoria) = 'a/c'
        GROUP BY pro.id_producto, pro.nombre, pro.descripcion, pro.precio_venta";


$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id_cliente', $id_cliente);
$stmt->execute();
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(['success' => true, 'productos' => $productos]);
