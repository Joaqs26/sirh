<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true" id="agregar_editar_falta">
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
                            <h1 class="text-tittle-card"><label id="titulo_falta"></label>
                                falta.
                            </h1>
                            <p class="color-text-white">Área para registrar los tiempos de faltas del empleado.</p>
                        </div>
                    </div>
                </div>
            </div>





            <div class="div-spacing"></div>
            <div class="card-body">
                <div class="container">

                    <div class="col-12">
                        <label for="campo" class="form-label input-text-form text-input-rem">
                            ¿Es falta por retardo? <span class="text-required">*</span>
                        </label>
                        <div class="form-check div-spacing d-inline-block" style="margin-left: 5px;">
                            <input class="form-check-input" type="checkbox" value="0" id="es_por_retardo">
                            <label class="form-check-label" for="es_por_retardo">
                                Si
                            </label>
                        </div>
                    </div>

                    <div id="falta_">
                        <div class="row mx-1">
                            <div class="col-6">
                                <label for="campo" class="form-label input-text-form text-input-rem">Fecha desde
                                </label><label class="text-required">*</label>
                                <input type="date" class="form-control custom-input" id="fecha_desde_"
                                    placeholder="Nombre" maxlength="20">
                                <div class="line"></div>
                            </div>

                            <div class="col-6">
                                <label for="campo" class="form-label input-text-form text-input-rem">Fecha hasta
                                </label><label class="text-required">*</label>
                                <input type="date" class="form-control custom-input" id="fecha_hasta_"
                                    placeholder="Nombre" maxlength="20">
                                <div class="line"></div>
                            </div>
                        </div>

                        <div class="div-spacing"></div>
                        <div class="row mx-1">
                            <div class="col-6">
                                <label for="campo" class="form-label input-text-form text-input-rem">Fecha de registro
                                </label><label class="text-required">*</label>
                                <input type="date" class="form-control custom-input" id="fecha_registro_"
                                    placeholder="Nombre" maxlength="20">
                                <div class="line"></div>
                            </div>

                            <div class="col-6">
                                <label for="campo" class="form-label input-text-form text-input-rem">C&oacutedigo
                                    certificaci&oacuten</label><label class="text-required">*</label>
                                <input onkeyup="convertirAMayusculas(event,'codigo_certificacion_')" type="text"
                                    class="form-control custom-input" id="codigo_certificacion_"
                                    placeholder="Código certificación" maxlength="20">
                                <div class="line"></div>
                            </div>
                        </div>
                    </div>

                    <div id="falta_retardo">
                        <div class="row mx-1">
                            <div class="col-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="campo" class="form-label input-text-form text-input-rem">Tipo de
                                            falta</label>
                                        <label class="text-required">*</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <select class="form-control custom-select selectpicker"
                                            data-style="input-select-selectpicker" aria-label="Default select example"
                                            data-live-search="true" id="id_cat_retardo_tipo_"
                                            data-none-results-text="Sin resultados">
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="campo"
                                            class="form-label input-text-form text-input-rem">Estatus</label>
                                        <label class="text-required">*</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <select class="form-control custom-select selectpicker"
                                            data-style="input-select-selectpicker" aria-label="Default select example"
                                            data-live-search="true" id="id_cat_retardo_estatus_"
                                            data-none-results-text="Sin resultados">
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="div-spacing"></div>
                        <div class="row mx-1">
                            <div class="col-4">
                                <label for="campo" class="form-label input-text-form text-input-rem">Fecha
                                </label><label class="text-required">*</label>
                                <input type="date" class="form-control custom-input" id="fecha_" placeholder="Nombre"
                                    maxlength="20">
                                <div class="line"></div>
                            </div>

                            <div class="col-4">
                                <label for="campo" class="form-label input-text-form text-input-rem">Hora
                                </label><label class="text-required"></label>
                                <input type="time" class="form-control custom-input" id="hora_" placeholder="Nombre"
                                    maxlength="20">
                                <div class="line"></div>
                            </div>

                            <div class="col-4">
                                <label for="campo" class="form-label input-text-form text-input-rem">Cantidad
                                </label><label class="text-required">*</label>
                                <input type="Number" class="form-control custom-input" id="cantidad_"
                                    placeholder="Cantidad" maxlength="20" oninput="validarNumero(this)">
                                <div class="line"></div>
                            </div>
                        </div>
                    </div>

                    <div class="div-spacing"></div>
                    <div class="row mx-1">
                        <div class="col-12">
                            <label for="campo"
                                class="form-label input-text-form text-input-rem">Observaciones</label><label
                                class="text-required">*</label>
                            <input onkeyup="convertirAMayusculas(event,'observaciones_')" type="text"
                                class="form-control custom-input" id="observaciones_" placeholder="Observaciones"
                                maxlength="20">
                            <div class="line"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="div-spacing"></div>
            <div class="modal-footer">
                <button onclick="salirAgregarEditarFalta_();" type="button" class="btn btn-secondary"
                    data-dismiss="modal"><i class="fas fa-times"></i> Cancelar</button>
                <button type="button" class="btn btn-success save-botton-modal" onclick="return validarFalta_();"><i
                        class="fas fa-save"></i> Guardar</button>
                <input type="hidden" id="id_object">
            </div>
        </div>
    </div>
</div>
















<!--
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true" id="agregar_editar_falta">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header background-modal">
                <h5 class="modal-title text-modal-tittle"><label id="titulo_falta" class="text-modal-tittle"></label>
                    falta.</h5>
            </div>

            <div class="card-body">
                <div class="container">
                    <div class="row">
                        <div class="col-4">
                            <label class="text-input-form text-input-rem">Fecha (Desde)</label><label
                                class="text-required">*</label>
                            <input type="date" class="form-control" id="fecha_desde" placeholder="Nombre"
                                maxlength="20">
                        </div>
                        <div class="col-4">
                            <label class="text-input-form text-input-rem">Fecha (Hasta)</label><label
                                class="text-required">*</label>
                            <input type="date" class="form-control" id="fecha_hasta" placeholder="Nombre"
                                maxlength="20">
                        </div>
                        <div class="col-4">
                            <label class="text-input-form text-input-rem">Fecha (Registro)</label><label
                                class="text-required">*</label>
                            <input type="date" class="form-control" id="fecha_registro" placeholder="Nombre"
                                maxlength="20">
                        </div>
                    </div>

                    <div class="div-spacing"></div>
                    <diw class="row">
                        <div class="col-4">
                            <label class="text-input-form div-spacing text-input-rem">Código certificación</label><label
                                class="text-required">*</label>
                            <input onkeyup="convertirAMayusculas(event,'codigo_certificacion')" type="text" class="form-control" id="codigo_certificacion" placeholder="Código certificación"
                                maxlength="20">
                        </div>

                        <div class="col-8">
                            <label class="text-input-form div-spacing text-input-rem">Observaciones</label><label
                                class="text-required">*</label>
                            <input onkeyup="convertirAMayusculas(event,'Observaciones_falta')" type="text" class="form-control" id="Observaciones_falta" placeholder="Observaciones"
                                maxlength="40">
                        </div>
                    </diw>
                </div>
            </div>

            <div class="div-spacing"></div>
            <div class="modal-footer">
                <button onclick="salirAgregarEditarFalta_();" type="button" class="btn btn-secondary"
                    data-dismiss="modal"><i class="fas fa-times"></i> Cancelar</button>
                <button type="button" class="btn btn-success save-botton-modal" onclick="return validarFalta_();"><i
                        class="fas fa-save"></i> Guardar</button>
                <input type="hidden" id="id_object">
            </div>
        </div>
    </div>
</div>
-->