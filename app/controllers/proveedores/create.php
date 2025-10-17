<?php
include ('../../config.php');

$nombre_proveedor = $_GET['nombre_proveedor'];
$celular = $_GET['celular'];
$telefono = $_GET['telefono'];

$email = $_GET['email'];
$direccion = $_GET['direccion'];
$id_distribuidora = $_GET['id_distribuidora']; // 👈 nuevo campo

$sentencia = $pdo->prepare("INSERT INTO tb_proveedores
    (nombre_proveedor, celular, telefono,  email, direccion, id_distribuidora, fyh_creacion, fyh_actualizacion) 
    VALUES (:nombre_proveedor, :celular, :telefono,  :email, :direccion, :id_distribuidora, :fyh_creacion, :fyh_actualizacion)");

$sentencia->bindParam('nombre_proveedor', $nombre_proveedor);
$sentencia->bindParam('celular', $celular);
$sentencia->bindParam('telefono', $telefono);

$sentencia->bindParam('email', $email);
$sentencia->bindParam('direccion', $direccion);
$sentencia->bindParam('id_distribuidora', $id_distribuidora);

$fechaHora = date("Y-m-d H:i:s");
$sentencia->bindParam('fyh_creacion', $fechaHora);
$sentencia->bindParam('fyh_actualizacion', $fechaHora);

if($sentencia->execute()){
    session_start();
    $_SESSION['mensaje'] = "Se registró al proveedor de la manera correcta";
    $_SESSION['icono'] = "success";
    ?>
    <script>
        location.href = "<?php echo $URL;?>/proveedores";
    </script>
    <?php
} else {
    session_start();
    $_SESSION['mensaje'] = "Error: no se pudo registrar en la base de datos";
    $_SESSION['icono'] = "error";
    ?>
    <script>
        location.href = "<?php echo $URL;?>/proveedores";
    </script>
    <?php
}
