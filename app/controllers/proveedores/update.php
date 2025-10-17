<?php
include ('../../config.php');

// Recoger datos
$id_proveedor = $_GET['id_proveedor'];
$nombre_proveedor = $_GET['nombre_proveedor'];
$celular = $_GET['celular'];
$telefono = $_GET['telefono'];
$email = $_GET['email'];
$direccion = $_GET['direccion'];
$id_distribuidora = $_GET['id_distribuidora'];

$fechaHora = date("Y-m-d H:i:s"); // 👈 Aquí generamos correctamente

// Preparar y ejecutar el UPDATE
$sentencia = $pdo->prepare("UPDATE tb_proveedores
    SET nombre_proveedor = :nombre_proveedor,
        celular = :celular,
        telefono = :telefono,
        email = :email,
        direccion = :direccion,
        id_distribuidora = :id_distribuidora,
        fyh_actualizacion = :fyh_actualizacion
    WHERE id_proveedor = :id_proveedor");

$sentencia->bindParam(':nombre_proveedor', $nombre_proveedor);
$sentencia->bindParam(':celular', $celular);
$sentencia->bindParam(':telefono', $telefono);
$sentencia->bindParam(':email', $email);
$sentencia->bindParam(':direccion', $direccion);
$sentencia->bindParam(':id_distribuidora', $id_distribuidora);
$sentencia->bindParam(':fyh_actualizacion', $fechaHora);
$sentencia->bindParam(':id_proveedor', $id_proveedor);

// Ejecutar
if ($sentencia->execute()) {
    echo "success"; // 👈 IMPORTANTE: Respondemos a la petición AJAX
} else {
    echo "error";   // 👈 IMPORTANTE: Respondemos si hay error
}
?>
