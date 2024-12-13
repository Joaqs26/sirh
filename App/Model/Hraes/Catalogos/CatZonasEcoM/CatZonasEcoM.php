<?php

class CatZonasEconomicas
{
    public function selectByAll()
    {
        $query = pg_query("SELECT 
                                public.cat_zona_economica.id_cat_zona_economica,
                                public.cat_zona_economica.clave
                            FROM public.cat_zona_economica
                            ORDER BY public.cat_zona_economica.clave ASC;");
        return $query;
    }

    public function selectByEdit($id)
    {
        $query = pg_query("SELECT 
                                public.cat_zona_economica.id_cat_zona_economica,
                                public.cat_zona_economica.clave
                            FROM public.cat_zona_economica
                            WHERE public.cat_zona_economica.id_cat_zona_economica = $id;");
        return $query;
    }

}