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
                AND daterange(ci.fecha_inicio::date, COALESCE(ci.fecha_fin::date, ci.fecha_inicio::date), '[]')
            @> Entradas.fecha::date
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
                    A.fecha::date AS fecha, 
                    MIN(A.hora)   AS hora,
                    A.id_tbl_empleados_hraes
                FROM central.ctrl_asistencia A
                WHERE A.fecha::date NOT IN (SELECT fecha::date FROM central.cat_dias_festivos)
                  AND A.fecha::date <> DATE '2025-05-14'
                GROUP BY A.fecha::date, A.id_tbl_empleados_hraes
            ) AS Minimo
            WHERE 
                (
                    Minimo.fecha = DATE '2025-06-02' 
                    AND Minimo.hora > TIME '10:00:59'
                )
                OR
                (
                    Minimo.fecha <> DATE '2025-06-02'
                    AND EXISTS (
                        SELECT 1
                        FROM central.ctrl_asistencia_info AI
                        JOIN central.cat_asistencia_config C 
                          ON C.id_cat_asistencia_config = AI.id_cat_asistencia_config
                        WHERE AI.id_tbl_empleados_hraes = Minimo.id_tbl_empleados_hraes
                          AND C.hora_max_retardo IS NOT NULL
                          AND Minimo.hora > C.hora_max_retardo
                    )
                )
        ) AS Entradas

        -- Evitar duplicado mismo día
        WHERE NOT EXISTS (
            SELECT 1
            FROM central.ctrl_faltas f
            WHERE f.id_tbl_empleados_hraes = Entradas.id_tbl_empleados_hraes
              AND f.fecha::date = Entradas.fecha::date
        )

        -- Justificación exacta por fecha (tabla temporal)
        AND NOT EXISTS (
            SELECT 1
            FROM central.masivo_ctrl_temp_faltas_just mj
            WHERE mj.rfc = (
                    SELECT e.rfc 
                    FROM central.tbl_empleados_hraes e
                    WHERE e.id_tbl_empleados_hraes = Entradas.id_tbl_empleados_hraes
                )
              AND mj.fecha IS NOT NULL
              AND mj.fecha::date = Entradas.fecha::date
        )

        -- Día extraordinario marcado como RETARDO MAYOR u OMISIÓN DE ENTRADA
        AND NOT EXISTS (
            SELECT 1
            FROM central.cat_dias_extraor ce
            WHERE ce.fecha::date = Entradas.fecha::date
              AND (
                    UPPER(TRIM(ce.tipo)) LIKE 'RETARDO MAYOR%'
                 OR UPPER(TRIM(ce.tipo)) LIKE 'OMISION DE ENTRADA%'
                 OR UPPER(TRIM(ce.tipo)) LIKE 'OMISIÓN DE ENTRADA%'
                 OR UPPER(TRIM(ce.tipo)) LIKE 'RETARDO MAYOR/OMISION DE ENTRADA%'
                 OR UPPER(TRIM(ce.tipo)) LIKE 'RETARDO MAYOR/OMISIÓN DE ENTRADA%'
              )
        )

        -- Incidencias que justifican (por ID o por descripción del catálogo) usando RANGO inclusivo
        AND NOT EXISTS (
            SELECT 1
            FROM central.ctrl_incidencias ci
            JOIN central.cat_incidencias c
              ON c.id_cat_incidencias = ci.id_cat_incidencias
            WHERE ci.id_tbl_empleados_hraes = Entradas.id_tbl_empleados_hraes
              AND NULLIF(TRIM(ci.fecha_inicio::text), '') IS NOT NULL
              -- si fecha_fin viene null, tratamos el mismo día
              AND daterange(ci.fecha_inicio::date, COALESCE(ci.fecha_fin::date, ci.fecha_inicio::date), '[]')
                    @> Entradas.fecha::date
              AND (
                    -- tus IDs originales + los que agregues
                    ci.id_cat_incidencias IN (1,3,4,6,9,12,10)
                    -- y también por descripción del catálogo
                 OR UPPER(TRIM(c.descripcion)) IN (
                        'OMISION DE ENTRADA', 'OMISIÓN DE ENTRADA',
                        'RETARDO MAYOR',
                        'RETARDO MAYOR/OMISION DE ENTRADA', 'RETARDO MAYOR/OMISIÓN DE ENTRADA'
                    )
              )
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
            s.id_tbl_empleados_hraes,
            NULL AS observaciones,
            TRUE AS es_por_retardo,
            2 AS id_cat_retardo_tipo,
            7 AS id_cat_retardo_estatus,
            NULL AS id_user,
            s.fecha,
            s.hora,
            1 AS cantidad
        FROM (
            SELECT  
                MAX(a.hora)        AS hora, 
                a.fecha::date      AS fecha,
                a.id_tbl_empleados_hraes
            FROM central.ctrl_asistencia a
            WHERE a.fecha::date NOT IN (
                SELECT cf.fecha::date
                FROM central.cat_dias_festivos cf
                WHERE cf.fecha IS NOT NULL
            )
            AND a.fecha::date <> DATE '2025-07-25'
            GROUP BY a.fecha::date, a.id_tbl_empleados_hraes
        ) AS s
        WHERE s.hora <= (
            SELECT c.hora_min_salida
            FROM central.cat_asistencia_config c
            WHERE c.id_cat_asistencia_config = (
                SELECT ai.id_cat_asistencia_config
                FROM central.ctrl_asistencia_info ai
                WHERE ai.id_tbl_empleados_hraes = s.id_tbl_empleados_hraes
                LIMIT 1
            )
        )
        -- excluir días extraordinarios de SALIDA ANTICIPADA
        AND NOT EXISTS (
            SELECT 1
            FROM central.cat_dias_extraor ce
            WHERE ce.fecha::date = s.fecha::date
              AND UPPER(TRIM(ce.tipo)) = 'SALIDA ANTICIPADA'
        )
        -- excluir incidencias que cubran la fecha (solo las categorías indicadas)
        AND NOT EXISTS (
            SELECT 1
            FROM central.ctrl_incidencias ci
            WHERE ci.id_tbl_empleados_hraes = s.id_tbl_empleados_hraes
              AND ci.id_cat_incidencias IN (2,4,10,16,15,14)
              AND ci.fecha_inicio IS NOT NULL
              AND daterange(ci.fecha_inicio::date, COALESCE(ci.fecha_fin::date, ci.fecha_inicio::date), '[]')
                    @> s.fecha::date
        )
        -- evitar duplicado en ctrl_faltas mismo empleado/fecha/tipo/estatus
        AND NOT EXISTS (
            SELECT 1
            FROM central.ctrl_faltas f
            WHERE f.id_tbl_empleados_hraes = s.id_tbl_empleados_hraes
              AND f.fecha::date = s.fecha::date
              AND f.id_cat_retardo_tipo = 2
              AND f.id_cat_retardo_estatus = 7
        );
    ");
    return $query;
}

