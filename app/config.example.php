<?php
/**
 * Archivo de configuración de ejemplo
 * Copia este archivo como 'config.php' y configura tus credenciales
 */

define('SERVIDOR','localhost');
define('USUARIO','tu_usuario_mysql');
define('PASSWORD','tu_password_mysql');
define('BD','c2840648_sistema');

$servidor = "mysql:dbname=".BD.";host=".SERVIDOR;

try{
    $pdo = new PDO($servidor,USUARIO,PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8"));
    //echo "La conexión a la base de datos fue con exito";
}catch (PDOException $e){
    //print_r($e);
    echo "Error al conectar a la base de datos";
}

// URL base del sistema (ajustar según tu entorno)
// Desarrollo: http://localhost/sistema-gestion-climatizacion
// Producción: https://tu-dominio.com
$URL = "http://localhost/sistema-gestion-climatizacion";

// Configuración SMTP para envío de correos
define('SMTP_HOST', 'tu_smtp_host');
define('SMTP_PORT', 587);
define('SMTP_USER', 'tu_correo@ejemplo.com');
define('SMTP_PASS', 'tu_password_smtp');
define('SMTP_FROM_NAME', 'Departamento de Sistemas');

// Zona horaria
date_default_timezone_set("America/Guayaquil");
$fechaHora = date('Y-m-d H:i:s');

