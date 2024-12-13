<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true" id="agregar_editar_modal">
    <div class="modal-dialog modal-lg modal-dialog-centered" style="max-width: 1000px;">
        <div class="modal-content">
            <div class="modal-header background-modal">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <img src="../../../../assets/sirh/logo_centro_trabajo.png" style="max-width: 300%;">
                        </div>
                        <div class="col-12 col-sm-10">
                            <h1 class="text-tittle-card"><label id="titulo_centro_trabajo"></label> centro de trabajo.
                            </h1>
                            <p class="color-text-white">Este espacio está destinado a agregar o modificar información
                                relacionada con un centro de trabajo. Aquí puedes ingresar nuevos datos o actualizar los
                                existentes según sea necesario.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="container">
                    <div class="row mx-1">
                        <div class="col-12 col-md-8 mb-4">
                            <label for="campo" class="form-label input-text-form">Nombre</label><label
                                class="text-required">*</label>
                            <input onkeyup="convertirAMayusculas(event,'nombre')" maxlength="60" type="text"
                                class="form-control custom-input" id="nombre" name="nombre" placeholder="Nombre"
                                required>
                            <div class="line"></div>
                        </div>
                        <div class="col-12 col-md-4 mb-4">
                            <label for="campo" class="form-label input-text-form">Clave</label><label
                                class="text-required">*</label>
                            <input maxlength="15" type="text" class="form-control  custom-input"
                                id="clave_centro_trabajo" onkeyup="convertirAMayusculas(event, 'clave_centro_trabajo')"
                                name="clave_centro_trabajo" placeholder="Clave de centro de trabajo">
                            <div class="line"></div>
                        </div>
                    </div>

                    <div class="row mx-1">
                        <div class="col-12 col-md-6 mb-4">
                            <label for="campo" class="form-label input-text-form">Colonia</label><label
                                class="text-required">*</label>
                            <input maxlength="30" type="text" class="form-control  custom-input" id="colonia"
                                onkeyup="convertirAMayusculas(event,'colonia')" name="colonia" placeholder="Colonia">
                            <div class="line"></div>
                        </div>
                        <div class="col-12 col-md-3 mb-4">
                            <label for="campo" class="form-label input-text-form">N&uacutemero exterior</label><label
                                class="text-required">*</label>
                            <input type="text" class="form-control  custom-input" id="num_exterior" name="num_exterior"
                                placeholder="Núm. exterior" maxlength="10"
                                onkeyup="convertirAMayusculas(event,'num_exterior')">
                            <div class="line"></div>
                        </div>
                        <div class="col-12 col-md-3 mb-4">
                            <label for="campo" class="form-label input-text-form">N&uacutemero interior</label><label
                                class="text-required"></label>
                            <input type="text" class="form-control  custom-input" id="num_interior" name="num_interior"
                                placeholder="Núm. interior" maxlength="10"
                                onkeyup="convertirAMayusculas(event,'num_interior')">
                            <div class="line"></div>
                        </div>
                    </div>

                    <div class="row mx-1">
                        <div class="col-12 col-md-3 mb-4">
                            <label for="campo" class="form-label input-text-form">Latitud</label><label
                                class="text-required">*</label>
                            <input maxlength="10" type="text" class="form-control  custom-input" id="latitud"
                                name="latitud" placeholder="Latitud" onkeyup="convertirAMayusculas(event,'latitud')">
                            <div class="line"></div>
                        </div>
                        <div class="col-12 col-md-3 mb-4">
                            <label for="campo" class="form-label input-text-form">Longitud</label><label
                                class="text-required">*</label>
                            <input maxlength="10" type="text" class="form-control  custom-input" id="longitud"
                                name="longitud" placeholder="Longitud" onkeyup="convertirAMayusculas(event,'longitud')">
                            <div class="line"></div>
                        </div>
                        <div class="col-12 col-md-3 mb-4">
                            <label for="campo" class="form-label input-text-form">C&oacutedigo
                                p&oacutestal</label><label class="text-required"></label>
                            <input type="number" class="form-control  custom-input" id="codigo_postal"
                                name="codigo_postal" placeholder="Código postal" oninput="validarNumero(this)">
                            <div class="line"></div>
                        </div>
                        <div class="col-12 col-md-3 mb-4">
                            <label for="campo" class="form-label input-text-form">Pa&iacutes</label><label
                                class="text-required"></label>
                            <input maxlength="10" type="text" class="form-control  custom-input" id="pais" name="País"
                                placeholder="País" onkeyup="convertirAMayusculas(event,'pais')">
                            <div class="line"></div>
                        </div>
                    </div>

                    <div class="row mx-1">
                        <div class="col-12 col-md-3 mb-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="campo" class="form-label input-text-form">Entidad</label>
                                    <label class="text-required">*</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <select class="form-control custom-select selectpicker"
                                        data-style="input-select-selectpicker" aria-label="Default select example"
                                        data-live-search="true" id="id_cat_entidad"
                                        data-none-results-text="Sin resultados">
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-3 mb-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="campo" class="form-label input-text-form">Zona econ&oacutemica</label>
                                    <label class="text-required">*</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <select class="form-control custom-select selectpicker"
                                        data-style="input-select-selectpicker" aria-label="Default select example"
                                        data-live-search="true" id="id_cat_zona_economica"
                                        data-none-results-text="Sin resultados">
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-3 mb-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="campo" class="form-label input-text-form">Regi&oacuten</label>
                                    <label class="text-required">*</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <select class="form-control custom-select selectpicker"
                                        data-style="input-select-selectpicker" aria-label="Default select example"
                                        data-live-search="true" id="id_cat_region"
                                        data-none-results-text="Sin resultados">
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-3 mb-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="campo" class="form-label input-text-form">Estatus</label>
                                    <label class="text-required">*</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <select class="form-control custom-select selectpicker"
                                        data-style="input-select-selectpicker" aria-label="Default select example"
                                        data-live-search="true" id="id_estatus_centro"
                                        data-none-results-text="Sin resultados">
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button onclick="ocultarModal();" type="button" class="btn btn-secondary" data-dismiss="modal"><i
                        class="fas fa-times"></i> Cancelar</button>
                <button type="button" class="btn btn-success save-botton-modal" onclick="return validarCentro();"><i
                        class="fas fa-save"></i> Guardar</button>
                <input type="hidden" id="id_object">
            </div>
        </div>
    </div>
</div>