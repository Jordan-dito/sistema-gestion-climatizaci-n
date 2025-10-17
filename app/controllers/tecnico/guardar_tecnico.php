<?php
// Incluir el archivo de conexión a la base de datos
include '../../config.php'; // Ruta correcta a la configuración

header('Content-Type: application/json');  // La respuesta será siempre JSON

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Obtener los datos del formulario
        $idHorarioTecnico = isset($_POST['id_horario_tecnico']) ? trim($_POST['id_horario_tecnico']) : null;  // ID del horario técnico
        $diaInicio = isset($_POST['dia_inicio_semana']) ? trim($_POST['dia_inicio_semana']) : null;
        $diaFin = isset($_POST['dia_fin_semana']) ? trim($_POST['dia_fin_semana']) : null;
        $horarioInicio = isset($_POST['horario_inicio']) ? trim($_POST['horario_inicio']) : null;
        $horarioFin = isset($_POST['horario_fin']) ? trim($_POST['horario_fin']) : null;

        // Leer y normalizar el estado (esperamos 'Disponible','Ocupado' o 'Inactivo')
        $estadoIn = isset($_POST['estado']) ? trim($_POST['estado']) : null;
        // Mapear posibles variantes a los tres estados válidos
        $mapEstados = [
            'disponible' => 'Disponible',
            'available' => 'Disponible',
            'ocupado' => 'Ocupado',
            'busy' => 'Ocupado',
            'inactivo' => 'Inactivo',
            'inactive' => 'Inactivo'
        ];
        $estado = null;
        if ($estadoIn !== null) {
            $k = mb_strtolower($estadoIn, 'UTF-8');
            if (isset($mapEstados[$k])) {
                $estado = $mapEstados[$k];
            }
        }

        // Verificar si el horario técnico existe en la base de datos
        $query = $pdo->prepare("SELECT * FROM horariostecnicos WHERE ID_HorarioTecnico = :idHorarioTecnico");
        $query->bindParam(':idHorarioTecnico', $idHorarioTecnico);
        $query->execute();
        $horarioTecnico = $query->fetch(PDO::FETCH_ASSOC);

        if ($horarioTecnico) {
            // Si se proporcionó estado y no es válido, devolver error
            if ($estadoIn !== null && $estado === null) {
                echo json_encode(['status' => 'error', 'message' => 'Estado no válido. Solo se permiten: Disponible, Ocupado o Inactivo.']);
                exit;
            }

            // Actualizar el horario técnico (incluir estado si fue enviado y validado)
            $sql = "UPDATE horariostecnicos SET Dia_Inicio_Semana = :diaInicio, Dia_Fin_Semana = :diaFin, Horario_Inicio = :horarioInicio, Horario_Fin = :horarioFin";
            if ($estado !== null) {
                $sql .= ", Estado = :estado";
            }
            $sql .= " WHERE ID_HorarioTecnico = :idHorarioTecnico";

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':diaInicio', $diaInicio);
            $stmt->bindParam(':diaFin', $diaFin);
            $stmt->bindParam(':horarioInicio', $horarioInicio);
            $stmt->bindParam(':horarioFin', $horarioFin);
            if ($estado !== null) {
                $stmt->bindParam(':estado', $estado);
            }
            $stmt->bindParam(':idHorarioTecnico', $idHorarioTecnico);

            if ($stmt->execute()) {
                $msg = 'Datos guardados correctamente';
                if ($estado !== null) $msg .= ", estado actualizado a $estado";
                echo json_encode(['status' => 'success', 'message' => $msg]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'No se pudo actualizar el registro.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'El registro no existe en la base de datos.']);
        }

        exit;
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Error en la base de datos: ' . $e->getMessage()]);
        exit;
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Método de solicitud no válido']);
    exit;
}
