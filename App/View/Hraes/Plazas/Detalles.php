<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true" id="modal_detallas_plazas">
    <div class="modal-dialog modal-lg modal-dialog-centered" style="max-width: 1200px;">
        <div class="modal-content">
            <div class="modal-header background-modal">
                <div class="container">
                    <div class="row">
                        <div class="col-1">
                            <img src="../../../../assets/sirh/logo_plaza.png" style="max-width: 1000%;">
                        </div>
                        <div class="col-11">
                            <h1 style="color:white; font-family: 'Montserrat';font-size: 40px;">Especificaciones de
                                plaza</h1>
                            <p style="color:white;">En los siguientes campos, encontrarás detallada información acerca
                                del centro de trabajo que están vinculado a la plaza, así como los diversos
                                movimientos registrados en dicha plaza. Además, podrás conocer al empleado que está
                                actualmente asociado a esta plaza.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="div-spacing"></div>
            <div class="card-body">
                <div class="container">
                    <div class="row">
                        <div class="col-4">
                            <fieldset disabled>
                                <label for="campo" class="form-label input-text-form">Clabe (Clues)</label>
                                <input type="text" class="form-control custom-input" id="espe_clabe">
                                <div class="line"></div>
                            </fieldset>
                        </div>
                        <div class="col-8">
                            <fieldset disabled>
                                <label for="campo" class="form-label input-text-form">Nombre
                                    (Clues)</label>
                                <input type="text" class="form-control custom-input" id="espe_nombre">
                                <div class="line"></div>
                            </fieldset>
                        </div>
                    </div>

                    <div class="div-spacing"></div>
                    <div class="row">
                        <div class="col-4">
                            <fieldset disabled>
                                <label for="campo" class="form-label input-text-form">Unidad responsable
                                    (Clues)</label>
                                <input type="text" class="form-control custom-input" id="espe_unidad_rep">
                                <div class="line"></div>
                            </fieldset>
                        </div>
                        <div class="col-4">
                            <fieldset disabled>
                                <label for="campo" class="form-label input-text-form">Entidad (Clues)</label>
                                <input type="text" class="form-control custom-input" id="espe_entidad">
                                <div class="line"></div>
                            </fieldset>
                        </div>
                        <div class="col-4">
                            <fieldset disabled>
                                <label for="campo" class="form-label input-text-form">C&oacutedigo p&oacutestal
                                    (Clues)</label>
                                <input type="text" class="form-control custom-input" id="espe_codigo_postal">
                                <div class="line"></div>
                            </fieldset>
                        </div>
                    </div>

                    <div class="div-spacing"></div>
                    <div class="row">
                        <div class="col-4">
                            <fieldset disabled>
                                <label for="campo" class="form-label input-text-form">Nombre (Empleado actual)</label>
                                <input type="text" class="form-control custom-input" id="espe_nombre_emp">
                                <div class="line"></div>
                            </fieldset>
                        </div>
                        <div class="col-4">
                            <fieldset disabled>
                                <label for="campo" class="form-label input-text-form">Curp (Empleado actual)</label>
                                <input type="text" class="form-control custom-input" id="espe_curp">
                                <div class="line"></div>
                            </fieldset>
                        </div>
                        <div class="col-4">
                            <fieldset disabled>
                                <label for="campo" class="form-label input-text-form">Rfc (Empleado actual)</label>
                                <input type="text" class="form-control custom-input" id="espe_rfc">
                                <div class="line"></div>
                            </fieldset>
                        </div>
                    </div>


                    <div class="div-spacing"></div>
                    <div class="card" style=" border: none !important;">
                        <div class="card-body">
                            <h6>&Uacuteltimos movimientos de plaza</h6>
                            <table class="table table-bordered" id="tabla_historia_plaza_empleado_ix"
                                style="width:100%">
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="div-spacing"></div>
            <div class="modal-footer">
                <button onclick="detallesPlazaModalOcultar();" type="button" class="btn btn-secondary"
                    data-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>
            </div>
        </div>
    </div>
</div>