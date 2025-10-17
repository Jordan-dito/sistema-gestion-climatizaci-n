// utils.js
function validarRangoFechas(fechaInicio, fechaFin) {
    if (new Date(fechaInicio) > new Date(fechaFin)) {
        Swal.fire({
            icon: 'error',
            title: 'Error en fechas',
            text: 'La fecha de inicio no puede ser posterior a la fecha de fin.',
            confirmButtonText: 'Entendido',
            confirmButtonColor: '#3085d6'
        }).then(() => {
            // Opcional: limpiar campos en la función llamadora
 // Limpiar los campos de fecha después de cerrar el mensaje de error
                    document.getElementById("fechaInicio").value = "";
                    document.getElementById("fechaFin").value = "";
        });
        return false;
    }
    return true;
}
