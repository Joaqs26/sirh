<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true" id="agregar_editar_licencia">
    <div class="modal-dialog modal-lg modal-dialog-centered" style="max-width: 1000px;">
        <div class="modal-content">
            <div class="modal-header background-modal">
                <div class="container">
                    <div class="row">
                        <div class="col-1">
                            <img src="../../../../assets/sirh/logo_licencia.png"
                                style="max-width: 120%;margin-top: 20px;">
                        </div>
                        <div class="col-11">
                            <h1 class="text-tittle-card"><label id="titulolicencia"></label>
                                licencia.
                            </h1>
                            <p class="color-text-white">Este espacio está destinado para añadir, visualizar o modificar
                                información relacionada con licencias. Aquí puedes registrar nuevos tipos de licencias,
                                actualizar fechas así como gestionar observaciones
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="div-spacing"></div>
            <div class="card-body">
                <div class="container">
                    <div class="row mx-1">
                        <div class="col-3">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="campo" class="text-input-rem form-label input-text-form">Tipo de
                                        licencia</label>
                                    <label class="text-required">*</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <select class="form-control custom-select selectpicker"
                                        data-style="input-select-selectpicker" aria-label="Default select example"
                                        data-live-search="true" id="id_cat_tipo_licencia"
                                        data-none-results-text="Sin resultados">
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="campo" class="text-input-rem form-label input-text-form">Tipo de
                                        d&iacuteas</label>
                                    <label class="text-required">*</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <select class="form-control custom-select selectpicker"
                                        data-style="input-select-selectpicker" aria-label="Default select example"
                                        data-live-search="true" id="id_cat_tipo_dias"
                                        data-none-results-text="Sin resultados">
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="campo" class="text-input-rem form-label input-text-form">Estatus</label>
                                    <label class="text-required">*</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <select class="form-control custom-select selectpicker"
                                        data-style="input-select-selectpicker" aria-label="Default select example"
                                        data-live-search="true" id="id_cat_estatus_incidencias"
                                        data-none-results-text="Sin resultados">
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-3">
                            <label for="campo" class="text-input-rem form-label input-text-form">Horas</label><label
                                class="text-required"></label>
                            <input type="number" class="form-control custom-input" id="horas_max_dia"
                                name="codigo_postal" placeholder="Horas max por día" oninput="validarNumero(this)">
                            <div class="line"></div>
                        </div>
                    </div>

                    <div class="div-spacing"></div>
                    <div class="row mx-1">
                        <div class="col-3">
                            <label for="campo" class="text-input-rem form-label input-text-form">Fecha
                                inicio</label><label class="text-required">*</label>
                            <input type="date" id="fecha_desde_" class="form-control custom-input">
                            <div class="line"></div>
                        </div>
                        <div class="col-3">
                            <label for="campo" class="text-input-rem form-label input-text-form">Fecha fin</label><label
                                class="text-required">*</label>
                            <input type="date" id="fecha_hasta_" placeholder="Motivo" class="form-control custom-input">
                            <div class="line"></div>
                        </div>
                        <div class="col-3">
                            <label for="campo" class="text-input-rem form-label input-text-form">Fecha inicio
                                n&oacutemina</label><label class="text-required">*</label>
                            <input type="date" id="fecha_inicio_nom" placeholder="Motivo"
                                class="form-control custom-input">
                            <div class="line"></div>
                        </div>
                        <div class="col-3">
                            <label for="campo" class="text-input-rem form-label input-text-form">Fecha fin
                                n&oacutemina</label><label class="text-required">*</label>
                            <input type="date" id="fecha_fin_nomina" placeholder="Motivo"
                                class="form-control custom-input">
                            <div class="line"></div>
                        </div>
                    </div>

                    <div class="div-spacing"></div>
                    <div class="row mx-1">
                        <div class="col-3">
                            <label for="campo" class="text-input-rem form-label input-text-form">Fecha
                                registro</label><label class="text-required">*</label>
                            <input type="date" id="fecha_registro_" placeholder="Motivo"
                                class="form-control custom-input">
                            <div class="line"></div>
                        </div>
                        <div class="col-9">
                            <label for="campo"
                                class="text-input-rem form-label input-text-form">Observaciones</label><label
                                class="text-required"></label>
                            <input type="text" placeholder="Observaciones"
                                onkeyup="convertirAMayusculas(event,'observaciones_licencia')"
                                class="form-control custom-input" id="observaciones_licencia" maxlength="75">
                            <div class="line"></div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="div-spacing"></div>
            <div class="modal-footer">
                <button onclick="salirAgregarLicencia();" type="button" class="btn btn-secondary"
                    data-dismiss="modal"><i class="fas fa-times"></i> Cancelar</button>
                <button type="button" class="btn btn-success save-botton-modal" onclick="return validarLicencia();"><i
                        class="fas fa-save"></i> Guardar</button>
                <input type="hidden" id="id_object">
            </div>
        </div>
    </div>
</div>