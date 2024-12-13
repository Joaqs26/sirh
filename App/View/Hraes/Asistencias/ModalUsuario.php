<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true" id="mostrar_usuario">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header background-modal">
                <h5 class="modal-title  text-modal-tittle"><label id="" class="text-modal-tittle"></label>
                Usuario más reciente en realizar la acción</h5>
            </div>

            <div class="card-body">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <br>
                            <h6 style="font-weight: bold" class="text-result-normal  input-text-form div-spacing">
                                <i class="fa fa-user"></i> USUARIO: <label class="text-result-normal"
                                    id="nombre_usuario_accion"></label>
                            </h6>
                        </div>
                    </div>
                </div>
            </div>

            <div class="div-spacing"></div>
            <div class="modal-footer">
                <button onclick="ocultarModalUsuario();" type="button" class="btn btn-secondary" data-dismiss="modal"><i
                        class="fas fa-times"></i> Cerrar</button>
            </div>

        </div>
    </div>
</div>