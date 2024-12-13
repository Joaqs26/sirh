


<style>
    .bootstrap-select:hover .dropdown-toggle {
      background-color: #f8f9fa; /* Cambia aquí el color cuando el cursor está encima */
      /*border-color: red; /* Cambia aquí el color del borde cuando el cursor está encima */
    }

  </style>

<div class="row font-size-modulo">
    <div class="col-9">
        <div class="form-inline">
            <button onclick="agregarEditarMovimiento(null)" class="btn btn-light"><i
                    class="fa fa-plus icon-size-add"></i>
                <span class="hide-menu text-button-add font-size-modulo">&nbsp;Agregar movimiento</span>
            </button>
        </div>
    </div>
    <div class="col-3 search-container">
        <input onkeyup="buscarMovimiento();" id="buscar_mv_text" type="text" placeholder="Buscar..."
            class="form-control mr-sm-2 search-input-small">
        <span class="search-icon"><i class="fas fa-search"></i></span>
    </div>
</div>

<br>
<div class="row">
    <div class="col">
        <div class="text-center">
            <table class="table table-bordered" id="tabla_movimientos" style="width:100%">
            </table>
        </div>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="table-right">
            <button onclick="anteriorValor_mv()" class="btn btn-light"><i class="fa fa-angle-double-left"></i>
                <span class="hide-menu" style="font-weight: bold;"></span>
            </button>
            <label id="idtable_mv">1</label>
            <button onclick="siguienteValor_mv()" class="btn btn-light"><i class="fa fa-angle-double-right"></i>
                <span class="hide-menu" style="font-weight: bold;"></span>
            </button>
        </div>
    </div>
</div>

<?php include 'AgregarEditar.php' ?>
