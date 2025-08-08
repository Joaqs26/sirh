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
                         UPPER(re.descripcion) AS estatus,
                        TO_CHAR(f.fecha, 'DD-MM-YYYY') AS fecha,
                        TO_CHAR(f.hora, 'HH24:MI') AS hora,
                        f.cantidad,
                        UPPER(rt.descripcion) AS tipo,
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
                    UPPER(re.descripcion) AS estatus,
                    TO_CHAR(f.fecha, 'DD-MM-YYYY') AS fecha,
                    TO_CHAR(f.hora, 'HH24:MI') AS hora,
                    f.cantidad,
                    UPPER(rt.descripcion) AS tipo,
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


    // SCRIPT PARA CÁLCULO DE FALTAS DE FORMA MASIVA
public function process_1()
    {
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
    1 AS id_cat_retardo_tipo,
    5 AS id_cat_retardo_estatus,
    Entradas.id_tbl_empleados_hraes,
    NULL AS id_user
FROM (
    SELECT     
        Minimo.hora, 
        Minimo.fecha, 
        Minimo.id_tbl_empleados_hraes
    FROM (
        SELECT  
            A.fecha, 
            MIN(A.hora) AS hora,
            A.id_tbl_empleados_hraes
        FROM central.ctrl_asistencia A
        WHERE A.fecha NOT IN (
            SELECT fecha FROM central.cat_dias_festivos
        )
        GROUP BY A.fecha, A.id_tbl_empleados_hraes
    ) AS Minimo
    WHERE 
        (
            Minimo.fecha = '2025-06-02' AND Minimo.hora > '10:00:59'
        )
        OR
        (
            Minimo.fecha <> '2025-06-02' AND Minimo.hora >= (
                SELECT C.hora_min_retardo
                FROM central.cat_asistencia_config C
                WHERE C.id_cat_asistencia_config = (
                    SELECT AI.id_cat_asistencia_config
                    FROM central.ctrl_asistencia_info AI
                    WHERE AI.id_tbl_empleados_hraes = Minimo.id_tbl_empleados_hraes
                )
            )
            AND Minimo.hora <= (
                SELECT C.hora_max_retardo
                FROM central.cat_asistencia_config C
                WHERE C.id_cat_asistencia_config = (
                    SELECT AI.id_cat_asistencia_config
                    FROM central.ctrl_asistencia_info AI
                    WHERE AI.id_tbl_empleados_hraes = Minimo.id_tbl_empleados_hraes
                )
            )
        )
) AS Entradas
WHERE NOT EXISTS (
    SELECT 1
    FROM central.masivo_ctrl_temp_faltas_just mj
    WHERE mj.rfc = (
        SELECT e.rfc 
        FROM central.tbl_empleados_hraes e
        WHERE e.id_tbl_empleados_hraes = Entradas.id_tbl_empleados_hraes
    )
    AND mj.fecha IS NOT NULL
    AND mj.fecha <> ''
    AND mj.fecha::date = Entradas.fecha::date
)
AND NOT EXISTS (
    SELECT 1
    FROM central.ctrl_incidencias ci
    WHERE ci.id_tbl_empleados_hraes = Entradas.id_tbl_empleados_hraes
    AND ci.id_cat_incidencias IN (3, 4, 5, 9, 13)
    AND ci.fecha_inicio IS NOT NULL
            AND ci.fecha_fin IS NOT NULL
            AND Entradas.fecha BETWEEN ci.fecha_inicio AND ci.fecha_fin
);");
        return $query;
    }   

    //RETARDO MAYOR/OMISION DE ENTRADA
