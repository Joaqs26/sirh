var id_tbl_empleados_hraes = document.getElementById('id_tbl_empleados_hraes').value;

function buscarFormaPago(){ //BUSQUEDA
    let buscarNew = clearElement(buscar_f);
    let buscarlenth = lengthValue(buscarNew);
    
    if (buscarlenth == 0){
        iniciarTabla_f(null, iniciarBusqueda_f(),id_tbl_empleados_hraes);
    } else {
        iniciarTabla_f(buscarNew, iniciarBusqueda_f(),id_tbl_empleados_hraes);
    }
}

function iniciarTabla_f(busqueda, paginador, id_tbl_empleados_hraes) { 
    $.post('../../../../App/View/Hraes/Modulo/FormaPago/tabla.php', {
        busqueda: busqueda, 
        paginador: paginador, 
        id_tbl_empleados_hraes:id_tbl_empleados_hraes
    },
        function (data) {
            $("#tabla_forma_pago").html(data); 
        }
    );
}

function agregarEditarFormaPago(id_object){
    $("#id_object").val(id_object);
    let titulo = document.getElementById("tituloFormaPago");
    titulo.textContent = 'Modificar';
    if (id_object == null){
        titulo.textContent = 'Agregar';
        $("#agregar_editar_forma_pago").find("input,textarea,select").val("");
    }

    $.post("../../../../App/Controllers/Hrae/FormaPagoC/DetallesC.php", {
        id_object: id_object
    },
        function (data) {
            let jsonData = JSON.parse(data);//se obtiene el json
            let entity = jsonData.response; //Se agrega a emtidad 
            let estatus = jsonData.estatus; //Se agrega a emtidad 
            let formatoPago = jsonData.formatoPago;
            let banco = jsonData.banco;

            $('#id_cat_estatus_formato_pago').empty();
            $('#id_cat_estatus_formato_pago').html(estatus); 
            $('#id_cat_formato_pago').empty();
            $('#id_cat_formato_pago').html(formatoPago); 

            $("#clabe").val(entity.clabe);
            $("#nombre_banco").val(banco);
            $("#id_cat_banco").val(entity.id_cat_banco);

            $('#id_cat_estatus_formato_pago').selectpicker('refresh');
            $('.selectpicker').selectpicker();
        }
    );

    $("#agregar_editar_forma_pago").modal("show");
}

function salirAgregarEditarFormaPago(){
    $("#agregar_editar_forma_pago").modal("hide");
}


function agregarEditarByDbByFormatoPago() {
    let clabe = $("#clabe").val();
    let id_object = $("#id_object").val();
    let id_cat_banco = $("#id_cat_banco").val();
    let id_cat_estatus_formato_pago = $("#id_cat_estatus_formato_pago").val();
    let id_cat_formato_pago = $("#id_cat_formato_pago").val();

    $.post("../../../../App/Controllers/Hrae/FormaPagoC/AgregarEditarC.php", {
        id_object: id_object,
        clabe: clabe,
        id_tbl_empleados_hraes:id_tbl_empleados_hraes,
        id_cat_banco:id_cat_banco,
        id_cat_estatus_formato_pago:id_cat_estatus_formato_pago,
        id_cat_formato_pago:id_cat_formato_pago,
    },
        function (data, status) {
            if (data == 'edit'){
                notyf.success('Forma de pago modificada con éxito');
            } else if (data == 'add') {
                notyf.success('Forma de pago agregada con éxito');  
            } else {
                notyf.error(mensajeSalida);
            }
            $("#agregar_editar_forma_pago").modal("hide");
            buscarFormaPago();
        }
    );
}


function eliminarFormaPago(id_object) {//ELIMINAR USUARIO
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
        $.post("../../../../App/Controllers/Hrae/FormaPagoC/EliminarC.php", {
                id_object: id_object
            },
            function (data, status) {
                if (data == 'delete'){
                    notyf.success('Forma de pago eliminada con éxito')
                } else {
                    notyf.error(mensajeSalida);
                }
                buscarFormaPago();
            }
        );
    }
    });
}

/*
document.addEventListener('DOMContentLoaded', function () {
    tippy('#agregar_forma_pago', {
        content: 'Agregar forma de pago.',
        theme: 'green',
    });
});
*/