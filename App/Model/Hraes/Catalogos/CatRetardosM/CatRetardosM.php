<?php

class CatRetardosM
{
    public function listadoRetardoTipo(){
        $query = pg_query("SELECT 
                                public.cat_retardo_tipo.id_cat_retardo_tipo,
                                UPPER(public.cat_retardo_tipo.descripcion)
                            FROM public.cat_retardo_tipo
                            ORDER BY public.cat_retardo_tipo.descripcion ASC;");
        return $query;
    }

    public function editRetardoTipo($id){
        $query = pg_query("SELECT 
                                public.cat_retardo_tipo.id_cat_retardo_tipo,
                                UPPER(public.cat_retardo_tipo.descripcion)
                            FROM public.cat_retardo_tipo
                            WHERE public.cat_retardo_tipo.id_cat_retardo_tipo = $id;");
        return $query;
    }

    public function listadoRetardoEstatus(){
        $query = pg_query("SELECT 
                                public.cat_retardo_estatus.id_cat_retardo_estatus,
                                UPPER(public.cat_retardo_estatus.descripcion)
                            FROM public.cat_retardo_estatus
                            WHERE public.cat_retardo_estatus.id_cat_retardo_estatus <> 4 -- EL ID = 4, SOLO SE OCUPA PARA FALTAS
                            ORDER BY public.cat_retardo_estatus.descripcion ASC;");
        return $query;
    }

    public function editRetardoEstatus($id){
        $query = pg_query("SELECT 
                                public.cat_retardo_estatus.id_cat_retardo_estatus,
                                UPPER(public.cat_retardo_estatus.descripcion)
                            FROM public.cat_retardo_estatus
                            WHERE public.cat_retardo_estatus.id_cat_retardo_estatus <> 4 -- EL ID = 4, SOLO SE OCUPA PARA FALTAS
                            AND public.cat_retardo_estatus.id_cat_retardo_estatus = $id");
        return $query;
    }
}
