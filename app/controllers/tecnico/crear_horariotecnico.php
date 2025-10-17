<?php
function guardarHorario() {
    include '../../config.php';  // Ajusta la ruta según tu estructura

    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        try {
            // Obtener los datos del formulario
            $idUsuario = $_POST['tecnico'];
            $diaInicio = $_POST['diaInicioSemana'];
            $diaFin = $_POST['diaFinSemana'];
            $horaInicio = $_POST['horaInicio'];
            $horaFin = $_POST['horaFin'];

            // Preparar la consulta SQL
            $query = "INSERT INTO horariostecnicos (id_usuario, Dia_Inicio_Semana, Dia_Fin_Semana, Horario_Inicio, Horario_Fin) 
                      VALUES (:idUsuario, :diaInicio, :diaFin, :horaInicio, :horaFin)";
            $stmt = $pdo->prepare($query);

            // Enlazar parámetros
            $stmt->bindParam(':idUsuario', $idUsuario);
            $stmt->bindParam(':diaInicio', $diaInicio);
            $stmt->bindParam(':diaFin', $diaFin);
            $stmt->bindParam(':horaInicio', $horaInicio);
            $stmt->bindParam(':horaFin', $horaFin);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                echo json_encode(['status' => 'success', 'message' => 'Horario guardado correctamente']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'No se pudo guardar el horario']);
            }

        } catch (PDOException $e) {
            echo json_encode(['status' => 'error', 'message' => 'Error en la base de datos: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Método de solicitud no válido']);
    }
}

// Llamar a la función
guardarHorario();
