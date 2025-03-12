    <?php
    include '../librerias.php';
  


    $catEntidadM = new catalogoEntidad();
    $model = new modelEmpleadosHraes();
    $row = new Row();
    $catalogoGeneroM = new CatalogoGeneroMHraes();
    $catalogoGeneroC = new CatalogoGeneroCHraes();
    $catEstadoCivilM = new CatEstadoCivilM();
    $catEstadoCivilC = new CatEstadoCivilC();
    $catPaisC = new CatPaisC();
    $catPaisM = new CatPaisM();
    $catSelectC = new CatSelectC();
    $catNacionalidadC = new CatNacionalidadC();
    $catEstadoC = new CatEstadoC();
    $catEstadoM = new CatEstadoM();
    
   

    $id_object = $_POST['id_object'];

    if ($id_object != null) {
        // ✅ Se obtiene el id_rusp también
        $response = $row->returnArray($model->listarByIdEdit($id_object));

        $estadoCivil = $catEstadoCivilC->selectById(
            $catEstadoCivilM->listarByAll(),
            $row->returnArrayById($catEstadoCivilM->obtenerElemetoById($response['id_cat_estado_civil']))
        );

        $pais = $catPaisC->selectById(
            $catPaisM->listarByAll(),
            $row->returnArrayById($catPaisM->listarById($response['id_cat_pais_nacimiento']))
        );

        $estado = $catEstadoC->selectById(
            $catEstadoM->listarEstado($response['id_cat_pais_nacimiento']),
            $row->returnArrayById($catEstadoM->listarById($response['id_cat_estado_nacimiento']))
        );

        $nacionalidad = $catNacionalidadC->selectById($response['nacionalidad']);
        
            

        // ✅ Se agrega id_rusp en la respuesta JSON
        $var = [
            'response' => $response,
            'estadoCivil' => $estadoCivil,
            'pais' => $pais,
            'estado' => $estado,
            'nacionalidad' => $nacionalidad,
            'id_rusp' => isset($response['id_rusp']) ? $response['id_rusp'] : null // ✅ Validación para evitar errores
        ];

        echo json_encode($var);
    } else {
        $response = $model->listarByNull();
        $estadoCivil = $catEstadoCivilC->selectByAll($catEstadoCivilM->listarByAll());
        $pais = $catPaisC->selectByAll($catPaisM->listarByAll());
        $estado = $catSelectC->selecStaticByNull();
        $nacionalidad = $catNacionalidadC->selectByAll();



        // ✅ id_rusp con valor vacío para evitar errores
        $var = [
            'response' => $response,
            'estadoCivil' => $estadoCivil,
            'pais' => $pais,
            'estado' => $estado,
            'nacionalidad' => $nacionalidad,
            'id_rusp' => null
        ];

        echo json_encode($var);
        }
