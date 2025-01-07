///modificar en caso de cambie id
///VARIABLES DE CATALOGO TBL MOVIMIENTOS
var movimientoBaja = 3;
var movimientoAlta = 1;
var movimientoMov = 2;

function validarAgregar(){
    let id_object = document.getElementById('id_object').value;
    if (id_object){
        if (validarAccion()){
            validarMovimiento();
        }
    } else {
        validarMovimiento();
    }
}

function validarMovimiento(){
    let movimiento_general = document.getElementById('movimiento_general').value;
    let id_tbl_movimientos = document.getElementById('id_tbl_movimientos').value;
    let fecha_movimiento = document.getElementById('fecha_movimiento').value;
    let id_tbl_control_plazas_hraes = document.getElementById('id_tbl_control_plazas_hraes').value;
    let fecha_inicio = document.getElementById('fecha_inicio').value;
    let id_cat_caracter_nom_hraes = document.getElementById('id_cat_caracter_nom_hraes').value;
    let id_object = document.getElementById('id_object').value;
    let situacionPlaza = document.getElementById('situacionPlaza').value;
    let num_plaza_new = document.getElementById('num_plaza_new').value;

    if (validarData(movimiento_general,'Movimiento general')){///CONDICION DE INICIAL PARA MOVIMIENTO GENERAL
        if(movimiento_general != movimientoBaja){ ///EL MOVIMIENTO ES UNA ALTA O MOVIMIENTO
            if(validarData(id_tbl_movimientos,'Movimiento especifico') && ///VALIDACION DE CAMPOS REQUERIDOS PARA ALTA O MOVIMIENTO
                validarData(fecha_movimiento,'Fecha de movimiento') &&
                validarData(id_tbl_control_plazas_hraes,'Núm. Plaza') &&
                validarData(fecha_inicio,'Fecha de inicio')){
                if (situacionPlaza == 0){ ///VALIDAR QUE EL NUEVO NUMERO DE PLAZA SEA VALIDO
                    if(validarData(num_plaza_new,'Núm. Plaza') &&
                       caracteresCount('Número de plaza',8,num_plaza_new)){
                        validarUltimoMovimiento(movimiento_general,id_object,fecha_movimiento,num_plaza_new,situacionPlaza);///FUNCION PARA VALIDAR EL ULTIMO MOVIMIENTO
                    }
                } else {
                    limpiarNumPlaza();
                    validarUltimoMovimiento(movimiento_general,id_object,fecha_movimiento,num_plaza_new,1);///FUNCION PARA VALIDAR EL ULTIMO MOVIMIENTO
                }
            }
        } else { ///EL MOVIMIENTO ES UN BAJA
            if(validarData(id_tbl_movimientos,'Movimiento especifico') && ///VALIDACION DE CAMPOS REQUERIDOS PARA BAJA
               validarData(fecha_movimiento,'Fecha de movimiento')){
                limpiarBaja(); 
                validarUltimoMovimiento(movimiento_general,id_object,fecha_movimiento,num_plaza_new,1);///FUNCION PARA VALIDAR EL ULTIMO MOVIMIENTO
            }
        }
    }
}

///LA FUNCION VALIDA EL ULTIMO MOVIMIENTO, FECHAS Y CAMPOS PARA ASIGNAR EL MOVIMIENTO
function validarUltimoMovimiento(movimiento_general,id_object,fecha_movimiento,num_plaza_new,situacionPlaza){
    $.post("../../../../App/Controllers/Hrae/MovimientosC/UltimoMovimientoC.php", {
        movimiento_general:movimiento_general,
        fecha_movimiento:fecha_movimiento,
        movimientoBaja:movimientoBaja,
        id_object:id_object,
        id_tbl_empleados_hraes:id_tbl_empleados_hraes,
        movimientoAlta:movimientoAlta,
        movimientoMov:movimientoMov,
        num_plaza_new:num_plaza_new,
        situacionPlaza:situacionPlaza,
    },  
        function (data) {
            console.log(data);
            let jsonData = JSON.parse(data);
            let bool = jsonData.bool;
            let mensaje = jsonData.mensaje;

            if(bool){
                guardarMovimiento();///ACCCION DE GUARDAR INFO
            } else {
                messageLarge(mensaje);
            }
        }
    );
}

