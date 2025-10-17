<?php
include('../../config.php'); // Verifica que esté correcta la ruta

$query = "SELECT 
            id_mantenimiento, 
            numero_factura, 
            fecha_mantenimiento, 
            tipo_servicio,
            DATE_ADD(fecha_mantenimiento, INTERVAL 6 MONTH) AS fecha_proximo_mantenimiento,
            CASE
                WHEN fecha_mantenimiento < NOW() THEN 'Pendiente'
                WHEN DATE(fecha_mantenimiento) = DATE(NOW()) THEN 'Hoy'
                ELSE 'Programado'
            END AS estado
          FROM ordenes_mantenimiento 
          ORDER BY fecha_mantenimiento DESC";

try {
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $mantenimientos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($mantenimientos);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
