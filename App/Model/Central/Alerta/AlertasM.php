<?php

class AlertasM
{
    function listarById($id_object, $paginator)
    {
        $listado = pg_query("WITH dias_validos AS (
            -- Generar un calendario de días hábiles excluyendo fines de semana y días festivos
            SELECT 
                fecha::DATE
            FROM GENERATE_SERIES(
                (SELECT MIN(fecha) FROM central.ctrl_faltas),
                (SELECT MAX(fecha) FROM central.ctrl_faltas),
                '1 day'::INTERVAL
            ) fecha
            WHERE EXTRACT(DOW FROM fecha) NOT IN (0, 6) -- Excluir fines de semana (domingo=0, sábado=6)
              AND fecha NOT IN (SELECT fecha FROM central.cat_dias_festivos) -- Excluir días festivos
        ),
        faltas_validas AS (
            -- Faltas que ocurren en días válidos (hábiles)
            SELECT 
                f.id_tbl_empleados_hraes,
                f.fecha
            FROM central.ctrl_faltas f
            WHERE f.fecha IN (SELECT fecha FROM dias_validos)
        ),
        faltas_consecutivas AS (
            -- Identificar grupos de días consecutivos de faltas
            SELECT 
                fv.id_tbl_empleados_hraes,
                fv.fecha,
                fv.fecha - ROW_NUMBER() OVER (PARTITION BY fv.id_tbl_empleados_hraes ORDER BY fv.fecha)::INTEGER AS grupo
            FROM faltas_validas fv
        ),
        agrupadas AS (
            -- Agrupar los días consecutivos por empleado
            SELECT 
                id_tbl_empleados_hraes,
                COUNT(*) AS total_faltas,
                STRING_AGG(TO_CHAR(fecha, 'DD-MM-YYYY'), ', ') AS dias_faltas
            FROM faltas_consecutivas
            GROUP BY id_tbl_empleados_hraes, grupo
            HAVING COUNT(*) >= 3 -- Grupos con al menos 3 días consecutivos de faltas
        )
        SELECT 
            e.rfc,
            CONCAT(UPPER(e.nombre), ' ', UPPER(e.primer_apellido), ' ', UPPER(e.segundo_apellido)) AS nombre_completo,
            agrupadas.total_faltas,
            agrupadas.dias_faltas
        FROM agrupadas
        INNER JOIN central.tbl_empleados_hraes e
            ON agrupadas.id_tbl_empleados_hraes = e.id_tbl_empleados_hraes
        ORDER BY agrupadas.total_faltas DESC;");
    
        return $listado;
    }
    

    function listarByNull()
    {
        return $raw = [
            'rfc' => null,
            'nombre_completo' => null,
            'total_faltas' => null,
            'dias_faltas' => null
        ];
    }

    function listarByBusqueda($busqueda, $paginator)
    {
        $listado = pg_query("SELECT 
                                e.rfc,
                                CONCAT(UPPER(e.nombre), ' ', UPPER(e.primer_apellido), ' ', UPPER(e.segundo_apellido)) AS nombre_completo,
                                COUNT(f.fecha) AS total_faltas,
                                STRING_AGG(TO_CHAR(f.fecha, 'DD-MM-YYYY'), ', ') AS dias_faltas
                            FROM central.ctrl_faltas f
                            INNER JOIN central.tbl_empleados_hraes e
                                ON f.id_tbl_empleados_hraes = e.id_tbl_empleados_hraes
                            INNER JOIN central.ctrl_asistencia_info cai
                                ON f.id_tbl_empleados_hraes = cai.id_tbl_empleados_hraes
                            INNER JOIN central.cat_retardo_estatus cre
                                ON f.id_cat_retardo_estatus = cre.id_cat_retardo_estatus
                            WHERE cai.id_cat_asistencia_estatus = 1
                              AND UPPER(cre.descripcion) = 'FALTA POR OMISION'
                              AND (
                                  CONCAT(
                                      e.rfc, ' ',
                                      UPPER(e.nombre), ' ',
                                      UPPER(e.primer_apellido), ' ',
                                      UPPER(e.segundo_apellido)
                                  ) LIKE '%' || '$busqueda' || '%'
                              )
                            GROUP BY e.rfc, e.nombre, e.primer_apellido, e.segundo_apellido
                          HAVING COUNT(f.fecha) >= 3
                            ORDER BY total_faltas DESC
                             LIMIT 3 OFFSET $paginator;");
        return $listado;
    }
}

?>dddd
