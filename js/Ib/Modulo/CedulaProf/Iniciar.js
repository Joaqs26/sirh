var id_tbl_empleados_hraes = document.getElementById('id_tbl_empleados_hraes').value;

function buscarCedula(){ //BUSQUEDA
    let buscarNew = clearElement(buscar_c);
    let buscarlenth = lengthValue(buscarNew);
    
    if (buscarlenth == 0){
        iniciarTabla_c(null, iniciarBusqueda_c(),id_tbl_empleados_hraes);
    } else {
        iniciarTabla_c(buscarNew, iniciarBusqueda_c(),id_tbl_empleados_hraes);
    }
}

function iniciarTabla_c(busqueda, paginador, id_tbl_empleados_hraes) { 
    $.post('../../../../App/View/Central/Modulo/CedulaProf/tabla.php', {
        busqueda: busqueda, 
        paginador: paginador, 
        id_tbl_empleados_hraes:id_tbl_empleados_hraes
    },
        function (data) {
            $("#tabla_cedula").html(data); 
        }
    );
}

function agregarEditarCedula(id_object){
    $("#id_object").val(id_object);
    let titulo = document.getElementById("tituloCedula");
    titulo.textContent = 'Modificar';
    $("#id_object").val(id_object);
    if (id_object == null){
        titulo.textContent = 'Agregar';
        $("#agregar_editar_cedula").find("input,textarea,select").val("");
    }

    $.post("../../../../App/Controllers/Central/CedulaC/DetallesC.php", {
        id_object: id_object
    },
        function (data) {
            var jsonData = JSON.parse(data);//se obtiene el json
            var entity = jsonData.response; //Se agrega a emtidad 

            $("#cedula_profesional").val(entity.cedula_profesional);
        }
    );

    $("#agregar_editar_cedula").modal("show");
}

function salirAgregarEditarCedula_x(){
    $("#agregar_editar_cedula").modal("hide");
}


function agregarEditarByDbByCedula() {
    let cedula_profesional = $("#cedula_profesional").val();
    let id_object = $("#id_object").val();

    $.post("../../../../App/Controllers/Central/CedulaC/AgregarEditarC.php", {
        id_object: id_object,
        cedula_profesional: cedula_profesional,
        id_tbl_empleados_hraes:id_tbl_empleados_hraes,
    },
        function (data, status) {
         
            if (data == 'edit'){
                mensajeExito('Cédula profesional modificada con éxito');
            } else if (data == 'add') {
                mensajeExito('Cédula profesional agregada con éxito');  
            } else {
                mensajeError(mensajeSalida);
            }
            $("#agregar_editar_cedula").modal("hide");
            buscarCedula();
        }
    );
}

function eliminarCedula(id_object) {//ELIMINAR USUARIO
    Swal.fire({
        title: "¿Está seguro?",
        text: "¡No podrás revertir esto!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, eliminar",
        cancelButtonText: "Cancelar"
      }).then((result) => {
        if (result.isConfirmed) {
        $.post("../../../../App/Controllers/Central/CedulaC/EliminarC.php", {
                id_object: id_object
            },
            function (data, status) {
                if (data == 'delete'){
                    mensajeExito('Cédula profesional eliminada con éxito')
                } else {
                    mensajeError(mensajeSalida);
                }
                buscarCedula();
            }
        );
    }
    });
}
