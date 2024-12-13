<div class="card border-light">

    <div class="row font-size-modulo">
        <div class="col-3">
            <label for="campo" class="text-input-rem form-label input-text-form">C&oacutedigo postal</label><label
                class="text-required">*</label>
            <input onkeyup="buscarInfor();" type="number" class="form-control custom-input" id="codigo_postal1"
                placeholder="Código postal" maxlength="25">
            <div class="line"></div>
        </div>

        <div class="col-3">
            <div class="row">
                <div class="col-md-12">
                    <label for="campo" class="form-label input-text-form text-input-rem">Municipio</label>
                    <label class="text-required">*</label>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <select class="form-control custom-select selectpicker" data-style="input-select-selectpicker"
                        aria-label="Default select example" data-live-search="true" id="municipio1"
                        data-none-results-text="Sin resultados">
                    </select>
                </div>
            </div>
        </div>

        <div class="col-3">
            <fieldset disabled>
                <label for="campo" class="form-label input-text-form text-input-rem">Entidad</label>
                <input type="text" placeholder="Entidad" class="form-control custom-input" id="entidad1">
                <div class="line"></div>
            </fieldset>
        </div>


        <div class="col-3">
            <fieldset disabled>
                <label for="campo" class="form-label input-text-form text-input-rem">Pa&iacutes</label>
                <input type="text" placeholder="MÉXICO" class="form-control custom-input" id="pais_f">
                <div class="line"></div>
            </fieldset>
        </div>

    </div>

    <div class="div-spacing"></div>
    <div class="row">

        <div class="col-6">
            <div class="row">
                <div class="col-md-12">
                    <label for="campo" class="form-label input-text-form text-input-rem">Colonia</label>
                    <label class="text-required">*</label>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <select class="form-control custom-select selectpicker" data-style="input-select-selectpicker"
                        aria-label="Default select example" data-live-search="true" id="colonia1"
                        data-none-results-text="Sin resultados">
                    </select>
                </div>
            </div>
        </div>

        <div class="col-6">
            <label for="campo" class="form-label input-text-form text-input-rem">Calle</label><label
                class="text-required"></label>
            <input onkeyup="convertirAMayusculas(event,'calle1')" type="text" class="form-control custom-input"
                id="calle1" placeholder="Calle" maxlength="35">
            <div class="line"></div>
        </div>
    </div>

    <div class="div-spacing"></div>
    <div class="row">

        <div class="col-3">
            <label for="campo" class="form-label input-text-form text-input-rem">N&uacutem. exterior</label><label
                class="text-required">*</label>
            <input type="text" onkeyup="convertirAMayusculas(event,'num_exterior1')" class="form-control custom-input"
                id="num_exterior1" placeholder="Núm. exterior" maxlength="10">
            <div class="line"></div>
        </div>

        <div class="col-3">
            <label for="campo" class="form-label input-text-form text-input-rem">N&uacutem. interior</label><label
                class="text-required">*</label>
            <input type="text" onkeyup="convertirAMayusculas(event,'num_interior1')" class="form-control custom-input"
                id="num_interior1" placeholder="Núm. interior" maxlength="10">
            <div class="line"></div>
        </div>

        <div class="col-3">
            <label for="campo" class="form-label input-text-form text-input-rem">C&oacutedigo postal
                f&iacutescal</label><label class="text-required">*</label>
            <input type="number" oninput="validarNumero(this)" class="form-control custom-input" id="codigo_postal2"
                placeholder="Código postal">
            <div class="line"></div>
        </div>

        <div class="modal-footer">
            <input type="hidden" id="id_tbl_domicilios">
            <button type="button" class="btn btn-success save-botton-modal" onclick="return validarDomicilio();"><i
                    class="fas fa-save"></i> Guardar</button>
        </div>
    </div>
</div>


<!--
<div class="card border-light">

    <div class="row font-size-modulo">
        <div class="col-3">
            <label class="text-input-rem div-spacing">C&oacutedigo postal</label><label class="text-required">*</label>
            <input onkeyup="buscarInfor();" type="number" class="form-control" id="codigo_postal1"
                placeholder="Código postal" maxlength="25">
        </div>
        <div class="col-4">
            <label class="text-input-rem div-spacing">Municipio</label><label class="text-required">*</label>
            <div class="custom-select-wrapper">
                <select class="form-control" aria-label="Default select example" id="municipio1" required>
                </select>
            </div>
        </div>

        <div class="col-3">
            <label class="text-input-rem div-spacing">Entidad</label><label class="text-required">*</label>
            <fieldset disabled>
                <input type="text" class="form-control" id="entidad1" placeholder="Entidad" maxlength="25">
            </fieldset>
        </div>

        <div class="col-2">
            <label class="text-input-rem div-spacing">Pa&iacutes</label><label class="text-required">*</label>
            <fieldset disabled>
                <input type="text" class="form-control" id="pais_f" placeholder="MÉXICO" maxlength="25">
            </fieldset>
        </div>
    </div>

    <div class="div-spacing"></div>
    <div class="row">
        <div class="col-6">
            <label class="text-input-rem div-spacing">Colonia</label><label class="text-required">*</label>
            <div class="custom-select-wrapper">
                <select class="form-control" aria-label="Default select example" id="colonia1" required>
                </select>
            </div>
        </div>

        <div class="col-6">
            <label class="text-input-rem div-spacing">Calle</label><label class="text-required"></label>
            <input onkeyup="convertirAMayusculas(event,'calle1')" type="text" class="form-control" id="calle1" placeholder="Calle" maxlength="35">
        </div>
    </div>

    <div class="div-spacing"></div>
    <div class="row">
        <div class="col-3">
            <label class="text-input-rem div-spacing">N&uacutem. exterior</label><label class="text-required">*</label>
            <input type="text" class="form-control" onkeyup="convertirAMayusculas(event,'num_exterior1')" id="num_exterior1" placeholder="Núm. exterior" maxlength="10">
        </div>
        <div class="col-3">
            <label class="text-input-rem div-spacing">N&uacutem. interior</label><label class="text-required"></label>
            <input type="text" class="form-control" onkeyup="convertirAMayusculas(event,'num_interior1')" id="num_interior1" placeholder="Núm. interior" maxlength="10">
        </div>
        <div class="col-3">
            <label class="text-input-rem div-spacing">C&oacutedigo postal f&iacutescal</label><label
                class="text-required"></label>
            <input  oninput="validarNumero(this)" type="number" class="form-control" id="codigo_postal2" placeholder="Código postal" maxlength="25">
        </div>

        <div class="modal-footer">
            <input type="hidden" id="id_tbl_domicilios">
            <button type="button" class="btn btn-success save-botton-modal" onclick="return validarDomicilio();"><i
                    class="fas fa-save"></i> Guardar</button>
        </div>
    </div>
</div>
-->