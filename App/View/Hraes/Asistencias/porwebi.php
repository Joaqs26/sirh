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
                        <button class="btn btn-light btn-circle" type="button" data-toggle="tooltip" title="Regresar"
                            onclick="window.location.href='index.php';">
                            <i class="fa fa-arrow-left"></i>
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
                    <h2 class="card-title tittle-card-index">Control de asistencias</h2>
                </div>


                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card font-size-modulo shadow-lg">
                                <h5 class="card-header text-center background-modal color-text-tittle">Reporteador</h5>
                                <div class="card-body" style="height: 600px;">

                                    <iframe title="ControlAsistencia" width="100%" height="100%"
                                        src="https://app.powerbi.com/view?r=eyJrIjoiODQyM2FhODItNGI0ZC00NWI0LTk0ZmQtYzRhN2M1Y2QzODM3IiwidCI6ImQxMzQ3MmY3LTVkMmQtNGU5NS1iNmIwLWZhNWE1ODhjODMyZCIsImMiOjR9&pageName=a460c205ed1a2d04acf6"
                                        frameborder="0" allowFullScreen="true"></iframe>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>



    <?php include '../../librerias.php' ?>