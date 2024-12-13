<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true" id="is_modal_config_asistencia">
    <div class="modal-dialog modal-lg modal-dialog-centered" style="max-width: 700px;">
        <div class="modal-content">
            <div class="modal-header background-modal">
                <div class="container">
                    <div class="row">
                        <div class="col-2">
                            <img src="../../../../assets/sirh/logo_config.png" style="max-width: 150%;margin-top: 0px;">
                        </div>
                        <div class="col-10">
                            <h1 class="text-tittle-card"><label id=""></label>
                                Actualizar información.
                            </h1>
                            <p class="color-text-white">Actualiza la información sobre la configuración del dispositivo
                                biométrico y la jornada asignada al empleado.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="div-spacing"></div>
            <div class="card-body">
                <div class="container">


                    <div class="row">
                        <div class="col-6">
                            <label for="campo" class="form-label input-text-form text-input-rem">No
                                biométrico</label><label class="text-required">*</label>
                            <input type="number" class="form-control custom-input" id="no_dispositivo_ass"
                                placeholder="Id asignado por biométrico" oninput="validarNumero(this)">
                            <div class="line"></div>
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="campo" class="form-label input-text-form text-input-rem">Estatus</label>
                                    <label class="text-required">*</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <select class="form-control custom-select selectpicker"
                                        data-style="input-select-selectpicker" aria-label="Default select example"
                                        data-live-search="true" id="id_cat_asistencia_estatus"
                                        data-none-results-text="Sin resultados">
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="div-spacing"></div>
                    <div class="row">
                        <div class="col-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="campo" class="form-label input-text-form text-input-rem">Turno</label>
                                    <label class="text-required">*</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <select class="form-control custom-select selectpicker"
                                        data-style="input-select-selectpicker" aria-label="Default select example"
                                        data-live-search="true" id="id_cat_jornada_turno"
                                        data-none-results-text="Sin resultados">
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="campo" class="form-label input-text-form text-input-rem">Jornada</label>
                                    <label class="text-required">*</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <select class="form-control custom-select selectpicker"
                                        data-style="input-select-selectpicker" aria-label="Default select example"
                                        data-live-search="true" id="id_cat_jornada_dias"
                                        data-none-results-text="Sin resultados">
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="div-spacing"></div>
                    <div class="row">
                        <div class="col-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="campo" class="form-label input-text-form text-input-rem">Horario</label>
                                    <label class="text-required">*</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <select class="form-control custom-select selectpicker"
                                        data-style="input-select-selectpicker" aria-label="Default select example"
                                        data-live-search="true" id="id_cat_jornada_horario"
                                        data-none-results-text="Sin resultados">
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="campo"
                                        class="form-label input-text-form text-input-rem">Ubicaci&oacuten</label>
                                    <label class="text-required">*</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <select class="form-control custom-select selectpicker"
                                        data-style="input-select-selectpicker" aria-label="Default select example"
                                        data-live-search="true" id="id_cat_asistencia_ubicacion"
                                        data-none-results-text="Sin resultados">
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="div-spacing"></div>
                    <div class="row">
                        <div class="col-12">
                            <label for="campo"
                                class="form-label input-text-form text-input-rem">Observaciones</label><label
                                class="text-required">*</label>
                            <input type="text" class="form-control custom-input"
                                onkeyup="convertirAMayusculas(event,'observaciones_ass')" id="observaciones_ass"
                                placeholder="Observaciones" maxlength="25">
                            <div class="line"></div>
                        </div>
                    </div>

                    <div id="id_estatus_is_div">
                        <br>
                        <div class="alert alert-warning" role="alert">
                            El estatus 'EXCLUIDO' no considerará las asistencias durante el periodo que se detalla a
                            continuación. Una vez finalizado dicho periodo, el estatus cambiará a 'ACTIVO' y las
                            asistencias comenzarán a contabilizarse.
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <label for="campo" class="text-input-rem form-label input-text-form">Fecha de
                                    inicio</label><label class="text-required">*</label>
                                <input type="date" class="form-control custom-input" id="fecha_inicio_ss"
                                    placeholder="">
                                <div class="line"></div>
                            </div>
                            <div class="col-4">
                                <label for="campo" class="text-input-rem form-label input-text-form">Fecha
                                    de fin</label><label class="text-required">*</label>
                                <input type="date" class="form-control custom-input" id="fecha_fin_ss"
                                    placeholder="">
                                <div class="line"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="div-spacing"></div>
            <div class="modal-footer">
                <button onclick="ocultarModalConfigAsistencia();" type="button" class="btn btn-secondary"
                    data-dismiss="modal"><i class="fas fa-times"></i> Cancelar</button>
                <button type="button" class="btn btn-success save-botton-modal"
                    onclick="return validadConfAsistencia();"><i class="fas fa-save"></i> Guardar</button>
                <input type="hidden" id="id_ctrl_jornada">
                <input type="hidden" id="id_ctrl_asistencia_info">
            </div>
        </div>
    </div>
</div>