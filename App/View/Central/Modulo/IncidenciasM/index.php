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
                        <h3>Incidencias y Control de Asistencia</h3>
                    </div>
                    <div class="col-auto">
                        <a href="../Empleados/index.php" class="btn btn-light" role="button">
                            <i style="color:#235B4E" class="fa fa-arrow-left icono-pequeno-tabla"></i>
                            <span class="hide-menu text-button-add">&nbsp;Regresar</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="div-spacing"></div>
            <div class="row">
                <div class="col-12 col-md-6 col-lg-6 col-xl-2">
                    <div class="card font-size-modulo shadow-lg">
                        <h6 class="card-header text-center background-modal color-text-tittle">Tipo de incidencia</h6>
                        <div class="nav flex-column nav-pills text-tittle-card-nav-x" id="v-tabs-tab" role="tablist">
                            <a onclick="buscarRetardo();" class="nav-link-mod active" id="v-tabs-home-tab" data-toggle="pill"
                                href="#v-tabs-home" role="tab" aria-selected="true">
                                <i class="fa fa-folder-open mr-2"></i> Retardos</a>
                            <a onclick="buscarFalta();" class="nav-link-mod" id="v-tabs-profile-tab" data-toggle="pill"
                                href="#v-tabs-profile" role="tab" aria-selected="false">
                                <i class="fa fa-folder-open mr-2"></i> Faltas</a>
                            <a onclick="buscarLicencia();" class="nav-link-mod" id="v-tabs-messages-tab" data-toggle="pill"
                                href="#v-tabs-messages" role="tab" aria-selected="false">
                                <i class="fa fa-folder-open mr-2"></i> Licencias</a>
                            <a onclick="buscarIncidencia();" class="nav-link-mod" id="v-tabs-incidencias-tab" data-toggle="pill"
                                href="#v-tabs-incidencias" role="tab" aria-selected="false">
                                <i class="fa fa-folder-open mr-2"></i> Incidencias</a>
                            <a onclick="buscarPreventivas();" class="nav-link-mod" id="v-tabs-preventivas-tab" data-toggle="pill"
                                href="#v-tabs-preventivas" role="tab" aria-selected="false">
                                <i class="fa fa-folder-open mr-2"></i> Preventivas</a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-12 col-lg-12 col-xl-10">
                    <div class="tab-content" id="v-tabs-tabContent">
                        <div class="tab-pane fade show active" id="v-tabs-home" role="tabpanel">
                            <div class="div-spacing"></div>
                            <h5 class="text-center">Retardos</h5>
                            <?php include 'Retardo/index.php' ?>
                        </div>
                        <div class="tab-pane fade" id="v-tabs-profile" role="tabpanel">
                            <div class="div-spacing"></div>
                            <h5 class="text-center">Faltas</h5>
                            <?php include 'Falta/index.php' ?>
                        </div>
                        <div class="tab-pane fade" id="v-tabs-messages" role="tabpanel">
                            <div class="div-spacing"></div>
                            <h5 class="text-center">Licencias</h5>
                            <?php include 'Licencias/index.php' ?>
                        </div>
                        <div class="tab-pane fade" id="v-tabs-incidencias" role="tabpanel">
                            <div class="div-spacing"></div>
                            <h5 class="text-center">Otras Incidencias</h5>
                            <?php include 'Incidencias/index.php' ?>
                        </div>
                        <div class="tab-pane fade" id="v-tabs-preventivas" role="tabpanel">
                            <div class="div-spacing"></div>
                            <h5 class="text-center">Preventivas</h5>
                            <?php include 'Preventivas/index.php' ?>
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
