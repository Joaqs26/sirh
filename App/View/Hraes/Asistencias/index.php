<?php include '../../nav-menu.php' ?>

<div class="container-fluid bg-image nav-padding">
    <br>
    <div class="card border-light shadow-lg">
        <div class="card-body">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <div class="vertical-line"></div>
                    </div>
                    <div class="col padding-left-0">
                        <h4>Hraes</h4>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-light btn-circle" type="button" data-toggle="tooltip"
                            title="Justificar faltas" onclick="mostrarModalFaltas();">
                            <i class="fa fa-upload"></i>
                        </button>
                        <button class="btn btn-light btn-circle" type="button" data-toggle="tooltip"
                            title="Mis estadísticas" onclick="window.location.href='porwebi.php';">
                            <i class="fa fa-line-chart"></i>
                        </button>
                        <button class="btn btn-light btn-circle" type="button" onclick="getReporteAsistencia()"
                            data-toggle="tooltip" title="Generar reporte">
                            <i class="fa fa-download"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>

    <div class="card border-light">
        <div class="card-body">
            <div class="row div-spacing">
                <div class="col-6">
                    <h2 class="card-title tittle-card-index">Administración de Asistencias</h2>
                </div>
                <div class="row div-spacing ">
                    <div class="col-12">
                        <nav>
                            <div class="nav nav-tabs justify-content-center" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home"
                                    onclick="buscarAsistencia();" role="tab" aria-controls="nav-home"
                                    aria-selected="true"><i class="fa fa-star"></i>
                                    Asistencias</a>
                                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile"
                                    onclick="buscarFalta();" role="tab" aria-controls="nav-profile"
                                    aria-selected="false"><i class="fa fa-close"></i> Faltas</a>
                                <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab"
                                    href="#nav-escolaridad" onclick="buscarRetardo();" role="tab"
                                    aria-controls="nav-contact" aria-selected="false"><i class="fa fa-history"></i>
                                    Retardos</a>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                                aria-labelledby="nav-home-tab">
                                <div class="div-spacing"></div>
                                <?php include 'Asistencias/index.php' ?>
                            </div>
                            <div class="tab-pane fade" id="nav-profile" role="tabpanel"
                                aria-labelledby="nav-profile-tab">
                                <div class="div-spacing"></div>
                                <?php include 'Falta/index.php' ?>
                            </div>
                            <div class="tab-pane fade" id="nav-escolaridad" role="tabpanel"
                                aria-labelledby="nav-contact-tab">
                                <div class="div-spacing"></div>
                                <?php include 'Retardos/index.php' ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?php include '../../librerias.php' ?>
<?php include 'Carga.php' ?>
<?php include 'CargaFaltas.php' ?>
<?php include 'ModalUsuario.php' ?>

<!-- -->
<script src="../../../../js/Hraes/Asistencias/Reporte/Reporte.js"></script>

<script src="../../../../js/Hraes/Asistencias/Asistencias/Listado.js"></script>
<script src="../../../../js/Hraes/Asistencias/Asistencias/Busqueda.js"></script>

<script src="../../../../js/Hraes/Asistencias/Falta/Listado.js"></script>
<script src="../../../../js/Hraes/Asistencias/Falta/Busqueda.js"></script>
<script src="../../../../js/Hraes/Asistencias/Falta/Masivo.js"></script>


<script src="../../../../js/Hraes/Asistencias/Retardos/Listado.js"></script>
<script src="../../../../js/Hraes/Asistencias/Retardos/Busqueda.js"></script>

<!-- -->
<script src="../../../../js/Hraes/Asistencias/Inicio.js"></script>
<script src="../../../../js/Hraes/Asistencias/Carga.js"></script>