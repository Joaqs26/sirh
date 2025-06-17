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


    ///GET PERIODO 
    public function getPeriodo($date){
                $query = pg_query ("SELECT 
                                        (central.cat_periodo.descripcion),
                                        fecha_inicio,
                                        fecha_fin
                                    FROM central.cat_periodo
                            WHERE '$date' BETWEEN fecha_inicio AND fecha_fin;");
        return $query;
    }

    public function getAllDays($fechaInicio, $fechaFin, $idEmployee){
        $query = pg_query ("SELECT
                                SUM(
                                    CASE
                                        WHEN fecha_fin IS NOT NULL THEN
                                            (fecha_fin - fecha_inicio)::int + 1 -- ES EL DIA DE AGREGAR UNO
                                        ELSE
                                            1
                                    END
                                ) AS total_dias
                            FROM
                                central.ctrl_incidencias
                            WHERE 
                                id_tbl_empleados_hraes = $idEmployee
                            AND id_cat_incidencias IN (7,14,15) -- REPRESENTA QUE SOLO CUENTE LOS DIAS DE VACACIONES
                            AND fecha_inicio BETWEEN '$fechaInicio' AND '$fechaFin';");
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
