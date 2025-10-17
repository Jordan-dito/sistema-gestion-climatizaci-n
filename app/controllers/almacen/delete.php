<?php
include ('../../config.php');
session_start();

// 1. Recibir el ID del producto por POST
$id_producto = $_POST['id_producto'];

// 2. Verificar el stock actual del producto
$consulta_stock = $pdo->prepare("SELECT stock FROM tb_almacen WHERE id_producto = :id_producto");
$consulta_stock->bindParam(':id_producto', $id_producto);
$consulta_stock->execute();
$stock_actual = $consulta_stock->fetchColumn();  // Devuelve solo la primera columna de la primera fila

if ($stock_actual !== false) {
    // 3. Evaluar si stock_actual == 0
    if ($stock_actual == 0) {
        // 4. Si el stock es 0, cambiar estado a 'inactivo'
        $sentencia = $pdo->prepare("UPDATE tb_almacen 
                                      SET estado = 'inactivo' 
                                    WHERE id_producto = :id_producto");
        $sentencia->bindParam(':id_producto', $id_producto);

        if ($sentencia->execute()) {
            $_SESSION['mensaje'] = "Se cambió el estado del producto a 'inactivo' correctamente.";
            $_SESSION['icono']   = "success";
            header('Location: '.$URL.'/almacen/');
        } else {
            $_SESSION['mensaje'] = "Ocurrió un error al intentar cambiar el estado del producto.";
            $_SESSION['icono']   = "error";
            header('Location: '.$URL.'/almacen/delete.php?id='.$id_producto);
        }
    } else {
        // Si el stock NO es 0, no se permite cambiar el estado a 'inactivo'
        $_SESSION['mensaje'] = "No se puede inactivar el producto porque su stock es diferente de 0 (stock actual: $stock_actual).";
        $_SESSION['icono']   = "warning";
        header('Location: '.$URL.'/almacen/delete.php?id='.$id_producto);
    }
} else {
    // Si no se encontró el producto o hubo un error en la consulta
    $_SESSION['mensaje'] = "No se encontró el producto o ocurrió un error consultando su stock.";
    $_SESSION['icono']   = "error";
    header('Location: '.$URL.'/almacen/');
}
