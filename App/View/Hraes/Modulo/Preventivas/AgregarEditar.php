<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true" id="agregar_editar_preventiva">
    <div class="modal-dialog modal-lg modal-dialog-centered" style="max-width: 900px;">
        <div class="modal-content">
            <div class="modal-header background-modal">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <img src="../../../../assets/sirh/logo_preventiva.png"
                                style="max-width: 150%;margin-top: 0px;">
                        </div>
                        <div class="col-12 col-sm-10">
                            <h1 class="text-tittle-card"><label id="titulo_preventiva"></label>
                                preventiva de pago.
                            </h1>
                            <p class="color-text-white">En esta sección, puedes agregar y actualizar la información
                                sobre las incidencias de los empleados. Aquí se gestionan todos los detalles relevantes
                                y se mantienen actualizados. </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="div-spacing"></div>
            <div class="card-body">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-3 mb-4">
                            <label for="campo" class="form-label input-text-form text-input-rem">Fecha de
                                inicio</label><label class="text-required">*</label>
                            <input type="date" class="form-control custom-input" id="fecha_inicio_pv">
                            <div class="line"></div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3 mb-4">
                            <label for="campo" class="form-label input-text-form text-input-rem">Fecha fin</label><label
                                class="text-required">*</label>
                            <input type="date" class="form-control custom-input" id="fecha_fin_pv">
                            <div class="line"></div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-2 mb-4">
                            <fieldset disabled>
                                <label for="campo" class="form-label input-text-form text-input-rem">Quincena</label>
                                <input type="text" placeholder="Quincena" class="form-control custom-input"
                                    id="quincena_pv">
                                <div class="line"></div>
                            </fieldset>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4 mb-4">
                            <fieldset disabled>
                                <label for="campo" class="form-label input-text-form text-input-rem">Periodo de
                                    quincena</label>
                                <input type="text" placeholder="Periodo de quincena" class="form-control custom-input"
                                    id="periodo_quincena_pv">
                                <div class="line"></div>
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-6 mb-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="campo" class="form-label input-text-form text-input-rem">Tipo de
                                        preventiva</label>
                                    <label class="text-required">*</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <select class="form-control custom-select selectpicker"
                                        data-style="input-select-selectpicker" aria-label="Default select example"
                                        data-live-search="true" id="id_cat_preventivas"
                                        data-none-results-text="Sin resultados">
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-6 mb-4">
                            <label for="campo" class="form-label input-text-form text-input-rem">No oficio
                            </label><label class="text-required">*</label>
                            <input type="text" class="form-control custom-input" id="no_oficio_pv"
                                placeholder="No oficio" onkeyup="convertirAMayusculas(event,'no_oficio_pv')"
                                maxlength="50">
                            <div class="line"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 mb-4">
                            <label for="campo" class="form-label input-text-form text-input-rem">Observaciones
                            </label><label class="text-required">*</label>
                            <input type="text" class="form-control custom-input" id="observaciones_pv"
                                placeholder="Observaciones" onkeyup="convertirAMayusculas(event,'observaciones_pv')"
                                maxlength="50">
                            <div class="line"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="div-spacing"></div>
            <div class="modal-footer">
                <button onclick="salirAgregarEditarPreventiva();" type="button" class="btn btn-secondary"
                    data-dismiss="modal"><i class="fas fa-times"></i> Cancelar</button>
                <button type="button" class="btn btn-success save-botton-modal" onclick="return validarPreventiva();"><i
                        class="fas fa-save"></i> Guardar</button>
                <input type="hidden" id="id_object">
            </div>
        </div>
    </div>
</div>