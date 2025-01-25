<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true" id="agregar_editar_movimiento">
    <div class="modal-dialog modal-lg modal-dialog-centered" style="max-width: 1000px;">
        <div class="modal-content">
            <!-- Encabezado del Modal -->
            <div class="modal-header background-modal">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-1">
                            <img src="../../../../assets/sirh/logo_movimiento.png" style="max-width: 120%; margin-top: 20px;">
                        </div>
                        <div class="col-11">
                            <h1 class="text-tittle-card"><label id="tituloMovimiento"></label> movimiento.</h1>
                            <p class="color-text-white">
                                Este espacio está destinado a registrar diversos cambios en el personal, tales como nuevas incorporaciones, salidas de empleados o movimientos dentro de la organización.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contenido del Modal -->
            <div class="div-spacing"></div>
            <div class="card-body">
                <div class="container">

                    <!-- Primera fila: Movimiento general y específico, Fecha de movimiento -->
                    <div class="row mx-1">
                        <div class="col-3">
                            <label for="movimiento_general" class="form-label input-text-form">Movimiento general</label>
                            <label class="text-required">*</label>
                            <select class="form-control div-spacing custom-select" id="movimiento_general" required></select>
                        </div>

                        <div class="col-4">
                            <label for="id_tbl_movimientos" class="form-label input-text-form">Movimiento espec&iacute;fico</label>
                            <label class="text-required">*</label>
                            <select class="form-control div-spacing custom-select" id="id_tbl_movimientos" required></select>
                        </div>

                        <div class="col-5">
                            <label for="fecha_movimiento" class="form-label input-text-form">Fecha de movimiento</label>
                            <label class="text-required">*</label>
                            <input type="date" class="form-control custom-input" id="fecha_movimiento" readonly>
                            <div class="line"></div>
                        </div>
                    </div>

                    <!-- Segunda fila: Número de plaza y fechas -->
                    <div id="ocultar_model">
                        <div class="div-spacing"></div>
                        <div class="row mx-1">
                            <div class="col-3">
                                <label for="id_tbl_control_plazas_hraes" class="form-label input-text-form">N&uacute;m. Plaza (VACANTES)</label>
                                <label class="text-required">*</label>
                                <select class="form-control div-spacing selectpicker" data-live-search="true"
                                    id="id_tbl_control_plazas_hraes" data-none-results-text="Sin resultados"></select>
                            </div>

                            <div class="col-3">
                                <label for="fecha_inicio" class="form-label input-text-form">Fecha de inicio</label>
                                <label class="text-required">*</label>
                                <input type="date" class="form-control custom-input" id="fecha_inicio">
                                <div class="line"></div>
                            </div>

                            <div class="col-4">
                                <label for="fecha_termino" class="form-label input-text-form">Fecha de t&eacute;rmino</label>
                                <input type="date" class="form-control custom-input" id="fecha_termino">
                                <div class="line"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Tercera fila: Observaciones -->
                    <div class="div-spacing"></div>
                    <div class="row mx-1">
                        <div class="col-9">
                            <label for="observaciones" class="form-label input-text-form">Observaciones</label>
                            <input type="text" class="form-control custom-input" id="observaciones" placeholder="Observaciones"
                                maxlength="70" onkeyup="convertirAMayusculas(event,'observaciones')">
                            <div class="line"></div>
                        </div>
                    </div>

                    <!-- Aviso y número de plaza provisional -->
                    <div id="ocultar_model_plaza">
                        <div class="div-spacing"></div>
                        <div class="row mx-1">
                            <div class="col-12">
                                <label for="observaciones" class="form-label input-text-form">Observaciones</label>
                                <input type="text" class="form-control custom-input" id="observaciones" placeholder="Observaciones"
                                    maxlength="70" onkeyup="convertirAMayusculas(event,'observaciones')">
                                <div class="line"></div>
                            </div>
                        </div>

                    <!-- Tercera fila: Observaciones -->
                    <div class="div-spacing"></div>
                    <div class="row mx-1">
                        <div class="col-9">
                            <label for="observaciones" class="form-label input-text-form">Observaciones</label>
                            <input type="text" class="form-control custom-input" id="observaciones" placeholder="Observaciones"
                                maxlength="70" onkeyup="convertirAMayusculas(event,'observaciones')">
                            <div class="line"></div>
                        </div>

                    </div>

                    <!-- Aviso y número de plaza provisional -->
                    <div id="ocultar_model_plaza">
                        <div class="div-spacing"></div>
                        <div class="row mx-1">
                            <div class="col-12">
                                <div class="custom-alert">
                                    <div class="d-flex align-items-center">
                                        <div class="mr-3" style="border-right: 2px solid #B87400;"></div>
                                        <p class="font-weight-bold">Importante: La plaza seleccionada es provisional, por favor ingresa el nuevo número de plaza asignado.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mx-1">
                            <div class="col-4">
                                <label for="num_plaza_new" class="form-label input-text-form">N&uacute;mero de plaza</label>
                                <label class="text-required">*</label>
                                <input type="number" class="form-control custom-input" id="num_plaza_new" placeholder="N&uacute;m. Plaza"
                                    maxlength="15" oninput="validarNumero(this)">
                                <div class="line"></div>
                            </div>
                        </div>
                    </div>

                </div>

                </div>
            </div>

            <!-- Pie del Modal -->
            <div class="div-spacing"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="salirAgregarEditarMovimiento();">
                    <i class="fas fa-times"></i> Cancelar
                </button>
                <button type="button" class="btn btn-success save-botton-modal" onclick="guardarMovimiento();">
                    <i class="fas fa-save"></i> Guardar
                </button>
                <input type="hidden" id="id_object">
                <input type="hidden" id="situacionPlaza">
            </div>
        </div>
    </div>
</div>

<!-- Script para autocompletar la fecha -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Función para obtener la fecha actual en formato yyyy-mm-dd
        function obtenerFechaActual() {
            const hoy = new Date();
            const anio = hoy.getFullYear();
            const mes = String(hoy.getMonth() + 1).padStart(2, '0');
            const dia = String(hoy.getDate()).padStart(2, '0');
            return `${anio}-${mes}-${dia}`; // Formato para inputs tipo date
        }

        // Asignar automáticamente la fecha actual al campo de fecha
        const fechaMovimientoInput = document.getElementById('fecha_movimiento');
        if (fechaMovimientoInput) {
            fechaMovimientoInput.value = obtenerFechaActual();
        }
    });

    // Actualizar el campo de fecha cuando se muestra el modal
    $('#agregar_editar_movimiento').on('shown.bs.modal', function () {
        const fechaMovimientoInput = document.getElementById('fecha_movimiento');
        if (fechaMovimientoInput && fechaMovimientoInput.value === '') {
            const hoy = new Date();
            const anio = hoy.getFullYear();
            const mes = String(hoy.getMonth() + 1).padStart(2, '0');
            const dia = String(hoy.getDate()).padStart(2, '0');
            fechaMovimientoInput.value = `${anio}-${mes}-${dia}`;
        }
    });
</script>
