<?php
include ('../app/config.php');
include ('../layout/sesion.php');

include ('../layout/parte1.php');

include ('../app/controllers/usuarios/show_usuario.php');

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Eliminar usuario</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-5">
                    <div class="card card-danger">
                        <div class="card-header">
                            <h3 class="card-title">¿Esta seguro de eliminar al usuario?</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                </button>
                            </div>

                        </div>

                        <div class="card-body" style="display: block;">
                            <div class="row">
                                <div class="col-md-12">
                                    <form action="../app/controllers/usuarios/delete_usuario.php" method="post">
                                        <input type="text" name="id_usuario" value="<?php echo $id_usuario_get;?>" hidden>

                                        <div class="form-group">
                          <label for="">Cedula</label>
                          <input type="number" name="cedula" id="cedula" class="form-control" value="<?php echo$cedula; ?>" disabled>
                        </div>

                                        <div class="form-group">
                                            <label for="">Nombres</label>
                                            <input type="text" name="nombres" class="form-control" value="<?php echo $nombres;?>" disabled>
                                        </div>

                                        <div class="form-group">
                          <label for="">Apellidos</label>
                          <input type="text" name="apellidos" class="form-control" value="<?php echo$apellidos; ?>" disabled>
                        </div>

                        <div class="form-group">
                          <label for="">Telefono</label>
                          <input type="number" name="telefono_empl" id="telefono_empl" class="form-control" value="<?php echo$telefono_empl; ?>" disabled>
                        </div>


                                        <div class="form-group">
                                            <label for="">Email</label>
                                            <input type="email" name="email" class="form-control" value="<?php echo $email;?>" disabled>
                                        </div>

                                        <div class="form-group">
                          <label for="">Direccion</label>
                          <input type="text" name="direccion_emple" class="form-control" value="<?php echo$direccion_emple; ?>" disabled>
                        </div>

                                        <div class="form-group">
                                            <label for="">Rol del usuario</label>
                                            <input type="text" name="email" class="form-control" value="<?php echo $rol;?>" disabled>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <a href="index.php" class="btn btn-secondary">Volver</a>
                                            <button class="btn btn-danger">Eliminar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Agrega esto al final de tu archivo create.php -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
  // Función para validar la cédula usando AJAX
  function validarCedula() {
    var cedula = document.getElementById('cedula').value;

    // Realiza la petición AJAX
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '../app/controllers/usuarios/validar_cedula.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        var response = JSON.parse(xhr.responseText);

        // Muestra el SweetAlert2 con el resultado de la validación
        Swal.fire({
          title: response.title,
          text: response.message,
          icon: response.icon
        });
      }
    };

    // Envía la cédula al servidor
    xhr.send('cedula=' + cedula);
  }
</script>


<?php include ('../layout/mensajes.php'); ?>
<?php include ('../layout/parte2.php'); ?>
