var id_tbl_empleados_hraes = document.getElementById('id_tbl_empleados_hraes').value;

function buscarJefe(){ //BUSQUEDA
    let buscarNew = clearElement(buscar_j);
    let buscarlenth = lengthValue(buscarNew);
    
    if (buscarlenth == 0){
        iniciarTabla_j(null, iniciarBusqueda_j(),id_tbl_empleados_hraes);
    } else {
        iniciarTabla_j(buscarNew, iniciarBusqueda_j(),id_tbl_empleados_hraes);
    }
}

function iniciarTabla_j(busqueda, paginador, id_tbl_empleados_hraes) { 
    $.post('../../../../App/View/Hraes/Modulo/Jefe/tabla.php', {
        busqueda: busqueda, 
        paginador: paginador, 
        id_tbl_empleados_hraes:id_tbl_empleados_hraes
    },
        function (data) {
            $("#tabla_jefe").html(data); 
        }
    );
}

function agregarEditarJefe(id_object){
    $("#id_object").val(id_object);
    let titulo = document.getElementById("tituloJefe");
    titulo.textContent = 'Modificar';
    $("#id_object").val(id_object);
    if (id_object == null){
        titulo.textContent = 'Agregar';
        $("#agregar_editar_cedula").find("input,textarea,select").val("");
    }

    $.post("../../../../App/Controllers/Hrae/JefeC/DetallesC.php", {
        id_object: id_object
    },
        function (data) {
            var jsonData = JSON.parse(data);//se obtiene el json
            var entity = jsonData.response; //Se agrega a emtidad 

            $("#jefe_inmediato").val(entity.jefe_inmediato);
        }
    );

    $("#agregar_editar_jefe").modal("show");
}

function salirAgregarEditarCedula(){
    $("#agregar_editar_jefe").modal("hide");
}


function guardarJefe() {
    $.post("../../../../App/Controllers/Hrae/JefeC/AgregarEditarC.php", {
        jefe_inmediato: $("#jefe_inmediato").val(),
        id_object: $("#id_object").val(),
        id_tbl_empleados_hraes:id_tbl_empleados_hraes,
    },
        function (data) {
            if (data == 'edit'){
                notyf.success('Jefe inmediato modificado con éxito');
            } else if (data == 'add') {
                notyf.success('Jefe inmediato agregado con éxito');  
            } else {
                notyf.error(mensajeSalida);
            }
            $("#agregar_editar_jefe").modal("hide");
            buscarJefe();
        }
    );
}

function eliminarJefe(id_object) {//ELIMINAR USUARIO
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
        $.post("../../../../App/Controllers/Hrae/JefeC/EliminarC.php", {
                id_object: id_object
            },
            function (data) {
                if (data == 'delete'){
                    notyf.success('Jefe inmediato eliminado con éxito')
                } else {
                    notyf.error(mensajeSalida);
                }
                buscarJefe();
            }
        );
    }
    });
}
