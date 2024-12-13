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
                1 AS id_cat_retardo_tipo,  -- Entrada 
                5 AS id_cat_retardo_estatus,  -- Por Aplicar
                Entradas.id_tbl_empleados_hraes,
                NULL AS id_user
            FROM 
            (
                SELECT 
                    MIN(ctrl_asistencia.hora) AS hora, -- Tomar la primera checada
                    ctrl_asistencia.fecha, 
                    ctrl_asistencia.id_tbl_empleados_hraes
                FROM central.ctrl_asistencia
                WHERE ctrl_asistencia.fecha NOT IN (SELECT fecha FROM central.cat_dias_festivos) -- Excluir días no laborables
                GROUP BY ctrl_asistencia.fecha, ctrl_asistencia.id_tbl_empleados_hraes
            ) AS Entradas
            WHERE 
                Entradas.hora >= '09:16:00' -- Hora mínima para retardo
                AND Entradas.hora <= '09:30:00' -- Hora máxima para retardo
                AND NOT EXISTS ( -- Validar que no exista un registro duplicado en ctrl_retardo
                    SELECT 1
                    FROM central.ctrl_retardo
                    WHERE central.ctrl_retardo.fecha = Entradas.fecha
                      AND central.ctrl_retardo.hora = Entradas.hora
                      AND central.ctrl_retardo.id_tbl_empleados_hraes = Entradas.id_tbl_empleados_hraes
                );");
        return $query;
    }
    

    public function process_2()
    {
        $query = pg_query(" INSERT INTO central.ctrl_faltas (
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
                1 AS id_cat_retardo_tipo, -- Entrada
                7 AS id_cat_retardo_estatus, -- Retardo Mayor
                NULL AS id_user,
                Entradas.fecha,
                Entradas.hora,
                1 AS cantidad
            FROM (
                SELECT 
                    MIN(ctrl_asistencia.hora) AS hora, -- Tomar la primera checada
                    ctrl_asistencia.fecha,
                    ctrl_asistencia.id_tbl_empleados_hraes
                FROM central.ctrl_asistencia
                WHERE ctrl_asistencia.fecha NOT IN (SELECT fecha FROM central.cat_dias_festivos) -- Excluir días festivos
                GROUP BY ctrl_asistencia.fecha, ctrl_asistencia.id_tbl_empleados_hraes
            ) AS Entradas
            WHERE 
                Entradas.hora > '09:30:00' -- Hora mínima para falta por retardo
                AND NOT EXISTS ( -- Evita duplicados en ctrl_faltas
                    SELECT 1
                    FROM central.ctrl_faltas
                    WHERE central.ctrl_faltas.fecha = Entradas.fecha
                      AND central.ctrl_faltas.hora = Entradas.hora
                      AND central.ctrl_faltas.id_tbl_empleados_hraes = Entradas.id_tbl_empleados_hraes
                );
        ");
        return $query;
    }
    

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
                2 AS id_cat_retardo_tipo, -- Salida
                4 AS id_cat_retardo_estatus, -- Falta por salida anticipada
                NULL AS id_user,
                Salidas.fecha,
                Salidas.hora,
                1 AS cantidad
            FROM (
                SELECT 
                    MAX(ctrl_asistencia.hora) AS hora, -- Tomar el último registro de checada
                    ctrl_asistencia.fecha,
                    ctrl_asistencia.id_tbl_empleados_hraes
                FROM central.ctrl_asistencia
                WHERE ctrl_asistencia.fecha NOT IN (SELECT fecha FROM central.cat_dias_festivos) -- Excluir días festivos
                GROUP BY ctrl_asistencia.fecha, ctrl_asistencia.id_tbl_empleados_hraes
            ) AS Salidas
            WHERE 
                Salidas.hora < '19:00:00' -- Salida antes de las 7:00 PM
                AND NOT EXISTS ( -- Evita duplicados en ctrl_faltas
                    SELECT 1
                    FROM central.ctrl_faltas
                    WHERE central.ctrl_faltas.fecha = Salidas.fecha
                      AND central.ctrl_faltas.hora = Salidas.hora
                      AND central.ctrl_faltas.id_tbl_empleados_hraes = Salidas.id_tbl_empleados_hraes
                );
        ");
        return $query;
    }
    

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
                    WHEN (NoRet >= 3 AND NoRet <  6) THEN 1  									-- Una falta cuando los retardos estan entre 3 y 6
			        WHEN (NoRet >= 6 AND NoRet <  9) THEN 2										-- Dos faltas cuando los retardos estan entre 6 y 9
			        WHEN (NoRet >= 9 AND NoRet < 12) THEN 3										-- Tres faltas cuando los retardos estan entre 9 y 12
			        WHEN (NoRet >= 12 			   ) THEN 4										-- Cuatro faltas 
                END AS Faltas, id_tbl_empleados_hraes, TRUE es_por_retardo, 3 id_cat_retardo_tipo, 6 id_cat_retardo_estatus,
		CASE WHEN SUBSTRING(CURRENT_DATE::TEXT,9,2) <= '15' 
			 THEN ('15'||'/'||SUBSTRING(CURRENT_DATE::TEXT,6,2)||'/'||SUBSTRING(CURRENT_DATE::TEXT,1,4))::DATE	-- Toma el día 15 del Mes
		    ELSE (date_trunc('MONTH', CURRENT_DATE) + INTERVAL '1 MONTH' - INTERVAL '1 DAY')::DATE					-- Toma el último día del Mes
		    END AS fecha    --Para este caso tomará el día 15 del mes cuando la fecha actual sea menor o igual a 15, de lo contrario el último día del mes
                FROM(SELECT COUNT(*) NoRet, id_tbl_empleados_hraes
		FROM central.ctrl_retardo
						-- ### Aquí ponemos una condición para una fecha mayor o igual, o se quita para procesar todo
	GROUP BY id_tbl_empleados_hraes
	HAVING COUNT(*) >= 3
	) AS Retardos;
        ");
        return $query;
    }
    

    public function process_5()
    {
        $query = pg_query("UPDATE central.cat_asistencia_config
    SET fecha_ult_proceso = CURRENT_DATE 
    WHERE id_cat_asistencia_config = 1; 
    (SELECT fecha_ult_proceso FROM central.cat_asistencia_config WHERE id_cat_asistencia_config = 1) -- Agregar esta condición");
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
    123 AS id_tbl_empleados_hraes,            -- Reemplaza 123 con un ID real de empleado
    TRUE AS es_por_retardo,                   -- Es por retardo
    3 AS id_cat_retardo_tipo,                 -- Tipo de retardo
    CASE 
        WHEN (NoRet >= 3 AND NoRet < 6) THEN 1
        WHEN (NoRet >= 6 AND NoRet < 9) THEN 2
        WHEN (NoRet >= 9 AND NoRet < 12) THEN 3
        WHEN (NoRet >= 12) THEN 4
    END AS id_cat_retardo_estatus,            -- Estatus de retardo
    CURRENT_DATE AS fecha                     -- Fecha actual
FROM (
    SELECT COUNT(*) + 6 AS NoRet
    FROM central.ctrl_retardo
    WHERE fecha <= '2024-08-15'               -- Fecha en formato YYYY-MM-DD
      AND id_tbl_empleados_hraes = 123       -- Reemplaza 123 con un ID real de empleado
) AS Retardos;");
        return $query;

    }        

    public function process_7()
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
    f.id_tbl_empleados_hraes,                      -- ID del empleado
    'FALTA POR OMISIÓN' AS observaciones,          -- Observación
    FALSE AS es_por_retardo,                       -- No es por retardo
    3 AS id_cat_retardo_tipo,                      -- Tipo de falta por omisión
    8 AS id_cat_retardo_estatus,                   -- Estatus para falta por omisión
    NULL AS id_user,                               -- Usuario que procesa
    f.fecha,                                       -- Fecha omitida
    '00:00:00' AS hora,                            -- Hora predeterminada
    1 AS cantidad                                  -- Una falta
FROM (
    -- Generar todas las combinaciones de empleados y fechas del rango
    SELECT 
        e.id_tbl_empleados_hraes,
        g.fecha
    FROM 
        central.tbl_empleados_hraes e              -- Tabla de empleados
    CROSS JOIN (
        -- Generar el rango de fechas dinámicamente desde ctrl_asistencia
        SELECT 
            GENERATE_SERIES(
                (SELECT MIN(fecha) FROM central.ctrl_asistencia),
                (SELECT MAX(fecha) FROM central.ctrl_asistencia),
                '1 day'::INTERVAL
            )::DATE AS fecha
    ) g
    INNER JOIN central.ctrl_asistencia_info ai    -- Filtrar empleados activos
        ON e.id_tbl_empleados_hraes = ai.id_tbl_empleados_hraes
        AND ai.id_cat_asistencia_estatus = 1      -- Solo empleados con estatus ACTIVO

    INNER JOIN asistencia.ctrl_plantilla_qna p
        ON e.id_tbl_empleados_hraes = CAST(p.ids AS INTEGER)
        AND p.ubicacion = 'E CAMPA'
        AND p.ids ~ '^\d+$'                      -- Filtrar solo valores numéricos en 
        ) f
LEFT JOIN central.ctrl_asistencia a
    ON f.id_tbl_empleados_hraes = a.id_tbl_empleados_hraes
    AND f.fecha = a.fecha                          -- Verificar si ya hay un registro de asistencia en esa fecha
WHERE a.fecha IS NULL                              -- No hay registros de asistencia en esa fecha
    AND f.fecha NOT IN (                           -- Excluir fechas en cat_dias_festivos
        SELECT fecha 
        FROM central.cat_dias_festivos
    )
    AND NOT EXISTS (                               -- Evitar duplicados en ctrl_faltas
        SELECT 1 
        FROM central.ctrl_faltas cf
        WHERE cf.id_tbl_empleados_hraes = f.id_tbl_empleados_hraes
          AND cf.fecha = f.fecha
          AND cf.id_cat_retardo_tipo = 3           -- Ya existe una falta por omisión
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