///LA FUNCION OBTIENE EL TIPO DE CONTRATACION  Y CENTRO DE TRABAJO CUANDO SE CAMBIA EL EVENTO DE  NUM_PLAZA
document.getElementById("id_tbl_control_plazas_hraes").addEventListener("change", function() {
    let id_tbl_control_plazas_hraes = this.value;
    $.post("../../../../App/Controllers/Hrae/MovimientosC/NumPlazaC.php", {
        id_tbl_control_plazas_hraes: id_tbl_control_plazas_hraes,
    },
        function (data) {
            console.log(data);
            let jsonData = JSON.parse(data);
            let contratacion = jsonData.contratacion;
            let centroTrabajo = jsonData.centroTrabajo;
            let situacionPlaza = jsonData.situacionPlaza;

            if(situacionPlaza == 0){
                mostrarContenido('ocultar_model_plaza');
            } else {
                ocultarContenido('ocultar_model_plaza');
            }

            $('#situacionPlaza').val(situacionPlaza);
            $('#tipo_contratacion_mx').val(contratacion); 
            $('#centro_trabajo_mx').val(centroTrabajo);
        }
    );
  });


///LA FUNCION PERMITE OCULTAR O MOSTRAR EL CONTENIDO DE UNA ETIQUETA DIV
///ASI COMO OBTIENE EL SEGUNDO CATALOGO DE MOVIMIENTO ESPECIFICO
document.getElementById("movimiento_general").addEventListener("change", function() {
    let movimiento_general = this.value;
    if (movimiento_general == movimientoBaja){
        $('#situacionPlaza').val(null);
        ocultarContenido('ocultar_model');
        ocultarContenido('ocultar_model_plaza');
    } else {
        mostrarContenido('ocultar_model');
    }
    $.post("../../../../App/Controllers/Hrae/MovimientosC/MEspecificoC.php", {
        movimiento_general: movimiento_general,
    },
        function (data) {
            console.log(data);
            var jsonData = JSON.parse(data);
            var especifico = jsonData.especifico; 

            $('#id_tbl_movimientos').empty();
            $('#id_tbl_movimientos').html(especifico);   
        }
    );
  });

function ocultarContenido(text) {
    let x = document.getElementById(text);
    x.style.display = "none";
    
}

function mostrarContenido(text) {
    let x = document.getElementById(text);
    x.style.display = "block";
}

///FUNCION DE MENSAJE EXTENDIDO
function messageLarge(text){
    Swal.fire({
        icon: "error",
        title: "Oops...",
        text: text,
      });
}

function limpiarBaja(){ ////LA FUNCION LIMPIA LOS COMPOS EXCEPTO LOS DE BAJA
    $('#id_tbl_control_plazas_hraes').val(''); 
    $('#tipo_contratacion_mx').val(''); 
    $('#centro_trabajo_mx').val(''); 
    $('#fecha_inicio').val(''); 
    $('#fecha_termino').val(''); 
    $('#id_cat_caracter_nom_hraes').val(''); 
}

function limpiarNumPlaza(){ ////LA FUNCION LIMPIA LOS CAMPO DE NUMERO DE PLAZA
    $('#num_plaza_new').val(''); 
}

