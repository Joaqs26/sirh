<?php

include '../librerias.php';

$faltaModelM = new FaltaModelM();

$bool = true;
$message = 'ok';

if ($faltaModelM->process_1()) {
    if ($faltaModelM->process_2()) {
        if ($faltaModelM->process_3()) {
            if ($faltaModelM->process_4()) {
                if ($faltaModelM->process_5()) {
                    if ($faltaModelM->process_6()) {
                        if ($faltaModelM->process_7()) {
                            // Éxito total
                        } else {
                            $bool = false;
                            $message = 'Error en p7';
                        }
                    } else {
                        $bool = false;
                        $message = 'Error en p6';
                    }
                } else {
                    $bool = false;
                    $message = 'Error en p5';
                }
            } else {
                $bool = false;
                $message = 'Error en p4';
            }
        } else {
            $bool = false;
            $message = 'Error en p3';
        }
    } else {
        $bool = false;
        $message = 'Error en p2';
    }
} else {
    $bool = false;
    $message = 'Error en p1';
}

echo json_encode([
    'bool' => $bool,
    'message' => $message,
]);
?>
