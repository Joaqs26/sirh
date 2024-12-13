var id_tbl_empleados_hraes = document.getElementById('id_tbl_empleados_hraes').value;

function buscarQuinquenio(){
    iniciarTabla_qu(id_tbl_empleados_hraes);
}

function iniciarTabla_qu(id_tbl_empleados_hraes) { 
    $.post('../../../../App/View/Hraes/Modulo/Quinquenio/tabla.php', {
        id_tbl_empleados_hraes:id_tbl_empleados_hraes
    },
        function (data) {
            $("#tabla_quinquenio").html(data); 
        }
    );
}

function agregarEditarQuinquenio(id_object){
    $("#id_object").val(id_object);
    let titulo = document.getElementById("titulo_quinquenio");
    titulo.textContent = 'Modificar';
    $("#id_object").val(id_object);
    if (id_object == null){
        titulo.textContent = 'Agregar';
        $("#agregar_editar_quinquenio").find("input,textarea,select").val("");
    }

    $.post("../../../../App/Controllers/Hrae/QuinquenioC/DetallesC.php", {
        id_object: id_object,
    },
        function (data) {
            let jsonData = JSON.parse(data);
            let entity = jsonData.response; 
            let quinquenio = jsonData.quinquenio; 

            $('#id_cat_quinquenio').empty();
            $('#id_cat_quinquenio').html(quinquenio);  
            $("#fecha_registro").val(entity.fecha_registro);

            $('#id_cat_quinquenio').selectpicker('refresh');
            $('.selectpicker').selectpicker();

        }
    );

    $("#agregar_editar_quinquenio").modal("show");
}

function salirAgregarEditarQuinquenio(){
    $("#agregar_editar_quinquenio").modal("hide");
}

function agregarEditarByDbByQuinquenio() {

    $.post("../../../../App/Controllers/Hrae/QuinquenioC/AgregarEditarC.php", {
        id_object: $("#id_object").val(),
        id_cat_quinquenio: $("#id_cat_quinquenio").val(),
        //fecha_registro: $("#fecha_registro").val(),
        id_tbl_empleados_hraes:id_tbl_empleados_hraes,
    },
        function (data) {
            if (data == 'edit'){
                notyf.success('Quinquenio modificado con éxito');
            } else if (data == 'add') {
                notyf.success('Quinquenio agregado con éxito');  
            } else {
                notyf.error(mensajeSalida);
            }
            $("#agregar_editar_quinquenio").modal("hide");
            buscarQuinquenio();
        }
    );
}

function eliminarQuinquenio(id_object) {
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
        $.post("../../../../App/Controllers/Hrae/QuinquenioC/EliminarC.php", {
                id_object: id_object
            },
            function (data) {
                if (data == 'delete'){
                    notyf.success('Quinquenio eliminado con éxito')
                } else {
                    notyf.error(mensajeSalida);
                }
                buscarQuinquenio();
            }
        );
    }
    });
}

