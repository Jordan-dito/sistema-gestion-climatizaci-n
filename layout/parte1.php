<?php



?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gary | Hermanos "Frios"</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="<?php echo $URL; ?>/public/templeates/AdminLTE-3.2.0/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo $URL; ?>/public/templeates/AdminLTE-3.2.0/dist/css/adminlte.min.css">


    <!--font awesome 6-->
    <script src="https://kit.fontawesome.com/2761596e8f.js" crossorigin="anonymous"></script>


    <link rel="shortcut icon" href="<?php echo $URL; ?>/public/images/icono/icono-negro.ico" type="image/x-icon">



    <!-- Libreria Sweetallert2-->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo $URL; ?>/public/templeates/AdminLTE-3.2.0/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo $URL; ?>/public/templeates/AdminLTE-3.2.0/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo $URL; ?>/public/templeates/AdminLTE-3.2.0/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

    <!-- jQuery -->
    <script src="<?php echo $URL; ?>/public/templeates/AdminLTE-3.2.0/plugins/jquery/jquery.min.js"></script>

</head>

<body class="hold-transition sidebar-mini">

    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">SISTEMA DE FRIOS </a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <!--<aside class="main-sidebar sidebar-dark-primary elevation-4">-->
        <!-- Brand Logo -->
        <!--<a href="<?php echo $URL; ?>" class="brand-link">
            <img src="<?php echo $URL; ?>/public/images/logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">SIS FRIOS</span>
        </a>-->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="<?php echo $URL ?>" class="brand-link">
                <img src="<?php echo $URL ?>/public/images/icono/icono-blanco.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">HERMANOS FRIOS</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <!--<img src="<?php echo $URL; ?>/public/templeates/AdminLTE-3.2.0/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">-->
                        <i class="fas fa-user-circle fa-3x"></i>

                    </div>
                    <div class="info">
                        <a href="#" class="d-block text-white text-uppercase"><?php echo $nombres_sesion; ?></a>

                    </div>
                </div>

                <div id="menu-container"> <!-- Añade este ID -->
                    <!-- Sidebar Menu -->
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                            <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->

                            <li class="nav-item">
                                <a href="<?php echo $URL; ?>/index.html" class="nav-link" style="background-color:#008000">
                                    <!--<i class="nav-icon fas fa-th"></i>-->
                                    <i class="nav-icon fa-brands fa-edge"></i>
                                    <p>
                                        Pagina Web
                                        <!--<span class="right badge badge-danger">New</span>-->
                                    </p>
                                </a>
                            </li>
                            <!--<li class="nav-item menu-open">-->




                            <li class="nav-item ">
                                <?php if (in_array('administracion', $modulos_permitidos)): ?>
                                    <a href="#" class="nav-link active">
                                        <i class="nav-icon fas fa-cogs"></i> <!-- Icono de administración (engranajes) -->
                                        <p>
                                            Administración
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>

                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="<?php echo $URL; ?>/clientes" class="nav-link">
                                                <i class="fas fa-user-friends nav-icon"></i> <!-- Icono de clientes -->
                                                <p> Clientes</p>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="<?php echo $URL; ?>/tecnico/index.php" class="nav-link">
                                                <i class="fas fa-calendar-alt nav-icon"></i> <!-- Icono de calendario -->
                                                <p>Horario Técnico</p>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="<?php echo $URL; ?>/almacen" class="nav-link">
                                                <i class="fas fa-boxes nav-icon"></i> <!-- Icono de listado de productos -->
                                                <p>Listado de productos</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="<?php echo $URL; ?>/almacen/create.php" class="nav-link">
                                                <i class="fas fa-plus-square nav-icon"></i> <!-- Icono de creación de productos -->
                                                <p>Creación de productos</p>
                                            </a>
                                        </li>


                                        <li class="nav-item">
                                            <a href="<?php echo $URL; ?>/usuarios/estado_civil.php" class="nav-link">
                                                <i class="fas fa-heart nav-icon"></i> <!-- Icono de estado civil -->
                                                <p>Estado Civil</p>
                                            </a>
                                        </li>



                                        <li class="nav-item">
                                            <a href="<?php echo $URL; ?>/distribuidor" class="nav-link">
                                                <i class="fas fa-network-wired nav-icon"></i> <!-- Icono de red para Distribuidores -->
                                                <p>Distribuidores</p>
                                            </a>
                                        </li>


                                        <li class="nav-item">
                                            <a href="<?php echo $URL; ?>/proveedores" class="nav-link">
                                                <i class="fas fa-briefcase nav-icon"></i> <!-- Icono de maletín para Proveedores -->
                                                <p>Proveedores</p>
                                            </a>
                                        </li>

                                    </ul>
                                <?php endif; ?>
                            </li>





                            <li class="nav-item">
                                <?php if (in_array('ordenes de trabajo', $modulos_permitidos)): ?>
                                    <a href="#" class="nav-link active">
                                        <i class="nav-icon fas fa-clipboard"></i>
                                        <p>
                                            Ordenes de Trabajo
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="<?php echo $URL; ?>/ordenes_trabajo/index.php" class="nav-link">
                                                <i class="fas fa-cogs nav-icon"></i> <!-- Icono de engranajes para Instalación -->
                                                <p>Instalación</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="<?php echo $URL; ?>/ordenes_trabajo/mantenimiento.php" class="nav-link">
                                                <i class="fas fa-tools nav-icon"></i> <!-- Icono de herramientas para Mantenimiento -->
                                                <p>Mantenimiento Y Reparación</p>
                                            </a>
                                        </li>



                                    </ul>
                                <?php endif; ?>
                            </li>


                            <li class="nav-item">

                                <a href="#" class="nav-link active">
                                    <i class="nav-icon fas fa-chart-line"></i> <!-- Icono de gráficos para Reportes -->
                                    <p>
                                        Reportes
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="<?php echo $URL; ?>/reportes/reportes_clientes.php" class="nav-link">
                                            <i class="fas fa-calendar-alt nav-icon"></i> <!-- Icono de calendario para Clientes por mes -->
                                            <p>Reporte de clientes</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo $URL; ?>/reportes/reporte_usuarios.php" class="nav-link">
                                            <i class="fas fa-user nav-icon"></i> <!-- Icono de usuario para Reporte de usuarios -->
                                            <p>Reporte de usuarios</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo $URL; ?>/reportes/reportes_compras.php" class="nav-link">
                                            <i class="fas fa-shopping-cart nav-icon"></i> <!-- Icono de carrito para Reporte de compras -->
                                            <p>Reporte de compras</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo $URL; ?>/ventas" class="nav-link">
                                            <i class="fas fa-dollar-sign nav-icon"></i> <!-- Icono de dólar para Reporte de ventas -->
                                            <p>Reporte de ventas</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="<?php echo $URL; ?>/reportes/reporte_historial_cliente.php" class="nav-link">
                                            <i class="fas fa-user-clock nav-icon"></i> <!-- Icono para historial -->
                                            <p>Historial de cliente</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="<?php echo $URL; ?>/reportes/reporte_ordenes_instalacion.php" class="nav-link">
                                            <i class="fas fa-file-alt nav-icon"></i> <!-- Icono para reporte/orden -->
                                            <p> Reporte Orden de instalación </p>
                                        </a>
                                    </li>


                                    <li class="nav-item">
                                        <a href="<?php echo $URL; ?>/reportes/reporte_mantenimiento_reparacion.php" class="nav-link">
                                            <i class="fas fa-wrench nav-icon"></i> <!-- Icono para reparación -->
                                            <p> Reporte Reparación Y Mantenimiento</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="<?php echo $URL; ?>/reportes/reporte_kardex.php" class="nav-link">
                                       <i class="fas fa-warehouse nav-icon"></i> <p>Kardex</p>

                                        </a>
                                    </li>

                                </ul>

                            </li>



                            <li class="nav-item">
                                <?php if (in_array('categorías', $modulos_permitidos)): ?>
                                    <a href="#" class="nav-link active">
                                        <i class="nav-icon fas fa-tags"></i>
                                        <p>
                                            Categorías
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="<?php echo $URL; ?>/categorias" class="nav-link">
                                                <i class="fas fa-th-list nav-icon"></i>
                                                <p>Listado de Categorías</p>
                                            </a>
                                        </li>
                                    </ul>
                                <?php endif; ?>
                            </li>









                            <li class="nav-item ">
                                <?php if (in_array('compras', $modulos_permitidos)): ?>

                                    <a href="#" class="nav-link active">
                                        <i class="nav-icon fas fa-cart-plus"></i>
                                        <p>
                                            Compras
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="<?php echo $URL; ?>/compras" class="nav-link">
                                                <i class="fas fa-shopping-cart nav-icon"></i> <!-- Icono de carrito de compras para Listado de compras -->
                                                <p>Listado de compras</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="<?php echo $URL; ?>/compras/create.php" class="nav-link">
                                                <i class="fas fa-cart-plus nav-icon"></i> <!-- Icono de añadir al carrito para Creación de compra -->
                                                <p>Creación de compra</p>
                                            </a>
                                        </li>

                                    </ul>
                                <?php endif; ?>

                            </li>




                            <li class="nav-item ">
                                <?php if (in_array('ventas', $modulos_permitidos)): ?>
                                    <a href="#" class="nav-link active">
                                        <i class="nav-icon fas fa-shopping-basket"></i>
                                        <p>
                                            Ventas
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="<?php echo $URL; ?>/ventas" class="nav-link">
                                                <i class="fas fa-shopping-basket nav-icon"></i> <!-- Icono de cesta de compras para Listado de ventas -->
                                                <p>Listado de ventas</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="<?php echo $URL; ?>/ventas/create.php" class="nav-link">
                                                <i class="fas fa-cash-register nav-icon"></i> <!-- Icono de caja registradora para Realizar venta -->
                                                <p>Realizar venta</p>
                                            </a>
                                        </li>

                                    </ul>
                                <?php endif; ?>
                            </li>




                            <!-- // todos los nombres de los modulos deben estar en miniscula asi en la base esten en mayusculas -->
                            <?php if (in_array('seguridad', $modulos_permitidos)): ?>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-shield-alt"></i>
                                        <p>
                                            Seguridad
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="<?php echo $URL; ?>/permisos" class="nav-link">
                                                <i class="fas fa-shield-alt nav-icon"></i>
                                                <p>Privilegios</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="<?php echo $URL; ?>/roles" class="nav-link">
                                                <i class="fas fa-users-cog nav-icon"></i>
                                                <p>Listado de roles</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="<?php echo $URL; ?>/roles/create.php" class="nav-link">
                                                <i class="fas fa-user-plus nav-icon"></i>
                                                <p>Creación de rol</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="<?php echo $URL; ?>/usuarios/create.php" class="nav-link">
                                                <i class="fas fa-user-plus nav-icon"></i>
                                                <p>Creación de usuario</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            <?php endif; ?>





                            <li class="nav-item">
                                <a href="<?php echo $URL; ?>/app/controllers/login/cerrar_sesion.php" class="nav-link" style="background-color: #ca0a0b">
                                    <i class="nav-icon fas fa-door-closed"></i>
                                    <p>
                                        Cerrar Sesión
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </nav>

                </div> <!-- Cierre del contenedor con ID -->
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>