var id_tbl_empleados_hraes = document.getElementById('id_tbl_empleados_hraes').value;
var mensajeSalida = 'Se produjo un error al ejecutar la acción';

function iniciarAdicional(){
    detallesAdicional(id_tbl_empleados_hraes);
}

function detallesAdicional(id_object){
    $.post("../../../../App/Controllers/Hrae/AdicionalC/DetallesC.php", {
        id_object: id_object
    },
        function (data) {
            let jsonData = JSON.parse(data);
            let entity = jsonData.response; 
            
            $("#fecha_expedicion").val(entity.fecha_expedicion);
            $("#fecha_ingreso_gob_fed").val(entity.fecha_ingreso_gob_fed);
            $("#vigencia_del").val(entity.vigencia_del);
            $("#vigencia_al").val(entity.vigencia_al);
            $("#funciones").val(entity.funciones);
            $("#antiguedad").val(entity.antiguedad);
            $("#id_ctrl_adic_emp_hraes").val(entity.id_ctrl_adic_emp_hraes);
        }
    );
}


function gurdarAdicionals() {
    $.post("../../../../App/Controllers/Hrae/AdicionalC/AgregarEditarC.php", {
        fecha_expedicion: $("#fecha_expedicion").val(),
        fecha_ingreso_gob_fed: $("#fecha_ingreso_gob_fed").val(),
        vigencia_del: $("#vigencia_del").val(),
        vigencia_al: $("#vigencia_al").val(),
        funciones: $("#funciones").val(),
        antiguedad: $("#antiguedad").val(),
        id_ctrl_adic_emp_hraes: $("#id_ctrl_adic_emp_hraes").val(),
        id_tbl_empleados_hraes: id_tbl_empleados_hraes,
    },
        function (data) {
            if (data == 'edit'){
                notyf.success('Información adicional modificada con éxito');
            } else if (data == 'add') {
                notyf.success('Información adicional agregada con éxito');  
            } else {
                notyf.error(mensajeSalida);
            }
            iniciarAdicional();
        }
    );
}
