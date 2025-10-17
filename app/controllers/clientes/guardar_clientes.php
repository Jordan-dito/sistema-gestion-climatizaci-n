<?php
include ('../../config.php');

$nombre_cliente = $_POST['nombre_cliente'];
$nit_ci_cliente = $_POST['nit_ci_cliente'];
$celular_cliente = $_POST['celular_cliente'];
$email_cliente = $_POST['email_cliente'];
$fechaHora = date('Y-m-d H:i:s');

// Preparar la sentencia para insertar en la base de datos
$sentencia = $pdo->prepare("INSERT INTO tb_clientes
       (nombre_cliente, nit_ci_cliente, celular_cliente, email_cliente, fyh_creacion) 
VALUES (:nombre_cliente, :nit_ci_cliente, :celular_cliente, :email_cliente, :fyh_creacion)");

$sentencia->bindParam('nombre_cliente', $nombre_cliente);
$sentencia->bindParam('nit_ci_cliente', $nit_ci_cliente);
$sentencia->bindParam('celular_cliente', $celular_cliente);
$sentencia->bindParam('email_cliente', $email_cliente);
$sentencia->bindParam('fyh_creacion', $fechaHora);

if ($sentencia->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al guardar el cliente.']);
}
?>
