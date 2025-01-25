<?php
include '../librerias.php';

// Obtener la fecha actual
$fechaActual = date('Y-m-d');

///ESTANCIAS DE CLASES 
$row = new Row();
$bitacoraM = new BitacoraM();
$modelMovimientosM = new ModelMovimientosM();
$catMovimientoM = new CatMovimientoM();
$modelEmpleadosHraes = new modelEmpleadosHraes();
$modelPlazasHraes = new modelPlazasHraes();

///VARIABLES DE MODEL JS
$nombreTabla = 'central.tbl_plazas_empleados_hraes';
$movimientoBaja = $_POST['movimientoBaja'];
$movimientoAlta = $_POST['movimientoAlta'];
$movimientoMov = $_POST['movimientoMov'];
$movimiento_general = $_POST['movimiento_general'];
$num_plaza = $_POST['num_plaza'];
$id_cat_situacion_plaza_hraes = $_POST['id_cat_situacion_plaza_hraes'];

// Validar si no hay una fecha de movimiento enviada y establecer la fecha actual
$fecha_movimiento = !empty($_POST['fecha_movimiento']) ? $_POST['fecha_movimiento'] : $fechaActual;

///SE OBTIENE EL MOVIMIENTO GENERAL, ES DECIR BAJA = 1, ALTA = 2, MOVIMIENTO 3 -- EJEMPLO
$idMovimiento = $row->returnArrayById($catMovimientoM->listadoIdMovimiento($_POST['id_tbl_movimientos']));
$ultimoMovimientoCount = $row->returnArrayById($modelMovimientosM->countUltimoMovimiento($_POST['id_tbl_empleados_hraes'])); ///VALIDA EL ULTIMO MOVIMIENTO

$idPlazaA = 0; ///VARIABLE CON EL NOMBRE DE PLAZA ANTERIOR, REPRESENTA EL ULTIMO ID DE PLAZA
if ($ultimoMovimientoCount[0] != 0) { ///VALIDA SI EXISTEN MOVIMIENTOS EN LA TABLA
    $ultimoIdPlaza = $row->returnArrayById($modelMovimientosM->idPlazaMovimiento($_POST['id_tbl_empleados_hraes'])); ///OBTIENE LA LISTA DE ID DE PLAZA
    $idPlazaA = $ultimoIdPlaza[0]; ////ULTIMO ID DE PLAZA EN TBL_PLAZAS_EMPLEADOS_HRAES
}

$id_tbl_control_plazas_hraes = $_POST['id_tbl_control_plazas_hraes']; ///ID DE PLAZA SELECCIONADA
if ($movimiento_general == $movimientoBaja) { ///VALIDA QUE EL MOVIMIENTO SELECCIONADO SEA IGUAL A BAJA
    $id_tbl_control_plazas_hraes = $idPlazaA; /////VALIDACION: Si el movimiento es baja, se toma como base el último movimiento de la tabla tbl_plazas_empleados_hraes, el id de la plaza para usarse como baja
}

if ($idMovimiento[0] != $movimientoBaja) {///MODIFICAR EL NUMERO DE EMPLEADO (Donde 3 = baja)
    $claveCentro = $row->returnArrayById($modelPlazasHraes->claveCentroTrabajo($_POST['id_tbl_control_plazas_hraes'])); ///SE OBTIENE LA CLAVE DEL CENTRO DE TRABAJO PARA CONCATENAR
    $numEmpleado = $row->returnArrayById($modelEmpleadosHraes->numEmpleado($_POST['id_tbl_empleados_hraes'])); ////SE OBTIENE EL NUM EMPLEADO PARA CONCATENARSE CON LA CLAVE DE CENTRO DE TRABAJO

    $condicion = [
        'id_tbl_empleados_hraes' => $_POST['id_tbl_empleados_hraes'] ///CONDICION
    ];

    $datos = [
        'num_empleado' => trim($numEmpleado[0]) . '-' . trim($claveCentro[0]), ///CONCATENACION DE NUM DE EMPLEADO
    ];
    $modelEmpleadosHraes->editarByArray($connectionDBsPro, $datos, $condicion); ///ACCION
}

$condicion = [ ///SE CREA LA CONDICION PARA MODIFICAR/AGREGAR INFORMACION TBL_PLAZAS_EMPLEADOS_HRAES
    'id_tbl_plazas_empleados_hraes' => $_POST['id_object']
];

$datos = [ ///INFORMACION A GUARDAR 
    'id_tbl_movimientos' => $_POST['id_tbl_movimientos'],
    'fecha_movimiento' => $fecha_movimiento, // USAR LA FECHA OBTENIDA
    'id_tbl_control_plazas_hraes' => $id_tbl_control_plazas_hraes,
    'fecha_inicio' => $_POST['fecha_inicio'],
    'fecha_termino' => $_POST['fecha_termino'],
   // 'id_cat_caracter_nombramiento' => $_POST['id_cat_caracter_nombramiento'],
  //  'motivo_estatus' => $_POST['motivo_estatus'],
    'observaciones' => $_POST['observaciones'],
    'id_tbl_empleados_hraes' => $_POST['id_tbl_empleados_hraes'],
];

