
function validarQuinquenio(){
    let id_cat_quinquenio = document.getElementById('id_cat_quinquenio').value;
    //let fecha_registro = document.getElementById('fecha_registro').value;
    let id_object = document.getElementById('id_object').value;

    if (validarData(id_cat_quinquenio,'Importe') 
    ){
        validarQuinquenio_x(id_tbl_empleados_hraes,id_object);
    }
}

function validarQuinquenio_x(id_tbl_empleados_hraes,id_object){
    $.post("../../../../App/Controllers/Hrae/QuinquenioC/ValidarC.php", {
        id_tbl_empleados_hraes:id_tbl_empleados_hraes,
        id_object:id_object
    },
        function (data) {
            let jsonData = JSON.parse(data);
            let message = jsonData.message; 
            let bool = jsonData.bool;
            if(!bool){
                agregarEditarByDbByQuinquenio();
            } else {
                notyf.error(message);
            }
        }
    );
}