public function process_2()
{
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
            4 AS id_cat_retardo_estatus,
            NULL AS id_user,
            Entradas.fecha,
            Entradas.hora,
            1 AS cantidad
        FROM (
            SELECT     
                Minimo.hora, 
                Minimo.fecha, 
                Minimo.id_tbl_empleados_hraes
            FROM (
                SELECT  
                    A.fecha, 
                    MIN(A.hora) AS hora,
                    A.id_tbl_empleados_hraes
                FROM central.ctrl_asistencia A
                WHERE A.fecha NOT IN (
                    SELECT fecha FROM central.cat_dias_festivos
                )
                AND A.fecha::date NOT IN ('2025-05-14')
                GROUP BY A.fecha, A.id_tbl_empleados_hraes
            ) AS Minimo
            WHERE 
                (
                    Minimo.fecha = '2025-06-02' AND Minimo.hora > '10:00:59'
                )
                OR
                (
                    Minimo.fecha <> '2025-06-02' AND Minimo.hora > (
                        SELECT C.hora_max_retardo
                        FROM central.cat_asistencia_config C
                        WHERE C.id_cat_asistencia_config = (
                            SELECT AI.id_cat_asistencia_config
                            FROM central.ctrl_asistencia_info AI
                            WHERE AI.id_tbl_empleados_hraes = Minimo.id_tbl_empleados_hraes
                        )
                    )
                )
        ) AS Entradas

        -- Validación de que no se haya registrado ya como falta
        WHERE NOT EXISTS (
            SELECT 1
            FROM central.ctrl_faltas f
            WHERE f.id_tbl_empleados_hraes = Entradas.id_tbl_empleados_hraes
            AND f.fecha = Entradas.fecha
        )

        -- Justificación exacta por fecha
        AND NOT EXISTS (
            SELECT 1
            FROM central.masivo_ctrl_temp_faltas_just mj
            WHERE mj.rfc = (
                SELECT e.rfc 
                FROM central.tbl_empleados_hraes e
                WHERE e.id_tbl_empleados_hraes = Entradas.id_tbl_empleados_hraes
            )
            AND mj.fecha IS NOT NULL
            AND mj.fecha <> ''
            AND mj.fecha::date = Entradas.fecha::date
        )

        -- Justificación por rango de fechas
        AND NOT EXISTS (
            SELECT 1
            FROM central.masivo_ctrl_temp_faltas_just mj
            WHERE mj.rfc = (
                SELECT e.rfc 
                FROM central.tbl_empleados_hraes e
                WHERE e.id_tbl_empleados_hraes = Entradas.id_tbl_empleados_hraes
            )
            
        )

        -- Día extra autorizado (ej. evento especial)
        AND NOT EXISTS (
            SELECT 1
            FROM central.cat_dias_extraor ce
            WHERE ce.fecha = Entradas.fecha
            AND ce.tipo = 'RETARDO MAYOR'
        )

        -- Justificación por incidencias (licencia, vacaciones, etc)
        AND NOT EXISTS (
            SELECT 1
            FROM central.ctrl_incidencias ci
            WHERE ci.id_tbl_empleados_hraes = Entradas.id_tbl_empleados_hraes
            AND ci.id_cat_incidencias IN (1, 3, 4, 9, 12)
            AND ci.fecha_inicio IS NOT NULL
            AND ci.fecha_fin IS NOT NULL
            AND Entradas.fecha BETWEEN ci.fecha_inicio AND ci.fecha_fin
        )
    ");

    return $query;
}


//OMISIÓN DE SALIDA
 public function process_3()
{
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
    2 AS id_cat_retardo_tipo,
    7 AS id_cat_retardo_estatus,
    NULL AS id_user,
    Salidas.fecha,
    Salidas.hora,
    1 AS cantidad
FROM (
    SELECT  
        MAX(A.hora) AS hora, 
        A.fecha,
        A.id_tbl_empleados_hraes
    FROM central.ctrl_asistencia A
    WHERE A.fecha NOT IN (
        SELECT fecha FROM central.cat_dias_festivos
        UNION
        SELECT DATE '2025-07-25'
    )
    GROUP BY A.fecha, A.id_tbl_empleados_hraes
) AS Salidas
WHERE Salidas.hora <= (
    SELECT C.hora_min_salida
    FROM central.cat_asistencia_config C
    WHERE C.id_cat_asistencia_config = (
        SELECT AI.id_cat_asistencia_config
        FROM central.ctrl_asistencia_info AI
        WHERE AI.id_tbl_empleados_hraes = Salidas.id_tbl_empleados_hraes
    )
)
AND NOT EXISTS (
    SELECT 1
    FROM central.cat_dias_extraor ce
    WHERE ce.fecha = Salidas.fecha
    AND ce.tipo = 'SALIDA ANTICIPADA'
)
AND NOT EXISTS (
    SELECT 1
    FROM central.ctrl_incidencias ci
    WHERE ci.id_tbl_empleados_hraes = Salidas.id_tbl_empleados_hraes
    AND ci.id_cat_incidencias IN (2, 4, 10, 16, 15, 14)
    AND ci.fecha_inicio IS NOT NULL
    AND ci.fecha_fin IS NOT NULL
    AND Salidas.fecha BETWEEN ci.fecha_inicio AND ci.fecha_fin
);

    ");
    return $query;
}

