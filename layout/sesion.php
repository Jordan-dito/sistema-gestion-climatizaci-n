<?php
session_start();

if (isset($_SESSION['sesion_email'])) {
    $email_sesion = $_SESSION['sesion_email'];
    $sql = "SELECT us.id_usuario as id_usuario, us.email as email, 
    rol.id_rol as id_rol,  CONCAT(us.nombres, ' ', us.apellidos) as nombres,
     rol.rol as nombre_rol
            FROM tb_usuarios as us 
            INNER JOIN tb_roles as rol ON us.id_rol = rol.id_rol 
            WHERE email = :email_sesion";
    $query = $pdo->prepare($sql);
    $query->execute(['email_sesion' => $email_sesion]);
    $usuario = $query->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
          // Guardar el id_usuario en la sesión
        $_SESSION['id_usuario'] = $usuario['id_usuario'];
        $rol_id = $usuario['id_rol'];
        $nombres_sesion = $usuario['nombres'];
        $_SESSION['nombre_rol'] = $usuario['nombre_rol']; // Guardar el nombre del rol en la sesión

        // Consultar módulos permitidos para el rol
        $query = $pdo->prepare("
            SELECT LOWER(m.nombre) AS nombre
            FROM tb_modulos m
            JOIN tb_permisos p ON m.id_modulo = p.id_modulo
            WHERE p.id_rol = :rol_id AND p.estado = 'activo'
        ");
        $query->execute(['rol_id' => $rol_id]);
        $modulos_permitidos = $query->fetchAll(PDO::FETCH_COLUMN);
    } else {
        header('Location: ' . $URL . '/login');
        exit();
    }
} else {
    header('Location: ' . $URL . '/login');
    exit();
}
