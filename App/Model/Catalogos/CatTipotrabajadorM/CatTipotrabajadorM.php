<?php
class CatTipotrabajadorM
{
    public function listarByAllGeneral()
    {
        $listado = pg_query("SELECT DISTINCT(descripcion),descripcion, 
                                   id_cat_tipo_trabajador
                             FROM central.cat_tipo_trabajador
                             ORDER BY descripcion ASC");
        return $listado;
    }

    public function listarByIdGeneral($id){
        $listado = pg_query("SELECT id_cat_tipo_trabajador,descripcion
                            FROM central.cat_tipo_trabajador
                            WHERE id_cat_tipo_trabajador = $id
                            ORDER BY descripcion ASC");
        return $listado;
    }

    public function obtenerByAllEspecifico($idObject)
    {
        $listado = pg_query("SELECT CONCAT(id_cat_tipo_trabajador, ' - ', descripcion),id_cat_tipo_trabajador
                             FROM central.cat_tipo_trabajador
                             WHERE id_cat_tipo_trabajador = $idObject;");
        return $listado;
    }

    public function obtenerByIdEspecifico($id){
            $listado = pg_query("SELECT CONCAT(id_cat_tipo_trabajador, ' - ', descripcion),id_cat_tipo_trabajador
                             FROM central.cat_tipo_trabajador
                             WHERE id_cat_tipo_trabajador = $id;");
        return $listado;
    }

    public function listadoIdMovimiento($id){
            $listado = pg_query("SELECT DISTINCT(id_cat_tipo_trabajador)
                             FROM central.cat_tipo_trabajador
                             WHERE id_cat_tipo_trabajador =  $id;;");
        return $listado;
    }
}
