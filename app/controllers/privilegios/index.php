<?php
include '../../config.php'; // Asegúrate de que la ruta sea correcta

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $modulo = $_POST['modulo'];
    $rol = $_POST['rol'];
    $estado = $_POST['estado'];

    // Consulta para obtener id_modulo e id_rol basados en nombres
    $sql = "UPDATE tb_permisos 
            SET estado = :estado 
            WHERE id_modulo = (SELECT id_modulo FROM tb_modulos WHERE LOWER(nombre) = :modulo)
            AND id_rol = (SELECT id_rol FROM tb_roles WHERE LOWER(rol) = :rol)";

    $query = $pdo->prepare($sql);
    $query->execute([
        'estado' => $estado,
        'modulo' => strtolower($modulo),
        'rol' => strtolower($rol)
    ]);

    if ($query->rowCount() > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No se actualizó ningún permiso.']);
    }
}
?>
