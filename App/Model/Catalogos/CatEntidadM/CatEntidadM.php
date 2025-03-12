    <?php
    class catalogoEntidad
    {
        public function listarByAll()
        {
            $listado = pg_query("SELECT id_cat_entidad, clave_entidad, entidad
                                FROM cat_entidad
                                ORDER BY entidad ASC");
            return $listado;
        }

        public function obtenerElemetoById($idObject)
        {
            $listado = pg_query("SELECT id_cat_entidad, CONCAT(clave_entidad, ' - ', entidad)
                                FROM cat_entidad
                                WHERE id_cat_entidad = $idObject");
            return $listado;
        }

        public function idEntidadText($text)
        {
            $listado = pg_query("SELECT id_cat_entidad
                                FROM cat_entidad
                                WHERE TRIM(UPPER(UNACCENT(entidad)))
                                    LIKE TRIM(UPPER(UNACCENT('%$text%')));");
            return $listado;
        }

        public function selectByAllv2()
        {
            $query = pg_query("SELECT 
                                    public.cat_entidad.id_cat_entidad,
                                    UPPER(public.cat_entidad.entidad)
                                FROM public.cat_entidad
                                ORDER BY public.cat_entidad.entidad ASC;");
            return $query;
        }

        public function selectByEditv2($id)
        {
            $query = pg_query("SELECT 
                                    public.cat_entidad.id_cat_entidad,
                                    UPPER(public.cat_entidad.entidad)
                                FROM public.cat_entidad
                                WHERE public.cat_entidad.id_cat_entidad = $id;");
            return $query;
        }
        
        public function selectByEditv3($claveEntidad)
    {
    $query = pg_query( "SELECT entidad FROM public.cat_entidad WHERE clave_curp = $claveEntidad; LIMIT 1");

    return $query;
}
    
}       
        
