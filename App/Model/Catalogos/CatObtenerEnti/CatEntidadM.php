    <?php
    class ObtenerEntidadM

    {
        
        public function selectByEditv3($claveEntidad)
    {
        // Usar una consulta preparada para evitar SQL Injection
        $query = "SELECT entidad FROM public.cat_entidad WHERE clave_curp = $1 LIMIT 1;";
        $result = pg_query_params($GLOBALS['conexion'], $query, [$claveEntidad]); // Usar la conexión de librerías.php

        return $result;
    }

        
    }
