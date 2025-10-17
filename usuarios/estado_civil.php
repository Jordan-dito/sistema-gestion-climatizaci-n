<?php
include('../app/config.php');
include('../layout/sesion.php');

include('../layout/parte1.php');


include('../app/controllers/categorias/listado_de_categoria.php');


$query = "SELECT estado_civil, COUNT(*) as cantidad 
                      FROM  tb_usuarios 
               
                      GROUP BY estado_civil;";
try {
    // Ejecutar la consulta y obtener los resultados
    $resultadoConsulta = $pdo->query($query);
    $usuarios = $resultadoConsulta->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error en la consulta: " . $e->getMessage();
    exit();
}




?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Estado Civil
                    
                    </h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-10">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Usuarios segun el estado civil </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                </button>
                            </div>

                        </div>

                        <div class="card-body" style="display: block;">
                            <table id="example1" class="table table-bordered table-striped">
                                <!-- <table id="datatablesSimple" class="table table-bordered table-hover mb-0"> -->
                                <thead>
                                    <tr>
                                        <th data-priority="1">Estado civil </th>
                                        <th data-priority="1">Cantidad</th>

                                     
                                    </tr>
                                </thead>
                                <tbody>



                                    <?php foreach ($usuarios as $tecnico) : ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($tecnico['estado_civil']); ?></td>
                                            <td><?php echo htmlspecialchars($tecnico['cantidad']); ?></td>

                                          

                                        </tr>
                                    <?php endforeach; ?>
                                    <!-- Aquí se llenarán los datos automáticamente con JavaScript -->
                                </tbody>
                            </table>
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
<!-- Modal para Editar Técnico -->




<?php include('../layout/mensajes.php'); ?>
<?php include('../layout/parte2.php'); ?>









<div id="respuesta"></div>