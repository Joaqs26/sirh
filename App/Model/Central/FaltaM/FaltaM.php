<?php

class FaltaModelM
{
    function listarById($id_object, $paginator)
    {
        $listado = pg_query("SELECT
                                    central.ctrl_faltas.id_ctrl_faltas,
                                    CASE 
                                        WHEN es_por_retardo THEN 'FALTA POR RETARDO'
                                        ELSE 'FALTA'
                                    END,
                                    TO_CHAR(central.ctrl_faltas.fecha_desde, 'DD/MM/YYYY'),
                                    TO_CHAR(central.ctrl_faltas.fecha_hasta, 'DD/MM/YYYY'),
                                    TO_CHAR(central.ctrl_faltas.fecha_registro, 'DD/MM/YYYY'),
                                    TO_CHAR(central.ctrl_faltas.fecha, 'DD/MM/YYYY'),
                                    TO_CHAR(central.ctrl_faltas.hora, 'HH:MM'),
                                    UPPER(central.ctrl_faltas.codigo_certificacion),
                                    UPPER(central.cat_retardo_estatus.descripcion),
                                    UPPER(central.cat_retardo_tipo.descripcion),
                                    UPPER(central.ctrl_faltas.observaciones),
                                    central.ctrl_faltas.id_user
                                FROM central.ctrl_faltas
                                LEFT JOIN central.cat_retardo_estatus
                                    ON central.ctrl_faltas.id_cat_retardo_estatus =
                                        central.cat_retardo_estatus.id_cat_retardo_estatus
                                LEFT JOIN central.cat_retardo_tipo
                                    ON central.ctrl_faltas.id_cat_retardo_tipo =
                                        central.cat_retardo_tipo.id_cat_retardo_tipo
                                WHERE central.ctrl_faltas.id_tbl_empleados_hraes = $id_object
                                ORDER BY central.ctrl_faltas.id_ctrl_faltas DESC
                                LIMIT 3 OFFSET $paginator;");
        return $listado;
    }

    function listarEditById($id_object)
    {
        $listado = pg_query("SELECT *
                            FROM central.ctrl_faltas
                            WHERE id_ctrl_faltas = $id_object
                            LIMIT 1;");
        return $listado;
    }

    function listarByNull()
    {
        return $raw = [
            'id_ctrl_retardo_hraes' => null,
            'fecha' => null,
            'hora_entrada' => null,
            'minuto_entrada' => null,
            'hora_salida' => null,
            'minuto_salida' => null,
            'id_tbl_empleados_hraes' => null,
        ];
    }

    function listarByBusqueda($id_object, $busqueda, $paginator)
    {
        $listado = pg_query("SELECT
                                    central.ctrl_faltas.id_ctrl_faltas,
                                    CASE 
                                        WHEN es_por_retardo THEN 'FALTA POR RETARDO'
                                        ELSE 'FALTA'
                                    END,
                                    TO_CHAR(central.ctrl_faltas.fecha_desde, 'DD/MM/YYYY'),
                                    TO_CHAR(central.ctrl_faltas.fecha_hasta, 'DD/MM/YYYY'),
                                    TO_CHAR(central.ctrl_faltas.fecha_registro, 'DD/MM/YYYY'),
                                    TO_CHAR(central.ctrl_faltas.fecha, 'DD/MM/YYYY'),
                                    TO_CHAR(central.ctrl_faltas.hora, 'HH:MM'),
                                    UPPER(central.ctrl_faltas.codigo_certificacion),
                                    UPPER(central.cat_retardo_estatus.descripcion),
                                    UPPER(central.cat_retardo_tipo.descripcion),
                                    UPPER(central.ctrl_faltas.observaciones),
                                    central.ctrl_faltas.id_user
                                FROM central.ctrl_faltas
                                LEFT JOIN central.cat_retardo_estatus
                                    ON central.ctrl_faltas.id_cat_retardo_estatus =
                                        central.cat_retardo_estatus.id_cat_retardo_estatus
                                LEFT JOIN central.cat_retardo_tipo
                                    ON central.ctrl_faltas.id_cat_retardo_tipo =
                                        central.cat_retardo_tipo.id_cat_retardo_tipo
                                WHERE central.ctrl_faltas.id_tbl_empleados_hraes = $id_object
                                AND (
                                    TO_CHAR(central.ctrl_faltas.fecha_desde, 'DD/MM/YYYY')::TEXT LIKE '%$busqueda%' OR 
                                    TO_CHAR(central.ctrl_faltas.fecha_hasta, 'DD/MM/YYYY')::TEXT LIKE '%$busqueda%' OR
                                    TO_CHAR(central.ctrl_faltas.fecha_registro, 'DD/MM/YYYY')::TEXT LIKE '%$busqueda%' OR
                                    TO_CHAR(central.ctrl_faltas.fecha, 'DD/MM/YYYY')::TEXT LIKE '%$busqueda%' OR
                                    TO_CHAR(central.ctrl_faltas.hora, 'HH:MM')::TEXT LIKE '%$busqueda%' OR
                                    TRIM(UNACCENT(UPPER(central.ctrl_faltas.codigo_certificacion))) LIKE '%$busqueda%' OR
                                    TRIM(UNACCENT(UPPER(central.cat_retardo_estatus.descripcion))) LIKE '%$busqueda%' OR
                                    TRIM(UNACCENT(UPPER(central.cat_retardo_tipo.descripcion))) LIKE '%$busqueda%' OR
                                    TRIM(UNACCENT(UPPER(central.ctrl_faltas.observaciones))) LIKE '%$busqueda%' 
                                )
                                ORDER BY central.ctrl_faltas.id_ctrl_faltas DESC
                                LIMIT 3 OFFSET $paginator;");
        return $listado;
    }

    function editarByArray($conexion, $datos, $condicion)
    {
        $pg_update = pg_update($conexion, 'central.ctrl_faltas', $datos, $condicion);
        return $pg_update;
    }

    function agregarByArray($conexion, $datos)
    {
        $pg_add = pg_insert($conexion, 'central.ctrl_faltas', $datos);
        return $pg_add;
    }

    function eliminarByArray($conexion, $condicion)
    {
        $pgs_delete = pg_delete($conexion, 'central.ctrl_faltas', $condicion);
        return $pgs_delete;
    }


    public function catFaltaEstatus()
    {
        $query = pg_query("SELECT 
                                central.cat_retardo_estatus.id_cat_retardo_estatus,
                                UPPER(central.cat_retardo_estatus.descripcion)
                            FROM central.cat_retardo_estatus
                            ORDER BY central.cat_retardo_estatus.descripcion ASC;");
        return $query;
    }

    public function catFaltaEstatusEdit($id)
    {
        $query = pg_query("SELECT 
                                central.cat_retardo_estatus.id_cat_retardo_estatus,
                                UPPER(central.cat_retardo_estatus.descripcion)
                            FROM central.cat_retardo_estatus
                            WHERE central.cat_retardo_estatus.id_cat_retardo_estatus = $id;");
        return $query;
    }
    public function catFaltaTipo()
    {
        $query = pg_query("SELECT 
                                central.cat_retardo_tipo.id_cat_retardo_tipo,
                                UPPER(central.cat_retardo_tipo.descripcion)
                            FROM central.cat_retardo_tipo
                            ORDER BY central.cat_retardo_tipo.descripcion ASC;");
        return $query;
    }

    public function catFaltaTipoEdit($id)
    {
        $query = pg_query("SELECT 
                                central.cat_retardo_tipo.id_cat_retardo_tipo,
                                UPPER(central.cat_retardo_tipo.descripcion)
                            FROM central.cat_retardo_tipo
                            WHERE central.cat_retardo_tipo.id_cat_retardo_tipo = $id;");
        return $query;
    }

    /// reporte de faltas para todos los empleados
    

    public function getAllFaltas($paginator)
    {
        $query = ("SELECT 
                    CONCAT(UPPER(e.nombre), ' ', UPPER(e.primer_apellido), ' ', UPPER(e.segundo_apellido)) AS nombre_completo,
                    UPPER(e.rfc) AS rfc,
                    'FALTA POR RETARDO' AS tipo_falta,
                    TO_CHAR(f.fecha, 'DD-MM-YYYY') AS fecha,
                    TO_CHAR(f.hora, 'HH24:MI') AS hora,
                    f.cantidad,
                    UPPER(rt.descripcion) AS tipo,
                    UPPER(re.descripcion) AS estatus,
                    f.id_user,
                    f.id_ctrl_faltas
                FROM central.ctrl_faltas f
                INNER JOIN central.tbl_empleados_hraes e ON f.id_tbl_empleados_hraes = e.id_tbl_empleados_hraes
                INNER JOIN central.cat_retardo_tipo rt ON f.id_cat_retardo_tipo = rt.id_cat_retardo_tipo
                INNER JOIN central.cat_retardo_estatus re ON f.id_cat_retardo_estatus = re.id_cat_retardo_estatus
                WHERE NOT EXISTS (
                    SELECT 1 
                    FROM central.masivo_ctrl_temp_faltas_just mj
                    WHERE f.id_tbl_empleados_hraes = (
                        SELECT id_tbl_empleados_hraes 
                        FROM central.tbl_empleados_hraes 
                        WHERE rfc = mj.rfc
                    )
                    AND f.fecha = TO_DATE(mj.fecha, 'YYYY-MM-DD')
                    AND rt.descripcion = UPPER(mj.tipo_falta)
                )
                AND NOT EXISTS (
                    SELECT 1 
                    FROM central.ctrl_incidencias ci
                    WHERE f.id_tbl_empleados_hraes = ci.id_tbl_empleados_hraes
                    AND f.fecha BETWEEN ci.fecha_inicio AND ci.fecha_fin
                )
                ORDER BY f.fecha DESC
                LIMIT 5 OFFSET $paginator;");
        return $query;
    }

    public function getAllFaltasBusqueda($busqueda, $paginator)
    {
        $query = ("SELECT 
                    CONCAT(UPPER(e.nombre), ' ', UPPER(e.primer_apellido), ' ', UPPER(e.segundo_apellido)) AS nombre_completo,
                    UPPER(e.rfc) AS rfc,
                    'FALTA POR RETARDO' AS tipo_falta,
                    TO_CHAR(f.fecha, 'DD-MM-YYYY') AS fecha,
                    TO_CHAR(f.hora, 'HH24:MI') AS hora,
                    f.cantidad,
                    UPPER(rt.descripcion) AS tipo,
                    UPPER(re.descripcion) AS estatus,
                    f.id_user,
                    f.id_ctrl_faltas
                FROM central.ctrl_faltas f
                INNER JOIN central.tbl_empleados_hraes e ON f.id_tbl_empleados_hraes = e.id_tbl_empleados_hraes
                INNER JOIN central.cat_retardo_tipo rt ON f.id_cat_retardo_tipo = rt.id_cat_retardo_tipo
                INNER JOIN central.cat_retardo_estatus re ON f.id_cat_retardo_estatus = re.id_cat_retardo_estatus
                WHERE (
                        CONCAT(UPPER(e.nombre), ' ', UPPER(e.primer_apellido), ' ', UPPER(e.segundo_apellido)) LIKE '%$busqueda%'
                        OR UPPER(e.rfc) LIKE '%$busqueda%'
                        OR TO_CHAR(f.fecha, 'DD-MM-YYYY') LIKE '%$busqueda%'
                        OR TO_CHAR(f.hora, 'HH24:MI') LIKE '%$busqueda%'
                        OR CAST(f.cantidad AS TEXT) LIKE '%$busqueda%'
                        OR UPPER(rt.descripcion) LIKE '%$busqueda%'
                        OR UPPER(re.descripcion) LIKE '%$busqueda%'
                    )
                    AND NOT EXISTS (
                        SELECT 1 
                        FROM central.masivo_ctrl_temp_faltas_just mj
                        WHERE f.id_tbl_empleados_hraes = (
                            SELECT id_tbl_empleados_hraes 
                            FROM central.tbl_empleados_hraes 
                            WHERE rfc = mj.rfc
                        )
                        AND f.fecha = TO_DATE(mj.fecha, 'YYYY-MM-DD')
                        AND rt.descripcion = UPPER(mj.tipo_falta)
                    )
                    AND NOT EXISTS (
                        SELECT 1 
                        FROM central.ctrl_incidencias ci
                        WHERE f.id_tbl_empleados_hraes = ci.id_tbl_empleados_hraes
                        AND f.fecha BETWEEN ci.fecha_inicio AND ci.fecha_fin
                    )
                    ORDER BY f.fecha DESC
                    LIMIT 5 OFFSET $paginator;");
        return $query;
    }


        ///SCRIP PARA CALCULO DE FLATAS DE FORMA MASIVApublic function process_1()
        public function process_1() {
            $query = pg_query("INSERT INTO central.ctrl_retardo (
                    fecha, 
                    hora, 
                    observaciones, 
                    id_cat_retardo_tipo, 
                    id_cat_retardo_estatus, 
                    id_tbl_empleados_hraes, 
                    id_user
                )
                SELECT 
                    Entradas.fecha,
                    Entradas.hora, 
                    NULL AS observaciones,
                    1 AS id_cat_retardo_tipo,  -- Entrada 
                    5 AS id_cat_retardo_estatus,  -- Por Aplicar
                    Entradas.id_tbl_empleados_hraes,
                    NULL AS id_user
                FROM (
                    SELECT 
                        MIN(ctrl_asistencia.hora) AS hora,
                        ctrl_asistencia.fecha, 
                        ctrl_asistencia.id_tbl_empleados_hraes
                    FROM central.ctrl_asistencia
                    WHERE ctrl_asistencia.fecha NOT IN (SELECT fecha FROM central.cat_dias_festivos)
                      AND ctrl_asistencia.fecha BETWEEN '2024/12/01' AND '2024/12/15'
                    GROUP BY ctrl_asistencia.fecha, ctrl_asistencia.id_tbl_empleados_hraes
                ) AS Entradas
                WHERE Entradas.hora >= '09:16:00' 
                  AND Entradas.hora <= '09:30:00' 
                  AND NOT EXISTS (
                        SELECT 1
                        FROM central.ctrl_retardo
                        WHERE ctrl_retardo.fecha = Entradas.fecha
                          AND ctrl_retardo.hora = Entradas.hora
                          AND ctrl_retardo.id_tbl_empleados_hraes = Entradas.id_tbl_empleados_hraes
                  )
                  AND NOT EXISTS (
                        SELECT 1
                        FROM central.masivo_ctrl_temp_faltas_just
                        WHERE rfc = (
                            SELECT rfc 
                            FROM central.tbl_empleados_hraes 
                            WHERE id_tbl_empleados_hraes = Entradas.id_tbl_empleados_hraes
                        )
                        AND fecha::DATE = Entradas.fecha -- Conversión explícita
                        
                  );");
            return $query;
        }
        
    

        public function process_2() {
            $query = pg_query("INSERT INTO central.ctrl_faltas (
                    id_tbl_empleados_hraes,
                    observaciones,
                    es_por_retardo,
                    id_cat_retardo_tipo,
                    id_cat_retardo_estatus,
                    id_user,
                    fecha,
                    hora,
                    cantidad
                )
                SELECT 
                    Entradas.id_tbl_empleados_hraes,
                    NULL AS observaciones,
                    TRUE AS es_por_retardo,
                    1 AS id_cat_retardo_tipo, 
                    7 AS id_cat_retardo_estatus,
                    NULL AS id_user,
                    Entradas.fecha,
                    Entradas.hora,
                    1 AS cantidad
                FROM (
                    SELECT 
                        MIN(ctrl_asistencia.hora) AS hora,
                        ctrl_asistencia.fecha,
                        ctrl_asistencia.id_tbl_empleados_hraes
                    FROM central.ctrl_asistencia
                    WHERE ctrl_asistencia.fecha NOT IN (SELECT fecha FROM central.cat_dias_festivos)
                      AND ctrl_asistencia.fecha BETWEEN '2024/12/01' AND '2024/12/15'
                    GROUP BY ctrl_asistencia.fecha, ctrl_asistencia.id_tbl_empleados_hraes
                ) AS Entradas
                WHERE Entradas.hora > '09:30:00' 
                  AND NOT EXISTS (
                        SELECT 1
                        FROM central.ctrl_faltas
                        WHERE ctrl_faltas.fecha = Entradas.fecha
                          AND ctrl_faltas.hora = Entradas.hora
                          AND ctrl_faltas.id_tbl_empleados_hraes = Entradas.id_tbl_empleados_hraes
                  )
                  AND NOT EXISTS (
                        SELECT 1
                        FROM central.masivo_ctrl_temp_faltas_just
                        WHERE rfc = (
                            SELECT rfc 
                            FROM central.tbl_empleados_hraes 
                            WHERE id_tbl_empleados_hraes = Entradas.id_tbl_empleados_hraes
                        )
                        AND fecha::DATE = Entradas.fecha -- Conversión explícita
                        
                  );");
            return $query;
        }
        

        public function process_3() {
            $query = pg_query("INSERT INTO central.ctrl_faltas (
                    id_tbl_empleados_hraes,
                    observaciones,
                    es_por_retardo,
                    id_cat_retardo_tipo,
                    id_cat_retardo_estatus,
                    id_user,
                    fecha,
                    hora,
                    cantidad
                )
                SELECT 
                    Salidas.id_tbl_empleados_hraes,
                    NULL AS observaciones,
                    TRUE AS es_por_retardo,
                    2 AS id_cat_retardo_tipo, -- Salida
                    4 AS id_cat_retardo_estatus, -- Falta por salida anticipada
                    NULL AS id_user,
                    Salidas.fecha,
                    Salidas.hora,
                    1 AS cantidad
                FROM (
                    SELECT 
                        MAX(ctrl_asistencia.hora) AS hora,
                        ctrl_asistencia.fecha,
                        ctrl_asistencia.id_tbl_empleados_hraes
                    FROM central.ctrl_asistencia
                    WHERE ctrl_asistencia.fecha NOT IN (SELECT fecha FROM central.cat_dias_festivos)
                      AND ctrl_asistencia.fecha BETWEEN '2024/12/01' AND '2024/12/15'
                    GROUP BY ctrl_asistencia.fecha, ctrl_asistencia.id_tbl_empleados_hraes
                ) AS Salidas
                WHERE Salidas.hora < '19:00:00'
                  AND NOT EXISTS (
                        SELECT 1
                        FROM central.ctrl_faltas
                        WHERE ctrl_faltas.fecha = Salidas.fecha
                          AND ctrl_faltas.hora = Salidas.hora
                          AND ctrl_faltas.id_tbl_empleados_hraes = Salidas.id_tbl_empleados_hraes
                  )
                  AND NOT EXISTS (
                        SELECT 1
                        FROM central.masivo_ctrl_temp_faltas_just
                        WHERE rfc = (
                            SELECT rfc 
                            FROM central.tbl_empleados_hraes 
                            WHERE id_tbl_empleados_hraes = Salidas.id_tbl_empleados_hraes
                        )
                        AND fecha::DATE = Salidas.fecha -- Conversión explícita
                        
                  );");
            return $query;
        }
        
        
        public function process_4() {
            $query = pg_query("INSERT INTO central.ctrl_faltas (
                    cantidad,
                    id_tbl_empleados_hraes,
                    es_por_retardo,
                    id_cat_retardo_tipo,
                    id_cat_retardo_estatus,
                    fecha
                )
                SELECT 
                    CASE 
                        WHEN (NoRet >= 3 AND NoRet < 6) THEN 1
                        WHEN (NoRet >= 6 AND NoRet < 9) THEN 2
                        WHEN (NoRet >= 9 AND NoRet < 12) THEN 3
                        WHEN (NoRet >= 12) THEN 4
                    END AS cantidad,
                    id_tbl_empleados_hraes,
                    TRUE AS es_por_retardo,
                    3 AS id_cat_retardo_tipo, 
                    6 AS id_cat_retardo_estatus,
                    CURRENT_DATE AS fecha
                FROM (
                    SELECT 
                        id_tbl_empleados_hraes,
                        COUNT(*) AS NoRet
                    FROM central.ctrl_retardo
                    WHERE fecha BETWEEN '2024/12/01' AND '2024/12/15'
                    GROUP BY id_tbl_empleados_hraes
                    HAVING COUNT(*) >= 3
                ) AS Retardos
                WHERE NOT EXISTS (
                    SELECT 1
                    FROM central.masivo_ctrl_temp_faltas_just
                    WHERE rfc = (
                        SELECT rfc 
                        FROM central.tbl_empleados_hraes 
                        WHERE id_tbl_empleados_hraes = Retardos.id_tbl_empleados_hraes
                    )
                    AND tipo_falta = 'FALTA'
                );");
            return $query;
        }
        
    

        public function process_5() {
            $query = pg_query("UPDATE central.cat_asistencia_config
                SET fecha_ult_proceso = CURRENT_DATE
                WHERE id_cat_asistencia_config = 1
                  AND CURRENT_DATE BETWEEN '2024/12/01' AND '2024/12/15';");
            return $query;
        }
        
        public function process_6()
        {
            $query = pg_query("INSERT INTO central.ctrl_faltas (
                    id_tbl_empleados_hraes,
                    es_por_retardo,
                    id_cat_retardo_tipo,
                    id_cat_retardo_estatus,
                    fecha
                )
                SELECT 
                    id_tbl_empleados_hraes,
                    TRUE AS es_por_retardo,
                    3 AS id_cat_retardo_tipo, -- Tipo de retardo
                    CASE 
                        WHEN (NoRet >= 3 AND NoRet < 6) THEN 1
                        WHEN (NoRet >= 6 AND NoRet < 9) THEN 2
                        WHEN (NoRet >= 9 AND NoRet < 12) THEN 3
                        WHEN (NoRet >= 12) THEN 4
                    END AS id_cat_retardo_estatus,
                    CURRENT_DATE AS fecha
                FROM (
                    SELECT 
                        id_tbl_empleados_hraes,
                        COUNT(*) AS NoRet
                    FROM central.ctrl_retardo
                    WHERE fecha BETWEEN '2024/12/01' AND '2024/12/31' -- Filtro por rango de fechas
                    GROUP BY id_tbl_empleados_hraes
                    HAVING COUNT(*) >= 3
                ) AS Retardos;
            ");
            return $query;
        }
        
        
        public function process_7() {
            $query = pg_query("INSERT INTO central.ctrl_faltas (
                    id_tbl_empleados_hraes,
                    observaciones,
                    es_por_retardo,
                    id_cat_retardo_tipo,
                    id_cat_retardo_estatus,
                    id_user,
                    fecha,
                    hora,
                    cantidad
                )
                SELECT 
                    f.id_tbl_empleados_hraes,
                    'FALTA POR OMISIÓN' AS observaciones,
                    FALSE AS es_por_retardo,
                    3 AS id_cat_retardo_tipo, -- Tipo de falta por omisión
                    8 AS id_cat_retardo_estatus, -- Estatus para falta por omisión
                    NULL AS id_user,
                    f.fecha,
                    '00:00:00' AS hora,
                    1 AS cantidad
                FROM (
                    SELECT 
                        e.id_tbl_empleados_hraes,
                        g.fecha
                    FROM central.tbl_empleados_hraes e
                    CROSS JOIN (
                        SELECT GENERATE_SERIES('2024/12/01'::DATE, '2024/12/31'::DATE, '1 day'::INTERVAL)::DATE AS fecha
                    ) g
                    INNER JOIN central.ctrl_asistencia_info ai
                        ON e.id_tbl_empleados_hraes = ai.id_tbl_empleados_hraes
                        AND ai.id_cat_asistencia_estatus = 1
                ) f
                LEFT JOIN central.ctrl_asistencia a
                    ON f.id_tbl_empleados_hraes = a.id_tbl_empleados_hraes
                    AND f.fecha = a.fecha
                WHERE a.fecha IS NULL
                  AND f.fecha NOT IN (
                        SELECT fecha 
                        FROM central.cat_dias_festivos
                  )
                  AND NOT EXISTS (
                        SELECT 1
                        FROM central.ctrl_faltas cf
                        WHERE cf.id_tbl_empleados_hraes = f.id_tbl_empleados_hraes
                          AND cf.fecha = f.fecha
                          AND cf.id_cat_retardo_tipo = 3
                  )
                  AND NOT EXISTS (
                        SELECT 1
                        FROM central.masivo_ctrl_temp_faltas_just
                        WHERE rfc = (
                            SELECT rfc 
                            FROM central.tbl_empleados_hraes 
                            WHERE id_tbl_empleados_hraes = f.id_tbl_empleados_hraes
                        )
                        AND fecha = f.fecha::TEXT
                      
                  );");
            return $query;
        }

    public function truncateTableTmpFaltas()
    {
        $query = pg_query("TRUNCATE TABLE central.masivo_ctrl_temp_faltas_just RESTART IDENTITY;");
    }

    public function addInfoFaltaTemp(
        $rfc,
        $fecha,
        $observaciones,
        $tipo,
        $tipo_falta
    ) {
        $query = pg_query("INSERT INTO central.masivo_ctrl_temp_faltas_just(
                            rfc, fecha, observaciones, tipo, tipo_falta)
                            VALUES ('$rfc', '$fecha', '$observaciones', '$tipo', '$tipo_falta ');");
        return $query;
    }

    public function udpdateFaltas()
    {

             $query = pg_query(" UPDATE central.ctrl_retardo R

                            SET id_cat_retardo_estatus = 3, -- JUSTIFICADA
                                observaciones = J.observaciones	-- Observaciones del Justificación
                            FROM central.masivo_ctrl_temp_faltas_just J	-- Justificaciones
                                JOIN central.tbl_empleados_hraes  E ON  J.rfc = E.rfc
                            WHERE R.id_tbl_empleados_hraes = E.id_tbl_empleados_hraes
                            AND R.fecha = J.fecha::DATE
                            AND UPPER(J.tipo) = 'RETARDO';
                            
                            -- #Script Para Actualización de Faltas #
                            -- ###Proceso Validado ##################
                            UPDATE central.ctrl_faltas F
                            SET id_cat_retardo_estatus = 3, -- JUSTIFICADA
                                observaciones = J.observaciones	-- Observaciones del Justificación
                            FROM central.masivo_ctrl_temp_faltas_just J	-- Justificaciones
                                JOIN central.tbl_empleados_hraes  E ON  J.rfc = E.rfc
                            WHERE F.id_tbl_empleados_hraes = E.id_tbl_empleados_hraes
                            AND F.fecha = J.fecha::DATE
                            AND UPPER(J.tipo) = 'FALTA'
                            AND F.id_cat_retardo_tipo = (SELECT id_cat_retardo_tipo
                                                        FROM central.cat_retardo_tipo
                                                        WHERE descripcion = UPPER(J.tipo_falta));");
        return $query;
    }

}