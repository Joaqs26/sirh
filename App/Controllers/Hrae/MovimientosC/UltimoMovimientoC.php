<?php
include '../librerias.php';

//CLASS
$modelMovimientosM = new ModelMovimientosM();
$row = new Row();
$modelPlazasHraes = new modelPlazasHraes();

///MESSAGES
$bool = true;
$mensaje = 'ok';

///variables
$fecha_movimiento = $_POST['fecha_movimiento'];
$movimiento_general = $_POST['movimiento_general'];
$movimientoBaja = $_POST['movimientoBaja'];
$movimientoMov = $_POST['movimientoMov'];
$movimientoAlta = $_POST['movimientoAlta'];
$id_object = $_POST['id_object'];
$id_tbl_empleados_hraes = $_POST['id_tbl_empleados_hraes'];


///INFO DATABASE 
$existUltimoM = $row->returnArrayById($modelMovimientosM->countUltimoMovimiento($id_tbl_empleados_hraes));

///VALIDACIONES
if ($existUltimoM[0] != 0) { ///EXISTEN REGISTROS DE MOVIMIENTOS
    $ultimoMovimiento = $row->returnArrayById($modelMovimientosM->listadoUltimoMovimiento($id_tbl_empleados_hraes));

    if ($movimiento_general == $movimientoBaja && $ultimoMovimiento[0] == $movimientoBaja) { ///EL USUARIO INTENTA HACER UNA BAJA CUANDO YA ESTÁ EN BAJA
        $bool = false; ///CAMBIAR ESTATUS DE VALORES Y MENSAJE DE ERROR
        $mensaje = 'Para asignar una baja, el empleado debe estar asociado a una plaza.';
    } else if ($movimiento_general == $movimientoAlta && $ultimoMovimiento[0] != $movimientoBaja) { ///EL USUARIO INTENTA HACER UNA ALTA CUANDO NO HAY UNA BAJA PREVIA
        $bool = false; ///CAMBIAR ESTATUS DE VALORES Y MENSAJE DE ERROR
        $mensaje = 'Para que un empleado pueda recibir una alta, debe haber tenido una baja previa.';
    } else if ($movimiento_general == $movimientoMov && $ultimoMovimiento[0] == $movimientoBaja) { ///EL USUARIO INTENTA HACER UN MOVIMIENTO SIN ALTA PREVIA
        $bool = false; ///CAMBIAR ESTATUS DE VALORES Y MENSAJE DE ERROR
        $mensaje = 'Para que un empleado reciba un movimiento, es necesario que tenga una alta previa.';
    } else if ($ultimoMovimiento[1] >= $fecha_movimiento) { ///LA FECHA INGRESADA ES ANTERIOR A LA FECHA DEL ÚLTIMO MOVIMIENTO
        $bool = false; ///CAMBIAR ESTATUS DE VALORES Y MENSAJE DE ERROR
        $mensaje = 'La fecha ingresada debe ser posterior a la fecha registrada del último movimiento.';
    }
} else { ///NO EXISTEN REGISTROS DEL USUARIO
    if ($movimiento_general != $movimientoAlta) { ///SOLO SE PERMITEN ALTAS PARA NUEVOS REGISTROS
        $bool = false; ///CAMBIAR ESTATUS DE VALORES Y MENSAJE DE ERROR
        $mensaje = 'Para asignar una baja o movimiento, el empleado debe estar asociado a una plaza.';
    }
}

$row = [
    'bool' => $bool,
    'mensaje' => $mensaje,
];

echo json_encode($row);
