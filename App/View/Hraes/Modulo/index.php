<?php
$id_tbl_empleados_hraes = $_POST['id_tbl_empleados_hraes'];
if ($id_tbl_empleados_hraes == null) {
    header('Location: ../Empleados/index.php');
}
?>

<link rel="stylesheet" href="../../../../assets/bootstrap-select/dist/css/bootstrap-select.min.css">

<?php include '../../nav-menu.php' ?>


<link rel="stylesheet" href="../../../../assets/styles/nav.css">
<div class="container-fluid bg-image-module nav-padding">
    <br>
    <input type="hidden" id="id_tbl_empleados_hraes" value="<?php echo $id_tbl_empleados_hraes ?>" />
    <div class="card border-light">
        <div class="card-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-auto">
                        <div class="vertical-line"></div>
                    </div>
                    <div class="col padding-left-0">
                        <h3>Datos complementarios</h3>
                    </div>
                    <div class="col-auto">
                        <a href="../Empleados/index.php" class="btn btn-light" role="button" aria-haspopup="true"
                            aria-expanded="false">
                            <i style="color:#235B4E" class="fa fa-arrow-left icono-pequeno-tabla"></i>
                            <span class="hide-menu text-button-add">&nbsp;Regresar</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="div-spacing"></div>

            <div class="row is-rem-text">
                <div class="col-12 col-md-6 col-lg-6 col-xl-4 col-xxl-4">
                    <h6 style="font-weight: bold" class="text-result-normal  input-text-form div-spacing">NOMBRE: <label
                            class="text-result-normal" id="nombreResult"></label>
                    </h6>
                </div>
                <div class="col-12 col-md-6 col-lg-6 col-xl-4 col-xxl-4">
                    <h6 style="font-weight: bold" class="text-result-normal  input-text-form div-spacing">PRIMER
                        APELLIDO: <label class="text-result-normal" id="primerA"></label>
                    </h6>
                </div>
                <div class="col-12 col-md-6 col-lg-6 col-xl-4 col-xxl-4">
                    <h6 style="font-weight: bold" class="text-result-normal  input-text-form div-spacing">SEGUNDO
                        APELLIDO: <label id="segundoA" class="text-result-normal"></label>
                    </h6>
                </div>
            </div>

            <div class="row is-rem-text">
                <div class="col-12 col-md-6 col-lg-6 col-xl-4 col-xxl-4">
                    <h6 style="font-weight: bold" class="text-result-normal  input-text-form div-spacing">RFC: <label
                            class="text-result-normal" id="rfcResult"></label>
                    </h6>
                </div>
                <div class="col-12 col-md-6 col-lg-6 col-xl-4 col-xxl-4">
                    <h6 style="font-weight: bold" class="text-result-normal  input-text-form div-spacing">CURP: <label
                            class="text-result-normal" id="curpResult"></label>
                    </h6>
                </div>
                <div class="col-12 col-md-6 col-lg-6 col-xl-4 col-xxl-4">
                    <h6 style="font-weight: bold" class="text-result-normal  input-text-form div-spacing">No DE
                        EMPLEADO: <label id="numEmpleadoResult" class="text-result-normal"></label>
                    </h6>
                </div>
            </div>

            <div class="row is-rem-text">
                <div class="col-12 col-md-6 col-lg-6 col-xl-4 col-xxl-4">
                    <h6 style="font-weight: bold" class="text-result-normal input-text-form div-spacing">C&OacuteDIGO DE
                        PUESTO: <label class="text-result-normal" id="codPuesto"></label>
                    </h6>
                </div>
                <div class="col-12 col-md-6 col-lg-6 col-xl-4 col-xxl-4">
                    <h6 style="font-weight: bold" class="text-result-normal  input-text-form div-spacing">NIVEL: <label
                            class="text-result-normal" id="isNivel"></label>
                    </h6>
                </div>
                <div class="col-12 col-md-6 col-lg-6 col-xl-4 col-xxl-4">
                    <h6 style="font-weight: bold" class="text-result-normal  input-text-form div-spacing">PUESTO: <label
                            id="nomPuesto" class="text-result-normal"></label>
                    </h6>
                </div>
            </div>

            <div class="row is-rem-text">
                <div class="col-12 col-md-6 col-lg-6 col-xl-4 col-xxl-4">
                    <h6 style="font-weight: bold" class="text-result-normal  input-text-form div-spacing">No PLAZA:
                        <label class="text-result-normal" id="numPlaza"></label>
                    </h6>
                </div>
                <div class="col-12 col-md-6 col-lg-6 col-xl-4 col-xxl-4">
                    <h6 style="font-weight: bold" class="text-result-normal  input-text-form div-spacing">CLUES: <label
                            class="text-result-normal" id="isClue"></label>
                    </h6>
                </div>
                <div class="col-12 col-md-6 col-lg-6 col-xl-4 col-xxl-4">
                    <h6 style="font-weight: bold" class="text-result-normal  input-text-form div-spacing">ZONA PAGADORA:
                        <label id="zonaPag" class="text-result-normal"></label>
                    </h6>
                </div>
            </div>

            <div class="div-spacing"></div>
            <div class="row div-spacing ">
                <div class="col-12">

                    <nav>
                        <div class="nav nav-tabs justify-content-center" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home"
                                onclick="iniciarPersonalBancario();" role="tab" aria-controls="nav-home"
                                aria-selected="true"><i class="fa fa-user"></i> Datos personales</a>
                            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile"
                                onclick="iniciarMediosContacto();" role="tab" aria-controls="nav-profile"
                                aria-selected="false"><i class="fa fa-address-book"></i> Medios de contacto</a>
                            <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-escolaridad"
                                onclick="iniciarEscolaridad();" role="tab" aria-controls="nav-contact"
                                aria-selected="false"><i class="fa fa-graduation-cap"></i> Escolaridad</a>
                            <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-programas"
                                onclick="iniciarProgramas();" role="tab" aria-controls="nav-contact"
                                aria-selected="false"><i class="fa fa-cubes"></i> Programas</a>
                            <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-movimientos"
                                onclick="iniciarMovimiento();" role="tab" aria-controls="nav-contact"
                                aria-selected="false"><i class="fa fa-random"></i> Movimientos</a>
                            
                            <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-incidencias"
                                onclick="iniciarIncidencias();" role="tab" aria-controls="nav-contact"
                                aria-selected="false"><i class="fa fa-anchor"></i> Incidencias</a>
                            <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-percepciones"
                                onclick="iniciarPercepciones();" role="tab" aria-controls="nav-contact"
                                aria-selected="false"><i class="fa fa-th-list"></i> Percepciones</a>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                            aria-labelledby="nav-home-tab">
                            <div class="div-spacing"></div>
                            <h5>Informaci&oacuten personal</h5>
                            <?php include 'PersonalBancarioM/index.php' ?>
                        </div>
                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                            <div class="div-spacing"></div>
                            <h5>Medios de contacto</h5>
                            <?php include 'MediosContactoM/index.php' ?>
                        </div>
                        <div class="tab-pane fade" id="nav-escolaridad" role="tabpanel"
                            aria-labelledby="nav-contact-tab">
                            <div class="div-spacing"></div>
                            <h5 class="card-title tittle-card-index">Escolaridad</h5>
                            <?php include 'EscolaridadM/index.php' ?>
                        </div>
                        <div class="tab-pane fade" id="nav-movimientos" role="tabpanel"
                            aria-labelledby="nav-contact-tab">
                            <div class="div-spacing"></div>
                            <h5 class="card-title tittle-card-index">Movimientos</h5>
                            <?php include 'MovimientosM/index.php' ?>
                        </div>
                        <div class="tab-pane fade" id="nav-incidencias" role="tabpanel"
                            aria-labelledby="nav-contact-tab">
                            <div class="div-spacing"></div>
                            <h5 class="card-title tittle-card-index">Incidencias</h5>
                            <?php include 'IncidenciasM/index.php' ?>
                        </div>
                        <div class="tab-pane fade" id="nav-percepciones" role="tabpanel"
                            aria-labelledby="nav-contact-tab">
                            <div class="div-spacing"></div>
                            <h5 class="card-title tittle-card-index">Percepciones</h5>
                            <?php include 'PercepcionesM/index.php' ?>
                        
                        </div>
                        <div class="tab-pane fade" id="nav-programas" role="tabpanel" aria-labelledby="nav-contact-tab">
                            <div class="div-spacing"></div>
                            <h5 class="card-title tittle-card-index">Programas</h5>
                            <?php include 'ProgramasM/index.php' ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br>

<script src="../../../../assets/notyf/notyf.min.js"></script>
<?php include 'librerias.php' ?>
<script src="../../../../assets/js/bootstrap.js"></script>

<script>
    $(document).ready(function () {
        buscarInfoEmpleado(id_tbl_empleados_hraes);
        iniciarPersonalBancario();
    });
</script>

<script src="../../../../assets/bootstrap-select/dist/js/bootstrap-select.min.js"></script>