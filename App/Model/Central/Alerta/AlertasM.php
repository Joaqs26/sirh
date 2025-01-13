<?php

class AlertasM
{
    function listarById($id_object, $paginator)
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
                                AND UPPER(cre.descripcion) = 'FALTA POR OMISIÓN'
                                GROUP BY e.rfc, e.nombre, e.primer_apellido, e.segundo_apellido
                            HAVING COUNT(f.fecha) >= 3
                                ORDER BY total_faltas DESC;");
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
