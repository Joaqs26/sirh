<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true" id="agregar_editar_modal">
    <div class="modal-dialog modal-lg modal-dialog-centered" style="max-width: 1000px;">
        <div class="modal-content">
            <div class="modal-header background-modal">
                <div class="container">
                    <div class="row">
                        <div class="col-2">
                            <img src="../../../../assets/sirh/logo_empleado.png" style="max-width: 400%;">
                        </div>
                        <div class="col-10">
                            <h1 class="text-tittle-card"><label id="titulo"></label>
                                empleado.
                            </h1>
                            <p class="color-text-white">Este espacio está destinado a agregar o modificar información
                                relacionada con empleados. Aquí puedes ingresar nuevos datos o actualizar los
                                existentes según sea necesario.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="div-spacing"></div>
            <div class="card-body">
                <div class="container">
                    <div class="row mx-1">
                        <div class="col-4">
                            <label for="campo" class="form-label input-text-form">Nombre</label><label
                                class="text-required">*</label>
                            <input onkeyup="convertirAMayusculas(event,'nombre')" maxlength="45" type="text"
                                class="form-control div-spacing custom-input" id="nombre" placeholder="Nombre" required>
                            <div class="line"></div>
                        </div>
                        <div class="col-4">
                            <label for="campo" class="form-label input-text-form">Apellido paterno</label><label
                                class="text-required">*</label>
                            <input onkeyup="convertirAMayusculas(event,'primer_apellido')" maxlength="25" type="text"
                                class="form-control div-spacing custom-input" id="primer_apellido"
                                placeholder="Apellido paterno">
                            <div class="line"></div>
                        </div>
                        <div class="col-4">
                            <label for="campo" class="form-label input-text-form">Apellido materno</label><label
                                class="text-required">*</label>
                            <input onkeyup="convertirAMayusculas(event,'segundo_apellido')" maxlength="25" type="text"
                                class="form-control div-spacing custom-input" id="segundo_apellido"
                                placeholder="Apellido materno">
                            <div class="line"></div>
                        </div>
                    </div>

                    <div class="div-spacing"></div>
                    <div class="row mx-1">
                        <div class="col-4">
                            <label for="campo" class="form-label input-text-form">Rfc</label><label
                                class="text-required">*</label>
                            <input onkeyup="convertirAMayusculas(event,'rfc')" maxlength="13" type="text"
                                class="form-control div-spacing custom-input" id="rfc" placeholder="Rfc">
                            <div class="line"></div>
                        </div>
                        <div class="col-4">
                            <label for="campo" class="form-label input-text-form">Curp</label><label
                                class="text-required">*</label>
                            <input onkeyup="obtenerGenero();" maxlength="18" type="text"
                                class="form-control div-spacing custom-input" id="curp" placeholder="Curp">
                            <div class="line"></div>
                        </div>
                        <div class="col-4">
                            <label for="campo" class="form-label input-text-form">N&uacutemero de empleado</label><label
                                class="text-required"></label>
                            <input onkeyup="convertirAMayusculas(event,'num_empleado')" maxlength="30" type="text"
                                class="form-control div-spacing custom-input" id="num_empleado"
                                placeholder="Núm de empleado">
                            <div class="line"></div>
                        </div>
                    </div>

                    <div class="div-spacing"></div>
                    <div class="row mx-1">
                        <div class="col-3">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="campo" class="form-label input-text-form">Pa&iacutes de
                                        nacimiento</label>
                                    <label class="text-required">*</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <select class="form-control custom-select selectpicker"
                                        data-style="input-select-selectpicker" aria-label="Default select example"
                                        data-live-search="true" id="id_cat_pais_nacimiento"
                                        data-none-results-text="Sin resultados">
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="campo" class="form-label input-text-form">Estado de nacimiento</label>
                                    <label class="text-required">*</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <select class="form-control custom-select selectpicker"
                                        data-style="input-select-selectpicker" aria-label="Default select example"
                                        data-live-search="true" id="id_cat_estado_nacimiento"
                                        data-none-results-text="Sin resultados">
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="campo" class="form-label input-text-form">Nacionalidad</label>
                                    <label class="text-required">*</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <select class="form-control custom-select selectpicker"
                                        data-style="input-select-selectpicker" aria-label="Default select example"
                                        data-live-search="true" id="nacionalidad"
                                        data-none-results-text="Sin resultados">
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                        <div class="row">
                                <div class="col-md-12">
                                    <label for="campo" class="form-label input-text-form">Estado civil</label>
                                    <label class="text-required">*</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <select class="form-control custom-select selectpicker"
                                        data-style="input-select-selectpicker" aria-label="Default select example"
                                        data-live-search="true" id="id_cat_estado_civil"
                                        data-none-results-text="Sin resultados">
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="div-spacing"></div>
                    <div class="row mx-1">
                        <div class="col-3">
                            <fieldset disabled>
                                <label for="campo" class="form-label input-text-form">G&eacutenero</label>
                                <input type="text" placeholder="Género" class="form-control custom-input" id="genero_x">
                                <div class="line"></div>
                            </fieldset>
                        </div>
                        <div class="col-3">
                            <label for="campo" class="form-label input-text-form">NSS</label><label
                                class="text-required">*</label>
                            <input type="number" oninput="validarNumero(this)" class="form-control custom-input"
                                id="nss" placeholder="Número de seguro social">
                            <div class="line"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="div-spacing"></div>
            <div class="modal-footer">
                <button onclick="ocultarModal();" type="button" class="btn btn-secondary" data-dismiss="modal"><i
                        class="fas fa-times"></i> Cancelar</button>
                <button type="button" class="btn btn-success save-botton-modal" onclick="return validar();"><i
                        class="fas fa-save"></i> Guardar</button>
                <input type="hidden" id="id_object">
            </div>
        </div>
    </div>
