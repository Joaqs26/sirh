var id_tbl_empleados_hraes = document.getElementById('id_tbl_empleados_hraes').value;

function buscarDependiente(){ //BUSQUEDA
    let buscarNew = clearElement(buscar_de);
    let buscarlenth = lengthValue(buscarNew);
    
    if (buscarlenth == 0){
        iniciarTabla_de(null, iniciarBusqueda_de(),id_tbl_empleados_hraes);
    } else {
        iniciarTabla_de(buscarNew, iniciarBusqueda_de(),id_tbl_empleados_hraes);
    }
}

function iniciarTabla_de(busqueda, paginador, id_tbl_empleados_hraes) { 
    $.post('../../../../App/View/Hraes/Modulo/Dependientes/tabla.php', {
        busqueda: busqueda, 
        paginador: paginador, 
        id_tbl_empleados_hraes:id_tbl_empleados_hraes
    },
        function (data) {
            $("#modulo_dependientes_economicos").html(data); 
        }
    );
}


function agregarEditarDependiente(id_object){
    $("#id_object").val(id_object);
    let titulo = document.getElementById("titulo_dependiete");
    titulo.textContent = 'Modificar';
    $("#id_object").val(id_object);
    if (id_object == null){
        titulo.textContent = 'Agregar';
        $("#agregar_editar_dependiente").find("input,textarea,select").val("");
    }

    $.post("../../../../App/Controllers/Hrae/DependientesC/DetallesC.php", {
        id_object: id_object
    },
        function (data) {
            var jsonData = JSON.parse(data);
            var entity = jsonData.response; 
            var dependiente = jsonData.dependiente; 

            $('#id_cat_dependientes_economicos_d').empty();
            $('#id_cat_dependientes_economicos_d').html(dependiente); 

            $("#nombre_d").val(entity.nombre);
            $("#curp_d").val(entity.curp);
            $("#apellido_paterno_d").val(entity.apellido_paterno);
            $("#id_cat_dependientes_economicos_d").val(entity.id_cat_dependientes_economicos);
            $("#apellido_materno_d").val(entity.apellido_materno);

            $('#id_cat_dependientes_economicos_d').selectpicker('refresh');
            $('.selectpicker').selectpicker();
        }
    );

    $("#agregar_editar_dependiente").modal("show");
}

function salirAgregarEditarDependiente(){
    $("#agregar_editar_dependiente").modal("hide");
}

function agregarEditarByDbByDependiente() {
    let nombre = $("#nombre_d").val();
    let curp = $("#curp_d").val();
    let apellido_paterno = $("#apellido_paterno_d").val();
    let apellido_materno = $("#apellido_materno_d").val();
    let id_cat_dependientes_economicos = $("#id_cat_dependientes_economicos_d").val();
    let id_object = $("#id_object").val();

    $.post("../../../../App/Controllers/Hrae/DependientesC/AgregarEditarC.php", {
        id_object: id_object,
        nombre: nombre,
        curp:curp,
        apellido_paterno:apellido_paterno,
        apellido_materno:apellido_materno,
        id_cat_dependientes_economicos:id_cat_dependientes_economicos,
        id_tbl_empleados_hraes:id_tbl_empleados_hraes
    },
        function (data) {
            if (data == 'edit'){
                notyf.success('Dependiente económico modificado con éxito');
            } else if (data == 'add') {
                notyf.success('Dependiente económico agregado con éxito');  
            } else {
                notyf.error(mensajeSalida);
            }
            $("#agregar_editar_dependiente").modal("hide");
            buscarDependiente();
        }
    );
}

function eliminarDependiente(id_object) {//ELIMINAR USUARIO
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
        $.post("../../../../App/Controllers/Hrae/DependientesC/EliminarC.php", {
                id_object: id_object
            },
            function (data) {
                if (data == 'delete'){
                    notyf.success('Dependiente económico eliminado con éxito')
                } else {
                    notyf.error('El dependiente se encuentra en módulo de juguetes');
                }
                buscarDependiente();
            }
        );
    }
    });
}
