<?php

class AlertasM
{
    /**
     * Lista por rango (opcional) solo INASISTENCIAS >= 3
     */
    function listarById($id_object, $paginator, $fechaInicio = null, $fechaFin = null)
    {
        $whereFechas = "";
        $params = [];

        if ($fechaInicio && $fechaFin) {
            $whereFechas = "AND f.fecha BETWEEN \$1::DATE AND \$2::DATE";
            $params = [$fechaInicio, $fechaFin];
        }

        $query = "
        SELECT
            e.rfc,
            CONCAT(UPPER(e.nombre), ' ', UPPER(e.primer_apellido), ' ', UPPER(e.segundo_apellido)) AS nombre_completo,
            COUNT(*) AS total_faltas,
            STRING_AGG(TO_CHAR(f.fecha, 'DD-MM-YYYY'), ', ' ORDER BY f.fecha) AS dias_faltas
        FROM central.ctrl_faltas f
        INNER JOIN central.tbl_empleados_hraes e
            ON e.id_tbl_empleados_hraes = f.id_tbl_empleados_hraes
        INNER JOIN central.cat_retardo_estatus cre
            ON cre.id_cat_retardo_estatus = f.id_cat_retardo_estatus
        WHERE UPPER(cre.descripcion) = 'INASISTENCIAS'
        $whereFechas
        GROUP BY e.rfc, e.nombre, e.primer_apellido, e.segundo_apellido
        HAVING COUNT(*) >= 3
        ORDER BY total_faltas DESC;
        ";

        return pg_query_params($query, $params);
    }

    function listarByNull()
    {
        return [
            'rfc' => null,
            'nombre_completo' => null,
            'total_faltas' => null,
            'dias_faltas' => null
        ];
    }

    /**
     * Búsqueda simple sobre RFC/nombre; solo INASISTENCIAS >= 3
     * Mantengo LIMIT 3 y OFFSET para probar paginación.
     */
    function listarByBusqueda($busqueda, $paginator)
    {
        $query = "
        SELECT
            e.rfc,
            CONCAT(UPPER(e.nombre), ' ', UPPER(e.primer_apellido), ' ', UPPER(e.segundo_apellido)) AS nombre_completo,
            COUNT(*) AS total_faltas,
            STRING_AGG(TO_CHAR(f.fecha, 'DD-MM-YYYY'), ', ' ORDER BY f.fecha) AS dias_faltas
        FROM central.ctrl_faltas f
        INNER JOIN central.tbl_empleados_hraes e
            ON e.id_tbl_empleados_hraes = f.id_tbl_empleados_hraes
        INNER JOIN central.cat_retardo_estatus cre
            ON cre.id_cat_retardo_estatus = f.id_cat_retardo_estatus
        WHERE UPPER(cre.descripcion) = 'INASISTENCIAS'
          AND (
              \$1 IS NULL OR
              CONCAT(e.rfc, ' ', UPPER(e.nombre), ' ', UPPER(e.primer_apellido), ' ', UPPER(e.segundo_apellido))
              ILIKE '%' || \$1 || '%'
          )
        GROUP BY e.rfc, e.nombre, e.primer_apellido, e.segundo_apellido
        HAVING COUNT(*) >= 3
        ORDER BY total_faltas DESC
        LIMIT 3 OFFSET \$2;
        ";

        return pg_query_params($query, [$busqueda, $paginator]);
    }
}
?>
