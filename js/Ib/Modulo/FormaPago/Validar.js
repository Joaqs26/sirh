function validarFormaPago(){
    let clabe = document.getElementById('clabe').value;
    let id_cat_estatus_formato_pago = document.getElementById('id_cat_estatus_formato_pago').value;
    //let id_cat_formato_pago = document.getElementById('id_cat_formato_pago').value;
    let id_object = document.getElementById('id_object').value;

    if (validarData(clabe,'Cuenta clabe') &&
        validarData(id_cat_estatus_formato_pago,'Estatus')// &&
       // validarData(id_cat_formato_pago,'Forma de pago') 
    ){
        if(validarCLABE(clabe)){
            //agregarEditarByDbByFormatoPago();
            validarEstatusCuentaC(id_object, id_cat_estatus_formato_pago);
        } else {
            notyf.error('Campo Cuenta clabe* invalida');
        }
    }
}

function validarCuenta(){
    let clabe = document.getElementById('clabe').value;
    let clabeSub = clabe.substr(0, 3);

    $.ajax({
        type: 'POST',
        url: "../../../../App/Controllers/Central/FormaPagoC/ValidarClabeC.php",
        data: {clabeSub:clabeSub },
        success: function (data) {
            jsonData = JSON.parse(data);
            let nombre = jsonData.nombre;
            let id = jsonData.id;

            $("#nombre_banco").val(nombre);
            $("#id_cat_banco").val(id);
        }
    });
}

function validarEstatusCuentaC(id_object, id_cat_estatus_formato_pago) { 
    $.post('../../../../App/Controllers/Central/FormaPagoC/ValidarEstatusC.php', {
        id_object: id_object, 
        id_cat_estatus_formato_pago: id_cat_estatus_formato_pago,
        id_tbl_empleados_hraes:id_tbl_empleados_hraes
    },
        function (data) {
            jsonData = JSON.parse(data);
            let bool = jsonData.bool;
            let message = jsonData.message;

            if(bool){
                agregarEditarByDbByFormatoPago();
            } else {
                notyf.error(message);
            }
        }
    );
}