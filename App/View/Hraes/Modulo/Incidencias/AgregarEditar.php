<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true" id="agregar_editar_incidencia">
    <div class="modal-dialog modal-lg modal-dialog-centered" style="max-width: 1000px;">
        <div class="modal-content">
            <div class="modal-header background-modal">
                <div class="container">
                    <div class="row">
                        <div class="col-2">
                            <img src="../../../../assets/sirh/logo_alarme.png" style="max-width: 150%;margin-top: 0px;">
                        </div>
                        <div class="col-10">
                            <h1 class="text-tittle-card"><label id="titulo_asistencia"></label>
                                incidencia.
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
                    <div id="ocultar_contenido_vacaciones">
                        <div class="row">
                            <div class="col-3">
                                <fieldset disabled>
                                    <label for="campo" class="form-label input-text-form text-input-rem">D&iacuteas
                                        seleccionados</label>
                                    <input type="text" placeholder="Días seleccionados"
                                        class="form-control custom-input" id="is_dias_seleccionados">
                                    <div class="line"></div>
                                </fieldset>
                            </div>
                            <div class="col-3">
                                <fieldset disabled>
                                    <label for="campo" class="form-label input-text-form text-input-rem">D&iacuteas
                                        restantes</label>
                                    <input type="text" placeholder="Días restantes" class="form-control custom-input"
                                        id="is_dias_restantes">
                                    <div class="line"></div>
                                </fieldset>
                            </div>
                            <div class="col-3">
                                <fieldset disabled>
                                    <label for="campo" class="form-label input-text-form text-input-rem">Periodo</label>
                                    <input type="text" placeholder="Periodo" class="form-control custom-input"
                                        id="is_peridodo_ins">
                                    <div class="line"></div>
                                </fieldset>
                            </div>
                            <div class="col-3">
                                <label for="campo" class="form-label input-text-form text-input-rem">¿Es m&aacutes de un
                                    d&iacutea?</label><label class="text-required">*</label>
                                <div class="form-check div-spacing">
                                    <input class="form-check-input " type="checkbox" value="0" id="es_mas_de_un_dia">
                                    <label class="form-check-label custom-input" for="defaultCheck1">
                                        Si
                                    </label>
                                </div>
                            </div>
                        </div>
                        <br>
                    </div>


                    <div class="div-spacing"></div>
                    <div class="row">
                        <div class="col-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="campo" class="form-label input-text-form text-input-rem">Tipo de
                                        incidencia</label>
                                    <label class="text-required">*</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <select class="form-control custom-select selectpicker"
                                        data-style="input-select-selectpicker" aria-label="Default select example"
                                        data-live-search="true" id="id_cat_incidencias_ins"
                                        data-none-results-text="Sin resultados">
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <label for="campo" class="form-label input-text-form text-input-rem">Fecha de
                                inicio</label><label class="text-required">*</label>
                            <input type="date" class="form-control custom-input" id="fecha_inicio_ins">
                            <div class="line"></div>
                        </div>
                        <div class="col-3">
                            <fieldset disabled id="checkbox_disabled">
                                <label for="campo" class="form-label input-text-form text-input-rem">Fecha
                                    fin</label><label class="text-required">*</label>
                                <input type="date" class="form-control custom-input" id="fecha_fin_ins">
                                <div class="line"></div>
                            </fieldset>
                        </div>
                    </div>

                    <br>
                    <div class="div-spacing"></div>
                    <div class="row">
                        <div class="col-6">
                            <label for="campo" class="form-label input-text-form text-input-rem">Observaciones
                            </label><label class="text-required"></label>
                            <input type="text" class="form-control custom-input" id="observaciones_ins"
                                placeholder="Observaciones" onkeyup="convertirAMayusculas(event,'observaciones_ins')"
                                maxlength="50">
                            <div class="line"></div>
                        </div>
                        <div class="col-3">
                            <label for="campo" class="form-label input-text-form text-input-rem">Fecha de
                                de justificaci&oacuten</label><label class="text-required">*</label>
                            <input type="date" class="form-control custom-input" id="fecha_captura_ins">
                            <div class="line"></div>
                        </div>
                        <div class="col-3">
                            <label for="campo" class="form-label input-text-form text-input-rem">Hora de
                                justificaci&oacuten
                            </label><label class="text-required"></label>
                            <input type="time" class="form-control custom-input" id="hora_ins">
                            <div class="line"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="div-spacing"></div>
            <div class="modal-footer">
                <button onclick="salirAgregarEditarIncidencia();" type="button" class="btn btn-secondary"
                    data-dismiss="modal"><i class="fas fa-times"></i> Cancelar</button>
                <button type="button" class="btn btn-success save-botton-modal" onclick="return validarIncidencia();"><i
                        class="fas fa-save"></i> Guardar</button>
                <input type="hidden" id="id_object">
            </div>
        </div>
    </div>
</div>