<!-- MODALE_UPLOAD_FALTA -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true" id="modal_carga_masiva_asistencias">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header background-modal">
                <div class="container">
                    <div class="row">
                        <div class="col-2">
                            <img src="../../../../assets/sirh/logo_carga_masiva.png" style="max-width: 100%;">
                        </div>
                        <div class="col-10">
                            <h1 style="color:white; font-family: 'Montserrat';font-size: 40px;">Carga masiva asistencias</h1>
                            <p style="color:white;">Espacio para realizar cargas masivas de faltas: Un área
                                dedicada para facilitar la inserción eficiente en el
                                sistema.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="div-spacing"></div>
            <div class="card-body">

                <form action="../../../../App/Controllers/Hrae/CentroTrabajoC/CargaC.php" method="POST"
                    enctype="multipart/form-data">
                    <div class="container">
                        <div class="container mt-4">
                            <div class="custom-file-container">
                                <div class="custom-file-caption">Haz clic en el icono para cargar archivos</div>
                                <div class="custom-file-hint">Tamaño máximo: 5 MB</div>
                                <label for="customFile" class="btn btn-ligth">
                                    <i style="background:white" class="fas fa-upload custom-file-icon"></i>
                                </label>
                                <input type="file" class="custom-file-input d-none" id="customFile"
                                    onchange="updateFileName(this)" name="exel_centro_trabajo">
                                <div class="custom-file-name"></div>
                            </div>
                        </div>
                    </div>
            </div>

            <div class="div-spacing"></div>
            <div class="modal-footer">
                <button onclick="ocultarModalAsistencia();" type="button" class="btn btn-secondary" data-dismiss="modal"><i
                        class="fas fa-times"></i> Cancelar</button>
                <button type="submit" onclick="return validarCargaAsistencia();" type="button"
                    class="btn btn-success save-botton-modal"><i class="fa fa-upload"></i>
                    Procesar</button>
            </div>
            </form>

        </div>
    </div>
</div>