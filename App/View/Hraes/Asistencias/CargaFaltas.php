<!-- MODALE_UPLOAD_FALTA -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true" id="modal_carga_masiva_faltas">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header background-modal">
                <div class="container">
                    <div class="row">
                        <div class="col-2">
                            <img src="../../../../assets/sirh/logo_carga_masiva.png" style="max-width: 100%;">
                        </div>
                        <div class="col-10">
                            <h1 style="color:white; font-family: 'Montserrat';font-size: 40px;">Justificación de faltas
                            </h1>
                            <p style="color:white;">ección para justificar faltas y retrasos de forma masiva. Aquí
                                podrás ingresar las razones correspondientes de manera rápida y organizada, facilitando
                                así la gestión de la asistencia.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="div-spacing"></div>
            <div class="card-body">

                <div class="container">
                    <div class="container mt-4">
                        <div class="instructions">
                            <p>Instrucciones</p>
                            <div class="alert alert-warning" role="alert">
                                <strong>Justificación de faltas o retardos:</strong><br>
                                1. Para una adecuada carga de archivos, <strong>descarga el formato
                                    LAYOUT_JUSTIFICACION</strong>
                                <a download href="../../../../assets/Formato/LAYOUT_JUSTIFICACION.xlsx">descargalo
                                    aqui</a>.<br>
                                3. En la columna TIPO*, debe indicarse si se desea justificar un retardo; para ello,
                                escribe <strong>RETARDO</strong>. Si quieres justificar una falta, escribe
                                <strong>FALTA</strong>.<br>
                                4. En la columna TIPO FALTA/RETARDO*, el tipo de incidencia; para ello,
                                escribe <strong>ENTRADA</strong>. Si quieres justificar por entrada, escribe
                                <strong>SALIDA</strong>. Si se quiere justificar por salida<br>
                                5. Las fechas deben ingresarse en el formato <strong>(YYYY/MM/DD).</strong><br>
                                6. Los campos marcados con <strong>*</strong> son obligatorios; es crucial <strong>no
                                    eliminar los encabezados.</strong><br>
                                7. Al finalizar, se generará un archivo con los registros que se hayan ingresado
                                correctamente.
                            </div>
                        </div>
                    </div>
                </div>


                <form action="../../../../App/Controllers/Hrae/CentroTrabajoC/CargaC.php" method="POST"
                    enctype="multipart/form-data">
                    <div class="container">
                        <div class="container mt-4">
                            <div class="custom-file-container">
                                <div class="custom-file-caption">Haz clic en el icono para cargar archivos</div>
                                <div class="custom-file-hint">Tamaño máximo: 5 MB</div>
                                <label for="customFileFaltas" class="btn btn-ligth">
                                    <i style="background:white" class="fas fa-upload custom-file-icon"></i>
                                </label>
                                <input type="file" class="custom-file-input d-none" id="customFileFaltas"
                                    onchange="updateFileNameFalta(this)" name="exel_centro_trabajo">
                                <div class="custom-file-name-faltas"></div>
                            </div>
                        </div>
                    </div>
            </div>

            <div class="div-spacing"></div>
            <div class="modal-footer">
                <button onclick="ocultarModalFaltas();" type="button" class="btn btn-secondary" data-dismiss="modal"><i
                        class="fas fa-times"></i> Cancelar</button>
                <button type="submit" onclick="return validarCargaFalta();" type="button"
                    class="btn btn-success save-botton-modal"><i class="fa fa-upload"></i>
                    Procesar</button>
            </div>
            </form>

        </div>
    </div>
</div>