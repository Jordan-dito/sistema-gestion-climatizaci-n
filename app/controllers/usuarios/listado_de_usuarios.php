<?php
/**
 
 */


 $sql_usuarios =" SELECT us.id_usuario as id_usuario,
 us.cedula as cedula, us.nombres as nombres , us.apellidos as apellidos ,rol.rol as rol,us.telefono_empl as telefono_empl, us.email as email,
 us.direccion_emple as direccion_emple
  FROM tb_usuarios as us INNER JOIN tb_roles as rol ON us.id_rol= rol.id_rol";
 
 $query_usuarios =$pdo->prepare($sql_usuarios);
 $query_usuarios->execute();
 
 $usuarios_datos =$query_usuarios->fetchAll(PDO::FETCH_ASSOC);
 