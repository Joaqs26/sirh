<?php

class ModelRetardoM
{
    function listarById($id_object, $paginator)
    {
        $listado = pg_query("SELECT 
                                public.ctrl_retardo.id_ctrl_retardo,
                                TO_CHAR(public.ctrl_retardo.fecha, 'DD/MM/YYYY'),
                                TO_CHAR(public.ctrl_retardo.hora, 'HH24:MI'),
                                UPPER(public.cat_retardo_tipo.descripcion),
                                UPPER(public.cat_retardo_estatus.descripcion),
                                UPPER(public.ctrl_retardo.observaciones),
                                public.ctrl_retardo.id_user
                            FROM public.ctrl_retardo
                            INNER JOIN public.cat_retardo_tipo
                                ON public.ctrl_retardo.id_cat_retardo_tipo =
                                    public.cat_retardo_tipo.id_cat_retardo_tipo
                            INNER JOIN public.cat_retardo_estatus
                                ON public.ctrl_retardo.id_cat_retardo_estatus =
                                    public.cat_retardo_estatus.id_cat_retardo_estatus
                            WHERE public.ctrl_retardo.id_tbl_empleados_hraes = $id_object
                            ORDER BY public.ctrl_retardo.fecha DESC
                             LIMIT 3 OFFSET $paginator;");
        return $listado;
    }

    function listarEditById($id_object)
    {
        $listado = pg_query("SELECT *
                            FROM public.ctrl_retardo
                            WHERE id_ctrl_retardo = $id_object
                            ORDER BY id_ctrl_retardo DESC
                            LIMIT 1;");
        return $listado;
    }

    function listarByNull()
    {
        return $raw = [
            'id_ctrl_retardo' => null,
            'fecha' => null,
            'hora' => null,
            'observaciones' => null,
            'id_cat_retardo_tipo' => null,
            'id_cat_retardo_estatus' => null,
            'id_tbl_empleados_hraes' => null,
            'id_user' => null,
            'id_cat_quincenas' => null
        ];
    }

    function listarByBusqueda($id_object, $busqueda, $paginator)
    {
        $listado = pg_query("SELECT 
    public.ctrl_retardo.id_ctrl_retardo,
    TO_CHAR(public.ctrl_retardo.fecha, 'DD/MM/YYYY') AS fecha,
    TO_CHAR(public.ctrl_retardo.hora, 'HH24:MI') AS hora,
    UPPER(public.cat_retardo_tipo.descripcion) AS tipo_descripcion,
    UPPER(public.cat_retardo_estatus.descripcion) AS estatus_descripcion,
    UPPER(public.ctrl_retardo.observaciones) AS observaciones,
    public.ctrl_retardo.id_user
FROM public.ctrl_retardo
INNER JOIN public.cat_retardo_tipo
    ON public.ctrl_retardo.id_cat_retardo_tipo = public.cat_retardo_tipo.id_cat_retardo_tipo
INNER JOIN public.cat_retardo_estatus
    ON public.ctrl_retardo.id_cat_retardo_estatus = public.cat_retardo_estatus.id_cat_retardo_estatus
WHERE public.ctrl_retardo.id_tbl_empleados_hraes = $id_object
AND (
    CONCAT(
        TO_CHAR(public.ctrl_retardo.fecha, 'DD/MM/YYYY'), ' ',
        TO_CHAR(public.ctrl_retardo.hora, 'HH24:MI'), ' ',
        UPPER(public.cat_retardo_tipo.descripcion), ' ',
        UPPER(public.cat_retardo_estatus.descripcion), ' ',
        UPPER(public.ctrl_retardo.observaciones)
    ) LIKE '%' || '$busqueda' || '%'
)
ORDER BY public.ctrl_retardo.fecha DESC
                             LIMIT 3 OFFSET $paginator;");
        return $listado;
    }

    function editarByArray($conexion, $datos, $condicion)
    {
        $pg_update = pg_update($conexion, 'public.ctrl_retardo', $datos, $condicion);
        return $pg_update;
    }

    function agregarByArray($conexion, $datos)
    {
        $pg_add = pg_insert($conexion, 'public.ctrl_retardo', $datos);
        return $pg_add;
    }

    function eliminarByArray($conexion, $condicion)
    {
        $pgs_delete = pg_delete($conexion, 'public.ctrl_retardo', $condicion);
        return $pgs_delete;
    }

    public function actualizarRetardos()
    {
        $query = pg_query("INSERT INTO public.ctrl_retardo (
                                        fecha, 
                                        hora, 
                                        Observaciones, 
                                        id_cat_retardo_tipo, 
                                        id_cat_retardo_estatus, 
                                        id_tbl_empleados_hraes, 
                                        id_user, 
                                        id_cat_quincenas
                                    )
                                    SELECT 
                                        entrada.fecha, 
                                        entrada.hora, 
                                        NULL AS Observaciones, 
                                        1 AS id_cat_retardo_tipo, 
                                        5 AS id_cat_retardo_estatus,  -- Tipo-Entrada | Estatus-Congelada
                                        entrada.id_empleado, 
                                        NULL AS id_user, 
                                        public.cat_quincenas.id_cat_quincenas AS id_quincena
                                    FROM 
                                        (
                                            SELECT 
                                                MIN(public.ctrl_asistencia.hora) AS hora,  -- Trae el primer registro por Fecha y Empleado
                                                public.ctrl_asistencia.fecha AS fecha, 
                                                public.ctrl_asistencia.id_tbl_empleados_hraes AS id_empleado
                                            FROM public.ctrl_asistencia
                                            GROUP BY 
                                                public.ctrl_asistencia.fecha, 
                                                public.ctrl_asistencia.id_tbl_empleados_hraes
                                        ) AS entrada
                                    INNER JOIN public.cat_quincenas 
                                        ON entrada.fecha BETWEEN public.cat_quincenas.fecha_inicio AND public.cat_quincenas.fecha_fin
                                    LEFT JOIN public.ctrl_retardo AS existente
                                        ON entrada.fecha = existente.fecha 
                                        AND entrada.hora = existente.hora
                                        AND entrada.id_empleado = existente.id_tbl_empleados_hraes
                                    WHERE 
                                        entrada.hora >= '09:16:00'  -- Para el horario establecido como Falta
                                        AND entrada.hora <= '09:30:59'
                                        AND existente.id_tbl_empleados_hraes IS NULL  -- Filtra para excluir registros ya existentes
                                    ORDER BY 
                                        entrada.fecha, 
                                        entrada.hora;");
        return $query;
    }

    public function listadoAllFaltas($paginator)
    {
        $query = ("SELECT
                    CONCAT(UPPER(public.tbl_empleados_hraes.nombre), ' ',
                        UPPER(public.tbl_empleados_hraes.primer_apellido), ' ',
                        UPPER(public.tbl_empleados_hraes.segundo_apellido)),
                    UPPER(public.tbl_empleados_hraes.rfc),
                    TO_CHAR(public.ctrl_retardo.fecha, 'DD-MM-YYYY'),
                    TO_CHAR(public.ctrl_retardo.hora, 'HH24:MI'),
                    UPPER(public.ctrl_retardo.observaciones),
                    UPPER(public.cat_retardo_tipo.descripcion),
                    UPPER(public.cat_retardo_estatus.descripcion),
                    public.ctrl_retardo.id_user
                FROM public.ctrl_retardo
                INNER JOIN public.cat_retardo_tipo
                    ON public.ctrl_retardo.id_cat_retardo_tipo = 
                        public.cat_retardo_tipo.id_cat_retardo_tipo
                INNER JOIN public.cat_retardo_estatus
                    ON public.ctrl_retardo.id_cat_retardo_estatus =
                        public.cat_retardo_estatus.id_cat_retardo_estatus
                INNER JOIN public.tbl_empleados_hraes
                    ON public.ctrl_retardo.id_tbl_empleados_hraes =
                        public.tbl_empleados_hraes.id_tbl_empleados_hraes 
                ORDER BY public.ctrl_retardo.fecha DESC
                LIMIT 5 OFFSET $paginator;");
        return $query;
    }

    public function listadoAllFaltasBusqueda($busqueda, $paginador)
    {
        $query = ("SELECT
                    CONCAT(UPPER(public.tbl_empleados_hraes.nombre), ' ',
                        UPPER(public.tbl_empleados_hraes.primer_apellido), ' ',
                        UPPER(public.tbl_empleados_hraes.segundo_apellido)),
                    UPPER(public.tbl_empleados_hraes.rfc),
                    TO_CHAR(public.ctrl_retardo.fecha, 'DD-MM-YYYY'),
                    TO_CHAR(public.ctrl_retardo.hora, 'HH24:MI'),
                    UPPER(public.ctrl_retardo.observaciones),
                    UPPER(public.cat_retardo_tipo.descripcion),
                    UPPER(public.cat_retardo_estatus.descripcion),
                    public.ctrl_retardo.id_user
                FROM public.ctrl_retardo
                INNER JOIN public.cat_retardo_tipo
                    ON public.ctrl_retardo.id_cat_retardo_tipo = 
                        public.cat_retardo_tipo.id_cat_retardo_tipo
                INNER JOIN public.cat_retardo_estatus
                    ON public.ctrl_retardo.id_cat_retardo_estatus =
                        public.cat_retardo_estatus.id_cat_retardo_estatus
                INNER JOIN public.tbl_empleados_hraes
                    ON public.ctrl_retardo.id_tbl_empleados_hraes =
                        public.tbl_empleados_hraes.id_tbl_empleados_hraes 
                WHERE (
                        CONCAT(UPPER(public.tbl_empleados_hraes.nombre), ' ',
                            UPPER(public.tbl_empleados_hraes.primer_apellido), ' ',
                            UPPER(public.tbl_empleados_hraes.segundo_apellido)) LIKE '%$busqueda%'
                        OR UPPER(public.tbl_empleados_hraes.rfc)::TEXT  LIKE '%$busqueda%'
                        OR TO_CHAR(public.ctrl_retardo.fecha, 'DD-MM-YYYY')::TEXT  LIKE '%$busqueda%'
                        OR TO_CHAR(public.ctrl_retardo.hora, 'HH24:MI')::TEXT  LIKE '%$busqueda%'
                        OR UPPER(public.ctrl_retardo.observaciones)::TEXT  LIKE '%$busqueda%'
                        OR UPPER(public.cat_retardo_tipo.descripcion)::TEXT  LIKE '%$busqueda%'
                        OR UPPER(public.cat_retardo_estatus.descripcion)::TEXT  LIKE '%$busqueda%'
                    )
                ORDER BY public.ctrl_retardo.fecha DESC
                LIMIT 5 OFFSET $paginador;");
        return $query;
    }
}
