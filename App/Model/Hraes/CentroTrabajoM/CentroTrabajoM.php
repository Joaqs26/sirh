<?php

class modelCentroTrabajoHraes
{
    public function validateClues($clues)
    {
        $query = pg_query("SELECT 
                                catalogos.cat_clues.nuevas_clues
                            FROM catalogos.cat_clues
                            WHERE catalogos.cat_clues.nuevas_clues = '$clues';");
        return $query;
    }



    public function infoCentroByPlaza($id)
    {
        $query = pg_query("SELECT 
                                public.tbl_centro_trabajo_hraes.nombre,
                                public.tbl_centro_trabajo_hraes.clave_centro_trabajo,
                                public.tbl_centro_trabajo_hraes.codigo_postal,
                                public.tbl_centro_trabajo_hraes.colonia,
                                CONCAT(public.cat_region.clave_region,' ', public.cat_region.region),
                                CONCAT(public.cat_entidad.clave_entidad, ' ', public.cat_entidad.entidad),
                                public.tbl_centro_trabajo_hraes.pais
                            FROM public.tbl_centro_trabajo_hraes
                            INNER JOIN public.cat_region
                                ON public.tbl_centro_trabajo_hraes.id_cat_region =
                                    public.cat_region.id_cat_region
                            INNER JOIN public.cat_entidad
                                ON public.tbl_centro_trabajo_hraes.id_cat_entidad =
                                    public.cat_entidad.id_cat_entidad
                            WHERE public.tbl_centro_trabajo_hraes.id_tbl_centro_trabajo_hraes = $id;");
        return $query;
    }
    public function allCountPlazas($idClue)
    {
        $isQuery = pg_query("SELECT 
                                    COUNT (id_tbl_control_plazas_hraes)
                                FROM public.tbl_control_plazas_hraes
                                WHERE id_tbl_centro_trabajo_hraes = $idClue;");
        return $isQuery;
    }
    public function listarByAll($paginator)
    {
        $listado = "SELECT tbl_centro_trabajo_hraes.id_tbl_centro_trabajo_hraes,
                            tbl_centro_trabajo_hraes.clave_centro_trabajo,
                            tbl_centro_trabajo_hraes.nombre,
                            cat_entidad.entidad, tbl_centro_trabajo_hraes.codigo_postal
                    FROM public.tbl_centro_trabajo_hraes
                    INNER JOIN cat_entidad
                    ON tbl_centro_trabajo_hraes.id_cat_entidad = 
                        cat_entidad.id_cat_entidad
                    ORDER BY tbl_centro_trabajo_hraes.id_tbl_centro_trabajo_hraes DESC
                    LIMIT 7 OFFSET $paginator;";

        return $listado;
    }

    public function listarByLike($busqueda, $paginator)
    {
        $listado = "SELECT tbl_centro_trabajo_hraes.id_tbl_centro_trabajo_hraes,
                            tbl_centro_trabajo_hraes.clave_centro_trabajo,
                            tbl_centro_trabajo_hraes.nombre,
                            cat_entidad.entidad, tbl_centro_trabajo_hraes.codigo_postal
                    FROM public.tbl_centro_trabajo_hraes
                    INNER JOIN cat_entidad
                    ON tbl_centro_trabajo_hraes.id_cat_entidad = 
                        cat_entidad.id_cat_entidad
                    WHERE TRIM(UPPER(UNACCENT(tbl_centro_trabajo_hraes.clave_centro_trabajo))) 
                          LIKE '%$busqueda%'
                    OR TRIM(UPPER(UNACCENT(tbl_centro_trabajo_hraes.nombre)))
                          LIKE '%$busqueda%'
                    OR TRIM(UPPER(UNACCENT(cat_entidad.entidad)))
                          LIKE '%$busqueda%'
                    OR TRIM(UPPER(UNACCENT(tbl_centro_trabajo_hraes.codigo_postal)))
                          LIKE '%$busqueda%'
                    ORDER BY tbl_centro_trabajo_hraes.id_tbl_centro_trabajo_hraes DESC
                    LIMIT 7 OFFSET $paginator;";

        return $listado;
    }

    public function listarByIdEdit($id_object)
    {
        $listado = pg_query("SELECT *
                            FROM public.tbl_centro_trabajo_hraes
                            WHERE id_tbl_centro_trabajo_hraes = $id_object");
        return $listado;
    }

    function editarByArray($conexion, $datos, $condicion, $tablaCentroTrabajoHraes)
    {
        $pg_update = pg_update($conexion, $tablaCentroTrabajoHraes, $datos, $condicion);
        return $pg_update;
    }

    function agregarByArray($conexion, $datos, $tablaCentroTrabajoHraes)
    {
        $pg_add = pg_insert($conexion, $tablaCentroTrabajoHraes, $datos);
        return $pg_add;
    }

    function eliminarByArray($conexion, $condicion, $tablaCentroTrabajoHraes)
    {
        $pgs_delete = pg_delete($conexion, $tablaCentroTrabajoHraes, $condicion);
        return $pgs_delete;
    }

    public function listarByNull()
    {
        return $array = [
            'id_tbl_centro_trabajo_hraes' => null,
            'clave_centro_trabajo' => null,
            'nombre' => null,
            'pais' => null,
            'colonia' => null,
            'codigo_postal' => null,
            'num_exterior' => null,
            'num_interior' => null,
            'latitud' => null,
            'longitud' => null,
            'id_cat_region' => null,
            'id_estatus_centro' => null,
            'id_cat_entidad' => null,
            'nivel_atencion' => null,
            'abreviatura' => null,
            'id_cat_zona_economica' => null,
            'fecha_usuario' => null,
            'id_user' => null,
        ];
    }



    ///COUNT 
    function listarAllCount()
    {
        $listado = pg_query("SELECT COUNT (id_tbl_centro_trabajo_hraes)
                             FROM public.tbl_centro_trabajo_hraes;");
        return $listado;
    }

    function listarByRegion($idRegion)
    {
        $listado = pg_query("SELECT COUNT (id_tbl_centro_trabajo_hraes)
                             FROM public.tbl_centro_trabajo_hraes
                             WHERE id_cat_region = $idRegion;");
        return $listado;
    }

    function getEntityZona($idClue)
    {
        $query = pg_query("SELECT CONCAT(public.cat_entidad.clave_entidad, ' - ', 
                                    public.cat_entidad.entidad)
                            FROM public.tbl_centro_trabajo_hraes
                            INNER JOIN public.cat_entidad
                                ON public.cat_entidad.id_cat_entidad =
                                    public.tbl_centro_trabajo_hraes.id_cat_entidad
                            WHERE public.tbl_centro_trabajo_hraes.id_tbl_centro_trabajo_hraes = $idClue;");
        return $query;
    }



    ///FUNCIONES PARA CARGA MASIVA
    function countClave($clave)
    {
        $listado = pg_query("SELECT COUNT (id_tbl_centro_trabajo_hraes)
                             FROM tbl_centro_trabajo_hraes
                             WHERE TRIM(UPPER(UNACCENT(clave_centro_trabajo))) = 
                                TRIM(UPPER(UNACCENT('$clave')));");
        return $listado;
    }

    function agregarCentroSQL(
        $clave_centro_trabajo,
        $nombre,
        $pais,
        $colonia,
        $codigo_postal,
        $num_exterior,
        $num_interior,
        $latitud,
        $longitud,
        $id_cat_region,
        $id_estatus_centro,
        $id_cat_entidad
    ) {
        $agregar = pg_query("INSERT INTO tbl_centro_trabajo_hraes (clave_centro_trabajo,nombre,
                                    pais,colonia,codigo_postal,num_exterior,num_interior,latitud,
                                    longitud,id_cat_region,id_estatus_centro,id_cat_entidad)
                            VALUES (UPPER('$clave_centro_trabajo'), UPPER('$nombre'), UPPER('$pais'),
                                     UPPER('$colonia'),'$codigo_postal',UPPER('$num_exterior'),
                                     UPPER('$num_interior'), UPPER('$latitud'), UPPER('$longitud'), 
                                     $id_cat_region, $id_estatus_centro, $id_cat_entidad);");
        return $agregar;
    }

    function modificarCentroSQL(
        $clave_centro_trabajo,
        $nombre,
        $pais,
        $colonia,
        $codigo_postal,
        $num_exterior,
        $num_interior,
        $latitud,
        $longitud,
        $id_cat_region,
        $id_estatus_centro,
        $id_cat_entidad,
        $condition
    ) {
        $idRegioN = strtoupper($id_cat_region) != strtoupper($condition) ? $id_cat_region : 1;
        $idEstatusN = strtoupper($id_estatus_centro) != strtoupper($id_estatus_centro) ? $id_estatus_centro : 1;
        $idEntidadN = strtoupper($id_cat_entidad) != strtoupper($id_cat_entidad) ? $id_cat_entidad : 1;

        $agregar = pg_query("UPDATE tbl_centro_trabajo_hraes
                             SET
                                nombre = CASE WHEN UPPER('$nombre') != UPPER('$condition') THEN UPPER('$nombre') ELSE nombre END,
                                pais = CASE WHEN UPPER('$pais') != UPPER('$condition') THEN UPPER('$pais') ELSE pais END,
                                colonia = CASE WHEN UPPER('$colonia') != UPPER('$condition') THEN UPPER('$colonia') ELSE colonia END,
                                codigo_postal = CASE WHEN UPPER('$codigo_postal') != UPPER('$condition') THEN UPPER('$codigo_postal') ELSE codigo_postal END,
                                num_exterior = CASE WHEN UPPER('$num_exterior') != UPPER('$condition') THEN UPPER('$num_exterior') ELSE num_exterior END,
                                num_interior = CASE WHEN UPPER('$num_interior') != UPPER('$condition') THEN UPPER('$num_interior') ELSE num_interior END,
                                latitud = CASE WHEN UPPER('$latitud') != UPPER('$condition') THEN UPPER('$latitud') ELSE latitud END,
                                longitud = CASE WHEN UPPER('$longitud') != UPPER('$condition') THEN UPPER('$longitud') ELSE longitud END,
                                id_cat_region = CASE WHEN UPPER('$id_cat_region') != UPPER('$condition') THEN $idRegioN ELSE id_cat_region END,
                                id_estatus_centro = CASE WHEN UPPER('$id_estatus_centro') != UPPER('$condition') THEN $idEstatusN ELSE id_estatus_centro END,
                                id_cat_entidad = CASE WHEN UPPER('$id_cat_entidad') != UPPER('$condition') THEN $idEntidadN ELSE id_cat_entidad END
                             WHERE
                                clave_centro_trabajo = '$clave_centro_trabajo';");
        return $agregar;
    }
    /*
    function modificarCentroSQL($clave_centro_trabajo,$nombre,$pais,$colonia,$codigo_postal,$num_exterior,$num_interior,
                              $latitud,$longitud,$id_cat_region,$id_estatus_centro,$id_cat_entidad, $condition){
        $agregar = pg_query("UPDATE tbl_centro_trabajo_hraes
                             SET
                                nombre = CASE WHEN UPPER('$nombre') != UPPER('$condition') THEN UPPER('$nombre') ELSE nombre END,
                                pais = CASE WHEN UPPER('$pais') != UPPER('$condition') THEN UPPER('$pais') ELSE pais END,
                                colonia = CASE WHEN UPPER('$colonia') != UPPER('$condition') THEN UPPER('$colonia') ELSE colonia END,
                                codigo_postal = CASE WHEN UPPER('$codigo_postal') != UPPER('$condition') THEN UPPER('$codigo_postal') ELSE codigo_postal END,
                                num_exterior = CASE WHEN UPPER('$num_exterior') != UPPER('$condition') THEN UPPER('$num_exterior') ELSE num_exterior END,
                                num_interior = CASE WHEN UPPER('$num_interior') != UPPER('$condition') THEN UPPER('$num_interior') ELSE num_interior END,
                                latitud = CASE WHEN UPPER('$latitud') != UPPER('$condition') THEN UPPER('$latitud') ELSE latitud END,
                                longitud = CASE WHEN UPPER('$longitud') != UPPER('$condition') THEN UPPER('$longitud') ELSE longitud END,
                                id_cat_region = CASE WHEN UPPER('$id_cat_region') != UPPER('$condition') THEN $id_cat_region ELSE id_cat_region END,
                                id_estatus_centro = CASE WHEN UPPER('$id_estatus_centro') != UPPER('$condition') THEN $id_estatus_centro ELSE id_estatus_centro END,
                                id_cat_entidad = CASE WHEN UPPER('$id_cat_entidad') != UPPER('$condition') THEN $id_cat_entidad ELSE id_cat_entidad END
                             WHERE
                                clave_centro_trabajo = '$clave_centro_trabajo';");
        return $agregar;
    }
        */
}
