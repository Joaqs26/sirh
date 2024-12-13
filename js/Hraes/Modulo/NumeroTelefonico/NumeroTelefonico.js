var id_tbl_empleados_hraes = document.getElementById('id_tbl_empleados_hraes').value;

function buscarNumTelefonico(){ //BUSQUEDA
    let buscarNew = clearElement(buscar_nt);
    let buscarlenth = lengthValue(buscarNew);
    
    if (buscarlenth == 0){
        iniciarTabla_nt(null, iniciarBusqueda_nt(),id_tbl_empleados_hraes);
    } else {
        iniciarTabla_nt(buscarNew, iniciarBusqueda_nt(),id_tbl_empleados_hraes);
    }
}

function iniciarTabla_nt(busqueda, paginador, id_tbl_empleados_hraes) { 
    $.post('../../../../App/View/Hraes/Modulo/NumeroTelefonico/tabla.php', {
        busqueda: busqueda, 
        paginador: paginador, 
        id_tbl_empleados_hraes:id_tbl_empleados_hraes
    },
        function (data) {
            $("#modulo_telefono").html(data); 
        }
    );
}

function iniciarTablaTelefono(id_tbl_empleados_hraes) { ///INGRESA LA TABLA
    $.ajax({
        type: 'POST',
        url: '../../../../App/View/Hraes/Modulo/NumeroTelefonico/tabla.php',
        data: { id_tbl_empleados_hraes: id_tbl_empleados_hraes },
        success: function (data) {
            $('#modulo_telefono').html(data);
        }
    });
}

function agregarEditarTelefono(id_object){

    let titulo = document.getElementById("titulo_fijo");
    titulo.textContent = 'Modificar';
    $("#id_object").val(id_object);
    if (id_object == null){
        $("#agregar_editar_telefono").find("input,textarea,select").val("");
        titulo.textContent = 'Agregar';
    }

    $.post("../../../../App/Controllers/Hrae/TelefonoC/DetallesC.php", {
        id_object: id_object
    },
        function (data) {
            var jsonData = JSON.parse(data);//se obtiene el json
            var entity = jsonData.response; //Se agrega a emtidad 
            var estatus = jsonData.estatus; //Se agrega a emtidad 

            $('#id_cat_estatus').empty();
            $('#id_cat_estatus').html(estatus); 
            $("#movil").val(entity.movil);
            $("#telefono").val(entity.telefono);

            $('#id_cat_estatus').selectpicker('refresh');
            $('.selectpicker').selectpicker();
        }
    );

    $("#agregar_editar_telefono").modal("show");
}

function salirAgregarEditarTelefono(){
    $("#agregar_editar_telefono").modal("hide");
}

function agregarEditarByDbByTelefono() {
    var movil = $("#movil").val();
    var telefono = $("#telefono").val();
    var id_cat_estatus = $("#id_cat_estatus").val();
    var id_object = $("#id_object").val();

    $.post("../../../../App/Controllers/Hrae/TelefonoC/AgregarEditarC.php", {
        movil: movil,
        id_cat_estatus: id_cat_estatus,
        id_object:id_object,
        id_tbl_empleados_hraes:id_tbl_empleados_hraes,
        telefono:telefono
    },
        function (data) {
            if (data == 'edit'){
                notyf.success('Número telefonico modificado con éxito');
            } else if (data == 'add') {
                notyf.success('Número telefonico agregado con éxito');  
            } else {
                notyf.error(mensajeSalida);
            }
            $("#agregar_editar_telefono").modal("hide");
            buscarNumTelefonico();
        }
    );
}

function eliminarTelefono(id_object) {//ELIMINAR USUARIO
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
        $.post("../../../../App/Controllers/Hrae/TelefonoC/EliminarC.php", {
                id_object: id_object
            },
            function (data, status) {
                if (data == 'delete'){
                    notyf.success('Número telefonico eliminado con éxito')
                } else {
                    notyf.error(mensajeSalida);
                }
                buscarNumTelefonico();
            }
        );
    }
    });
}
