<?php
class CatPeriodoMM
{
    public function getPeriodo($date){
        $query = pg_query ("SELECT 
                                *
                            FROM public.cat_periodo
                            WHERE id_cat_periodo = 1");
        $query;
    }
}
