<div class="div-spacing"></div>
<div class="row">
    <div class="col-12 col-md-12 col-lg-12 col-xl-8 mb-4">

        <div class="card font-size-modulo shadow-lg">
            <h5 class="card-header text-center background-modal color-text-tittle">Asistencias</h5>
            <div class="card-body">
            <?php  include 'Asistencia/index.php' ?>
            </div>
        </div>
        <!--
        <div class="card font-size-modulo shadow-lg">
            <div style="background:#235B4E" class="card-header d-flex justify-content-between align-items-center">
                <h5 class="text-center background-modal color-text-tittle mb-0">Asistencias</h5>

                
                <button style="color: #9F2241;" onclick="mostrarModalCargaAsistencia();"
                    class="btn btn-circle-custom btn-outline-custom-red btn-light" data-toggle="tooltip" data-placement="top"
                    title="Power Bi Refresh">
                    <i class="fa fa-upload" style="color: #9F2241;"></i>
                </button>


                <button style="background:#235B4E;border: none" onclick="mostrarModalCargaAsistencia()" type="button"
                    class="btn btn-light" aria-haspopup="true" aria-expanded="false" data-toggle="tooltip"
                    data-placement="top" title="Agregar nuevo domicilio">
                    <i style="color:white" class="fa fa-upload icono-pequeno-tabla"></i>
                    <span class="hide-menu text-button-add"></span>
                </button>
            </div>
            <div class="card-body">
                <?php //include 'Asistencia/index.php'; ?>
            </div>
        </div>
-->

        <!--
        <div class="card font-size-modulo shadow-lg">
            <h5 class="card-header text-center background-modal color-text-tittle">Asistencias</h5>
            <div class="card-body">
                <?php  // include 'Asistencia/index.php' ?>
            </div>
        </div>-->
    </div>

    <div class="col-12 col-md-12 col-lg-12 col-xl-4 mb-4">
        <div class="card font-size-modulo shadow-lg">
            <h5 class="card-header text-center background-modal color-text-tittle">Parametros</h5>
            <div class="card-body">
                <?php include 'ConfAsistencia/index.php' ?>
            </div>
        </div>
    </div>

</div>


<!--
<div class="card font-size-modulo shadow-lg">
            <div style="background:#235B4E" class="card-header d-flex justify-content-between align-items-center">
                <h5 class="text-center background-modal color-text-tittle mb-0">Domicilio</h5>
                <button style="background:#235B4E;border: none" onclick="addDomiclio()" type="button" class="btn btn-light" 
                    aria-haspopup="true" aria-expanded="false" data-toggle="tooltip" data-placement="top" title="Agregar nuevo domicilio">
                    <i style="color:white" class="fa fa-plus icono-pequeno-tabla"></i>
                    <span class="hide-menu text-button-add"></span>
                </button>
            </div>
            <div class="card-body">
            <?php // include  'Domicilio/DomicilioP.php'; ?>
                <?php // include  'Domicilio/AgregarDomicilio.php'; ?>
            </div>
        </div>

-->