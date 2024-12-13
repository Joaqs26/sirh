var id_tbl_empleados_hraes = document.getElementById('id_tbl_empleados_hraes').value;

function buscarEstudio(){ //BUSQUEDA
    let buscarNew = clearElement(buscar_ne);
    let buscarlenth = lengthValue(buscarNew);
    
    if (buscarlenth == 0){
        iniciarTabla_ne(null, iniciarBusqueda_ne(),id_tbl_empleados_hraes);
    } else {
        iniciarTabla_ne(buscarNew, iniciarBusqueda_ne(),id_tbl_empleados_hraes);
    }
}

function iniciarTabla_ne(busqueda, paginador, id_tbl_empleados_hraes) { 
    $.post('../../../../App/View/Hraes/Modulo/Estudio/tabla.php', {
        busqueda: busqueda, 
        paginador: paginador, 
        id_tbl_empleados_hraes:id_tbl_empleados_hraes
    },
        function (data) {
            $("#tabla_estudio").html(data); 
        }
    );
}

function agregarEditarEstudio(id_object){
    $("#id_object").val(id_object);
    let titulo = document.getElementById("tituloEstudio");
    titulo.textContent = 'Modificar';
    $("#id_object").val(id_object);
    if (id_object == null){
        titulo.textContent = 'Agregar';
        $("#agregar_editar_estudio").find("input,textarea,select").val("");
    }

    $.post("../../../../App/Controllers/Hrae/EstudioC/DetallesC.php", {
        id_object: id_object
    },
        function (data) {
            let jsonData = JSON.parse(data);
            let estudio = jsonData.estudio; 

            let carrera = jsonData.carrera;
            let response = jsonData.response;

            $('#cedula_es_').val(response.cedula);

            $('#id_cat_nivel_estudios').empty();
            $('#id_cat_nivel_estudios').html(estudio);
            
            $('#id_cat_carrera_hraes').empty();
            $('#id_cat_carrera_hraes').html(carrera);
            
            $('#id_cat_nivel_estudios').selectpicker('refresh');
            $('#id_cat_carrera_hraes').selectpicker('refresh');
            $('.selectpicker').selectpicker();
        }
    );

    $("#agregar_editar_estudio").modal("show");
}

function salirAgregarEstudio(){
    $("#agregar_editar_estudio").modal("hide");
}


function guardarEstudio() {
    $.post("../../../../App/Controllers/Hrae/EstudioC/AgregarEditarC.php", {
        id_object: $("#id_object").val(),
        id_cat_carrera_hraes: $("#id_cat_carrera_hraes").val(),
        id_cat_nivel_estudios: $("#id_cat_nivel_estudios").val(),
        cedula: $("#cedula_es_").val(),
        id_tbl_empleados_hraes:id_tbl_empleados_hraes
    },
        function (data) {
            if (data == 'edit'){
                notyf.success('Nivel de estudio modificado con éxito');
            } else if (data == 'add') {
                notyf.success('Nivel de estudio agregado con éxito');  
            } else {
                notyf.error(mensajeSalida);
            }
            $("#agregar_editar_estudio").modal("hide");
            buscarEstudio();
        }
    );
}

function eliminarEstudio(id_object) {//ELIMINAR USUARIO
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
        $.post("../../../../App/Controllers/Hrae/EstudioC/EliminarC.php", {
                id_object: id_object
            },
            function (data) {
                if (data == 'delete'){
                    notyf.success('Nivel de estudio eliminado con éxito')
                } else {
                    notyf.error(mensajeSalida);
                }
                buscarEstudio();
            }
        );
    }
    });
}