//RETARDOS MENORES
public function process_4()
{
    $query = pg_query("WITH base AS (
            SELECT
                r.id_tbl_empleados_hraes,
                COUNT(DISTINCT r.fecha::date) AS cnt,  -- días únicos con retardo menor
                MAX(r.fecha::date)            AS fecha_max
            FROM central.ctrl_retardo r
            WHERE r.fecha::date BETWEEN DATE '2025-07-01' AND DATE '2025-07-31'  -- ⬅️ periodo que esperas
              AND (r.id_cat_retardo_estatus = 5 OR r.id_cat_retardo_estatus IS NULL)  -- ⬅️ retardo menor (ajusta si aplica)
            GROUP BY r.id_tbl_empleados_hraes
            HAVING COUNT(DISTINCT r.fecha::date) >= 3
        )
        INSERT INTO central.ctrl_faltas (
            cantidad, id_tbl_empleados_hraes, es_por_retardo,
            id_cat_retardo_tipo, id_cat_retardo_estatus, fecha
        )
        SELECT
            CASE
                WHEN b.cnt >= 12 THEN 4
                WHEN b.cnt >=  9 THEN 3
                WHEN b.cnt >=  6 THEN 2
                ELSE 1
            END AS cantidad,
            b.id_tbl_empleados_hraes,
            TRUE AS es_por_retardo,
            3    AS id_cat_retardo_tipo,
            6    AS id_cat_retardo_estatus,   -- 'RETARDOS MENORES'
            b.fecha_max AS fecha
        FROM base b
        WHERE NOT EXISTS (  -- evita duplicar si ya lo insertaste antes
            SELECT 1
            FROM central.ctrl_faltas f
            WHERE f.id_tbl_empleados_hraes = b.id_tbl_empleados_hraes
              AND f.fecha::date            = b.fecha_max
              AND f.id_cat_retardo_tipo    = 3
              AND f.id_cat_retardo_estatus = 6
        );
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
        (SELECT MIN(a.fecha)::date FROM central.ctrl_asistencia a),
        (SELECT MAX(a.fecha)::date FROM central.ctrl_asistencia a),
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

    -- no hay asistencia ese día
    AND NOT EXISTS (
        SELECT 1
        FROM central.ctrl_asistencia a
        WHERE a.id_tbl_empleados_hraes = e.id_tbl_empleados_hraes
          AND a.fecha::date = gs.fecha::date
    )

    -- no es día festivo
    AND gs.fecha::date NOT IN (
        SELECT cf.fecha::date
        FROM central.cat_dias_festivos cf
    )

    -- no existe ya una falta tipo INASISTENCIA para ese día
    AND NOT EXISTS (
        SELECT 1
        FROM central.ctrl_faltas cf
        WHERE cf.id_tbl_empleados_hraes = e.id_tbl_empleados_hraes
          AND cf.fecha::date = gs.fecha::date
          AND cf.id_cat_retardo_tipo = 3
    )

    -- no está justificado por carga temporal
    AND NOT EXISTS (
        SELECT 1
        FROM central.masivo_ctrl_temp_faltas_just mj
        WHERE mj.rfc = (
            SELECT te.rfc 
            FROM central.tbl_empleados_hraes te 
            WHERE te.id_tbl_empleados_hraes = e.id_tbl_empleados_hraes
        )
        AND mj.fecha::date = gs.fecha::date
    )

    -- no hay ninguna incidencia que cubra ese día (rango inclusivo; fin NULL = 1 día)
    AND NOT EXISTS (
        SELECT 1
        FROM central.ctrl_incidencias ci
        WHERE ci.id_tbl_empleados_hraes = e.id_tbl_empleados_hraes
          AND ci.fecha_inicio IS NOT NULL
          AND daterange(ci.fecha_inicio::date, COALESCE(ci.fecha_fin::date, ci.fecha_inicio::date), '[]')
                @> gs.fecha::date
    )

    -- no está marcado como OMISION (día extraordinario)
    AND NOT EXISTS (
        SELECT 1
        FROM central.cat_dias_extraor ce
        WHERE ce.fecha::date = gs.fecha::date
          AND UPPER(TRIM(ce.tipo)) = 'OMISION'
    )

    -- (opcional) excluir solo si la incidencia es de ciertos tipos
    AND NOT EXISTS (
        SELECT 1
        FROM central.ctrl_incidencias ci2
        WHERE ci2.id_tbl_empleados_hraes = e.id_tbl_empleados_hraes
          AND ci2.id_cat_incidencias IN (3, 5, 6, 7, 8, 11, 14, 15, 16, 17, 18) -- tu lista
          AND ci2.fecha_inicio IS NOT NULL
          AND daterange(ci2.fecha_inicio::date, COALESCE(ci2.fecha_fin::date, ci2.fecha_inicio::date), '[]')
                @> gs.fecha::date
    );
");
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
        (SELECT MIN(a.fecha)::date FROM central.ctrl_asistencia a),
        (SELECT MAX(a.fecha)::date FROM central.ctrl_asistencia a),
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

    -- no hay asistencia ese día
    AND NOT EXISTS (
        SELECT 1
        FROM central.ctrl_asistencia a
        WHERE a.id_tbl_empleados_hraes = e.id_tbl_empleados_hraes
          AND a.fecha::date = gs.fecha::date
    )

    -- no es día festivo
    AND gs.fecha::date NOT IN (
        SELECT cf.fecha::date
        FROM central.cat_dias_festivos cf
    )

    -- no existe ya una falta tipo INASISTENCIA para ese día
    AND NOT EXISTS (
        SELECT 1
        FROM central.ctrl_faltas cf
        WHERE cf.id_tbl_empleados_hraes = e.id_tbl_empleados_hraes
          AND cf.fecha::date = gs.fecha::date
          AND cf.id_cat_retardo_tipo = 3
    )

    -- no está justificado por carga temporal
    AND NOT EXISTS (
        SELECT 1
        FROM central.masivo_ctrl_temp_faltas_just mj
        WHERE mj.rfc = (
            SELECT te.rfc 
            FROM central.tbl_empleados_hraes te 
            WHERE te.id_tbl_empleados_hraes = e.id_tbl_empleados_hraes
        )
        AND mj.fecha::date = gs.fecha::date
    )

    -- no hay ninguna incidencia que cubra ese día (rango inclusivo; fin NULL = 1 día)
    AND NOT EXISTS (
        SELECT 1
        FROM central.ctrl_incidencias ci
        WHERE ci.id_tbl_empleados_hraes = e.id_tbl_empleados_hraes
          AND ci.fecha_inicio IS NOT NULL
          AND daterange(ci.fecha_inicio::date, COALESCE(ci.fecha_fin::date, ci.fecha_inicio::date), '[]')
                @> gs.fecha::date
    )

    -- no está marcado como OMISION (día extraordinario)
    AND NOT EXISTS (
        SELECT 1
        FROM central.cat_dias_extraor ce
        WHERE ce.fecha::date = gs.fecha::date
          AND UPPER(TRIM(ce.tipo)) = 'OMISION'
    )

    -- (opcional) excluir solo si la incidencia es de ciertos tipos
    AND NOT EXISTS (
        SELECT 1
        FROM central.ctrl_incidencias ci2
        WHERE ci2.id_tbl_empleados_hraes = e.id_tbl_empleados_hraes
          AND ci2.id_cat_incidencias IN (3, 5, 6, 7, 8, 11, 14, 15, 16, 17, 18) -- tu lista
          AND ci2.fecha_inicio IS NOT NULL
          AND daterange(ci2.fecha_inicio::date, COALESCE(ci2.fecha_fin::date, ci2.fecha_inicio::date), '[]')
                @> gs.fecha::date
    );");
    
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

public function updateincidencias()
    {

        $query = pg_query("WITH fechas_unicas AS (            -- 1) quitar duplicados por día
    SELECT DISTINCT
        rfc,
        observaciones,
        tipo,
        fecha::date AS fecha
    FROM central.masivo_ctrl_temp_faltas_just
),
fechas_ordenadas AS (              -- 2) ordenar y numerar
    SELECT
        rfc,
        observaciones,
        tipo,
        fecha,
        ROW_NUMBER() OVER (
            PARTITION BY rfc, observaciones, tipo
            ORDER BY fecha
        ) AS rn
    FROM fechas_unicas
),
-- 3) Agrupar islas consecutivas: usar (fecha - rn)
bloques AS (
    SELECT
        x.rfc,
        x.observaciones,
        x.tipo,
        MIN(x.fecha) AS fecha_inicio,
        MAX(x.fecha) AS fecha_fin,
        COUNT(*)     AS total_dias
    FROM (
        SELECT rfc, observaciones, tipo, fecha, (fecha - rn::int) AS grp
        FROM fechas_ordenadas
    ) x
    GROUP BY x.rfc, x.observaciones, x.tipo, x.grp
),
datos_empleados AS (               -- 4) RFC -> id_tbl_empleados_hraes
    SELECT rfc, id_tbl_empleados_hraes
    FROM central.tbl_empleados_hraes
),
preparado AS (                      -- 5) mapear tipo -> id_cat_incidencias y armar payload
    SELECT
        b.fecha_inicio,
        CASE WHEN b.total_dias > 1 THEN b.fecha_fin ELSE NULL END AS fecha_fin,
        CURRENT_DATE AS fecha_captura,
        CURRENT_TIME AS hora,
        b.observaciones,
        b.tipo AS otro_cat_incidencias,
        e.id_tbl_empleados_hraes,
        CASE
            WHEN unaccent(b.tipo) ILIKE unaccent('AUTORIZACION DE OMISION DE REGISTRO DE ENTRADA') THEN 1
            WHEN unaccent(b.tipo) ILIKE unaccent('AUTORIZACION DE OMISION DE REGISTRO DE SALIDA')  THEN 2
            WHEN unaccent(b.tipo) ILIKE unaccent('CAPACITACION FUERA DE LAS INSTALACIONES')        THEN 3
            WHEN unaccent(b.tipo) ILIKE unaccent('CONSTANCIA DE TIEMPO ISSSTE')                    THEN 4
            WHEN unaccent(b.tipo) ILIKE unaccent('COMISION OFICIAL')                               THEN 5
            WHEN unaccent(b.tipo) ILIKE unaccent('CUIDADOS MEDICOS')                               THEN 6
            WHEN unaccent(b.tipo) ILIKE unaccent('DIAS A CUENTA DE VACACIONES')                    THEN 7
            WHEN unaccent(b.tipo) ILIKE unaccent('OTRO')                                           THEN 8
            WHEN unaccent(b.tipo) ILIKE unaccent('PASE DE ENTRADA')                                THEN 9
            WHEN unaccent(b.tipo) ILIKE unaccent('PASE DE SALIDA')                                 THEN 10
            WHEN unaccent(b.tipo) ILIKE unaccent('PERMISO POR DEFUNCION DE UN FAMILIAR DIRECTO')   THEN 11
            WHEN unaccent(b.tipo) ILIKE unaccent('RETARDO MAYOR')                                  THEN 12
            WHEN unaccent(b.tipo) ILIKE unaccent('RETARDO MENOR')                                  THEN 13
            WHEN unaccent(b.tipo) ILIKE unaccent('VACACIONES EXTRAORDINARIAS')                     THEN 14
            WHEN unaccent(b.tipo) ILIKE unaccent('VACACIONES ORDINARIAS')                          THEN 15
            WHEN unaccent(b.tipo) ILIKE unaccent('LICENCIA MEDICA')                                THEN 16
            WHEN unaccent(b.tipo) ILIKE unaccent('PERMISO POR PATERNIDAD')                         THEN 17
            WHEN unaccent(b.tipo) ILIKE unaccent('FALTA REGISTRO EN BIOMETRICO')                   THEN 18
            ELSE NULL
        END AS id_cat_incidencias,
        3 AS id_user,
        CASE WHEN b.total_dias > 1 THEN TRUE ELSE NULL END AS es_mas_de_un_dia,
        b.observaciones AS num_oficio
    FROM bloques b
    JOIN datos_empleados e ON b.rfc = e.rfc
)
INSERT INTO central.ctrl_incidencias (
    fecha_inicio,
    fecha_fin,
    fecha_captura,
    hora,
    observaciones,
    otro_cat_incidencias,
    id_tbl_empleados_hraes,
    id_cat_incidencias,
    id_user,
    es_mas_de_un_dia,
    num_oficio
)
SELECT
    p.fecha_inicio,
    p.fecha_fin,
    p.fecha_captura,
    p.hora,
    p.observaciones,
    p.otro_cat_incidencias,
    p.id_tbl_empleados_hraes,
    p.id_cat_incidencias,
    p.id_user,
    p.es_mas_de_un_dia,
    p.num_oficio
FROM preparado p
WHERE p.id_cat_incidencias IS NOT NULL
  AND p.id_tbl_empleados_hraes IS NOT NULL
  -- Evitar duplicado exacto (mismo empleado, mismas fechas e incidencia)
  AND NOT EXISTS (
      SELECT 1
      FROM central.ctrl_incidencias ci
      WHERE ci.id_tbl_empleados_hraes = p.id_tbl_empleados_hraes
        AND ci.id_cat_incidencias     = p.id_cat_incidencias
        AND ci.fecha_inicio::date IS NOT DISTINCT FROM p.fecha_inicio
        AND ci.fecha_fin::date    IS NOT DISTINCT FROM p.fecha_fin
  );");
        return $query;
    }


}
