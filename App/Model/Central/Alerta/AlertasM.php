<?php

class AlertasM
{
      function listarById($id_object, $paginator, $fechaInicio = null, $fechaFin = null)
{
    $whereFechas = "";
    $params = [];

    if ($fechaInicio && $fechaFin) {
        $whereFechas = "AND f.fecha BETWEEN \$1::DATE AND \$2::DATE";
        $params = [$fechaInicio, $fechaFin];
    }

    $query = " WITH dias_validos AS (
            SELECT 
                fecha::DATE,
                ROW_NUMBER() OVER (ORDER BY fecha) AS idx_dia
            FROM GENERATE_SERIES(
                (SELECT MIN(fecha) FROM central.ctrl_faltas),
                (SELECT MAX(fecha) FROM central.ctrl_faltas),
                INTERVAL '1 day'
            ) fecha
            WHERE EXTRACT(DOW FROM fecha) NOT IN (0, 6)
              AND fecha NOT IN (
                  SELECT fecha FROM central.cat_dias_festivos
              )
        ),
        faltas_filtradas AS (
            SELECT 
                f.id_tbl_empleados_hraes,
                f.fecha
            FROM central.ctrl_faltas f
            INNER JOIN central.tbl_empleados_hraes e
                ON f.id_tbl_empleados_hraes = e.id_tbl_empleados_hraes
            INNER JOIN central.ctrl_asistencia_info cai
                ON f.id_tbl_empleados_hraes = cai.id_tbl_empleados_hraes
            INNER JOIN central.cat_retardo_estatus cre
                ON f.id_cat_retardo_estatus = cre.id_cat_retardo_estatus
            WHERE UPPER(cre.descripcion) = 'FALTA POR OMISIÓN'
              AND cai.id_cat_asistencia_estatus = 1
              AND cai.id_cat_asistencia_ubicacion = 1
              AND cai.id_cat_asistencia_config = 1
              AND NOT EXISTS (
                  SELECT 1 
                  FROM central.masivo_ctrl_temp_faltas_just mctf
                  WHERE mctf.rfc = e.rfc
                    AND mctf.tipo_falta = 'FALTA'
              )
              AND f.fecha IN (SELECT fecha FROM dias_validos)
              $whereFechas
        ),
        faltas_indexadas AS (
            SELECT 
                f.id_tbl_empleados_hraes,
                f.fecha,
                d.idx_dia,
                ROW_NUMBER() OVER (PARTITION BY f.id_tbl_empleados_hraes ORDER BY d.idx_dia) AS rn
            FROM faltas_filtradas f
            INNER JOIN dias_validos d
                ON f.fecha = d.fecha
        ),
        grupos AS (
            SELECT 
                id_tbl_empleados_hraes,
                fecha,
                idx_dia,
                rn,
                idx_dia - rn AS grupo
            FROM faltas_indexadas
        ),
        agrupadas AS (
            SELECT 
                id_tbl_empleados_hraes,
                COUNT(*) AS total_faltas,
                STRING_AGG(TO_CHAR(fecha, 'DD-MM-YYYY'), ', ' ORDER BY fecha) AS dias_faltas
            FROM grupos
            GROUP BY id_tbl_empleados_hraes, grupo
            HAVING COUNT(*) >= 3
        )
        SELECT 
            e.rfc,
            CONCAT(UPPER(e.nombre), ' ', UPPER(e.primer_apellido), ' ', UPPER(e.segundo_apellido)) AS nombre_completo,
            a.total_faltas,
            a.dias_faltas
        FROM agrupadas a
        INNER JOIN central.tbl_empleados_hraes e
            ON a.id_tbl_empleados_hraes = e.id_tbl_empleados_hraes
        ORDER BY a.total_faltas DESC;
    ";

    return pg_query_params($query, $params);
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
      '$busqueda' IS NULL OR
      CONCAT(e.rfc, ' ', UPPER(e.nombre), ' ', UPPER(e.primer_apellido), ' ', UPPER(e.segundo_apellido))
      ILIKE '%' || '$busqueda' || '%'
  )
  AND NOT EXISTS (
      SELECT 1
      FROM central.masivo_ctrl_temp_faltas_just mctf
      WHERE mctf.rfc = e.rfc
      AND mctf.fecha::TEXT = f.fecha::TEXT
  )
GROUP BY e.rfc, e.nombre, e.primer_apellido, e.segundo_apellido
HAVING COUNT(f.fecha) >= 3
ORDER BY total_faltas DESC
LIMIT 3 OFFSET $paginator ;");
        return $listado;
    }
}

?>