///BITACORA
$var = [
    'datos' => $datos,
    'condicion' => $condicion
];

///MODIFICAR ESTATUS DE PLAZA    
modificarPlaza($connectionDBsPro, $movimientoBaja, $movimientoAlta, $movimientoMov, $movimiento_general, $_POST['id_tbl_control_plazas_hraes'], $idPlazaA, $_POST['id_tbl_empleados_hraes'], $fecha_movimiento, $num_plaza, $id_cat_situacion_plaza_hraes);
if ($_POST['id_object'] != null) { //Modificar
    if ($modelMovimientosM->editarByArray($connectionDBsPro, $datos, $condicion, $nombreTabla)) {
        $dataBitacora = [
            'nombre_tabla' => '<central.tbl_plazas_empleados_hraes',
            'accion' => 'MODIFICAR',
            'valores' => json_encode($var),
            'fecha' => $timestamp,
            'id_users' => $_SESSION['id_user']
        ];
        $bitacoraM->agregarByArray($connectionDBsPro, $dataBitacora, 'central.bitacora_hraes');
        echo 'edit';
    }
} else { //Agregar
    if ($modelMovimientosM->agregarByArray($connectionDBsPro, $datos, $nombreTabla)) {
        $dataBitacora = [
            'nombre_tabla' => 'central.tbl_plazas_empleados_hraes',
            'accion' => 'AGREGAR',
            'valores' => json_encode($var),
            'fecha' => $timestamp,
            'id_users' => $_SESSION['id_user']
        ];
        $bitacoraM->agregarByArray($connectionDBsPro, $dataBitacora, 'central.bitacora_hraes');
        echo 'add';
    }
}



/////------------------------------- FUNCIONES AUXILIARES
function modificarPlaza($connectionDBsPro, $movimientoBaja, $movimientoAlta, $movimientoMov, $movimiento_general, $idPlaza, $idPlazaAnte, $idEmpleados, $fecha, $num_plaza, $id_cat_situacion_plaza_hraes)
{
    ///VARIABLES DE CATALOGO CAT_PLAZAS -> CAMBIAR EN CASO DE CAMBIAR ID
    $vacante = 5;///CATALOGO
    $ocupada = 3;///CATALOGO
    $congelada = 6;
    $idMovimientoVal = null;
    if ($movimiento_general == $movimientoBaja) { ///MOVIMIENTO BAJA, SE PONE EN BACANTE LA PLAZA A LA QUE ESTABA ASIGNADO
        $idMovimientoVal = $congelada;
        $idPlaza = $idPlazaAnte;
        $id_cat_situacion_plaza_hraes = 1;
    } else if ($movimiento_general == $movimientoAlta) { ///MOVIMIENTO ALTA, PONE EN OCUPADA LA NUEVA PLAZA
        $idMovimientoVal = $ocupada;
    } else if ($movimiento_general == $movimientoMov) {
        $idMovimientoVal = $congelada;
        //agregarMovimiento($connectionDBsPro,20,$idPlazaAnte,$idEmpleados,$fecha);
        actualizarPlaza($connectionDBsPro, $idMovimientoVal, $idPlazaAnte, $num_plaza, 1);
        $idMovimientoVal = $ocupada;
    }

    //UPDATE PLAZA
    actualizarPlaza($connectionDBsPro, $idMovimientoVal, $idPlaza, $num_plaza, $id_cat_situacion_plaza_hraes);
}


function agregarMovimiento($connectionDBsPro, $idMovimiento, $idPlaza, $idEmpleados, $fecha)
{
    $modelMovimientosM = new ModelMovimientosM();
    $datos = [
        'id_tbl_movimientos' => $idMovimiento,
        'id_tbl_control_plazas_hraes' => $idPlaza,
        'id_tbl_empleados_hraes' => $idEmpleados,
        'fecha_movimiento' => $fecha,
    ];
    $modelMovimientosM->agregarByArray($connectionDBsPro, $datos, 'tbl_plazas_empleados_hraes');
}


///LA FUNCION ESPERA COMO PARAMETRO  LA CONEXION, EL ID DEL CATALOGO Y LA CONDICION PARA UPDATE
function actualizarPlaza($connectionDBsPro, $id_cat_plazas, $id_tbl_control_plazas_hraes, $num_plaza, $id_cat_situacion_plaza_hraes)
{
    $model = new modelPlazasHraes(); ///CLASS

    $condicion = [
        'id_tbl_control_plazas_hraes' => $id_tbl_control_plazas_hraes, ///CONDICION DE PLAZA
    ];

    $datos = [
        'id_cat_tipo_plazas' => $id_cat_plazas,
    ];

    if ($id_cat_situacion_plaza_hraes == 0) { ////VALIDA PARA ACTUALIZACION DE NUM DE PLAZA
        $datos = [
            'id_cat_tipo_plazas' => $id_cat_plazas,
            'num_plaza' => $num_plaza,
            'id_cat_situacion_plaza_hraes' => 1,
        ];
    }

    $model->editarByArray($connectionDBsPro, $datos, $condicion);
}