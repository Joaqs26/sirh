<?php
class ModelMovimientosM
{
    public function listarByIdEmpleado($idEmpleado, $paginator)
    {
        $listado = pg_query("SELECT tbl_plazas_empleados_hraes.id_tbl_plazas_empleados_hraes, 
                                    tbl_plazas_empleados_hraes.fecha_inicio, 
                                    tbl_plazas_empleados_hraes.fecha_movimiento,
                                    tbl_plazas_empleados_hraes.id_tbl_movimientos, 
                                    tbl_plazas_empleados_hraes.fecha_movimiento, 
                                    tbl_plazas_empleados_hraes.id_tbl_empleados_hraes,
                                    CONCAT(tbl_movimientos.codigo,' - ',tbl_movimientos.nombre_movimiento),
                                    tbl_movimientos.tipo_movimiento,
                                    tbl_control_plazas_hraes.num_plaza
                            FROM public.tbl_plazas_empleados_hraes
                            INNER JOIN tbl_movimientos
                            ON public.tbl_plazas_empleados_hraes.id_tbl_movimientos = 
                                tbl_movimientos.id_tbl_movimientos
                            INNER JOIN public.tbl_control_plazas_hraes  
                            ON public.tbl_plazas_empleados_hraes.id_tbl_control_plazas_hraes =
                                public.tbl_control_plazas_hraes.id_tbl_control_plazas_hraes
                            WHERE public.tbl_plazas_empleados_hraes.id_tbl_empleados_hraes = $idEmpleado
                            ORDER BY tbl_plazas_empleados_hraes.id_tbl_plazas_empleados_hraes DESC
                            LIMIT 3 OFFSET $paginator;");

        return $listado;
    }

    public function listarByBusqueda($idEmpleado, $paginator, $busqueda)
    {
        $listado = pg_query("SELECT tbl_plazas_empleados_hraes.id_tbl_plazas_empleados_hraes, 
                                    tbl_plazas_empleados_hraes.fecha_inicio, 
                                    tbl_plazas_empleados_hraes.fecha_movimiento,
                                    tbl_plazas_empleados_hraes.id_tbl_movimientos, 
                                    tbl_plazas_empleados_hraes.fecha_movimiento, 
                                    tbl_plazas_empleados_hraes.id_tbl_empleados_hraes,
                                    CONCAT(tbl_movimientos.codigo,' - ',tbl_movimientos.nombre_movimiento),
                                    tbl_movimientos.tipo_movimiento,
                                    tbl_control_plazas_hraes.num_plaza
                            FROM public.tbl_plazas_empleados_hraes
                            INNER JOIN tbl_movimientos
                            ON tbl_plazas_empleados_hraes.id_tbl_movimientos = 
                                tbl_movimientos.id_tbl_movimientos
                            INNER JOIN public.tbl_control_plazas_hraes
                            ON public.tbl_plazas_empleados_hraes.id_tbl_control_plazas_hraes =
                                public.tbl_control_plazas_hraes.id_tbl_control_plazas_hraes
                            WHERE public.tbl_plazas_empleados_hraes.id_tbl_empleados_hraes = $idEmpleado
                            AND (TRIM(UPPER(UNACCENT(tbl_plazas_empleados_hraes.fecha_movimiento::TEXT))) 
                                    LIKE '%$busqueda%' OR
                                    TRIM(UPPER(UNACCENT(tbl_movimientos.nombre_movimiento::TEXT)))
                                    LIKE '%$busqueda%' OR
                                public.tbl_control_plazas_hraes.num_plaza LIKE '%$busqueda%'
                            )
                            ORDER BY tbl_plazas_empleados_hraes.id_tbl_plazas_empleados_hraes DESC
                            LIMIT 3 OFFSET $paginator;");
        return $listado;
    }

    public function listarByEdit($idMovimiento)
    {
        $listado = pg_query("SELECT id_tbl_plazas_empleados_hraes,fecha_inicio,
                                    fecha_termino,id_tbl_movimientos,fecha_movimiento,
                                    id_tbl_control_plazas_hraes,id_tbl_empleados_hraes,
                                    observaciones, motivo_estatus
                             FROM public.tbl_plazas_empleados_hraes
                             WHERE id_tbl_plazas_empleados_hraes = $idMovimiento;");
        return $listado;
    }

    public function listarByNull()
    {
        return $array = [
            'id_tbl_plazas_empleados_hraes' => null,
            'fecha_inicio' => null,
            'fecha_termino' => null,
            'id_tbl_movimientos' => null,
            'fecha_movimiento' => null,
            'id_tbl_control_plazas_hraes' => null,
            'id_tbl_empleados_hraes' => null,
            'motivo_estatus' => null,
            'observaciones' => null,
        ];
    }




    public function listarCountPlaza($id)
    {
        $listado = pg_query("SELECT COUNT(tbl_plazas_empleados_hraes)
                             FROM public.tbl_plazas_empleados_hraes
                             WHERE id_tbl_control_plazas_hraes = $id");
        return $listado;
    }




    public function listadoByIdPlaza($idEmpleado)
    {
        $listado = pg_query("SELECT id_tbl_control_plazas_hraes
                             FROM public.tbl_plazas_empleados_hraes
                             WHERE id_tbl_empleados_hraes = $idEmpleado
                             ORDER BY fecha_movimiento DESC
                             LIMIT 1");
        return $listado;
    }

    function agregarByArray($conexion, $datos, $name)
    {
        // Obtener las columnas válidas de la tabla
        $columnasTabla = pg_meta_data($conexion, $name);
    
        // Filtrar los datos para que solo incluyan columnas válidas
        $datosFiltrados = array_intersect_key($datos, $columnasTabla);
    
        // Realizar la inserción con los datos filtrados
        $pg_add = pg_insert($conexion, $name, $datosFiltrados);
    
        return $pg_add;
    }
    

    function eliminarByArray($conexion, $condicion, $name)
    {
        $pgs_delete = pg_delete($conexion, $name, $condicion);
        return $pgs_delete;
    }

    public function ultimoMovimientoByVal($idPlaza)
    {
        $listado = pg_query("SELECT tbl_movimientos.id_tipo_movimiento,
                                    tbl_plazas_empleados_hraes.id_tbl_control_plazas_hraes
                            FROM public.tbl_plazas_empleados_hraes
                            INNER JOIN tbl_movimientos
                                ON public.tbl_plazas_empleados_hraes.id_tbl_movimientos =
                                    tbl_movimientos.id_tbl_movimientos
                            WHERE id_tbl_empleados_hraes = (
                                SELECT id_tbl_empleados_hraes
                                FROM public.tbl_plazas_empleados_hraes
                                WHERE id_tbl_control_plazas_hraes = $idPlaza 
                                ORDER BY id_tbl_plazas_empleados_hraes DESC
                                LIMIT 1)
                            ORDER BY id_tbl_plazas_empleados_hraes DESC
                            LIMIT 1");
        return $listado;
    }

    public function countPlazasById($idPlaza)
    {
        $listado = pg_query("SELECT COUNT (id_tbl_plazas_empleados_hraes)
                             FROM public.tbl_plazas_empleados_hraes
                             WHERE id_tbl_control_plazas_hraes = $idPlaza;");
        return $listado;
    }


    ///LA FUNCION PERMITE SABER SI EXISTE INFORMACION EN LA BASE DEL EMPLEADO
    public function countUltimoMovimiento($idEmpleado)
    {
        $listado = pg_query("SELECT COUNT(id_tbl_plazas_empleados_hraes)
                                 FROM public.tbl_plazas_empleados_hraes 
                                 WHERE id_tbl_empleados_hraes = $idEmpleado");
        return $listado;
    }

    ///LA FUNCION TRAE EL ULTIMO MOVIMIENTO (ALTA, BAJA, MOVIMIENTO DEL EMPLEADO)
    public function listadoUltimoMovimiento($idEmpleado)
    {
        $listado = pg_query("SELECT tbl_movimientos.id_tipo_movimiento,
                                        tbl_plazas_empleados_hraes.fecha_movimiento
                                 FROM public.tbl_plazas_empleados_hraes 
                                 INNER JOIN tbl_movimientos
                                 ON public.tbl_plazas_empleados_hraes.id_tbl_movimientos =
                                    tbl_movimientos.id_tbl_movimientos
                                 WHERE public.tbl_plazas_empleados_hraes.id_tbl_empleados_hraes = $idEmpleado
                                 GROUP BY public.tbl_plazas_empleados_hraes.fecha_movimiento,
                                        tbl_movimientos.id_tipo_movimiento
                                 ORDER BY public.tbl_plazas_empleados_hraes.fecha_movimiento DESC
                                 LIMIT 1;");
        return $listado;
    }

    public function idPlazaMovimiento($idEmpleado)
    {
        $listado = pg_query("SELECT id_tbl_control_plazas_hraes
                                 FROM public.tbl_plazas_empleados_hraes
                                 WHERE id_tbl_empleados_hraes = $idEmpleado
                                 ORDER BY id_tbl_plazas_empleados_hraes DESC
                                 LIMIT 1;");
        return $listado;
    }

    //La funcion retorna el id de la plaza a la que esta actualmente asociado
    public function getMaxIdPlaza($schema, $idEmpleado){
        $isQuery = pg_query("SELECT 
                                $schema.tbl_plazas_empleados_hraes.id_tbl_control_plazas_hraes
                            FROM $schema.tbl_plazas_empleados_hraes
                            INNER JOIN public.tbl_movimientos
                                ON public.tbl_movimientos.id_tbl_movimientos = 
                                    $schema.tbl_plazas_empleados_hraes.id_tbl_movimientos
                            WHERE $schema.tbl_plazas_empleados_hraes.fecha_movimiento = (
                                                        SELECT MAX($schema.tbl_plazas_empleados_hraes.fecha_movimiento) 
                                                        FROM $schema.tbl_plazas_empleados_hraes
                                                        WHERE $schema.tbl_plazas_empleados_hraes.id_tbl_empleados_hraes = $idEmpleado)
                            AND $schema.tbl_plazas_empleados_hraes.id_tbl_empleados_hraes = $idEmpleado
                            AND public.tbl_movimientos.id_tipo_movimiento <> 3; --> ES DISNTO DE BAJA");
        return $isQuery;
    }
}