/*
var id_tbl_empleados_hraes = document.getElementById('id_tbl_empleados_hraes').value;
var id_baja = 3; ///CATALOGO
var id_movimiento = 2;///CATALOGO
var id_alta = 1;///CATALOGO
var id_movimiento_vacante = 5;///CATALOGO

function validarPw(){
    let id_object = document.getElementById('id_object').value;
    if (id_object){
        if (validarAccion()){
            validarMovimiento();
        }
    } else {
        validarMovimiento();
    }
}


function validarMovimiento(){
    let num_plaza_m = document.getElementById('num_plaza_m').value;
    let movimiento_general = document.getElementById('movimiento_general').value;
    let id_tbl_movimientos = document.getElementById('id_tbl_movimientos').value;
    let fecha_inicio = document.getElementById('fecha_inicio').value;
    let fecha_termino = document.getElementById('fecha_termino').value;
    let fecha_movimiento = document.getElementById('fecha_movimiento').value;

    let id_tipo_plaza = document.getElementById('id_tipo_plaza').value;

    let num_plaza_validate = document.getElementById('num_plaza_validate').value;
    let id_tbl_movimientos_validate = document.getElementById('id_tbl_movimientos_validate').value;

    if (validarData(movimiento_general,'Movimiento general') &&
    validarData(id_tbl_movimientos,'Movimiento especifico') &&
    validarData(fecha_movimiento,'Fecha de movimiento')   
    ){
        if (movimiento_general != id_baja){
            if (validarData(num_plaza_m,'Núm. de plaza') &&
            validarData(fecha_inicio,'Fecha inicio')
        ){
            if (num_plaza_validate == num_plaza_m && id_tbl_movimientos_validate == id_tbl_movimientos){
                guardarMovimiento(null);
            } else {
                validarUltimoMovimiento(movimiento_general,id_tipo_plaza,movimiento_general);
            }
        }
        } else {
            if (num_plaza_validate == num_plaza_m && id_tbl_movimientos_validate == id_tbl_movimientos){
                guardarMovimiento(null);

            } else {
                validarUltimoMovimiento(movimiento_general,id_tipo_plaza,movimiento_general);
            }
            
        }
    }
}

document.getElementById("movimiento_general").addEventListener("change", function() {
    let movimiento_general = this.value;
    if (movimiento_general == id_baja){
        ocultarContenido();
    } else {
        mostrarContenido();
    }
    $.post("../../../../App/Controllers/Hrae/MovimientosC/MEspecificoC.php", {
        movimiento_general: movimiento_general,
    },
        function (data) {
            var jsonData = JSON.parse(data);
            var especifico = jsonData.especifico; 

            $('#id_tbl_movimientos').empty();
            $('#id_tbl_movimientos').html(especifico);   
        }
    );
  });

function validarNumPlaza(){
    let num_plaza_m = document.getElementById('num_plaza_m').value.trim();

    $.ajax({
        type: 'POST',
        url: "../../../../App/Controllers/Hrae/MovimientosC/NumPlazaC.php",
        data: {num_plaza_m:num_plaza_m },
        success: function (data) {
            jsonData = JSON.parse(data);
            let tipo_plaza = jsonData.tipo_plaza;
            let unidad_responsable = jsonData.unidad_responsable;
            let id_tipo_plaza = jsonData.id_tipo_plaza;
            let id_plaza = jsonData.id_plaza;

            $("#id_tipo_plaza").val(id_tipo_plaza);
            $("#id_plaza").val(id_plaza);
            $("#tipo_plaza_m").val(tipo_plaza);
            $("#unidad_responsable_m").val(unidad_responsable);
        }
    });
}

///LA FUNCION PERMITE CONSULTAR EL ULTIMO MOVIMIENTO DEL EMPLEADO
function validarUltimoMovimiento(id_movimiento,id_tipo_plaza,movimiento_general){
    $.ajax({
        type: 'POST',
        url: "../../../../App/Controllers/Hrae/MovimientosC/UltimoMovimientoC.php",
        data: {id_tbl_empleados_hraes:id_tbl_empleados_hraes,
            id_movimiento:id_movimiento
         },
        success: function (data) {
            jsonData = JSON.parse(data);
            let bool = jsonData.bool;
            let mensaje = jsonData.mensaje;
            let id_plaza_x = jsonData.id_plaza_x;

            if (bool){
                if (movimiento_general != id_baja){
                if (id_tipo_plaza == id_movimiento_vacante){
                    ///Guardar
                    guardarMovimiento(null);
                } else {
                    mensajeError('La plaza no se encuentra vacante');
                }
            } else {
                guardarMovimiento(id_plaza_x);
            }
            } else {   
                mensajeError(mensaje);
            }
        }
    });
}





function ocultarContenido() {
    let x = document.getElementById("ocultar_model");
    x.style.display = "none";
    
}

function mostrarContenido() {
    let x = document.getElementById("ocultar_model");
    x.style.display = "block";
}
    */