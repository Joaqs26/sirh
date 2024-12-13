<?php

class ContratacionM
{
    public function listarByAllPrograma()
    {
        $query = pg_query("SELECT 
                                public.cat_tipo_programa.id_cat_tipo_programa,
                                public.cat_tipo_programa.descripcion
                            FROM public.cat_tipo_programa
                            ORDER BY public.cat_tipo_programa.descripcion ASC;");
        return $query;
    }

    public function listarByEditPrograma($id)
    {
        $query = pg_query("SELECT 
                                public.cat_tipo_programa.id_cat_tipo_programa,
                                public.cat_tipo_programa.descripcion
                            FROM public.cat_tipo_programa
                            WHERE public.cat_tipo_programa.id_cat_tipo_programa = $id;");
        return $query;
    }

    public function listarByAllTrabajador()
    {
        $query = pg_query("SELECT 
                                public.cat_tipo_trabajador.id_cat_tipo_trabajador,
                                UPPER(public.cat_tipo_trabajador.descripcion)
                            FROM public.cat_tipo_trabajador
                            ORDER BY public.cat_tipo_trabajador.descripcion ASC;");
        return $query;
    }

    public function listarByAEditTrabajador($id)
    {
        $query = pg_query("SELECT 
                                public.cat_tipo_trabajador.id_cat_tipo_trabajador,
                                UPPER(public.cat_tipo_trabajador.descripcion)
                            FROM public.cat_tipo_trabajador
                            WHERE public.cat_tipo_trabajador.id_cat_tipo_trabajador = $id;");
        return $query;
    }

    public function listarByAllContratacion($id_cat_tipo_trabajador)
    {
        $query = pg_query("SELECT 
                                public.cat_tipo_contratacion.id_cat_tipo_contratacion,
                                UPPER(public.cat_tipo_contratacion.descripcion)
                            FROM public.cat_tipo_contratacion
                            INNER JOIN public.cat_trabajador_contratacion
                                ON public.cat_tipo_contratacion.id_cat_tipo_contratacion =
                                    public.cat_trabajador_contratacion.id_cat_tipo_contratacion
                            WHERE public.cat_trabajador_contratacion.id_cat_tipo_trabajador = $id_cat_tipo_trabajador;");
        return $query;
    }

    public function listarByEditContratacion($id)
    {
        $query = pg_query("SELECT
                                public.cat_tipo_contratacion.id_cat_tipo_contratacion,
                                UPPER(public.cat_tipo_contratacion.descripcion)
                            FROM public.cat_tipo_contratacion 
                            WHERE public.cat_tipo_contratacion.id_cat_tipo_contratacion = $id;");
        return $query;
    }

    public function listarCatCaracter()
    {
        $query = pg_query("SELECT 
                                public.cat_caracter_nombramiento.id_cat_caracter_nombramiento,
                                public.cat_caracter_nombramiento.nombre
                            FROM public.cat_caracter_nombramiento
                            ORDER BY public.cat_caracter_nombramiento.nombre ASC;");
        return $query;
    }

    public function editCatCaracter($id)
    {
        $query = pg_query("SELECT 
                                public.cat_caracter_nombramiento.id_cat_caracter_nombramiento,
                                public.cat_caracter_nombramiento.nombre
                            FROM public.cat_caracter_nombramiento
                            WHERE public.cat_caracter_nombramiento.id_cat_caracter_nombramiento = $id;");
        return $query;
    }
}