<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true" id="modal_detalles">
    <div class="modal-dialog modal-lg modal-dialog-centered" style="max-width: 1200px;">
        <div class="modal-content">
            <div class="modal-header background-modal">
                <div class="container">
                    <div class="row">
                        <div class="col-1">
                            <img src="../../../../assets/sirh/logo_ass.png" style="">
                        </div>
                        <div class="col-11">
                            <h1 style="color:white; font-family: 'Montserrat';font-size: 35px;">Especificaciones de
                                asistencia</h1>
                            <p style="color:white;">En este espacio podrás visualizar la información detallada de las
                                asistencias asociadas al empleado. Si deseas modificar esta información, puedes hacerlo
                                desde el módulo de asistencias en empleados, haciendo click en el botón de acciones.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="div-spacing"></div>
            <div class="card-body">
                <div class="container">
                    <div class="row">
                        <div class="col-8">
                            <fieldset disabled>
                                <label for="campo" class="form-label input-text-form">Nombre</label>
                                <input type="text" class="form-control custom-input" id="nombre_ass">
                                <div class="line"></div>
                            </fieldset>
                        </div>
                        <div class="col-4">
                            <fieldset disabled>
                                <label for="campo" class="form-label input-text-form">RFC</label>
                                <input type="text" class="form-control custom-input" id="rfc_ss">
                                <div class="line"></div>
                            </fieldset>
                        </div>
                    </div>

                    <div class="div-spacing"></div>
                    <div class="row">
                        <div class="col-3">
                            <fieldset disabled>
                                <label for="campo" class="form-label input-text-form">Fecha</label>
                                <input type="text" class="form-control custom-input" id="fecha_ss">
                                <div class="line"></div>
                            </fieldset>
                        </div>
                        <div class="col-3">
                            <fieldset disabled>
                                <label for="campo" class="form-label input-text-form">Hora</label>
                                <input type="text" class="form-control custom-input" id="hora_ss">
                                <div class="line"></div>
                            </fieldset>
                        </div>
                        <div class="col-3">
                            <fieldset disabled>
                                <label for="campo" class="form-label input-text-form">Dispositivo</label>
                                <input type="text" class="form-control custom-input" id="dispositivo_ss">
                                <div class="line"></div>
                            </fieldset>
                        </div>
                        <div class="col-3">
                            <fieldset disabled>
                                <label for="campo" class="form-label input-text-form">Verificaci&oacuten</label>
                                <input type="text" class="form-control custom-input" id="verificacion_ss">
                                <div class="line"></div>
                            </fieldset>
                        </div>
                    </div>

                    <div class="div-spacing"></div>
                    <div class="row">
                        <div class="col-3">
                            <fieldset disabled>
                                <label for="campo" class="form-label input-text-form">Estado</label>
                                <input type="text" class="form-control custom-input" id="estado_ss">
                                <div class="line"></div>
                            </fieldset>
                        </div>
                        <div class="col-3">
                            <fieldset disabled>
                                <label for="campo" class="form-label input-text-form">Evento</label>
                                <input type="text" class="form-control custom-input" id="evento_ss">
                                <div class="line"></div>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </div>

            <div class="div-spacing"></div>
            <div class="modal-footer">
                <button onclick="cerrarDetallesAsis();" type="button" class="btn btn-secondary" data-dismiss="modal"><i
                        class="fas fa-times"></i> Cerrar</button>
                <a href="../Empleados/index.php" class="btn btn-success save-botton-modal" role="button">
                    <i style="color:white" class="	fa fa-arrow-right"></i>
                    <span class="hide-menu">&nbsp;Acciones</span>
                </a>
            </div>
        </div>
    </div>
</div>