<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Solicitar restablecimiento de contraseña</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<style>
    body {
       
        background-size: cover;
    }
    .card {
        background: rgba(255, 255, 255, 0.8);
        border-radius: 8px;
    }
</style>
</head>
<body>
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card my-5">
        <div class="card-body">
          <h5 class="card-title text-center">Restablecer contraseña</h5>
          <p class="text-center">Ingresa tu dirección de correo electrónico y te enviaremos un enlace para restablecer tu contraseña.</p>
          <form id="email-form" action="send_email.php" method="POST">
            <div class="form-group">
              <label for="email">Correo electrónico</label>
              <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Enviar enlace de restablecimiento</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
document.getElementById('email-form').onsubmit = function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    var emailInput = document.getElementById('email'); // Obtiene el input de correo electrónico

    fetch('send_email.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.status === 'success') {
            Swal.fire({
                title: 'Enviado!',
                text: data.message,
                icon: 'success'
            }).then((result) => {
                if (result.isConfirmed || result.isDismissed) {
                    emailInput.value = ''; // Limpia el campo de correo electrónico después de cerrar el alerta
                }
            });
        } else {
            Swal.fire({
                title: 'Error!',
                text: data.message,
                icon: 'error'
            }).then((result) => {
                if (result.isConfirmed || result.isDismissed) {
                    emailInput.value = ''; // También limpia el campo si se muestra un error
                }
            });
        }
    })
    .catch(error => {
        Swal.fire({
            title: 'Error!',
            text: 'Algo salió mal con la solicitud AJAX.',
            icon: 'error'
        }).then((result) => {
            if (result.isConfirmed || result.isDismissed) {
                emailInput.value = ''; // Limpia el campo en caso de error en la solicitud
            }
        });
    });
};

</script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
