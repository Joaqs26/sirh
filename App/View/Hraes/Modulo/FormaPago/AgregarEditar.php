<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true" id="agregar_editar_forma_pago">
    <div class="modal-dialog modal-lg modal-dialog-centered" style="max-width: 700px;">
        <div class="modal-content">
            <div class="modal-header background-modal">
                <div class="container">
                    <div class="row">
                        <div class="col-2">
                            <img src="../../../../assets/sirh/logo_banco.png" style="max-width: 350%;margin-top: 0px;">
                        </div>
                        <div class="col-10">
                            <h1 class="text-tittle-card"><label id="tituloFormaPago"></label>
                                forma de pago.
                            </h1>
                            <p class="color-text-white">Espacio para ingresar o actualizar la información de pago del
                                empleado.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="div-spacing"></div>
            <div class="card-body">
                <div class="container">

                    <div class="row">
                        <div class="col-8">
                            <label for="campo" class="form-label input-text-form text-input-rem">Cuenta
                                clabe</label><label class="text-required">*</label>
                            <input onkeyup="validarCuenta();" type="number" class="form-control custom-input" id="clabe"
                                placeholder="Cuenta clabe" maxlength="18">
                            <div class="line"></div>
                        </div>
                        <div class="col-4">
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
                                        data-live-search="true" id="id_cat_estatus_formato_pago"
                                        data-none-results-text="Sin resultados">
                                    </select>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="div-spacing"></div>
                    <div class="div-spacing"></div>
                    <div class="row">
                        <div class="col-8">
                            <fieldset disabled>
                                <label for="campo" class="form-label input-text-form text-input-rem">Banco</label>
                                <input type="text" class="form-control custom-input" id="nombre_banco"
                                    placeholder="BANCO">
                                <div class="line"></div>
                            </fieldset>
                        </div>
                        <div class="col-4">
                            <fieldset disabled>
                                <label for="campo" class="form-label input-text-form text-input-rem">Forma de
                                    pago</label>
                                <input type="text" placeholder="TRANSFERENCIA" class="form-control custom-input">
                                <div class="line"></div>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </div>

            <div class="div-spacing"></div>
            <div class="modal-footer">
                <button onclick="salirAgregarEditarFormaPago();" type="button" class="btn btn-secondary"
                    data-dismiss="modal"><i class="fas fa-times"></i> Cancelar</button>
                <button type="button" class="btn btn-success save-botton-modal" onclick="return validarFormaPago();"><i
                        class="fas fa-save"></i> Guardar</button>
                <input type="hidden" id="id_object">
                <input type="hidden" id="id_cat_banco">
            </div>
        </div>
    </div>
</div>
