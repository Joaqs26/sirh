<div class="modal fade" id="modalAgregarAsistencia" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header background-modal">
                <div class="container">
                    <div class="row">
                        <div class="col-2">
                            <img src="../../../../assets/sirh/logo_ass.png" style="max-width: 1000%;">
                        </div>
                        <div class="col-10">
                            <h1 class="text-tittle-card"><label id="" claa="text-modal-tittle"></label>
                                Agregar asistencia.
                            </h1>
                            <p class="color-text-white">Este espacio está diseñado para permitir la incorporación de
                                asistencias a los empleados de manera manual o a través de carga masiva, facilitando así
                                una gestión de la información de asistencia.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning" role="alert">
                    <h6 class="alert-heading"><i class="fa fa-exclamation-circle"></i> ¿Cómo agregar una asistencia?
                    </h6>

                    <div>
                        <p>
                            <strong>Para agregar una asistencia</strong>, puedes hacerlo de dos maneras:
                            <strong>manualmente</strong>
                            o mediante <strong>carga masiva</strong>.
                        </p>
                        <p>
                            <strong>1. Método manual:</strong>
                        <ul>
                            <li class="step"> Pulsa el botón <strong>Ir</strong> o
                                accede desde el menú de empleados.</li>
                            <li class="step"> Selecciona el empleado.</li>
                            <li class="step"> En los módulos disponibles, selecciona
                                <strong>Asistencias</strong>.
                            </li>
                            <li class="step"> Desde este módulo, puedes
                                <strong>agregar</strong>, <strong>modificar</strong> o <strong>actualizar</strong> las
                                asistencias del empleado.
                            </li>
                        </ul>
                        </p>
                        <p>
                            <strong>2. Método de carga masiva:</strong>
                        <ul>
                            <li class="step"> Pulsa el botón <strong>Carga</strong>.
                            </li>
                            <li class="step"> Se habilitará la opción de subir un
                                archivo de Excel. <strong>Es importante</strong> que el archivo a subir esté de acuerdo
                                al <strong>layout solicitado</strong>. <a download
                                    href="../../../../assets/Formato/LAYOUT_ASISTENCIAS.xls">descargalo aqui</a>.</li>
                            <li class="step"> Procesa la información, lo cual asignará las
                                asistencias cargadas del Excel a los empleados.</li>
                        </ul>
                        </p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button onclick="ocultarAgregar();" type="button" class="btn btn-secondary" data-dismiss="modal"><i
                        class="fas fa-times"></i>
                    Cancelar</button>
                <button onclick="activeCargaMasiva();" type="button" class="btn btn-success save-botton-modal"
                    data-dismiss="modal"><i class="fa fa-cloud-upload"></i>
                    Carga masiva</button>
                <a href="../Empleados/index.php" type="button" class="btn btn-success save-botton-modal"><i
                        class="fa fa-arrow-right"></i> Ir</a>
            </div>
        </div>
    </div>
</div>