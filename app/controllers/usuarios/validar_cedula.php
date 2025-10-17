<?php
/*include('../../config.php');

$cedula = $_POST['cedula'];

// Lógica de validación de la cédula (puedes personalizar esto según tus necesidades)
$validacionExitosa = true;
$mensaje = 'La cédula es válida.';
$icono = 'success';

// Ejemplo de validación: verifica si la cédula ya existe en la base de datos
$sentencia = $pdo->prepare("SELECT COUNT(*) AS count FROM tb_usuarios WHERE cedula = :cedula");
$sentencia->bindParam(':cedula', $cedula);
$sentencia->execute();
$resultado = $sentencia->fetch(PDO::FETCH_ASSOC);

if ($resultado['count'] > 0) {
  $validacionExitosa = false;
  $mensaje = 'La cédula ya está registrada.';
  $icono = 'error';
}

// Devuelve el resultado como JSON
echo json_encode(['title' => ($validacionExitosa ? 'Éxito' : 'Error'), 'message' => $mensaje, 'icon' => $icono]);
?>*/



include('../../config.php');

$cedula = $_POST['cedula'];

// Lógica de validación de la cédula ecuatoriana
function validarCedulaEcuatoriana($cedula)
{
    // Verifica que la cédula tenga 10 dígitos
    if (strlen($cedula) !== 10 || !ctype_digit($cedula)) {
        return false;
    }

    // ... (Resto de la lógica de validación de la cédula ecuatoriana)
     // Extrae la provincia y el dígito verificador
     $provincia = substr($cedula, 0, 2);
     $digitoVerificador = substr($cedula, 9, 1);
 
     // Verifica que la provincia sea válida (01-24)
     if ($provincia < 1 || $provincia > 24) {
         return false;
     }
 
     // Calcula el dígito verificador esperado
     $coeficientes = [2, 1, 2, 1, 2, 1, 2, 1, 2];
     $suma = 0;
 
     for ($i = 0; $i < 9; $i++) {
         $producto = $cedula[$i] * $coeficientes[$i];
         $suma += ($producto >= 10) ? ($producto - 9) : $producto;
     }
 
     $suma = (int)substr($suma, -1);
 
     $digitoCalculado = ($suma !== 0) ? 10 - $suma : 0;
 
     // Verifica que el dígito verificador sea válido
     return ($digitoCalculado == $digitoVerificador);
 
}

// Lógica de validación de la cédula (puedes personalizar esto según tus necesidades)
$validacionExitosa = true;
$mensaje = 'La cédula es válida.';
$icono = 'success';

// Verifica la cédula ecuatoriana
if (!validarCedulaEcuatoriana($cedula)) {
    $validacionExitosa = false;
    $mensaje = 'La cédula no es válida.';
    $icono = 'error';
} else {
    // Ejemplo de validación: verifica si la cédula ya existe en la base de datos
    $sentencia = $pdo->prepare("SELECT COUNT(*) AS count FROM tb_usuarios WHERE cedula = :cedula");
    $sentencia->bindParam(':cedula', $cedula);
    $sentencia->execute();
    $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);

    if ($resultado['count'] > 0) {
        $validacionExitosa = false;
        $mensaje = 'La cédula ya está registrada.';
        $icono = 'error';
    }
}

// Devuelve el resultado como JSON
echo json_encode(['title' => ($validacionExitosa ? 'Éxito' : 'Error'), 'message' => $mensaje, 'icon' => $icono]);
?>

