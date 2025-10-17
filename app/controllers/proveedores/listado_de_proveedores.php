<?php
/**
 * Created by PhpStorm.
 * User: HILARIWEB
 * Date: 1/2/2023
 * Time: 18:16
 */
$sql_proveedores = "SELECT 
    p.*, 
    d.compania AS nombre_distribuidora
FROM 
    tb_proveedores p
JOIN 
    distribuidora d 
ON 
    p.id_distribuidora = d.id_distribuidora";

$query_proveedores = $pdo->prepare($sql_proveedores);
$query_proveedores->execute();
$proveedores_datos = $query_proveedores->fetchAll(PDO::FETCH_ASSOC);
?>
