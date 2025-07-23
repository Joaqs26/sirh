<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="agregar_editar_incidencia">
    <div class="modal-dialog modal-lg modal-dialog-centered" style="max-width: 1000px;">
        <div class="modal-content">
            <div class="modal-header background-modal">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-2 text-center">
                            <img src="../../../../assets/sirh/logo_alarme.png" style="max-width: 120%;">
                        </div>
                        <div class="col-10">
                            <h1 class="text-tittle-card mb-1">
                                <label id="titulo_asistencia"></label> incidencia.
                            </h1>
                            <p class="color-text-white mb-0">
                                En esta sección puedes agregar y actualizar la información sobre las incidencias de los empleados. Aquí se gestionan todos los detalles relevantes y se mantienen actualizados.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="container">
                    <div id="ocultar_contenido_vacaciones">
                        <div class="row">
                            <div class="col-md-4 mb-2">
                                <fieldset disabled>
                                    <label class="form-label input-text-form text-input-rem">Días seleccionados</label>
                                    <input type="text" placeholder="Días seleccionados" class="form-control custom-input" id="is_dias_seleccionados">
                                </fieldset>
                            </div>
                            <div class="col-md-4 mb-2">
                                <fieldset disabled>
                                    <label class="form-label input-text-form text-input-rem">Días restantes</label>
                                    <input type="text" placeholder="Días restantes" class="form-control custom-input" id="is_dias_restantes">
                                </fieldset>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label class="form-label input-text-form text-input-rem">Periodo oficial <span class="text-required">*</span></label>
                                <select class="form-control custom-select" id="periodo_oficial_ins">
                                    <option value="">Selecciona un periodo</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-4">
                                <label class="form-label input-text-form text-input-rem">¿Es más de un día? <span class="text-required">*</span></label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="0" id="es_mas_de_un_dia">
                                    <label class="form-check-label custom-input">Sí</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6 mb-2">
                            <label class="form-label input-text-form text-input-rem">Tipo de incidencia <span class="text-required">*</span></label>
                            <select class="form-control custom-select selectpicker" data-style="input-select-selectpicker" aria-label="Default select example" data-live-search="true" id="id_cat_incidencias_ins" data-none-results-text="Sin resultados"></select>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label class="form-label input-text-form text-input-rem">Fecha de inicio <span class="text-required">*</span></label>
                            <input type="date" class="form-control custom-input" id="fecha_inicio_ins">
                        </div>
                        <div class="col-md-3 mb-2">
                            <fieldset disabled id="checkbox_disabled">
                                <label class="form-label input-text-form text-input-rem">Fecha fin <span class="text-required">*</span></label>
                                <input type="date" class="form-control custom-input" id="fecha_fin_ins">
                            </fieldset>
                        </div>
                    </div>

                    <div class="row mt-3" id="campo_num_oficio" style="display: none;">
                        <div class="col-md-6">
                            <label class="form-label input-text-form text-input-rem">No. de Oficio <span class="text-required">*</span></label>
                            <input type="text" class="form-control custom-input" id="num_oficio_ins" placeholder="Número de Oficio" maxlength="50">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6 mb-2">
                            <label class="form-label input-text-form text-input-rem">Folio</label>
                            <input type="text" class="form-control custom-input" id="observaciones_ins" placeholder="Observaciones" onkeyup="convertirAMayusculas(event,'observaciones_ins')" maxlength="50">
                        </div>
                        <div class="col-md-3 mb-2">
                            <label class="form-label input-text-form text-input-rem">Fecha de justificación <span class="text-required">*</span></label>
                            <input type="date" class="form-control custom-input" id="fecha_captura_ins">
                        </div>
                        <div class="col-md-3 mb-2">
                            <label class="form-label input-text-form text-input-rem">Hora de justificación</label>
                            <input type="time" class="form-control custom-input" id="hora_ins">
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button onclick="salirAgregarEditarIncidencia();" type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Cancelar
                </button>
                <button type="button" class="btn btn-success save-botton-modal" onclick="return validarIncidencia();">
                    <i class="fas fa-save"></i> Guardar
                </button>
                <input type="hidden" id="id_object">
            </div>
        </div>
    </div>
</div>
