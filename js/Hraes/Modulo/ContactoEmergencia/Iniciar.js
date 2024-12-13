var id_tbl_empleados_hraes = document.getElementById('id_tbl_empleados_hraes').value;

function buscarEmergencia(){ //BUSQUEDA
    let buscarNew = clearElement(buscar_e);
    let buscarlenth = lengthValue(buscarNew);
    
    if (buscarlenth == 0){
        iniciarTablaEmergencia(null, iniciarBusqueda_e(),id_tbl_empleados_hraes);
    } else {
        iniciarTablaEmergencia(buscarNew, iniciarBusqueda_e(),id_tbl_empleados_hraes);
    }
}

function iniciarTablaEmergencia(busqueda, paginador, id_tbl_empleados_hraes) { 
    $.post('../../../../App/View/Hraes/Modulo/ContactoEmergencia/tabla.php', {
        busqueda: busqueda, 
        paginador: paginador, 
        id_tbl_empleados_hraes:id_tbl_empleados_hraes
    },
        function (data) {
            $("#modulo_contacto_emergencia").html(data); 
        }
    );
}

function agregarEditarEmergencia(id_object){
    $("#id_object").val(id_object);
    let titulo = document.getElementById("titulo_emergencia");
    titulo.textContent = 'Modificar';

    if (id_object == null){
        $("#agregar_editar_contacto_emergencia").find("input,textarea,select").val("");
        titulo.textContent = 'Agregar';
    }

    $.post("../../../../App/Controllers/Hrae/ContactoEmergenciaC/DetallesC.php", {
        id_object: id_object
    },
        function (data) {
            var jsonData = JSON.parse(data);//se obtiene el json
            var entity = jsonData.response; //Se agrega a emtidad 

            $("#nombre").val(entity.nombre);
            $("#primer_apellido").val(entity.primer_apellido);
            $("#segundo_apellido").val(entity.segundo_apellido);
            $("#parentesco").val(entity.parentesco);
            $("#movil_emergencia").val(entity.movil);
        }
    );

    $("#agregar_editar_contacto_emergencia").modal("show");
}

function salirAgregarEditarEmergencia(){
    $("#agregar_editar_contacto_emergencia").modal("hide");
}

function agregarEditarByDbByEmergencia() {
    var movil = $("#movil_emergencia").val();
    var nombre = $("#nombre").val();
    var primer_apellido = $("#primer_apellido").val();
    var segundo_apellido = $("#segundo_apellido").val();
    var parentesco = $("#parentesco").val();
    var id_object = $("#id_object").val();

    $.post("../../../../App/Controllers/Hrae/ContactoEmergenciaC/AgregarEditarC.php", {
        movil: movil,
        nombre: nombre,
        primer_apellido: primer_apellido,
        segundo_apellido: segundo_apellido,
        parentesco: parentesco,
        id_object:id_object,
        id_tbl_empleados_hraes:id_tbl_empleados_hraes,
    },
        function (data) {
            if (data == 'edit'){
                notyf.success('Contacto emergencia modificado con éxito');
            } else if (data == 'add') {
                notyf.success('Contacto emergencia agregado con éxito');  
            } else {
                notyf.error(mensajeSalida);
            }
            $("#agregar_editar_contacto_emergencia").modal("hide");
            buscarEmergencia();
        }
    );
}

function eliminarEmergencia(id_object) {//ELIMINAR USUARIO
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
        $.post("../../../../App/Controllers/Hrae/ContactoEmergenciaC/EliminarC.php", {
                id_object: id_object
            },
            function (data, status) {
                if (data == 'delete'){
                    notyf.success('Contacto emergencia eliminado con éxito')
                } else {
                    notyf.error(mensajeSalida);
                }
                buscarEmergencia();
            }
        );
    }
    });
}
