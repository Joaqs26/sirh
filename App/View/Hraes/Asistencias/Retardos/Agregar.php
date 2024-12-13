<div class="modal fade" id="modalAgregarRetardo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header background-modal">
                <div class="container">
                    <div class="row">
                        <div class="col-2">
                            <img src="../../../../assets/sirh/logo_alarma.png" style="max-width: 1000%;">
                        </div>
                        <div class="col-10">
                            <h1 class="text-tittle-card"><label id="" claa="text-modal-tittle"></label>
                                Agregar Retardo.
                            </h1>
                            <p class="color-text-white">Este espacio está diseñado para agregar, actualizar o eliminar
                                retardos. Para garantizar un proceso exitoso, es fundamental seguir las observaciones
                                que se detallan a continuación.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning" role="alert">
                    <p><strong>Cómo agregar o modificar una retardo:</strong></p>
                    <ol>
                        <li><strong>Desde el botón "Ir" en la parte inferior</strong> o en el menú de empleados.</li>
                        <li><strong>Selecciona el empleado</strong> para ver los retardos que tiene asignados.</li>
                        <li>Accede al <strong>Módulo de Incidencias / Retardos</strong>.</li>
                        <li>Dentro del módulo, podrás <strong>agregar, actualizar o eliminar</strong> los retardos
                            asignados.</li>
                    </ol>
                </div>
            </div>
            <div class="modal-footer">
                <button onclick="ocultarRetardo();" type="button" class="btn btn-secondary" data-dismiss="modal"><i
                        class="fas fa-times"></i>
                    Cancelar</button>
                <a href="../Empleados/index.php" type="button" class="btn btn-success save-botton-modal"><i
                        class="fa fa-arrow-right"></i> Ir</a>
            </div>
        </div>
    </div>
</div>