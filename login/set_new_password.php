<?php
// Incluir el archivo de configuración para la conexión a la base de datos
include('../app/config.php');

// Configurar el encabezado para devolver JSON
header('Content-Type: application/json');

// Verificar que la petición sea POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'status' => 'error',
        'message' => 'Método no permitido'
    ]);
    exit();
}

// Obtener los datos del formulario
$cedula = isset($_POST['cedula']) ? trim($_POST['cedula']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';

// Validar que los campos no estén vacíos
if (empty($cedula) || empty($password)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Por favor, completa todos los campos.'
    ]);
    exit();
}

// Validar que la cédula tenga 10 dígitos
if (!preg_match('/^[0-9]{10}$/', $cedula)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'El número de cédula debe tener 10 dígitos.'
    ]);
    exit();
}

try {
    // Buscar el usuario por número de cédula
    $query = "SELECT id_usuario, nombres, apellidos FROM tb_usuarios WHERE cedula = :cedula LIMIT 1";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':cedula', $cedula, PDO::PARAM_STR);
    $stmt->execute();
    
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Verificar si el usuario existe
    if (!$usuario) {
        echo json_encode([
            'status' => 'error',
            'message' => 'No se encontró ningún usuario con ese número de cédula.'
        ]);
        exit();
    }
    
    // Encriptar la nueva contraseña
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    
    // Actualizar la contraseña del usuario
    $updateQuery = "UPDATE tb_usuarios SET password_user = :password WHERE cedula = :cedula";
    $updateStmt = $pdo->prepare($updateQuery);
    $updateStmt->bindParam(':password', $password_hash, PDO::PARAM_STR);
    $updateStmt->bindParam(':cedula', $cedula, PDO::PARAM_STR);
    
    if ($updateStmt->execute()) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Tu contraseña ha sido actualizada exitosamente. Ya puedes iniciar sesión con tu nueva contraseña.'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'No se pudo actualizar la contraseña. Por favor, intenta de nuevo.'
        ]);
    }
    
} catch (PDOException $e) {
    // Manejar errores de la base de datos
    echo json_encode([
        'status' => 'error',
        'message' => 'Error en la base de datos: ' . $e->getMessage()
    ]);
    exit();
}
?>

