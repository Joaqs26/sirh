<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true" id="agregar_editar_modal">
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
                                Plaza.
                            </h1>
                            <p class="color-text-white">
                                Este espacio está destinado a agregar o modificar información relacionada con plazas. 
                                Aquí puedes ingresar nuevos datos o actualizar los existentes según sea necesario.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="div-spacing"></div>
            <div class="card-body">
                <div class="container">
                    <div class="row mx-1">
                        <div class="col-12 col-md-4 col-lg-3 mb-4">
                            <fieldset disabled>
                                <label for="campo" class="form-label input-text-form">Zona pagadora</label>
                                <input type="text" placeholder="Zona pagadora" class="form-control custom-input"
                                    id="id_zona_pagadora_clue">
                                <div class="line"></div>
                            </fieldset>
                        </div>

                        <div class="col-12 col-md-4 col-lg-2 mb-4">
                            <fieldset disabled>
                                <label for="campo" class="form-label input-text-form">Nivel de puesto</label>
                                <input type="text" placeholder="Nivel" class="form-control custom-input"
                                    id="id_cat_niveles_hraes">
                                <div class="line"></div>
                            </fieldset>
                        </div>

                        <div class="col-12 col-md-4 col-lg-3 mb-4">
                            <label for="campo" class="form-label input-text-form">Número de plaza</label>
                            <label class="text-required">*</label>
                            <input minlength="7" type="number" class="form-control custom-input" id="num_plaza"
                                placeholder="Número de plaza" oninput="validarNumero(this)">
                            <div class="line"></div>
                        </div>

                        <div class="col-12 col-md-8 col-lg-4 mb-4">
                            <label for="campo" class="form-label input-text-form">Tipo de plaza</label>
                            <label class="text-required">*</label>
                            <select class="form-control custom-select selectpicker" data-live-search="true"
                                id="id_cat_plazas" data-none-results-text="Sin resultados">
                            </select>
                        </div>
                    </div>

                    <div class="row mx-1">
                        <div class="col-12 col-md-6 col-lg-5 mb-4">
                            <label for="campo" class="form-label input-text-form">Puesto</label>
                            <label class="text-required">*</label>
                            <select class="form-control custom-select selectpicker" data-live-search="true"
                                id="id_cat_puesto_hraes" data-none-results-text="Sin resultados">
                            </select>
                        </div>

                        <div class="col-12 col-md-6 col-lg-4 mb-4">
                            <label for="campo" class="form-label input-text-form">Puesto específico</label>
                            <label class="text-required">*</label>
                            <select class="form-control custom-select selectpicker" data-live-search="true"
                                id="id_cat_aux_puesto" data-none-results-text="Sin resultados">
                            </select>
                        </div>

                        <div class="col-12 col-md-6 col-lg-3 mb-4">
                            <label for="campo" class="form-label input-text-form">Categoría de puesto</label>
                            <label class="text-required">*</label>
                            <select class="form-control custom-select selectpicker" data-live-search="true"
                                id="id_cat_categoria_puesto" data-none-results-text="Sin resultados">
                            </select>
                        </div>
                    </div>

                    <div class="row mx-1">
                        <div class="col-12 col-md-6 col-lg-4 mb-4">
                            <label for="campo" class="form-label input-text-form">Contratación</label>
                            <label class="text-required">*</label>
                            <select class="form-control custom-select selectpicker" data-live-search="true"
                                id="id_cat_tipo_contratacion" data-none-results-text="Sin resultados">
                            </select>
                        </div>

                        <div class="col-12 col-md-6 col-lg-4 mb-4">
                            <label for="campo" class="form-label input-text-form">Programa</label>
                            <label class="text-required">*</label>
                            <select class="form-control custom-select selectpicker" data-live-search="true"
                                id="id_cat_tipo_programa" data-none-results-text="Sin resultados">
                            </select>
                        </div>
                    </div>

                    <div class="row mx-1">
                        <div class="col-12 col-md-6 col-lg-6 mb-4">
                            <label for="campo" class="form-label input-text-form">Unidad administrativa</label>
                            <label class="text-required">*</label>
                            <select class="form-control custom-select selectpicker" data-live-search="true"
                                id="id_cat_unidad" data-none-results-text="Sin resultados">
                            </select>
                        </div>

                        <div class="col-12 col-md-6 col-lg-6 mb-4">
                            <label for="campo" class="form-label input-text-form">Coordinación</label>
                            <label class="text-required">*</label>
                            <select class="form-control custom-select selectpicker" data-live-search="true"
                                id="id_cat_coordinacion" data-none-results-text="Sin resultados">
                            </select>
                        </div>
                    </div>

                    <div class="row mx-1">
                        <div class="col-12 col-md-6 col-lg-3 mb-4">
                            <label for="campo" class="form-label input-text-form">Fecha inicio</label>
                            <input type="date" class="form-control custom-input" id="is_fecha_inicio">
                            <div class="line"></div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-3 mb-4">
                            <label for="campo" class="form-label input-text-form">Fecha fin</label>
                            <input type="date" class="form-control custom-input" id="is_fecha_fin">
                            <div class="line"></div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="modal-footer">
                <button onclick="ocultarModal();" type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Cancelar
                </button>
                <button type="button" class="btn btn-success save-botton-modal" onclick="return validar();">
                    <i class="fas fa-save"></i> Guardar
                </button>
                <input type="hidden" id="id_object">
                <input type="hidden" id="id_tbl_centro_trabajo_hraes_aux">
            </div>
        </div>
    </div>
</div>
