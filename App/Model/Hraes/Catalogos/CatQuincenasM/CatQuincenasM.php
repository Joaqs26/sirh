<?php

class CatQuincenasM
{
    public function getInfoQuincena($date){
        $query = pg_query("SELECT 
                                central.cat_quincenas.id_cat_quincenas,
                                CONCAT(central.cat_quincenas.no_quincena, ' - ', central.cat_quincenas.nombre),
                                CONCAT(TO_CHAR(central.cat_quincenas.fecha_inicio, 'DD/MM/YY'), ' - ',
                                        TO_CHAR(central.cat_quincenas.fecha_fin, 'DD/MM/YY'))
                            FROM central.cat_quincenas
                            WHERE '$date' 
                            BETWEEN central.cat_quincenas.fecha_inicio AND
                                    central.cat_quincenas.fecha_fin");
        return $query;
    }

}
