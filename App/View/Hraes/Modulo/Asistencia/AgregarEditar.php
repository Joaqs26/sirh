<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true" id="agregar_editar_asistencia">
    <div class="modal-dialog modal-lg modal-dialog-centered" style="max-width: 700px;">
        <div class="modal-content">
            <div class="modal-header background-modal">
                <div class="container">
                    <div class="row">
                        <div class="col-2">
                            <img src="../../../../assets/sirh/logo_asistencia.png"
                                style="max-width: 150%;margin-top: 0px;">
                        </div>
                        <div class="col-10">
                            <h1 class="text-tittle-card"><label id="titulo_asistencia"></label>
                                asistencia.
                            </h1>
                            <p class="color-text-white">Área destinada a registrar o actualizar las asistencias de los
                                empleados.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="div-spacing"></div>
            <div class="card-body">
                <div class="container">
                    <div class="row">
                        <div class="col-6">
                            <label for="campo" class="form-label input-text-form text-input-rem">Fecha</label><label
                                class="text-required">*</label>
                            <input type="date" class="form-control custom-input" id="fecha_ss_">
                            <div class="line"></div>
                        </div>
                        <div class="col-6">
                            <label for="campo" class="form-label input-text-form text-input-rem">Hora</label><label
                                class="text-required">*</label>
                            <input type="time" class="form-control custom-input" id="hora_ss_">
                            <div class="line"></div>
                        </div>
                    </div>

                    <div class="div-spacing"></div>
                    <div class="row">
                        <div class="col-6">
                            <label for="campo" class="form-label input-text-form text-input-rem">Nombre de
                                dispositivo</label><label class="text-required">*</label>
                            <input type="text" class="form-control custom-input" id="dispositivo_ss"
                                placeholder="Dispositivo biométrico" maxlength="30"
                                onkeyup="convertirAMayusculas(event,'dispositivo_ss')">
                            <div class="line"></div>
                        </div>
                        <div class="col-6">
                            <label for="campo" class="form-label input-text-form text-input-rem">Tipo de
                                verificaci&oacuten
                            </label><label class="text-required">*</label>
                            <input type="email" class="form-control custom-input" id="verificacion_ss"
                                placeholder="Tipo de verificación"
                                onkeyup="convertirAMayusculas(event,'verificacion_ss')" maxlength="30">
                            <div class="line"></div>
                        </div>
                    </div>

                    <div class="div-spacing"></div>
                    <div class="row">
                        <div class="col-6">
                            <label for="campo" class="form-label input-text-form text-input-rem">Estado</label><label
                                class="text-required">*</label>
                            <input type="email" class="form-control custom-input" id="estado_ss"
                                placeholder="Estado" maxlength="30" onkeyup="convertirAMayusculas(event,'estado_ss')">
                            <div class="line"></div>
                        </div>
                        <div class="col-6">
                            <label for="campo" class="form-label input-text-form text-input-rem">Evento</label><label
                                class="text-required">*</label>
                            <input type="text" class="form-control custom-input" id="evento_ss"
                                placeholder="Evento" onkeyup="convertirAMayusculas(event,'evento_ss')"
                                maxlength="30">
                            <div class="line"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="div-spacing"></div>
            <div class="modal-footer">
                <button onclick="salirAgregarEditarAsistencia();" type="button" class="btn btn-secondary"
                    data-dismiss="modal"><i class="fas fa-times"></i> Cancelar</button>
                <button type="button" class="btn btn-success save-botton-modal" onclick="return validarAsistencia();"><i
                        class="fas fa-save"></i> Guardar</button>
                <input type="hidden" id="id_object">
            </div>
        </div>
    </div>
</div>