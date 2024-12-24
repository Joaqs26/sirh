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
                        <h4>HRAES</h4>
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
                    <h2 class="card-title tittle-card-index">Empleados</h2>
                </div>
                <div class="col-3 search-container">
                    <input onkeyup="buscarEmpleado();" id="buscar" type="text" placeholder="Buscar..."
                        class="form-control mr-sm-2 search-input">
                    <span class="search-icon"><i class="fas fa-search"></i></span>
                </div>
            </div>

            <div class="row div-spacing">
                <div class="col-9">
                    <div class="form-inline">
                        <button onclick="agregarEditarDetalles(null)" type="button" class="btn btn-light"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                class="fa fa-plus icono-pequeno-tabla"></i>
                            <span class="hide-menu text-button-add">&nbsp;Agregar</span>
                        </button>
                    </div>
                </div>
                <div class="col text-right">
                    <button onclick="powerBiRefresh();" class="btn btn-circle-custom btn-outline-custom"
                        data-toggle="tooltip" data-placement="top" title="Power Bi Refresh">
                        <i class="fa fa-line-chart" style="color: #235B4E;"></i> <!-- Icono de Font Awesome -->
                    </button>
                </div>
            </div>

            <div class="col-12 table-responsive">
                <div class="text-center">
                    <table class="table table-bordered table-fixed" id="tabla_empleados">
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="table-right">
                        <button onclick="anteriorValor()" class="btn btn-light"><i class="fa fa-angle-double-left"></i>
                            <span class="hide-menu" style="font-weight: bold;"></span>
                        </button>
                        <label id="idEmpleadotable">1</label>
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

<div class="overlay" id="overlay">
    <div class="spinner">
        <div class="spinner-border" role="status">
            <span class="sr-only">Cargando...</span>
        </div>
        <p class="mt-3" id="loaderMessage">Cargando...</p>
    </div>
</div>

<?php include '../../librerias.php' ?>
<?php include 'AgregarEditar.php' ?>

<script src="../../../../js/Hraes/Empleados/Empleados.js"></script>
<script src="../../../../js/Hraes/Empleados/validar.js"></script>
<script src="../../../../js/Hraes/Empleados/Busqueda.js"></script>
