<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true" id="agregar_editar_retardo">
    <div class="modal-dialog modal-lg modal-dialog-centered" style="max-width: 700px;">
        <div class="modal-content">
            <div class="modal-header background-modal">
                <div class="container">
                    <div class="row">
                        <div class="col-2">
                            <img src="../../../../assets/sirh/logo_retardo.png"
                                style="max-width: 150%;margin-top: 0px;">
                        </div>
                        <div class="col-10">
                            <h1 class="text-tittle-card"><label id="titulo_retardo"></label>
                                retardo.
                            </h1>
                            <p class="color-text-white">Área para registrar los tiempos de retrasos del empleado.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="div-spacing"></div>
            <div class="card-body">
                <div class="container">
                    <div class="row">
                        <div class="col-4">
                            <label for="campo" class="form-label input-text-form text-input-rem">Fecha</label><label
                                class="text-required">*</label>
                            <input type="date" class="form-control custom-input" id="fecha_rr">
                            <div class="line"></div>
                        </div>

                        <div class="col-4">
                            <label for="campo" class="form-label input-text-form text-input-rem">Hora</label><label class="text-required">*</label>
                            <input type="time" class="form-control custom-input" id="hora_ss">
                            <div class="line"></div>
                        </div>

                        <div class="col-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="campo" class="form-label input-text-form text-input-rem">Tipo de
                                        retardo</label>
                                    <label class="text-required">*</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <select class="form-control custom-select selectpicker"
                                        data-style="input-select-selectpicker" aria-label="Default select example"
                                        data-live-search="true" id="id_cat_retardo_tipo"
                                        data-none-results-text="Sin resultados">
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="div-spacing"></div>
                    <div class="row">
                        <div class="col-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="campo" class="form-label input-text-form text-input-rem">Retardo
                                        estatus</label>
                                    <label class="text-required">*</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <select class="form-control custom-select selectpicker"
                                        data-style="input-select-selectpicker" aria-label="Default select example"
                                        data-live-search="true" id="id_cat_retardo_estatus"
                                        data-none-results-text="Sin resultados">
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <fieldset disabled>
                                <label for="campo" class="form-label input-text-form text-input-rem">Quincena</label>
                                <input type="text" placeholder="Quincena" class="form-control custom-input"
                                    id="quincena_rr">
                                <div class="line"></div>
                            </fieldset>
                        </div>
                        <div class="col-4">
                            <fieldset disabled>
                                <label for="campo" class="form-label input-text-form text-input-rem">Periodo de
                                    quincena</label>
                                <input type="text" placeholder="Periodo de quincena" class="form-control custom-input"
                                    id="periodo_quincena_rr">
                                <div class="line"></div>
                            </fieldset>
                        </div>
                    </div>

                    <div class="div-spacing"></div>
                    <div class="row">
                        <div class="col-12">
                            <label for="campo"
                                class="form-label input-text-form text-input-rem">Observaciones</label><label
                                class="text-required">*</label>
                            <input type="text" placeholder="Observaciones" onkeyup="convertirAMayusculas(event,'observaciones_rr')" maxlength="40"
                                class="form-control custom-input" id="observaciones_rr">
                            <div class="line"></div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="div-spacing"></div>
            <div class="modal-footer">
                <button onclick="salirAgregarEditarRetardo_();" type="button" class="btn btn-secondary"
                    data-dismiss="modal"><i class="fas fa-times"></i> Cancelar</button>
                <button type="button" class="btn btn-success save-botton-modal"
                    onclick="return validarDependiente_();"><i class="fas fa-save"></i> Guardar</button>
                <input type="hidden" id="id_object">
            </div>
        </div>
    </div>
</div>