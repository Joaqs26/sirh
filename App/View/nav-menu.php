<?php include '../../../../conexion.php'; ?>
<?php include 'validar_sesion.php'; ?>

<?php
$id_user = $_SESSION['id_user'];
$nick = $_SESSION['nick'];
$nombre = $_SESSION['nombre'];
$id_rol = $_SESSION['id_rol'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIRH</title>
    <!--
    <script src="../../../../assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="../../../../assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <link rel="stylesheet" href="../../../../assets/bootstrap/css/bootstrap.min.css">
    <script src="../../../../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    -->
    <script src="../../../../dist/js/sweetalert2.all.min.js"></script>
    <script src="../../../../assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <link rel="stylesheet" href="../../../../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../../assets/styles/menu.css">
    <link rel="stylesheet" href="../../../../assets/styles/NewMenu.css">
    <link rel="stylesheet" href="../../../../assets/font/fontawesome/css/all.min.css">

    <script src="../../../../assets/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="../../../../assets/jquery/jquery-351.js"></script>

    <script src="../../../../js/Mensajes/mensajes.js"></script>
    <script src="../../../../js/Mensajes/mensajes.js"></script>
    <script src="../../../../js/Global/Curp/ValidarCurp.js"></script>
    <script src="../../../../js/Global/Mensajes/Mensajes.js"></script>
    <script src="../../../../js/Global/Seguridad/Confirmacion.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>

    <link rel="stylesheet" href="../../../../assets/bootstrap-select/dist/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="../../../../assets/notyf/notyf.min.css">


    <!--

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

    <script src="../../../../assets/jquery/chart.min.js"></script> 
-->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

        .form-control.custom-select {
            border: none;
            border-bottom: 2px solid #6c757d;
            border-radius: 0;
            box-shadow: none;
        }
    </style>

</head>

<body>

    <nav class="navbar bg-light nav-all-not-size">
        <div class="container-fluid nav-color-green-dad mb-0 nav-padding">
            <a class="navbar-brand navbar-header" href="../../System/home/index.php">
                <img src="../../../../assets/images/imss_bienestar.png" width="30" height="24"
                    class="d-inline-block align-text-top wider-image">
            </a>
            <h3 class="nav-tittle">IMSS-BIENESTAR</h3>
        </div>
    </nav>


    <nav class="navbar navbar-expand-lg nav-color-green-son mt-0">
        <div class="container-fluid nav-color-green-son mt-0 nav-padding">
            <a class="navbar-brand nav-text-tittle custom-link" href="../../System/home/index.php">Inicio</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll"
                aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarScroll">
                <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll nav-text-tittle"
                    style="--bs-scroll-height: 100px;">

                    <!-- ADMIN -->
                    <?php if ($id_rol == 1) { ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle nav-text-tittle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Administraci&oacuten
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="../../Admin/Usuarios/index.php">Usuarios</a></li>
                            </ul>
                        </li>
                    <?php } ?>
                    <!-- ADMIN -->

                    <!-- CENTRAL -->
                    <?php if ($id_rol == 1 || $id_rol == 2) { ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle nav-text-tittle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                IB - CENTRAL
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="../../Central/Asistencias/index.php">Asistencias</a></li>
                                <li><a class="dropdown-item" href="../../Central/CentroTrabajo/index.php">Centro de trabajo</a></li>
                                <li><a class="dropdown-item" href="../../Central/Empleados/index.php">Empleados</a></li>
                                <li><a class="dropdown-item" href="../../Central/Plazas/index.php">Plazas</a></li>
                                 <li><a class="dropdown-item" href="../../Central/Asistencias/index.php">Formato Nómina</a></li>
                            </ul>
                        </li>
                    <?php } ?>
                    <!-- CENTRAL -->

                    <!-- HRAES -->
                    <?php if ($id_rol == 1 || $id_rol == 3) { ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle nav-text-tittle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Nom. Hraes
                            </a>
                            <ul class="dropdown-menu">
                                <!--
                                <li><a class="dropdown-item" href="../../Hraes/Carga/index.php">Carga masiva</a></li>
                    -->
                                <li><a class="dropdown-item" href="../../Hraes/CentroTrabajo/index.php">Centro de
                                        trabajo</a></li>
                                <li><a class="dropdown-item" href="../../Hraes/Empleados/index.php">Empleados</a></li>
                                <li><a class="dropdown-item" href="../../Hraes/Plazas/index.php">Plazas</a></li>
                            </ul>
                        </li>
                    <?php } ?>
                    <!-- HRAES -->

                    <!-- FEDERALIZADA -->
                    <?php if ($id_rol == 1 || $id_rol == 4) { ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle nav-text-tittle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Nom. Federalizada
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Centros trabajo</a></li>
                                <li><a class="dropdown-item" href="#">Empleados</a></li>
                                <li><a class="dropdown-item" href="#">Plazas</a></li>
                            </ul>
                        </li>
                    <?php } ?>
                    <!-- FEDERALIZADA -->

                    <!-- FEDERALIZADA -->
                    <?php if ($id_rol == 1) { ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle nav-text-tittle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Otras acciones
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="../../Otros/Catalogos/index.php">Catalogos</a></li>
                            </ul>
                        </li>
                    <?php } ?>
                    <!-- FEDERALIZADA -->



                </ul>

                <!-- CONFIG -->
                <ul class="navbar-nav ml-custom">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle dropdown-toggle-ix" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-cog icon-config"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-result">
                            <button onclick="modalEditPw();" class="dropdown-item">Modificar contraseña</button>
                            <div class="dropdown-divider"></div>
                            <button onclick="activarModal();" class="dropdown-item">Salir</button>
                        </ul>
                    </li>
                </ul>
                <!-- CONFIG -->

            </div>
        </div>
    </nav>

    <!-- MODAL SALIR-->
    <div class="modal fade" id="modal_exit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background:#235B4E">
                    <h4 style="color:white" class="modal-title" id="exampleModalLongTitle">Confirmar cierre de
                        ses&oacuten</h4>
                </div>
                <div class="modal-footer">
                    <a href="../../salir.php" style="color:  #235B4E;" class="btn btn-light"><i class=""></i>
                        <span class="hide-menu" style="font-weight: bold;">&nbsp;Salir</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- MODAL SALIR-->

    <!-- FIN MODAL MODIFICAR PW -->
    <input type="hidden" id="id_user" value="<?php echo $id_user ?>">
    <input type="hidden" id="pw">
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true" id="modificar_pw">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header background-modal">
                    <h5 class="modal-title  text-modal-tittle">
                        Actualizar contraseña</h5>
                </div>

                <div class="card-body">
                    <div class="container">
                        <div class="row">
                            <div class="div-spacing"></div>
                            <div class="col-12">
                                <label class="text-input-form div-spacing text-input-rem">Contraseña
                                    anterior</label><label class="text-required">*</label>
                                <input type="password" class="form-control" id="pw_anterior"
                                    placeholder="Contraseña anterior">
                            </div>
                            <div class="div-spacing"></div>
                            <div class="col-12">
                                <label class="text-input-form div-spacing text-input-rem">Nueva contraseña</label><label
                                    class="text-required">*</label>
                                <input type="password" class="form-control" id="pw_nueva"
                                    placeholder="Nueva contraseña">
                            </div>
                            <div class="div-spacing"></div>
                            <div class="col-12">
                                <label class="text-input-form div-spacing text-input-rem">Confirmar
                                    contraseña</label><label class="text-required">*</label>
                                <input type="password" class="form-control" id="pw_confirmar"
                                    placeholder="Confirmar contraseña">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="div-spacing"></div>
                <div class="modal-footer">
                    <button onclick="modalEditPwExit();" type="button" class="btn btn-secondary" data-dismiss="modal"><i
                            class="fas fa-times"></i> Cancelar</button>
                    <button type="button" class="btn btn-success save-botton-modal" onclick="return validarPW();"><i
                            class="fas fa-save"></i> Guardar</button>
                </div>

            </div>
        </div>
    </div>



    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true" id="modal_mostrar_usuario">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header background-modal">
                    <h5 class="modal-title  text-modal-tittle"><label id="" class="text-modal-tittle"></label>
                        Último en realizar la acción
                    </h5>
                </div>

                <div class="card-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <br>
                                <h6 style="font-weight: " class="text-result-normal  input-text-form div-spacing">
                                    <i class="fa fa-user"></i> &nbsp USUARIO: <label class="text-result-normal"
                                        id="nombre_usuario_"></label>
                                </h6>
                            </div>
                            <div class="col-12">
                                <br>
                                <h6 style="font-weight: " class="text-result-normal  input-text-form div-spacing">
                                    <i class="fa fa-calendar"></i> &nbsp FECHA: <label class="text-result-normal"
                                        id="fecha_usuario_"></label>
                                </h6>
                            </div>
                            <div class="col-12">
                                <br>
                                <h6 style="font-weight: " class="text-result-normal  input-text-form div-spacing">
                                    <i class="fa fa-history"></i> &nbsp HORA: <label class="text-result-normal"
                                        id="hora_usuario_"></label>
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="div-spacing"></div>
                <div class="modal-footer">
                    <button onclick="hiddenModalUser();" type="button" class="btn btn-secondary" data-dismiss="modal"><i
                            class="fas fa-times"></i> Cerrar</button>
                </div>

            </div>
        </div>
    </div>


    <div class="overlay" id="overlay">
        <div class="spinner">
            <div class="spinner-border" role="status">
                <span class="sr-only">Cargando...</span>
            </div>
            <p class="mt-3" id="loaderMessage">Cargando...</p>
        </div>
    </div>

    <script src="../../../../js/Admin/Perfil/Perfil.js"></script>
    <script src="../../../../js/Admin/Usuarios/GetUser.js"></script>
</body>

<script>
    function activarModal() {
        $("#modal_exit").modal("show");
    }
</script>

</html>