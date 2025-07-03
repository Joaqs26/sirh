<?php
class CatDiasM
{
    public function listarByAll()
    {
        $listado = pg_query("SELECT 
                                id_cat_tipo_dias,
                                nombre
                            FROM cat_tipo_dias
                            ORDER BY nombre ASC");
        return $listado;
    }

    public function listarById($id_object)
    {
        $listado = pg_query("SELECT 
                                id_cat_tipo_dias,
                                nombre
                            FROM cat_tipo_dias
                            WHERE id_cat_tipo_dias = $id_object");
        return $listado;
    }


    public function getPeriodos(){
                $query = pg_query("SELECT 
                                        id_cat_periodo, 
                                        descripcion
                                    FROM central.cat_periodo
                                    ORDER BY id_cat_periodo;");
         return $query;
}


    public function getAllDays($fechaInicio, $fechaFin, $idEmployee){
        $query = pg_query ("SELECT
                            SUM(
                            CASE
                             WHEN ci.fecha_fin IS NOT NULL THEN
                                    (ci.fecha_fin - ci.fecha_inicio)::int + 1
                            ELSE
                                         1
                             END
                                    ) AS total_dias
                            FROM
                                    central.ctrl_incidencias ci
                            INNER JOIN
                                    central.cat_periodo p
                            ON ci.fecha_inicio BETWEEN p.fecha_inicio AND p.fecha_fin
                            WHERE
                                p.id_cat_periodo = $idPeriodo
                            AND ci.id_tbl_empleados_hraes = $idEmployee
                            AND ci.id_cat_incidencias IN (7,14,15);");
        return $query;
    }

    public function getMoreDaysForP(){
        $query = pg_query ("SELECT 
                                central.cat_asistencia_config.dias_x_periodo
                            FROM central.cat_asistencia_config
                            WHERE central.cat_asistencia_config.id_cat_asistencia_config = 1 -- IS THE DATA FIRST
                            LIMIT 1;");
        return $query;
    }
}
    