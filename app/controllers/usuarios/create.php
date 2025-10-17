<?php
include ('../../config.php');
header('Content-Type: application/json'); // Importante para que devuelva JSON

session_start();

$response = [];

try {
    // Recoger los datos del formulario
    $cedula = $_POST['cedula'];
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $rol = $_POST['rol'];
    $telefono_empl = $_POST['telefono_empl'];
    $email = $_POST['email'];
    $direccion_emple = $_POST['direccion_emple'];
    $password_user = $_POST['password_user'];
    $estado_civil = $_POST['estado_civil']; // <-- Nuevo campo

    // Preparar la consulta de inserción
    $sentencia = $pdo->prepare("INSERT INTO tb_usuarios 
        (cedula, nombres, apellidos, id_rol, telefono_empl, email, direccion_emple, password_user, estado_civil) 
        VALUES (:cedula, :nombres, :apellidos, :id_rol, :telefono_empl, :email, :direccion_emple, :password_user, :estado_civil)");

    // Asociar parámetros
    $sentencia->bindParam('cedula', $cedula);
    $sentencia->bindParam('nombres', $nombres);
    $sentencia->bindParam('apellidos', $apellidos);
    $sentencia->bindParam('id_rol', $rol);
    $sentencia->bindParam('telefono_empl', $telefono_empl);
    $sentencia->bindParam('email', $email);
    $sentencia->bindParam('direccion_emple', $direccion_emple);
    $sentencia->bindParam('password_user', $password_user);
    $sentencia->bindParam('estado_civil', $estado_civil); // <-- Nuevo parámetro

    // Ejecutar la consulta
    $sentencia->execute();

    // Respuesta en JSON
    $response['status'] = "success";
    $response['message'] = "El usuario ha sido registrado correctamente.";

} catch (PDOException $e) {
    $response['status'] = "error";
    $response['message'] = "Error al registrar el usuario: " . $e->getMessage();
}

// Devolver respuesta en formato JSON
echo json_encode($response);
exit();
