<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true" id="verTabulacion">
    <div class="modal-dialog modal-lg modal-dialog-centered" style="max-width: 1200px;">
        <div class="modal-content">
            <div class="modal-header background-modal">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-sm-1">
                            <img src="../../../../assets/sirh/logo_plaza.png" style="max-width: 1000%;">
                        </div>
                        <div class="col-12 col-sm-11">
                            <h1 class="text-tittle-card">
                                <label id="titulo_plazas" class="text-modal-tittle"></label>
                                Tabulador.
                            </h1>
                            <p class="color-text-white">
                                Este espacio está destinado a conocer el tabulador de las plazas.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="div-spacing"></div>
            <div class="card-body">
                <div class="container">
                    <!-- 🔹 Primera fila -->
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <fieldset disabled>
                                <label for="codigo_puesto_actual" class="form-label input-text-form">Código Puesto</label>
                                <input type="text" class="form-control custom-input" id="codigo_puesto">
                            </fieldset>
                        </div>
                        <div class="col-md-3 mb-4">
                            <fieldset disabled>
                                <label for="sueldo_base" class="form-label input-text-form">Sueldo Base</label>
                                <input type="text" class="form-control custom-input currency-format" id="sueldo_base">
                            </fieldset>
                        </div>
                        <div class="col-md-3 mb-4">
                            <fieldset disabled>
                                <label for="ayuda_gastos_actualizacion" class="form-label input-text-form">Ayuda Gastos</label>
                                <input type="text" class="form-control custom-input currency-format" id="ayuda_gastos_actualizacion">
                            </fieldset>
                        </div>
                    </div>

                    <!-- 🔹 Segunda fila (Se eliminó Compensación Garantizada) -->
                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <fieldset disabled>
                                <label for="asignacion_bruta" class="form-label input-text-form">Asignación Bruta</label>
                                <input type="text" class="form-control custom-input currency-format" id="asignacion_bruta">
                            </fieldset>
                        </div>
                        <div class="col-md-3 mb-4">
                            <fieldset disabled>
                                <label for="compensacion_servicios" class="form-label input-text-form">Comp. Servicios</label>
                                <input type="text" class="form-control custom-input currency-format" id="compensacion_servicios">
                            </fieldset>
                        </div>
                        <div class="col-md-3 mb-4">
                            <fieldset disabled>
                                <label for="compensacion_polivalencia" class="form-label input-text-form">Comp. Polivalencia</label>
                                <input type="text" class="form-control custom-input currency-format" id="compensacion_polivalencia">
                            </fieldset>
                        </div>
                    </div>

                    <!-- 🔹 Tercera fila -->
                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <fieldset disabled>
                                <label for="total_bruto_mensual" class="form-label input-text-form">Total Bruto</label>
                                <input type="text" class="form-control custom-input currency-format" id="total_bruto_mensual">
                            </fieldset>
                        </div>
                        <div class="col-md-3 mb-4">
                            <fieldset disabled>
                                <label for="total_neto_mensual" class="form-label input-text-form">Total Neto</label>
                                <input type="text" class="form-control custom-input currency-format" id="total_neto_mensual">
                            </fieldset>
                        </div>
                        <div class="col-md-3 mb-4">
                            <fieldset disabled>
                                <label for="sueldo_quincenal_neto" class="form-label input-text-form">Sueldo Quincenal</label>
                                <input type="text" class="form-control custom-input currency-format" id="sueldo_quincenal_neto">
                            </fieldset>
                        </div>
                        <div class="col-md-3 mb-4">
                            <fieldset disabled>
                                <label for="zona_economica_tabulador" class="form-label input-text-form">Zona Económica</label>
                                <input type="text" class="form-control custom-input" id="zona_economica_tabulador">
                            </fieldset>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button onclick="ocultarModalTab();" type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times"></i> Cancelar
                        </button>
                        <input type="hidden" id="id_object">
                        <input type="hidden" id="id_tbl_centro_trabajo_hraes_aux">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Función para formatear los valores numéricos como moneda
function formatCurrency(value) {
    return value ? `$${parseFloat(value).toLocaleString('es-MX', { minimumFractionDigits: 2 })}` : '$0.00';
}

// Aplicar la función de formateo a los campos cuando se cargue el modal
$(document).ready(function () {
    $('#verTabulacion').on('shown.bs.modal', function () {
        $('.currency-format').each(function () {
            let value = $(this).val();
            $(this).val(formatCurrency(value));
        });
    });
});
</script>
