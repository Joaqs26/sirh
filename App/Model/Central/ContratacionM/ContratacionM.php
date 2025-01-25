<?php

class ContratacionM
{
    public function listarByAllPrograma()
    {
        $query = pg_query("SELECT 
                                central.cat_tipo_programa.id_cat_tipo_programa,
                                central.cat_tipo_programa.descripcion
                            FROM central.cat_tipo_programa
                            ORDER BY central.cat_tipo_programa.descripcion ASC;");
        return $query;
    }

    public function listarByEditPrograma($id)
    {
        $query = pg_query("SELECT 
                                central.cat_tipo_programa.id_cat_tipo_programa,
                                central.cat_tipo_programa.descripcion
                            FROM central.cat_tipo_programa
                            WHERE central.cat_tipo_programa.id_cat_tipo_programa = $id;");
        return $query;
    }

    public function listarByAllTrabajador()
    {
        $query = pg_query("SELECT 
                                central.cat_tipo_trabajador.id_cat_tipo_trabajador,
                                UPPER(central.cat_tipo_trabajador.descripcion)
                            FROM central.cat_tipo_trabajador
                            ORDER BY central.cat_tipo_trabajador.descripcion ASC;");
        return $query;
    }

    public function listarByAEditTrabajador($id)
    {
        $query = pg_query("SELECT 
                                central.cat_tipo_trabajador.id_cat_tipo_trabajador,
                                UPPER(central.cat_tipo_trabajador.descripcion)
                            FROM central.cat_tipo_trabajador
                            WHERE central.cat_tipo_trabajador.id_cat_tipo_trabajador = $id;");
        return $query;
    }

    public function listarByAllContratacion($id_cat_tipo_trabajador)
    {
        $query = pg_query("SELECT 
                                central.cat_tipo_contratacion.id_cat_tipo_contratacion,
                                UPPER(central.cat_tipo_contratacion.descripcion)
                            FROM central.cat_tipo_contratacion
                            INNER JOIN central.cat_trabajador_contratacion
                                ON central.cat_tipo_contratacion.id_cat_tipo_contratacion =
                                    central.cat_trabajador_contratacion.id_cat_tipo_contratacion
                            WHERE central.cat_trabajador_contratacion.id_cat_tipo_trabajador = $id_cat_tipo_trabajador;");
        return $query;
    }

    public function listarByEditContratacion($id)
    {
        $query = pg_query("SELECT
                                central.cat_tipo_contratacion.id_cat_tipo_contratacion,
                                UPPER(central.cat_tipo_contratacion.descripcion)
                            FROM central.cat_tipo_contratacion 
                            WHERE central.cat_tipo_contratacion.id_cat_tipo_contratacion = $id;");
        return $query;
    }

    public function listarCatCaracter()
    {
        $query = pg_query("SELECT 
                                central.cat_caracter_nombramiento.id_cat_caracter_nombramiento,
                                central.cat_caracter_nombramiento.nombre
                            FROM central.cat_caracter_nombramiento
                            ORDER BY central.cat_caracter_nombramiento.nombre ASC;");
        return $query;
    }

    public function editCatCaracter($id)
    {
        $query = pg_query("SELECT 
                                central.cat_caracter_nombramiento.id_cat_caracter_nombramiento,
                                central.cat_caracter_nombramiento.nombre
                            FROM central.cat_caracter_nombramiento
                            WHERE central.cat_caracter_nombramiento.id_cat_caracter_nombramiento = $id;");
        return $query;
    }

    public function  Contratacionlist () {
        $query = pg_query("SELECT   
                                central.cat_tipo_contratacion.id_cat_tipo_contratacion,
                                UPPER(central.cat_tipo_contratacion.descripcion)
                            FROM central.cat_tipo_contratacion;");
        return $query;
    }

}

