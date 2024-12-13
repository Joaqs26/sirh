<style>
    .form-check-input:checked {
        background-color: #78808d;
        border-color: #6d737d;
    }

    .form-check-input[type=checkbox] {
        border-radius: .45em;
    }

    .form-check .form-check-input {
        float: none; 
        margin-left: 1.5em; 
    }

    .form-check-input {
        --bs-form-check-bg: var(--bs-body-bg);
        flex-shrink: 0;
        width: 1.5em;
        height: 1.5em;
        margin-top: .25em;
        vertical-align: top;
    }
</style>

<div class="row font-size-modulo">
    <div class="col-9">
        <div class="form-inline">
            <button onclick="agregarEditarIncidencia(null)" type="button" class="btn btn-light" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false"><i class="fa fa-plus icono-pequeno-tabla"></i>
                <span class="hide-menu text-button-add">&nbsp;Agregar</span>
            </button>
        </div>
    </div>
    <div class="col-3 search-container">
        <input onkeyup="buscarIncidencia();" id="buscar_ins" type="text" placeholder="Buscar..."
            class="form-control mr-sm-2 search-input-small">
        <span class="search-icon"><i class="fas fa-search"></i></span>
    </div>
</div>

<br>
<div class="col-12 table-responsive">
    <div class="text-center">
        <table class="table table-bordered table-fixed" id="tabla_incidencia">
        </table>
    </div>
</div>


<div class="row">
    <div class="col">
        <div class="table-right">
            <button onclick="anteriorValor_ins()" class="btn btn-light"><i class="fa fa-angle-double-left"></i>
                <span class="hide-menu" style="font-weight: bold;"></span>
            </button>
            <label id="idtable_ins">1</label>
            <button onclick="siguienteValor_ins()" class="btn btn-light"><i class="fa fa-angle-double-right"></i>
                <span class="hide-menu" style="font-weight: bold;"></span>
            </button>
        </div>
    </div>
</div>

<?php include 'AgregarEditar.php' ?>