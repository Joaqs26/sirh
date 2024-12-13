<?php
$id_tbl_centro_trabajo_hraes = null;
if (isset($_POST['id_tbl_centro_trabajo_hraes'])) {
    $id_tbl_centro_trabajo_hraes = $_POST['id_tbl_centro_trabajo_hraes'];
}
?>
<?php include '../../nav-menu.php' ?>


<div class="container-fluid bg-image nav-padding">
    <input type="hidden" id="id_tbl_centro_trabajo_hraes" value="<?php echo $id_tbl_centro_trabajo_hraes ?>" />
    <br>
    <div class="card border-light shadow-lg">
        <div class="card-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-auto">
                        <div class="vertical-line"></div>
                    </div>
                    <div class="col padding-left-0">
                        <h4>HRAES</h4>
                    </div>
                    <?php if ($id_tbl_centro_trabajo_hraes != null) { ?>
                        <div class="col-auto">
                            <a href="../CentroTrabajo/index.php" class="btn btn-light" role="button" aria-haspopup="true"
                                aria-expanded="false">
                                <i style="color:#235B4E" class="fa fa-arrow-left icono-pequeno-tabla"></i>
                                <span class="hide-menu text-button-add">&nbsp;Regresar</span>
                            </a>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <?php if ($id_tbl_centro_trabajo_hraes != null) { ?>
                <div class="div-spacing"></div>
                <?php include 'InfoClue.php' ?>
            <?php } ?>
        </div>
    </div>
    <br>

    <div class="card border-light">
        <div class="card-body">
            <div class="row div-spacing">
                <div class="row">

                    <div class="col-12 col-md-6 col-lg-9 col-xl-9">
                        <h2 class="card-title tittle-card-index">Plazas</h2>
                    </div>


                    <div class="col-3 search-container d-flex align-items-center">
                        <?php if ($id_tbl_centro_trabajo_hraes != null) { ?>
                            <button class="btn btn-light btn-circle" type="button" onclick="agregarEditarDetalles(null)"
                                data-toggle="tooltip" title="Agregar plaza">
                                <i class="fa fa-plus"></i>
                            </button>
                        <?php } else { ?>

                            <button class="btn btn-light btn-circle" type="button" onclick="abrirModalAdd()" type="button"
                                data-toggle="tooltip" title="Agregar plaza">
                                <i class="fa fa-plus"></i>
                            </button>

                        <?php } ?>

                        <input onkeyup="buscarPlaza();" id="buscar" type="text" placeholder="Buscar..."
                            class="form-control search-input" style="margin-left: 15px;">
                        <span class="search-icon ml-2"><i class="fas fa-search"></i></span>
                    </div>

                </div>
            </div>

            <div class="div-spacing"></div>
            <div class="col-12 table-responsive">
                <div class="text-center">
                    <table class="table table-bordered table-fixed" id="tabla_plazas">
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


<!-- Modal agregar plaza-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header background-modal">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-sm-1">
                            <img src="../../../../assets/sirh/logo_plaza.png" style="max-width: 1000%;">
                        </div>
                        <div class="col-12 col-sm-11">
                            <h1 class="text-tittle-card"><label id="" claa="text-modal-tittle"></label>
                                Agregar plaza.
                            </h1>
                            <p class="color-text-white">Este espacio está destinado a agregar o modificar información
                                relacionada con plazas. Aquí puedes ingresar nuevos datos o actualizar los
                                existentes según sea necesario.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning" role="alert">
                    <h6 class="alert-heading"><i class="fa fa-exclamation-circle"></i> ¿Cómo agregar una plaza?</h6>
                    <p>Para agregar una plaza:</p>
                    <p> - Desde el menú del centro de trabajo o accede pulsando el botón 'Ir'</p>
                    <p> - Selecciona el centro de trabajo al que deseas añadir la plaza y dirígete a la
                        sección de 'Plazas Asignadas al Centro de Trabajo'.</p>
                    <p> - Aquí encontrarás todas las plazas que pertenecen a ese centro, junto con la opción de agregar
                        una nueva plaza.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="cerrarModalAdd()"><i class="fas fa-times"></i>
                    Cancelar</button>
                <a href="../CentroTrabajo/index.php" type="button" class="btn btn-success save-botton-modal"><i
                        class="fa fa-arrow-right"></i> Ir</a>
            </div>
        </div>
    </div>
</div>
<!-- Modal agregar plaza-->





<?php include 'AgregarEditar.php' ?>
<?php include 'Detalles.php' ?>
<?php include '../../librerias.php' ?>

<script src="../../../../js/Hraes/Plazas/Busqueda.js"></script>
<script src="../../../../js/Hraes/Plazas/Plazas.js"></script>
<script src="../../../../js/Hraes/Plazas/validar.js"></script>