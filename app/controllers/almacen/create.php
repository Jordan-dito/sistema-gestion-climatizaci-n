<?php


include ('../../config.php');

// Obtener datos del formulario
$codigo = $_POST['codigo'];
$id_categoria = $_POST['id_categoria'];
$nombre = $_POST['nombre'];
$id_usuario = $_POST['id_usuario'];
$descripcion = $_POST['descripcion'];
$stock = $_POST['stock'];
$stock_minimo = $_POST['stock_minimo'];
$stock_maximo = $_POST['stock_maximo'];
$precio_compra = $_POST['precio_compra'];
$precio_venta = $_POST['precio_venta'];
$fecha_ingreso = $_POST['fecha_ingreso'];

// Verificar si la imagen fue subida correctamente
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $nombreDelArchivo = date("Y-m-d-h-i-s");
    $filename = $nombreDelArchivo . "__" . $_FILES['image']['name'];
    $location = "../../../almacen/img_productos/" . $filename;
    move_uploaded_file($_FILES['image']['tmp_name'], $location);
} else {
    $filename = null; // Si no hay imagen, manejar adecuadamente
}

// Verificar si el usuario existe
$stmt = $pdo->prepare("SELECT COUNT(*) FROM tb_usuarios WHERE id_usuario = :id_usuario");
$stmt->bindParam(':id_usuario', $id_usuario);
$stmt->execute();

if ($stmt->fetchColumn() == 0) {
    session_start();
    $_SESSION['mensaje'] = "Error: El usuario no existe.";
    $_SESSION['icono'] = "error";
    header('Location: '.$URL.'/almacen/create.php');
    exit();
}

// Registrar el producto en la base de datos
$fechaHora = date('Y-m-d H:i:s'); // Definir la fecha y hora actuales

try {
    $sentencia = $pdo->prepare("INSERT INTO tb_almacen
           (codigo, nombre, descripcion, stock, stock_minimo, stock_maximo, precio_compra, precio_venta, fecha_ingreso, imagen, id_usuario, id_categoria, fyh_creacion) 
    VALUES (:codigo,:nombre,:descripcion,:stock,:stock_minimo,:stock_maximo,:precio_compra,:precio_venta,:fecha_ingreso,:imagen,:id_usuario,:id_categoria,:fyh_creacion)");

    $sentencia->bindParam('codigo', $codigo);
    $sentencia->bindParam('nombre', $nombre);
    $sentencia->bindParam('descripcion', $descripcion);
    $sentencia->bindParam('stock', $stock);
    $sentencia->bindParam('stock_minimo', $stock_minimo);
    $sentencia->bindParam('stock_maximo', $stock_maximo);
    $sentencia->bindParam('precio_compra', $precio_compra);
    $sentencia->bindParam('precio_venta', $precio_venta);
    $sentencia->bindParam('fecha_ingreso', $fecha_ingreso);
    $sentencia->bindParam('imagen', $filename);
    $sentencia->bindParam('id_usuario', $id_usuario);
    $sentencia->bindParam('id_categoria', $id_categoria);
    $sentencia->bindParam('fyh_creacion', $fechaHora);

    if($sentencia->execute()){
        session_start();
        $_SESSION['mensaje'] = "Se registró el producto de manera correcta";
        $_SESSION['icono'] = "success";
        header('Location: '.$URL.'/almacen/');
    } else {
        throw new Exception("Error al registrar en la base de datos");
    }
} catch (Exception $e) {
    session_start();
    $_SESSION['mensaje'] = "Error: " . $e->getMessage();
    $_SESSION['icono'] = "error";
    header('Location: '.$URL.'/almacen/create.php');
}
?>
