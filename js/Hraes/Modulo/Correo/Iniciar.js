var id_tbl_empleados_hraes = document.getElementById('id_tbl_empleados_hraes').value;

function buscarCorreo(){ //BUSQUEDA
    let buscarNew = clearElement(buscar_ce);
    let buscarlenth = lengthValue(buscarNew);
    
    if (buscarlenth == 0){
        iniciarTabla_ce(null, iniciarBusqueda_ce(),id_tbl_empleados_hraes);
    } else {
        iniciarTabla_ce(buscarNew, iniciarBusqueda_ce(),id_tbl_empleados_hraes);
    }
}

function iniciarTabla_ce(busqueda, paginador, id_tbl_empleados_hraes) { 
    $.post('../../../../App/View/Hraes/Modulo/Correo/tabla.php', {
        busqueda: busqueda, 
        paginador: paginador, 
        id_tbl_empleados_hraes:id_tbl_empleados_hraes
    },
        function (data) {
            $("#tabla_correo").html(data); 
        }
    );
}

function agregarEditarCorreo(id_object){
    $("#id_object").val(id_object);
    let titulo = document.getElementById("titulo_correo");
    titulo.textContent = 'Modificar';
    $("#id_object").val(id_object);
    if (id_object == null){
        titulo.textContent = 'Agregar';
        $("#agregar_editar_correo").find("input,textarea,select").val("");
    }

    $.post("../../../../App/Controllers/Hrae/CorreoC/DetallesC.php", {
        id_object: id_object
    },
        function (data) {
            var jsonData = JSON.parse(data);//se obtiene el json
            var entity = jsonData.response; //Se agrega a emtidad 

            $("#correo_electronico").val(entity.correo_electronico);
        }
    );

    $("#agregar_editar_correo").modal("show");
}

function salirAgregarEditarCorreo(){
    $("#agregar_editar_correo").modal("hide");
}


function guardarCorreo() {
    $.post("../../../../App/Controllers/Hrae/CorreoC/AgregarEditarC.php", {
        correo_electronico: $("#correo_electronico").val(),
        id_object: $("#id_object").val(),
        id_tbl_empleados_hraes:id_tbl_empleados_hraes,
    },
        function (data) {
            if (data == 'edit'){
                notyf.success('Correo electrónico modificado con éxito');
            } else if (data == 'add') {
                notyf.success('Correo electrónico agregado con éxito');  
            } else {
                notyf.error(mensajeSalida);
            }
            $("#agregar_editar_correo").modal("hide");
            buscarCorreo();
        }
    );
}

function eliminarCorreo(id_object) {//ELIMINAR USUARIO
    Swal.fire({
        title: "¿Está seguro?",
        text: "¡No podrás revertir esto!",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#235B4E",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Si, eliminar",
        cancelButtonText: "Cancelar"
      }).then((result) => {
        if (result.isConfirmed) {
        $.post("../../../../App/Controllers/Hrae/CorreoC/EliminarC.php", {
                id_object: id_object
            },
            function (data) {
                if (data == 'delete'){
                    notyf.success('Correo electrónico eliminado con éxito')
                } else {
                    notyf.error(mensajeSalida);
                }
                buscarCorreo();
            }
        );
    }
    });
}
