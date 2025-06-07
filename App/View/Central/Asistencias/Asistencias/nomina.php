<div class="row font-size-modulo">
    <div class="col-9">
        <div class="form-inline">
            <button onclick="mostrarAgregar()" type="button" class="btn btn-light" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-plus icono-pequeno-tabla"></i>
                <span class="hide-menu text-button-add">&nbsp;Agregar asistencia</span>
            </button>
        </div>
    </div>
    <div class="col-3 search-container d-flex align-items-center">
        <button class="btn btn-light btn-circle" type="button" onclick="mostrarModalCargaAsistencia()" data-toggle="tooltip"
            title="Cargar masiva">
            <i class="fa fa-upload"></i>
        </button>
        <input onkeyup="buscarAsistencia();" id="buscar_asistencia" type="text" placeholder="Buscar..."
            class="form-control search-input" style="margin-left: 15px;"> <!-- Añadir margen aquí -->
        <span class="search-icon ml-2"><i class="fas fa-search"></i></span>
    </div>
</div>
<br>

<div class="row">
    <div class="col-12">
        <div class="col-12 table-responsive">
            <div class="text-center">
                <table class="table table-bordered table-fixed" id="tabla_asistencias_">
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="table-right">
            <button onclick="anteriorValor_ass()" class="btn btn-light"><i class="fa fa-angle-double-left"></i>
                <span class="hide-menu" style="font-weight: bold;"></span>
            </button>
            <label id="idtable_ass">1</label>
            <button onclick="siguienteValor_ass()" class="btn btn-light"><i class="fa fa-angle-double-right"></i>
                <span class="hide-menu" style="font-weight: bold;"></span>
            </button>
        </div>
    </div>
</div>

<?php include 'Detalles.php' ?>
<?php include 'Agregar.php' ?>