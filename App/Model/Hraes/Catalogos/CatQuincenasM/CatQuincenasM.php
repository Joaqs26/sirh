<?php

class CatQuincenasM
{
    public function getInfoQuincena($date){
        $query = pg_query("SELECT 
                                public.cat_quincenas.id_cat_quincenas,
                                CONCAT(public.cat_quincenas.no_quincena, ' - ', public.cat_quincenas.nombre),
                                CONCAT(TO_CHAR(public.cat_quincenas.fecha_inicio, 'DD/MM/YY'), ' - ',
                                        TO_CHAR(public.cat_quincenas.fecha_fin, 'DD/MM/YY'))
                            FROM public.cat_quincenas
                            WHERE '$date' 
                            BETWEEN public.cat_quincenas.fecha_inicio AND
                                    public.cat_quincenas.fecha_fin");
        return $query;
    }

}