</div>

<!--
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true" id="agregar_editar_modal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header background-modal">
                <h5 class="modal-title text-modal-tittle"><label id="titulo" class="text-modal-tittle"></label>
                    empleado.</h5>
            </div>

            <div class="div-spacing"></div>
            <div class="card-body">
                <div class="container">

                    <div class="row">
                        <div class="col-6">
                            <label class="text-input-form div-spacing">Nombre</label><label
                                class="text-required">*</label>
                            <input onkeyup="convertirAMayusculas(event,'nombre')" maxlength="45" type="text"
                                class="form-control" id="nombre" placeholder="Nombre" required>
                        </div>
                        <div class="col-6">
                            <label class="text-input-form div-spacing">Apellido paterno</label><label
                                class="text-required">*</label>
                            <input onkeyup="convertirAMayusculas(event,'primer_apellido')" maxlength="25" type="text"
                                class="form-control" id="primer_apellido" placeholder="Apellido paterno">
                        </div>
                    </div>

                    <div class="div-spacing"></div>
                    <div class="row">
                        <div class="col-6">
                            <label class="text-input-form div-spacing">Apelldio materno</label><label
                                class="text-required">*</label>
                            <input onkeyup="convertirAMayusculas(event,'segundo_apellido')" maxlength="25" type="text"
                                class="form-control" id="segundo_apellido" placeholder="Apellido materno">
                        </div>
                        <div class="col-6">
                            <label class="text-input-form div-spacing">Rfc</label><label class="text-required">*</label>
                            <input onkeyup="convertirAMayusculas(event,'rfc')" maxlength="13" type="text"
                                class="form-control" id="rfc" placeholder="Rfc">
                        </div>
                    </div>

                    <div class="div-spacing"></div>
                    <div class="row">
                        <div class="col-6">
                            <label class="text-input-form div-spacing">Curp</label><label
                                class="text-required">*</label>
                            <input onkeyup="obtenerGenero();" maxlength="18" type="text" class="form-control" id="curp"
                                placeholder="Curp">
                        </div>

                        <div class="col-6">
                            <label class="text-input-form div-spacing">N&uacutem. de empleado</label><label
                                class="text-required">*</label>
                            <input onkeyup="convertirAMayusculas(event,'num_empleado')" maxlength="30" type="text"
                                class="form-control" id="num_empleado" placeholder="Núm de empleado">
                        </div>
                    </div>

                    <div class="div-spacing"></div>
                    <div class="row">
                        <div class="col-4">
                            <label class="text-input-form div-spacing text-input-rem">Pa&iacutes de
                                nacimiento</label><label class="text-required">*</label>
                            <div class="custom-select-wrapper">
                                <select class="form-control div-spacing" aria-label="Default select example"
                                    id="id_cat_pais_nacimiento" required>
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <label class="text-input-form div-spacing text-input-rem">Estado de nacimiento</label><label
                                class="text-required"></label>
                            <div class="custom-select-wrapper">
                                <select class="form-control div-spacing" aria-label="Default select example"
                                    id="id_cat_estado_nacimiento" required>
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <label class="text-input-form div-spacing text-input-rem">Nacionalidad</label><label
                                class="text-required"></label>
                            <div class="custom-select-wrapper">
                                <select class="form-control div-spacing" aria-label="Default select example"
                                    id="nacionalidad" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="div-spacing"></div>
                    <div class="row">
                        <div class="col-4">
                            <label class="text-input-form div-spacing">G&eacutenero</label><label
                                class="text-required">*</label>
                            <fieldset disabled>
                                <input type="text" class="form-control" id="genero_x" placeholder="Género"
                                    maxlength="25">
                            </fieldset>
                        </div>

                        <div class="col-4">
                            <label class="text-input-form div-spacing">Estado civil</label><label
                                class="text-required">*</label>
                            <div class="custom-select-wrapper">
                                <select class="form-control" aria-label="Default select example"
                                    id="id_cat_estado_civil" required>
                                </select>
                            </div>
                        </div>

                        <div class="col-4">
                            <label class="text-input-form div-spacing">N&uacutemero de seguro social</label><label
                                class="text-required"></label>
                            <input type="number" oninput="validarNumero(this)" class="form-control" id="nss"
                                placeholder="Número de seguro social">
                        </div>
                    </div>
                </div>
            </div>

            <div class="div-spacing"></div>
            <div class="modal-footer">
                <button onclick="ocultarModal();" type="button" class="btn btn-secondary" data-dismiss="modal"><i
                        class="fas fa-times"></i> Cancelar</button>
                <button type="button" class="btn btn-success save-botton-modal" onclick="return validar();"><i
                        class="fas fa-save"></i> Guardar</button>
                <input type="hidden" id="id_object">
            </div>

        </div>
    </div>
</div>
-->