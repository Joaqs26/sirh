<?php
// Ejemplo final simplificado del controlador:
    include '../librerias.php';

    $id_falta = $_POST['id_object'];
    $faltaModelM = new FaltaModelM();
    $catSelectC = new CatSelectC();
    $row = new row();
    
    $response = [];
    $faltaEstatusHtml = '';
    $faltaTipoHtml = '';
    
    // Consulta general siempre realizada:
    $faltaEstatusHtml = $catSelectC->selectByAllCatalogo($faltaModelM->catFaltaEstatus());
    $faltaTipoHtml = $catSelectC->selectByAllCatalogo($faltaModelM->catFaltaTipo());
    
    if ($id_falta != null) {
        $response = $row->returnArray($faltaModelM->listarEditById($id_falta));
    
        if (!empty($response['id_cat_retardo_tipo'])) {
            $faltaTipoHtml = $catSelectC->selectByEditCatalogo(
                $faltaModelM->catFaltaTipo(),
                $row->returnArrayById($faltaModelM->catFaltaTipoEdit($response['id_cat_retardo_tipo']))
            );
        }
    
        if (!empty($response['id_cat_retardo_estatus'])) {
            $faltaEstatusHtml = $catSelectC->selectByEditCatalogo(
                $faltaModelM->catFaltaEstatus(),
                $row->returnArrayById($faltaModelM->catFaltaEstatusEdit($response['id_cat_retardo_estatus']))
            );
        }
    } else {
        // formulario nuevo (sin datos previos)
        $response = [
            'es_por_retardo' => '',
            'fecha' => '',                          
            'hora' => '',
            'cantidad' => '',
            'fecha_desde' => '',
            'fecha_hasta' => '',
            'fecha_registro' => '',
            'codigo_certificacion' => '',
            'observaciones' => ''
        ];
    }
    
    // Retorno JSON con HTML directo para desplegables
    $var = [
        'response' => $response,
        'faltaEstatus' => $faltaEstatusHtml,
        'faltaTipo' => $faltaTipoHtml,
    ];
    
    echo json_encode($var);
    
