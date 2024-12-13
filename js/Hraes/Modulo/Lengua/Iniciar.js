var id_tbl_empleados_hraes = document.getElementById('id_tbl_empleados_hraes').value;

function buscarLengua(){ //BUSQUEDA
    let buscarNew = clearElement(buscar_lg);
    let buscarlenth = lengthValue(buscarNew);
    
    if (buscarlenth == 0){
        iniciarTabla_lg(null, iniciarBusqueda_lg(),id_tbl_empleados_hraes);
    } else {
        iniciarTabla_lg(buscarNew, iniciarBusqueda_lg(),id_tbl_empleados_hraes);
    }
}

function iniciarTabla_lg(busqueda, paginador, id_tbl_empleados_hraes) { 
    $.post('../../../../App/View/Hraes/Modulo/Lengua/tabla.php', {
        busqueda: busqueda, 
        paginador: paginador, 
        id_tbl_empleados_hraes:id_tbl_empleados_hraes
    },
        function (data) {
            $("#tabla_lengua").html(data); 
        }
    );
}

function agregarEditarLengua(id_object){
    $("#id_object").val(id_object);
    let titulo = document.getElementById("tituloEspecialidad");
    titulo.textContent = 'Modificar';
    $("#id_object").val(id_object);
    if (id_object == null){
        titulo.textContent = 'Agregar';
        $("#agregar_editar_lengua").find("input,textarea,select").val("");
    }

    $.post("../../../../App/Controllers/Hrae/LenguaC/DetallesC.php", {
        id_object: id_object
    },
        function (data) {
            let jsonData = JSON.parse(data);
            let islengua = jsonData.lengua; 

            $('#id_cat_lengua').empty();
            $('#id_cat_lengua').html(islengua); 
            $('#id_cat_lengua').selectpicker('refresh');
            $('.selectpicker').selectpicker();
        }
    );

    $("#agregar_editar_lengua").modal("show");
}

function salirAgregarEditarLengua(){
    $("#agregar_editar_lengua").modal("hide");
}


function guardarLengua() {
    $.post("../../../../App/Controllers/Hrae/LenguaC/AgregarEditarC.php", {
        id_object: $("#id_object").val(),
        id_cat_lengua: $("#id_cat_lengua").val(),
        id_tbl_empleados_hraes:id_tbl_empleados_hraes
    },
        function (data) {
            if (data == 'edit'){
                notyf.success('Lengua modificada con éxito');
            } else if (data == 'add') {
                notyf.success('Lengua agregada con éxito');  
            } else {
                notyf.error(mensajeSalida);
            }
            $("#agregar_editar_lengua").modal("hide");
            buscarLengua();
        }
    );
}

function eliminarLengua(id_object) {//ELIMINAR USUARIO
    Swal.fire({
        title: "¿Está seguro?",
        text: "¡No podrás revertir esto!",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, eliminar",
        cancelButtonText: "Cancelar",
        confirmButtonColor: '#235B4E', 
        cancelButtonColor:'#6c757d',
      }).then((result) => {
        if (result.isConfirmed) {
        $.post("../../../../App/Controllers/Hrae/LenguaC/EliminarC.php", {
                id_object: id_object
            },
            function (data) {
                if (data == 'delete'){
                    notyf.success('Lengua eliminada con éxito')
                } else {
                    notyf.error(mensajeSalida);
                }
                buscarLengua();
            }
        );
    }
    });
}
