<div class="card border-light">

    <div class="row font-size-modulo">
        <div class="col-4">
            <label for="campo" class="text-input-rem form-label input-text-form">F. Expedici&oacuten</label><label
                class="text-required">*</label>
            <input type="date" class="form-control custom-input" id="fecha_expedicion" placeholder="">
            <div class="line"></div>
        </div>

        <div class="col-4">
            <label for="campo" class="text-input-rem form-label input-text-form">F. Ingreso Gob. Federal</label><label
                class="text-required">*</label>
            <input type="date" class="form-control custom-input" id="fecha_ingreso_gob_fed" placeholder="">
            <div class="line"></div>
        </div>

        <div class="col-4">
            <label for="campo" class="text-input-rem form-label input-text-form">F. Vigencia del</label><label
                class="text-required">*</label>
            <input type="date" class="form-control custom-input" id="vigencia_del" placeholder="">
            <div class="line"></div>
        </div>
    </div>

    <div class="div-spacing"></div>
    <div class="row">
        <div class="col-4">
            <label for="campo" class="text-input-rem form-label input-text-form">F. Vigencia al</label><label
                class="text-required">*</label>
            <input type="date" class="form-control custom-input" id="vigencia_al" placeholder="">
            <div class="line"></div>
        </div>

        <div class="col-8">
            <label for="campo" class="form-label input-text-form text-input-rem">Antigüedad</label><label
                class="text-required"></label>
            <input maxlength="60" type="text" class="form-control custom-input"
                onkeyup="convertirAMayusculas(event,'antiguedad')" id="antiguedad" placeholder="Antiguedad">
            <div class="line"></div>
        </div>
    </div>

    <div class="div-spacing"></div>
    <div class="row">

        <div class="col-12">
            <label for="campo" class="form-label input-text-form text-input-rem">Funciones</label><label
                class="text-required">*</label>
            <input maxlength="120" type="text" class="form-control custom-input"
                onkeyup="convertirAMayusculas(event,'funciones')" id="funciones" placeholder="Funciones">
            <div class="line"></div>
        </div>
    </div>

    <div class="div-spacing"></div>
    <div class="modal-footer">
        <input type="hidden" id="id_tbl_domicilios">
        <button type="button" class="btn btn-success save-botton-modal" onclick="return validarAdicional();"><i
                class="fas fa-save"></i> Guardar</button>
        <input type="hidden" id="id_ctrl_adic_emp_hraes">
    </div>

</div>