//RETARDOS MENORES
public function process_4()
{
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
            WHEN COUNT(*) >= 3 AND COUNT(*) < 6 THEN 1
            WHEN COUNT(*) >= 6 AND COUNT(*) < 9 THEN 2
            WHEN COUNT(*) >= 9 AND COUNT(*) < 12 THEN 3
            WHEN COUNT(*) >= 12 THEN 4
        END AS cantidad,
        r.id_tbl_empleados_hraes,
        TRUE AS es_por_retardo,
        3 AS id_cat_retardo_tipo,
        6 AS id_cat_retardo_estatus,
        MAX(r.fecha) AS fecha
    FROM central.ctrl_retardo r
    INNER JOIN central.tbl_empleados_hraes e 
        ON e.id_tbl_empleados_hraes = r.id_tbl_empleados_hraes
    WHERE r.fecha BETWEEN '2025-07-01' AND '2025-07-15'
    AND NOT EXISTS (
        SELECT 1
        FROM central.ctrl_incidencias ci
        WHERE ci.id_tbl_empleados_hraes = r.id_tbl_empleados_hraes
          AND ci.id_cat_incidencias IN (3, 4, 5, 9, 13)
          AND ci.fecha_inicio IS NOT NULL
          AND ci.fecha_fin IS NOT NULL
          AND r.fecha BETWEEN ci.fecha_inicio AND ci.fecha_fin
    )
    AND NOT EXISTS (
        SELECT 1
        FROM central.cat_dias_extraor ce
        WHERE ce.fecha = r.fecha
          AND ce.tipo = 'RETARDO MAYOR'
    )
    GROUP BY r.id_tbl_empleados_hraes
    HAVING COUNT(*) >= 3
    ");

    return $query;
}

//INASISTENCIAS
    public function process_5()
    {
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
    e.id_tbl_empleados_hraes,
    'INASISTENCIA' AS observaciones,
    FALSE AS es_por_retardo,
    3 AS id_cat_retardo_tipo,
    8 AS id_cat_retardo_estatus,
    NULL AS id_user,
    gs.fecha,
    '00:00:00' AS hora,
    1 AS cantidad
FROM (
    SELECT generate_series(
        (SELECT MIN(fecha) FROM central.ctrl_asistencia),
        (SELECT MAX(fecha) FROM central.ctrl_asistencia),
        interval '1 day'
    )::date AS fecha
) gs
CROSS JOIN central.tbl_empleados_hraes e
INNER JOIN central.ctrl_asistencia_info ai 
    ON e.id_tbl_empleados_hraes = ai.id_tbl_empleados_hraes
WHERE 
    ai.id_cat_asistencia_ubicacion = 1
    AND ai.id_cat_asistencia_estatus = 1
    AND ai.id_cat_asistencia_config = 1
    AND ai.no_dispositivo IS NOT NULL
    AND NOT EXISTS (
        SELECT 1
        FROM central.ctrl_asistencia a
        WHERE a.id_tbl_empleados_hraes = e.id_tbl_empleados_hraes
          AND a.fecha = gs.fecha
    )
    AND gs.fecha NOT IN (
        SELECT fecha FROM central.cat_dias_festivos
    )
    AND NOT EXISTS (
        SELECT 1
        FROM central.ctrl_faltas cf
        WHERE cf.id_tbl_empleados_hraes = e.id_tbl_empleados_hraes
          AND cf.fecha = gs.fecha
          AND cf.id_cat_retardo_tipo = 3
    )
    AND NOT EXISTS (
        SELECT 1
        FROM central.masivo_ctrl_temp_faltas_just mj
        WHERE mj.rfc = (
            SELECT rfc FROM central.tbl_empleados_hraes WHERE id_tbl_empleados_hraes = e.id_tbl_empleados_hraes
        )
        AND mj.fecha = gs.fecha::text
    )
    AND NOT EXISTS (
        SELECT 1
        FROM central.ctrl_incidencias ci
        WHERE ci.id_tbl_empleados_hraes = e.id_tbl_empleados_hraes
          AND ci.fecha_inicio IS NOT NULL
          AND (
              (ci.fecha_fin IS NULL AND gs.fecha = ci.fecha_inicio)
              OR (ci.fecha_fin IS NOT NULL AND gs.fecha BETWEEN ci.fecha_inicio AND ci.fecha_fin)
          )
    )
    AND NOT EXISTS (
        SELECT 1
        FROM central.cat_dias_extraor ce
        WHERE ce.fecha = gs.fecha
          AND ce.tipo = 'OMISION'
    )
    AND NOT EXISTS (
    SELECT 1
    FROM central.ctrl_incidencias ci2
    WHERE ci2.id_tbl_empleados_hraes = e.id_tbl_empleados_hraes
      AND ci2.id_cat_incidencias IN (3, 5, 6, 7, 8, 14, 15, 16, 11, 17, 18)
      AND ci2.fecha_inicio IS NOT NULL
      AND ci2.fecha_fin IS NOT NULL
      AND gs.fecha BETWEEN ci2.fecha_inicio AND ci2.fecha_fin
);");
        return $query;
    }

