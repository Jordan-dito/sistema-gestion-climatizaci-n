<?php
include('../../config.php');

// Habilitar el informe de errores (solo para desarrollo)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verificar si se recibió una solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $id_usuario = $_POST['userId'];
    $cedula = $_POST['cedula'];
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
   
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $direccion = $_POST['direccion'];

    // Consulta para actualizar los datos del usuario
    $query = "UPDATE tb_usuarios SET 
                cedula = :cedula, 
                nombres = :nombres, 
                apellidos = :apellidos, 
                
                telefono_empl = :telefono, 
                email = :email, 
                direccion_emple = :direccion 
              WHERE id_usuario = :id_usuario";

    try {
        $stmt = $pdo->prepare($query);
        
        // Vincular parámetros
        $stmt->bindParam(':cedula', $cedula);
        $stmt->bindParam(':nombres', $nombres);
        $stmt->bindParam(':apellidos', $apellidos);
       
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':id_usuario', $id_usuario);
        
        // Imprimir consulta y datos para depuración
        echo "Consulta: $query\n";
        echo "Datos: ";
        var_dump($_POST);
        
        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Si se actualiza correctamente, devolver un mensaje de éxito
            echo json_encode(['message' => 'Usuario actualizado correctamente.']);
        } else {
            // Si no se actualiza, devolver un mensaje de error
            echo json_encode(['error' => 'No se pudo actualizar el usuario.']);
        }
    } catch (PDOException $e) {
        // Manejo de errores en caso de que falle la consulta
        http_response_code(500); // Establecer el código de respuesta HTTP a 500
        echo json_encode(['error' => 'Error en la consulta: ' . $e->getMessage()]);
    }
} else {
    // Si la solicitud no es POST, devuelve un error
    http_response_code(405); // Método no permitido
    echo json_encode(['error' => 'Método no permitido.']);
}
?>
