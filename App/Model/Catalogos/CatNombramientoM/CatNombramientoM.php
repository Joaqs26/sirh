<?php
class CatNombramientoM
{
    public function listarByAll()
    {
        $listado = pg_query("SELECT id_cat_caracter_nombramiento, nombre
               FROM central.cat_caracter_nombramiento 
                             ORDER BY nombre ASC");
        return $listado;
    }

    public function listarByIdEdit($id_object)
    {
        $listado = pg_query("SELECT id_cat_caracter_nombramiento, nombre
                             FROM central.cat_caracter_nombramiento
                             WHERE id_cat_caracter_nombramiento = '$id_object'");                     
                             
                             
                             
                             
                            
        return $listado;
    }
}
