<?php

include '../librerias.php';

$faltaModelM = new FaltaModelM();

$bool = false;
$message = 'ok';

if ($faltaModelM->process_1()) {
    if ($faltaModelM->process_2()) {
        if ($faltaModelM->process_3()) {
            if ($faltaModelM->process_4()) {
                if ($faltaModelM->process_5()) {
                    if ($faltaModelM->process_6()) {
                        if ($faltaModelM->process_7()) {
                            if ($faltaModelM->process_8()) {
                                $bool = true;
                            } else {
                                $message = 'Error en p8';
                            }
                        } else {
                            $message = 'Error en p7';
                        }
                    } else {
                        $message = 'Error en p6';
                    }
                } else {
                    $message = 'Error en p5';
                }
            } else {
                $message = 'Error en p4';
            }
        } else {
            $message = 'Error en p3';
        }
    } else {
        $message = 'Error en p2';
    }
} else {
    $message = 'Error en p1';
}

$var = [
    'bool' => $bool,
    'message' => $message,
];
echo json_encode($var);
