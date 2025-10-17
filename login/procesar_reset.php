<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Establecer Nueva Contraseña</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<style>
    body {
        background: url('https://url-a-tu-imagen.com/imagen.jpg') no-repeat center center fixed; 
        background-size: cover;
    }
    .card {
        background: rgba(255, 255, 255, 0.8);
        border-radius: 8px;
        margin-top: 50px;
    }
    .input-group-append .input-group-text {
        cursor: pointer;
    }
</style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center">Establecer Nueva Contraseña</h5>
                    <p class="text-center">Ingresa tu número de cédula como llave de seguridad  y tu nueva contraseña a continuación.</p>
                    <form id="reset-password-form" action="set_new_password.php" method="POST">
                        <div class="form-group">
                            <label for="cedula">Número de Cédula</label>
                            <input type="text" class="form-control" id="cedula" name="cedula" required pattern="[0-9]{10}" title="Ingresa un número de cédula válido de 10 dígitos." maxlength="10">
                        </div>
                        <div class="form-group">
                            <label for="password">Nueva Contraseña</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" name="password" required maxlength="12">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i id="togglePassword" class="fas fa-eye"></i></span>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Establecer Contraseña</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Script to toggle password visibility
document.getElementById('togglePassword').onclick = function() {
    var passwordInput = document.getElementById('password');
    var toggleIcon = document.getElementById('togglePassword');
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
    }
};
</script>

<script>
document.getElementById('reset-password-form').addEventListener('submit', function(e) {
    e.preventDefault(); // Evitar el envío del formulario de forma predeterminada

    var formData = new FormData(this); // Preparar los datos del formulario para enviarlos

    fetch('set_new_password.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        // Mostrar respuesta con SweetAlert
        Swal.fire({
            title: data.status === 'success' ? 'Éxito' : 'Error',
            text: data.message,
            icon: data.status === 'success' ? 'success' : 'error'
        }).then((result) => {
            if (result.isConfirmed || result.isDismissed) {
                // Limpiar el formulario si se desea, o redirigir al usuario
                document.getElementById('cedula').value = '';
                document.getElementById('password').value = '';
            }
        });
    })
    .catch(error => {
        // Manejar errores de la solicitud
        Swal.fire({
            title: 'Error',
            text: 'Hubo un problema con la solicitud.',
            icon: 'error'
        });
    });
});
</script>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
