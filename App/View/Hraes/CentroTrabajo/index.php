<?php include '../../nav-menu.php' ?>
<div class="container-fluid bg-image nav-padding">
    <br>
    <div class="card border-light shadow-lg">
        <div class="card-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-auto">
                        <div class="vertical-line"></div>
                    </div>
                    <div class="col padding-left-0">
                        <h4>hares</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>

    <div class="card border-light">
        <div class="card-body">
            <div class="row div-spacing">
                <div class="col-9">
                    <h2 class="card-title tittle-card-index">Centro de trabajo</h2>
                </div>

                <div class="col-3 search-container d-flex align-items-center">
                    <button class="btn btn-light btn-circle" type="button" onclick="agregarEditarDetalles(null)"
                        data-toggle="tooltip" title="Agregar centro de trabajo">
                        <i class="fa fa-plus"></i>
                    </button>
                    <input onkeyup="buscarCentro();" id="buscar" type="text" placeholder="Buscar..."
                        class="form-control search-input" style="margin-left: 15px;">
                    <span class="search-icon ml-2"><i class="fas fa-search"></i></span>
                </div>
            </div>

            <br>
            <div class="col-12 table-responsive">
                <div class="text-center">
                    <table class="table table-bordered table-fixed" id="tabla_centro_trabajo">
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="table-right">
                        <button onclick="anteriorValor()" class="btn btn-light"><i class="fa fa-angle-double-left"></i>
                            <span class="hide-menu" style="font-weight: bold;"></span>
                        </button>
                        <label id="idtable">1</label>
                        <button onclick="siguienteValor()" class="btn btn-light"><i
                                class="fa fa-angle-double-right"></i>
                            <span class="hide-menu" style="font-weight: bold;"></span>
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div id="myChart"></div>


<?php include '../../librerias.php' ?>
<?php include 'AgregarEditar.php' ?>
<?php include 'Carga.php' ?>

<script src="../../../../js/Hraes/CentroTrabajo/CentroTrabajo.js"></script>
<script src="../../../../js/Hraes/CentroTrabajo/validar.js"></script>
<script src="../../../../js/Hraes/CentroTrabajo/Busqueda.js"></script>
<script src="../../../../js/Hraes/CentroTrabajo/Carga.js"></script>