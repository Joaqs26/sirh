var id_tbl_empleados_hraes = document.getElementById('id_tbl_empleados_hraes').value;

function buscarLicencia(){ //BUSQUEDA
    let buscarNew = clearElement(buscar_li);
    let buscarlenth = lengthValue(buscarNew);
    
    if (buscarlenth == 0){
        iniciarTabla_li(null, iniciarBusqueda_li(),id_tbl_empleados_hraes);
    } else {
        iniciarTabla_li(buscarNew, iniciarBusqueda_li(),id_tbl_empleados_hraes);
    }
}

function iniciarTabla_li(busqueda, paginador, id_tbl_empleados_hraes) { 
    $.post('../../../../App/View/Hraes/Modulo/Licencias/tabla.php', {
        busqueda: busqueda, 
        paginador: paginador, 
        id_tbl_empleados_hraes:id_tbl_empleados_hraes
    },
        function (data) {
            $("#tabla_licencia").html(data); 
        }
    );
}

function agregarEditarLicencia(id_object){
    $("#id_object").val(id_object);
    let titulo = document.getElementById("titulolicencia");
    titulo.textContent = 'Modificar';
    $("#id_object").val(id_object);
    if (id_object == null){
        titulo.textContent = 'Agregar';
        $("#agregar_editar_licencia").find("input,textarea,select").val("");
    }

    $.post("../../../../App/Controllers/Hrae/LicenciaC/DetallesC.php", {
        id_object: id_object
    },
        function (data) {
            let jsonData = JSON.parse(data);
            let entity = jsonData.entity; 
            let licencia = jsonData.licencia;
            let dias = jsonData.dias;
            let estatus_ = jsonData.estatus;

            $('#horas_max_dia').val(entity.horas_max_dia);
            $('#fecha_desde_').val(entity.fecha_desde);
            $('#fecha_hasta_').val(entity.fecha_hasta);
            $('#fecha_inicio_nom').val(entity.fecha_inicio_nom);
            $('#fecha_fin_nomina').val(entity.fecha_fin_nomina);
            $('#fecha_registro_').val(entity.fecha_registro);
            $('#observaciones_licencia').val(entity.observaciones);

            $('#id_cat_tipo_licencia').empty();
            $('#id_cat_tipo_licencia').html(licencia);

            $('#id_cat_tipo_dias').empty();
            $('#id_cat_tipo_dias').html(dias);

            $('#id_cat_estatus_incidencias').empty();
            $('#id_cat_estatus_incidencias').html(estatus_);

            $('#id_cat_estatus_incidencias').selectpicker('refresh');
            $('#id_cat_tipo_licencia').selectpicker('refresh');
            $('#id_cat_tipo_dias').selectpicker('refresh');
            $('.selectpicker').selectpicker();
        }
    );

    $("#agregar_editar_licencia").modal("show");
}

function salirAgregarLicencia(){
    $("#agregar_editar_licencia").modal("hide");
}


function guardarLicencia() {
    $.post("../../../../App/Controllers/Hrae/LicenciaC/AgregarEditarC.php", {
        id_object: $("#id_object").val(),
        id_cat_tipo_licencia: $("#id_cat_tipo_licencia").val(),
        id_cat_tipo_dias: $("#id_cat_tipo_dias").val(),
        horas_max_dia: $("#horas_max_dia").val(),
        fecha_desde: $("#fecha_desde_").val(),
        fecha_hasta: $("#fecha_hasta_").val(),
        fecha_inicio_nom: $("#fecha_inicio_nom").val(),
        fecha_fin_nomina: $("#fecha_fin_nomina").val(),
        fecha_registro: $("#fecha_registro_").val(),
        observaciones: $("#observaciones_licencia").val(),
        id_cat_estatus_incidencias: $("#id_cat_estatus_incidencias").val(),
        id_tbl_empleados_hraes:id_tbl_empleados_hraes
    },
        function (data) {
            if (data == 'edit'){
                notyf.success('Licencia modificada con éxito');
            } else if (data == 'add') {
                notyf.success('Licencia agregada con éxito');  
            } else {
                notyf.error(mensajeSalida);
            }
            $("#agregar_editar_licencia").modal("hide");
            buscarLicencia();
        }
    );
}

function eliminarlicencia(id_object) {//ELIMINAR USUARIO
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
        $.post("../../../../App/Controllers/Hrae/LicenciaC/EliminarC.php", {
                id_object: id_object
            },
            function (data) {
                if (data == 'delete'){
                    notyf.success('Licencia eliminada con éxito')
                } else {
                    notyf.error(mensajeSalida);
                }
                buscarLicencia();
            }
        );
    }
    });
}
