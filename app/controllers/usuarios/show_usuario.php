<?php
/**
 * 
 */

$id_usuario_get = $_GET['id'];

/*$sql_usuarios = "SELECT us.id_usuario as id_usuario, us.nombres as nombres, us.email as email, rol.rol as rol 
                  FROM tb_usuarios as us INNER JOIN tb_roles as rol ON us.id_rol = rol.id_rol where id_usuario = '$id_usuario_get' ";
$query_usuarios = $pdo->prepare($sql_usuarios);
$query_usuarios->execute();
$usuarios_datos = $query_usuarios->fetchAll(PDO::FETCH_ASSOC);

foreach ($usuarios_datos as $usuarios_dato){
    $nombres = $usuarios_dato['nombres'];
    $email = $usuarios_dato['email'];
    $rol = $usuarios_dato['rol'];
}*/

/*$sql_usuarios =" SELECT * FROM tb_usuarios WHERE id_usuario='$id_usuario_get' ";*/

$sql_usuarios =" SELECT us.id_usuario as id_usuario,
us.cedula as cedula, us.nombres as nombres , us.apellidos as apellidos ,rol.rol as rol,us.telefono_empl as telefono_empl, us.email as email,
us.direccion_emple as direccion_emple
 FROM tb_usuarios as us INNER JOIN tb_roles as rol ON us.id_rol= rol.id_rol";

$query_usuarios =$pdo->prepare($sql_usuarios);
$query_usuarios->execute();

$usuarios_datos =$query_usuarios->fetchAll(PDO::FETCH_ASSOC);


foreach ($usuarios_datos as $usuarios_dato){
    $cedula= $usuarios_dato['cedula'];
    $nombres= $usuarios_dato['nombres'];
    $apellidos= $usuarios_dato['apellidos'];
    $rol= $usuarios_dato['rol'];

    $telefono_empl= $usuarios_dato['telefono_empl'];
    $email= $usuarios_dato['email'];
    $direccion_emple= $usuarios_dato['direccion_emple'];

}