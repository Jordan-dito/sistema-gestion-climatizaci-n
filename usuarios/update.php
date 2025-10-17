<?php
include ('../app/config.php');
include ('../layout/sesion.php');

include ('../layout/parte1.php');

include ('../app/controllers/usuarios/update_usuario.php');
include ('../app/controllers/roles/listado_de_roles.php');




?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Actualizar usuario</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <!--<div class="col-md-5">-->
                <div class="col-md-8">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Llene los datos con cuidado</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                </button>
                            </div>

                        </div>

                        <div class="card-body" style="display: block;">
                            <div class="row">
                                <div class="col-md-12">

                                    <form action="../app/controllers/usuarios/update.php" method="post">
                                        <input type="text" name="id_usuario" value="<?php echo $id_usuario_get; ?>" hidden>

                                        <!-- Modifica el campo de cédula en tu formulario -->
                        <div class="form-group">
                            <label for="">Cedula</label>
                            <input type="number" name="cedula" id="cedula" class="form-control" value="<?php echo $cedula;?>" placeholder="Escriba aqui el numero de cedula del nuevo empleado" onblur="validarCedula()">
                        </div>

                                        <div class="form-group">
                                            <label for="">Nombres</label>
                                            <input type="text" name="nombres" class="form-control" value="<?php echo $nombres;?>" placeholder="Escriba aquí el nombre del nuevo usuario..." required>
                                        </div>

                                        <div class="form-group">
                            <label for="">Apellidos</label>
                            <input type="text" name="apellidos" class="form-control"  value="<?php echo $apellidos;?>" placeholder="Escriba aqui el apellido del nuevo empleado" >
                        </div>

                        <div class="form-group">
                            <label for="">Telefono</label>
                            <input type="number" name="telefono_empl" id="telefono_empl" class="form-control"  value="<?php echo $telefono_empl;?>" placeholder="Escriba aqui el numero de cedula del nuevo empleado" >
                        </div>


                                        <div class="form-group">
                                            <label for="">Email</label>
                                            <input type="email" name="email" class="form-control" value="<?php echo $email;?>" placeholder="Escriba aquí el correo del nuevo usuario..." required>
                                        </div>

                                        <div class="form-group">
                            <label for="">Direccion</label>
                            <input type="text" name="direccion_emple" class="form-control"  value="<?php echo $direccion_emple;?>" placeholder="Escriba aqui la direccion del nuevo empleado" required>
                        </div>

                        

                        <div class="form-group">
                                    <label for="">Rol del usuario</label>
                                 <select name="rol" id="" class="form-control">
                                     <?php
                                        foreach ($roles_datos as $roles_dato){
                                        $rol_tabla = $roles_dato['rol'];
                                         $id_rol = $roles_dato['id_rol'];?>
                                            <option value="<?php echo $id_rol; ?>"<?php if($rol_tabla == $rol){ ?> selected="selected" <?php } ?> >
                                                 <?php echo $rol_tabla;?>
                                            </option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>





                                        <div class="form-group">
                                            <label for="">Contraseña</label>
                                            <input type="text" name="password_user" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Repita la Contraseña</label>
                                            <input type="text" name="password_repeat" class="form-control">
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <a href="index.php" class="btn btn-secondary">Cancelar</a>
                                            <button type="submit" class="btn btn-success">Actualizar</button>
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
