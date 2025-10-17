<?php
// buscar_cliente.php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json; charset=utf-8');

// Asegúrate que la ruta esté bien

include ('../../config.php');

$cedula = $_GET['cedula'] ?? '';

try {
    $sql = "SELECT nombre_cliente AS nombre, email_cliente AS correo 
            FROM tb_clientes
            WHERE nit_ci_cliente = :cedula 
            LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':cedula', $cedula, PDO::PARAM_STR);
    $stmt->execute();

    $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($cliente) {
        echo json_encode([
            'success' => true,
            'nombre'  => $cliente['nombre'],
            'correo'  => $cliente['correo']
        ]);
    } else {
        echo json_encode([
            'success' => false
        ]);
    }
} catch (PDOException $e) {
    // Si hay error, mostramos el mensaje de error en JSON
    // (aunque devuelvas HTML, al menos sabrás lo que pasa)
    echo json_encode([
        'success' => false,
        'error'   => $e->getMessage()
    ]);
}