public function process_6()
{
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
    e.id_tbl_empleados_hraes,
    'FALTA POR OMISIÓN DE SALIDA' AS observaciones,
    FALSE AS es_por_retardo,
    3 AS id_cat_retardo_tipo,
    7 AS id_cat_retardo_estatus,
    NULL AS id_user,
    e.fecha,
    e.hora,
    1 AS cantidad
FROM (
    SELECT 
        ca.fecha,
        MIN(ca.hora) AS hora,
        ca.id_tbl_empleados_hraes,
        COUNT(ca.hora) AS registros
    FROM central.ctrl_asistencia ca
    INNER JOIN central.ctrl_asistencia_info ai
        ON ca.id_tbl_empleados_hraes = ai.id_tbl_empleados_hraes
    WHERE ca.fecha NOT IN (
        SELECT fecha FROM central.cat_dias_festivos
    )
    AND ai.id_cat_asistencia_ubicacion = 1
    AND ai.id_cat_asistencia_estatus = 1   
    AND ai.id_cat_asistencia_config = 1
    AND ai.no_dispositivo IS NOT NULL
    GROUP BY ca.fecha, ca.id_tbl_empleados_hraes
) AS e
WHERE e.registros = 1
AND e.fecha NOT IN (
    '2024-12-24', '2024-12-31', '2024-01-10', '2025-05-30'
)
AND NOT EXISTS (
    SELECT 1
    FROM central.ctrl_faltas cf
    WHERE cf.fecha = e.fecha
      AND cf.hora = e.hora
      AND cf.id_tbl_empleados_hraes = e.id_tbl_empleados_hraes
)
AND NOT EXISTS (
    SELECT 1
    FROM central.masivo_ctrl_temp_faltas_just mctf
    WHERE mctf.rfc = (
        SELECT rfc 
        FROM central.tbl_empleados_hraes 
        WHERE id_tbl_empleados_hraes = e.id_tbl_empleados_hraes
    )
    AND mctf.fecha::text = e.fecha::text
)
AND NOT EXISTS (
    SELECT 1
    FROM central.ctrl_incidencias ci2
    WHERE ci2.id_tbl_empleados_hraes = e.id_tbl_empleados_hraes
      AND ci2.id_cat_incidencias IN (2, 10, 3, 4, 5, 6, 16, 11, 17)
      AND ci2.fecha_inicio IS NOT NULL
      AND ci2.fecha_fin IS NOT NULL
      AND e.fecha BETWEEN ci2.fecha_inicio AND ci2.fecha_fin
)
AND NOT EXISTS (
    SELECT 1
    FROM central.cat_dias_extraor ce
    WHERE ce.fecha = e.fecha
      AND ce.tipo = 'OMISION DE SALIDA'
)
AND e.id_tbl_empleados_hraes IN (
    SELECT id_tbl_empleados_hraes
    FROM (
        SELECT filtro.id_tbl_empleados_hraes, COUNT(*) AS total
        FROM (
            SELECT ca.fecha, ca.id_tbl_empleados_hraes
            FROM central.ctrl_asistencia ca
            INNER JOIN central.ctrl_asistencia_info ai
                ON ca.id_tbl_empleados_hraes = ai.id_tbl_empleados_hraes
            WHERE ca.fecha NOT IN (
                SELECT fecha FROM central.cat_dias_festivos
            )
            AND ai.id_cat_asistencia_ubicacion = 1
            AND ai.id_cat_asistencia_estatus = 1   
            AND ai.id_cat_asistencia_config = 1
            AND ai.no_dispositivo IS NOT NULL
            GROUP BY ca.fecha, ca.id_tbl_empleados_hraes
            HAVING COUNT(ca.hora) = 1
        ) AS filtro
        GROUP BY filtro.id_tbl_empleados_hraes
    ) AS resumen
);
    ");
    
    return $query;
}


    public function process_7()
    {
        $query = pg_query("UPDATE central.cat_asistencia_config
            SET fecha_ult_proceso = CURRENT_DATE
            WHERE id_cat_asistencia_config = 1;
        ");
        return $query;
    }

  public function truncateTableTmpFaltas()
{
    return pg_query("TRUNCATE TABLE central.masivo_ctrl_temp_faltas_just RESTART IDENTITY;");
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
                            VALUES ('$rfc', '$fecha', '$observaciones', '$tipo', '$tipo_falta');");
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
