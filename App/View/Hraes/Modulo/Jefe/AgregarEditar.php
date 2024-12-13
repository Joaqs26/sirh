<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true" id="agregar_editar_jefe">
    <div class="modal-dialog modal-lg modal-dialog-centered" style="max-width: 700px;">
        <div class="modal-content">
            <div class="modal-header background-modal">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <h1 class="text-tittle-card"><label id="tituloJefe"></label>
                                jefe inmediato.
                            </h1>
                        </div>
                    </div>
                </div>
            </div>

            <div class="div-spacing"></div>
            <div class="card-body">
                <div class="container">
                    <div class="row mx-1">
                        <div class="col-12">
                            <label for="campo" class="form-label input-text-form text-input-rem">Nombre de jefe inmediato</label><label
                                class="text-required">*</label>
                            <input onkeyup="convertirAMayusculas(event,'jefe_inmediato')" maxlength="60" type="text"
                                class="form-control div-spacing custom-input" id="jefe_inmediato"
                                placeholder="Nombre">
                            <div class="line"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="div-spacing"></div>
            <div class="modal-footer">
                <button onclick="salirAgregarEditarCedula();" type="button" class="btn btn-secondary"
                    data-dismiss="modal"><i class="fas fa-times"></i> Cancelar</button>
                <button type="button" class="btn btn-success save-botton-modal" onclick="return validarJefe();"><i
                        class="fas fa-save"></i> Guardar</button>
                <input type="hidden" id="id_object">
            </div>
        </div>
    </div>
</div>


