<div class="row font-size-modulo">
    <div class="col-9">
        <div class="form-inline">
            <button onclick="agregarEditarAsistencia_(null)" type="button" class="btn btn-light" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false"><i class="fa fa-plus icono-pequeno-tabla"></i>
                <span class="hide-menu text-button-add">&nbsp;Agregar</span>
            </button>
        </div>
    </div>
    <!--
    <div class="col-3">
        <div class="col text-right">
            <button style="color: #9F2241;" onclick="mostrarModalCargaAsistencia();" class="btn btn-circle-custom btn-outline-custom-red" data-toggle="tooltip"
                data-placement="top" title="Power Bi Refresh">
                <i class="fa fa-upload" style="color: #9F2241;"></i>
            </button>
        </div>
    </div>
-->
    <div class="col-3 search-container">
        <input onkeyup="buscarAsistencia();" id="buscar_ass" type="text" placeholder="Buscar..."
            class="form-control mr-sm-2 search-input-small">
        <span class="search-icon"><i class="fas fa-search"></i></span>
    </div>
</div>

<br>
<div class="col-12 table-responsive">
    <div class="text-center">
        <table class="table table-bordered table-fixed" id="tabla_asistencia">
        </table>
    </div>
</div>


<div class="row">
    <div class="col">
        <div class="table-right">
            <button onclick="anteriorValor_ss()" class="btn btn-light"><i class="fa fa-angle-double-left"></i>
                <span class="hide-menu" style="font-weight: bold;"></span>
            </button>
            <label id="idtable_ass">1</label>
            <button onclick="siguienteValor_ss()" class="btn btn-light"><i class="fa fa-angle-double-right"></i>
                <span class="hide-menu" style="font-weight: bold;"></span>
            </button>
        </div>
    </div>
</div>

<?php include 'AgregarEditar.php' ?>
<?php include 'ModalUsuario.php' ?>
<?php include 'CargaMasiva.php' ?>