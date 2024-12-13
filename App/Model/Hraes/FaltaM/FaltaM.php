<?php

class FaltaModelM
{
    function listarById($id_object, $paginator)
    {
        $listado = pg_query("SELECT
                                    public.ctrl_faltas.id_ctrl_faltas,
                                    CASE 
                                        WHEN es_por_retardo THEN 'FALTA POR RETARDO'
                                        ELSE 'FALTA'
                                    END,
                                    TO_CHAR(public.ctrl_faltas.fecha_desde, 'DD/MM/YYYY'),
                                    TO_CHAR(public.ctrl_faltas.fecha_hasta, 'DD/MM/YYYY'),
                                    TO_CHAR(public.ctrl_faltas.fecha_registro, 'DD/MM/YYYY'),
                                    TO_CHAR(public.ctrl_faltas.fecha, 'DD/MM/YYYY'),
                                    TO_CHAR(public.ctrl_faltas.hora, 'HH:MM'),
                                    UPPER(public.ctrl_faltas.codigo_certificacion),
                                    UPPER(public.cat_retardo_estatus.descripcion),
                                    UPPER(public.cat_retardo_tipo.descripcion),
                                    UPPER(public.ctrl_faltas.observaciones),
                                    public.ctrl_faltas.id_user
                                FROM public.ctrl_faltas
                                LEFT JOIN public.cat_retardo_estatus
                                    ON public.ctrl_faltas.id_cat_retardo_estatus =
                                        public.cat_retardo_estatus.id_cat_retardo_estatus
                                LEFT JOIN public.cat_retardo_tipo
                                    ON public.ctrl_faltas.id_cat_retardo_tipo =
                                        public.cat_retardo_tipo.id_cat_retardo_tipo
                                WHERE public.ctrl_faltas.id_tbl_empleados_hraes = $id_object
                                ORDER BY public.ctrl_faltas.id_ctrl_faltas DESC
                                LIMIT 3 OFFSET $paginator;");
        return $listado;
    }

    function listarEditById($id_object)
    {
        $listado = pg_query("SELECT *
                            FROM public.ctrl_faltas
                            WHERE id_ctrl_faltas = $id_object
                            LIMIT 1;");
        return $listado;
    }

    function listarByNull()
    {
        return $raw = [
            'id_ctrl_retardo_hraes' => null,
            'fecha' => null,
            'hora_entrada' => null,
            'minuto_entrada' => null,
            'hora_salida' => null,
            'minuto_salida' => null,
            'id_tbl_empleados_hraes' => null,
        ];
    }

    function listarByBusqueda($id_object, $busqueda, $paginator)
    {
        $listado = pg_query("SELECT
                                    public.ctrl_faltas.id_ctrl_faltas,
                                    CASE 
                                        WHEN es_por_retardo THEN 'FALTA POR RETARDO'
                                        ELSE 'FALTA'
                                    END,
                                    TO_CHAR(public.ctrl_faltas.fecha_desde, 'DD/MM/YYYY'),
                                    TO_CHAR(public.ctrl_faltas.fecha_hasta, 'DD/MM/YYYY'),
                                    TO_CHAR(public.ctrl_faltas.fecha_registro, 'DD/MM/YYYY'),
                                    TO_CHAR(public.ctrl_faltas.fecha, 'DD/MM/YYYY'),
                                    TO_CHAR(public.ctrl_faltas.hora, 'HH:MM'),
                                    UPPER(public.ctrl_faltas.codigo_certificacion),
                                    UPPER(public.cat_retardo_estatus.descripcion),
                                    UPPER(public.cat_retardo_tipo.descripcion),
                                    UPPER(public.ctrl_faltas.observaciones),
                                    public.ctrl_faltas.id_user
                                FROM public.ctrl_faltas
                                LEFT JOIN public.cat_retardo_estatus
                                    ON public.ctrl_faltas.id_cat_retardo_estatus =
                                        public.cat_retardo_estatus.id_cat_retardo_estatus
                                LEFT JOIN public.cat_retardo_tipo
                                    ON public.ctrl_faltas.id_cat_retardo_tipo =
                                        public.cat_retardo_tipo.id_cat_retardo_tipo
                                WHERE public.ctrl_faltas.id_tbl_empleados_hraes = $id_object
                                AND (
                                    TO_CHAR(public.ctrl_faltas.fecha_desde, 'DD/MM/YYYY')::TEXT LIKE '%$busqueda%' OR 
                                    TO_CHAR(public.ctrl_faltas.fecha_hasta, 'DD/MM/YYYY')::TEXT LIKE '%$busqueda%' OR
                                    TO_CHAR(public.ctrl_faltas.fecha_registro, 'DD/MM/YYYY')::TEXT LIKE '%$busqueda%' OR
                                    TO_CHAR(public.ctrl_faltas.fecha, 'DD/MM/YYYY')::TEXT LIKE '%$busqueda%' OR
                                    TO_CHAR(public.ctrl_faltas.hora, 'HH:MM')::TEXT LIKE '%$busqueda%' OR
                                    TRIM(UNACCENT(UPPER(public.ctrl_faltas.codigo_certificacion))) LIKE '%$busqueda%' OR
                                    TRIM(UNACCENT(UPPER(public.cat_retardo_estatus.descripcion))) LIKE '%$busqueda%' OR
                                    TRIM(UNACCENT(UPPER(public.cat_retardo_tipo.descripcion))) LIKE '%$busqueda%' OR
                                    TRIM(UNACCENT(UPPER(public.ctrl_faltas.observaciones))) LIKE '%$busqueda%' 
                                )
                                ORDER BY public.ctrl_faltas.id_ctrl_faltas DESC
                                LIMIT 3 OFFSET $paginator;");
        return $listado;
    }

    function editarByArray($conexion, $datos, $condicion)
    {
        $pg_update = pg_update($conexion, 'public.ctrl_faltas', $datos, $condicion);
        return $pg_update;
    }

    function agregarByArray($conexion, $datos)
    {
        $pg_add = pg_insert($conexion, 'public.ctrl_faltas', $datos);
        return $pg_add;
    }

    function eliminarByArray($conexion, $condicion)
    {
        $pgs_delete = pg_delete($conexion, 'public.ctrl_faltas', $condicion);
        return $pgs_delete;
    }


    public function catFaltaEstatus()
    {
        $query = pg_query("SELECT 
                                public.cat_retardo_estatus.id_cat_retardo_estatus,
                                UPPER(public.cat_retardo_estatus.descripcion)
                            FROM public.cat_retardo_estatus
                            ORDER BY public.cat_retardo_estatus.descripcion ASC;");
        return $query;
    }

    public function catFaltaEstatusEdit($id)
    {
        $query = pg_query("SELECT 
                                public.cat_retardo_estatus.id_cat_retardo_estatus,
                                UPPER(public.cat_retardo_estatus.descripcion)
                            FROM public.cat_retardo_estatus
                            WHERE public.cat_retardo_estatus.id_cat_retardo_estatus = $id;");
        return $query;
    }
    public function catFaltaTipo()
    {
        $query = pg_query("SELECT 
                                public.cat_retardo_tipo.id_cat_retardo_tipo,
                                UPPER(public.cat_retardo_tipo.descripcion)
                            FROM public.cat_retardo_tipo
                            ORDER BY public.cat_retardo_tipo.descripcion ASC;");
        return $query;
    }

    public function catFaltaTipoEdit($id)
    {
        $query = pg_query("SELECT 
                                public.cat_retardo_tipo.id_cat_retardo_tipo,
                                UPPER(public.cat_retardo_tipo.descripcion)
                            FROM public.cat_retardo_tipo
                            WHERE public.cat_retardo_tipo.id_cat_retardo_tipo = $id;");
        return $query;
    }

    /// reporte de faltas para todos los empleados
    public function getAllFaltas($paginator)
    {
        $query = ("SELECT 
                                CONCAT(UPPER(public.tbl_empleados_hraes.nombre), ' ',
                                    UPPER(public.tbl_empleados_hraes.primer_apellido), ' ',
                                    UPPER(public.tbl_empleados_hraes.segundo_apellido)) AS nombre_completo,
                                UPPER(public.tbl_empleados_hraes.rfc) AS rfc,
                                'FALTA POR RETARDO',
                                to_char(public.ctrl_faltas.fecha, 'DD-MM-YYYY'),
                                to_char(public.ctrl_faltas.hora, 'HH24:MI'),
                                public.ctrl_faltas.cantidad,
                                UPPER(public.cat_retardo_tipo.descripcion),
                                UPPER(public.cat_retardo_estatus.descripcion),
                                public.ctrl_faltas.id_user,
                                public.ctrl_faltas.id_ctrl_faltas
                            FROM public.ctrl_faltas
                            INNER JOIN public.cat_retardo_tipo
                                ON public.ctrl_faltas.id_cat_retardo_tipo =
                                    public.cat_retardo_tipo.id_cat_retardo_tipo
                            INNER JOIN public.cat_retardo_estatus
                                ON public.ctrl_faltas.id_cat_retardo_estatus =
                                    public.cat_retardo_estatus.id_cat_retardo_estatus
                            INNER JOIN public.tbl_empleados_hraes
                                ON public.ctrl_faltas.id_tbl_empleados_hraes =
                                    public.tbl_empleados_hraes.id_tbl_empleados_hraes 
                            WHERE public.ctrl_faltas.es_por_retardo 
                            ORDER BY public.ctrl_faltas.fecha DESC
                            LIMIT 5 OFFSET $paginator;");
        return $query;
    }

    public function getAllFaltasBusqueda($busqueda, $paginator)
    {
        $query = ("SELECT 
                                CONCAT(UPPER(public.tbl_empleados_hraes.nombre), ' ',
                                    UPPER(public.tbl_empleados_hraes.primer_apellido), ' ',
                                    UPPER(public.tbl_empleados_hraes.segundo_apellido)),
                                UPPER(public.tbl_empleados_hraes.rfc),
                                'FALTA POR RETARDO',
                                to_char(public.ctrl_faltas.fecha, 'DD-MM-YYYY'),
                                to_char(public.ctrl_faltas.hora, 'HH24:MI'),
                                public.ctrl_faltas.cantidad,
                                UPPER(public.cat_retardo_tipo.descripcion),
                                UPPER(public.cat_retardo_estatus.descripcion),
                                public.ctrl_faltas.id_user,
                                public.ctrl_faltas.id_ctrl_faltas
                            FROM public.ctrl_faltas
                            INNER JOIN public.cat_retardo_tipo
                                ON public.ctrl_faltas.id_cat_retardo_tipo =
                                    public.cat_retardo_tipo.id_cat_retardo_tipo
                            INNER JOIN public.cat_retardo_estatus
                                ON public.ctrl_faltas.id_cat_retardo_estatus =
                                    public.cat_retardo_estatus.id_cat_retardo_estatus
                            INNER JOIN public.tbl_empleados_hraes
                                ON public.ctrl_faltas.id_tbl_empleados_hraes =
                                    public.tbl_empleados_hraes.id_tbl_empleados_hraes 
                            WHERE public.ctrl_faltas.es_por_retardo 
                            AND (
                                    CONCAT(UPPER(public.tbl_empleados_hraes.nombre), ' ',
                                        UPPER(public.tbl_empleados_hraes.primer_apellido), ' ',
                                        UPPER(public.tbl_empleados_hraes.segundo_apellido)) LIKE '%$busqueda%'
                                OR UPPER(public.tbl_empleados_hraes.rfc):: TEXT LIKE '%$busqueda%'
                                OR to_char(public.ctrl_faltas.fecha, 'DD-MM-YYYY'):: TEXT LIKE '%$busqueda%'
                                OR to_char(public.ctrl_faltas.hora, 'HH24:MI'):: TEXT LIKE '%$busqueda%'
                                OR public.ctrl_faltas.cantidad:: TEXT LIKE '%$busqueda%'
                                OR UPPER(public.cat_retardo_tipo.descripcion):: TEXT LIKE '%$busqueda%'
                                OR UPPER(public.cat_retardo_estatus.descripcion):: TEXT LIKE '%$busqueda%'
                                )
                            ORDER BY public.ctrl_faltas.fecha DESC
                            LIMIT 5 OFFSET $paginator;");
        return $query;
    }



    ///SCRIP PARA CALCULO DE FLATAS DE FORMA MASIVA
    public function process_1()
    {
        $query = pg_query("--########################
                            --### PROCESO VALIDADO ### 1
                            --########################
                            --============================================================================================
                            --### Tomar el Primer registro por Fecha y empleado para dejarlo en la tabla de retardos   ### De acuerdo a horarios establecidos 
                            --============================================================================================
                            INSERT INTO public.ctrl_retardo (	fecha, 
                                                                hora,
                                                                observaciones,
                                                                id_cat_retardo_tipo, 					-- 1-Entrada 
                                                                id_cat_retardo_estatus, 				-- 5-Por Aplicar
                                                                id_tbl_empleados_hraes, 
                                                                id_user)

                            SELECT 	Entradas.fecha,
                                    Entradas.hora, 
                                    NULL observaciones,
                                    1 id_cat_retardo_tipo, 						-- Entrada 
                                    5 id_cat_retardo_estatus, 						-- Por Aplicar
                                    Entradas.id_tbl_empleados_hraes,
                                    NULL id_user
                            FROM 
                            (
                                SELECT 	 
                                    Minimo.hora, Minimo.fecha, Minimo.id_tbl_empleados_hraes
                                FROM
                                (
                                    SELECT 	public.ctrl_asistencia.fecha, 
                                        MIN(public.ctrl_asistencia.hora) hora,
                                        public.ctrl_asistencia.id_tbl_empleados_hraes
                                    FROM public.ctrl_asistencia 
                                    WHERE public.ctrl_asistencia.fecha NOT IN (SELECT fecha from public.cat_dias_festivos) -- Se excluyen no laborables
                                    GROUP BY  public.ctrl_asistencia.fecha, public.ctrl_asistencia.id_tbl_empleados_hraes
                                    ORDER BY public.ctrl_asistencia.id_tbl_empleados_hraes
                                ) AS Minimo
                                WHERE Minimo.hora >= (select cat_asistencia_config.hora_min_retardo from public.cat_asistencia_config
                                                        WHERE id_cat_asistencia_config = 
                                                        (SELECT id_cat_asistencia_config FROM public.ctrl_asistencia_info AI 
                                                        WHERE AI.id_tbl_empleados_hraes = Minimo.id_tbl_empleados_hraes))
                                AND Minimo.hora <= (select cat_asistencia_config.hora_max_retardo from public.cat_asistencia_config
                                                        WHERE id_cat_asistencia_config = 
                                                        (SELECT id_cat_asistencia_config FROM public.ctrl_asistencia_info AI 
                                                        WHERE AI.id_tbl_empleados_hraes = Minimo.id_tbl_empleados_hraes))
                            ) AS Entradas");
        return $query;
    }

    public function process_2()
    {
        $query = pg_query("--########################
                            --### PROCESO VALIDADO ### 2
                            --########################
                            --============================================================================================
                            --### Tomar el Primer registro por Fecha y empleado para dejarlo en la tabla de retardos   ### De acuerdo a horarios establecios para falta
                            --============================================================================================ por Entrada después de Hora Máxima establecida
                            INSERT INTO public.ctrl_faltas (id_tbl_empleados_hraes,
                                                            observaciones,
                                                            es_por_retardo,
                                                            id_cat_retardo_tipo,						-- 1-Entrada
                                                            id_cat_retardo_estatus,					-- 7-Retardo Mayor
                                                            id_user,
                                                            fecha,
                                                            hora,
                                                            cantidad)

                            SELECT 	Entradas.id_tbl_empleados_hraes,
                                    NULL observaciones,
                                    TRUE es_por_retardo,							-- Entrada despues de Hora Máxima de Retardo
                                    1 id_cat_retardo_tipo, 							-- Entrada 
                                    7 id_cat_retardo_estatus, 						-- Retardo Mayor
                                    NULL id_user,
                                    Entradas.fecha,
                                    Entradas.hora,
                                    1 cantidad
                            FROM 
                            (
                                SELECT 	 
                                    Minimo.hora, Minimo.fecha, Minimo.id_tbl_empleados_hraes
                                FROM
                                (
                                    SELECT 	public.ctrl_asistencia.fecha, 
                                        MIN(public.ctrl_asistencia.hora) hora,
                                        public.ctrl_asistencia.id_tbl_empleados_hraes		
                                    FROM public.ctrl_asistencia 
                                        WHERE public.ctrl_asistencia.fecha NOT IN (SELECT fecha from public.cat_dias_festivos) -- Se excluyen no laborables
                                    GROUP BY  public.ctrl_asistencia.fecha, public.ctrl_asistencia.id_tbl_empleados_hraes
                                    ORDER BY public.ctrl_asistencia.id_tbl_empleados_hraes
                                ) AS Minimo
                                WHERE Minimo.hora > (SELECT cat_asistencia_config.hora_max_retardo FROM public.cat_asistencia_config
                                                        WHERE id_cat_asistencia_config = 
                                                        (SELECT id_cat_asistencia_config FROM public.ctrl_asistencia_info AI 
                                                        WHERE AI.id_tbl_empleados_hraes = Minimo.id_tbl_empleados_hraes)) -- Después de hora Max
                            ) AS Entradas");
        return $query;
    }

    public function process_3()
    {
        $query = pg_query("--########################
                            --### PROCESO VALIDADO ### 3
                            --########################
                            --============================================================================================												  
                            --### Tomar el ültimo registro por Fecha y empleado para dejarlo en la tabla de faltas     ### Para el caso donde las salidas sean antes de la
                            --============================================================================================ Hora establecida								  
                            INSERT INTO public.ctrl_faltas (id_tbl_empleados_hraes,
                                                            observaciones,
                                                            es_por_retardo,
                                                            id_cat_retardo_tipo,						-- 2-Salida
                                                            id_cat_retardo_estatus,					-- 4-Falta (Salida Anticipada)
                                                            id_user,
                                                            fecha,
                                                            hora,
                                                            cantidad)
                                                            
                            SELECT 	Salidas.id_tbl_empleados_hraes,
                                    NULL observaciones,
                                    TRUE es_por_retardo,							-- Falta por Salida Anticipada, no se debe a ningún Retardo
                                    2 id_cat_retardo_tipo, 							-- Salida 
                                    4 id_cat_retardo_estatus, 						-- Falta (Salida Anticipada)
                                    NULL id_user,
                                    Salidas.fecha,
                                    Salidas.hora,
                                    1 cantidad
                            FROM 
                            (
                                SELECT 	 
                                    Maximo.hora, Maximo.fecha, Maximo.id_tbl_empleados_hraes
                                FROM
                                (
                                    SELECT 	 
                                        MAX(public.ctrl_asistencia.hora) hora, public.ctrl_asistencia.fecha,
                                        public.ctrl_asistencia.id_tbl_empleados_hraes		
                                    FROM public.ctrl_asistencia 
                                        WHERE public.ctrl_asistencia.fecha NOT IN (SELECT fecha FROM public.cat_dias_festivos) -- Se excluyen no laborables
                                    GROUP BY  public.ctrl_asistencia.fecha, public.ctrl_asistencia.id_tbl_empleados_hraes
                                    ORDER BY public.ctrl_asistencia.id_tbl_empleados_hraes
                                ) 	AS Maximo 
                                WHERE Maximo.hora <= (SELECT cat_asistencia_config.hora_min_salida FROM public.cat_asistencia_config
                                                        WHERE id_cat_asistencia_config = 
                                                        (SELECT id_cat_asistencia_config FROM public.ctrl_asistencia_info AI 
                                                        WHERE AI.id_tbl_empleados_hraes = Maximo.id_tbl_empleados_hraes)) 			-- Salidas Antes de la hora establecida
                            ) AS Salidas");
        return $query;
    }

    public function process_4()
    {
        $query = pg_query("--########################
                            --### PROCESO VALIDADO ### 4
                            --########################
                            --===================================================================
                            --### Script para Contabilizar las Faltas por Retardos acumulados ###
                            --===================================================================
                            INSERT INTO public.ctrl_faltas (cantidad, id_tbl_empleados_hraes,es_por_retardo,id_cat_retardo_tipo,id_cat_retardo_estatus,fecha)

                            SELECT CASE WHEN (NoRet >= 3 AND NoRet <  6) THEN 1  									-- Una falta cuando los retardos estan entre 3 y 6
                                        WHEN (NoRet >= 6 AND NoRet <  9) THEN 2										-- Dos faltas cuando los retardos estan entre 6 y 9
                                        WHEN (NoRet >= 9 AND NoRet < 12) THEN 3										-- Tres faltas cuando los retardos estan entre 9 y 12
                                        WHEN (NoRet >= 12 			   ) THEN 4										-- Cuatro faltas cuando los retardos son 12 o más.
                                    END AS Faltas, id_tbl_empleados_hraes, TRUE es_por_retardo, 3 id_cat_retardo_tipo, 6 id_cat_retardo_estatus,
                                    CASE WHEN SUBSTRING(CURRENT_DATE::TEXT,9,2) <= '15' 
                                        THEN ('15'||'/'||SUBSTRING(CURRENT_DATE::TEXT,6,2)||'/'||SUBSTRING(CURRENT_DATE::TEXT,1,4))::DATE	-- Toma el día 15 del Mes
                                    ELSE (date_trunc('MONTH', CURRENT_DATE) + INTERVAL '1 MONTH' - INTERVAL '1 DAY')::DATE					-- Toma el último día del Mes
                                    END AS fecha    --Para este caso tomará el día 15 del mes cuando la fecha actual sea menor o igual a 15, de lo contrario el último día del mes
                            FROM
                                (
                                SELECT COUNT(*) NoRet, id_tbl_empleados_hraes
                                    FROM public.ctrl_retardo
                                WHERE fecha > (SELECT fecha_ult_proceso FROM public.cat_asistencia_config) --<= '15/08/2024' 							-- ### Aquí ponemos una condición para una fecha mayor o igual, o se quita para procesar todo
                                GROUP BY id_tbl_empleados_hraes
                                HAVING COUNT(*) >= 3
                                ) AS Retardos");
        return $query;
    }

    public function process_5()
    {
        $query = pg_query("--########################
                            --### PROCESO VALIDADO ### 5
                            --########################
                            --==========================================================================
                            --### Script para Actualizar la Fecha de Último Proceso en Configuración ###
                            --==========================================================================
                            UPDATE public.cat_asistencia_config
                            SET fecha_ult_proceso = CURRENT_DATE;");
        return $query;
    }

    public function truncateTableTmpFaltas()
    {
        $query = pg_query("TRUNCATE TABLE public.masivo_ctrl_temp_faltas_just RESTART IDENTITY;");
    }

    public function addInfoFaltaTemp(
        $rfc,
        $fecha,
        $observaciones,
        $tipo,
        $tipo_falta
    ) {
        $query = pg_query("INSERT INTO public.masivo_ctrl_temp_faltas_just(
                            rfc, fecha, observaciones, tipo, tipo_falta)
                            VALUES ('$rfc', '$fecha', '$observaciones', '$tipo', '$tipo_falta ');");
        return $query;
    }

    public function udpdateFaltas()
    {
        $query = pg_query("-- #Script Para Actualización de Retardos #
                            -- ### Proceso Validado ###################
                            UPDATE public.ctrl_retardo R
                            SET id_cat_retardo_estatus = 3, -- JUSTIFICADA
                                observaciones = J.observaciones	-- Observaciones del Justificación
                            FROM public.masivo_ctrl_temp_faltas_just J	-- Justificaciones
                                JOIN public.tbl_empleados_hraes  E ON  J.rfc = E.rfc
                            WHERE R.id_tbl_empleados_hraes = E.id_tbl_empleados_hraes
                            AND R.fecha = J.fecha::DATE
                            AND UPPER(J.tipo) = 'RETARDO';
                            
                            -- #Script Para Actualización de Faltas #
                            -- ###Proceso Validado ##################
                            UPDATE public.ctrl_faltas F
                            SET id_cat_retardo_estatus = 3, -- JUSTIFICADA
                                observaciones = J.observaciones	-- Observaciones del Justificación
                            FROM public.masivo_ctrl_temp_faltas_just J	-- Justificaciones
                                JOIN public.tbl_empleados_hraes  E ON  J.rfc = E.rfc
                            WHERE F.id_tbl_empleados_hraes = E.id_tbl_empleados_hraes
                            AND F.fecha = J.fecha::DATE
                            AND UPPER(J.tipo) = 'FALTA'
                            AND F.id_cat_retardo_tipo = (SELECT id_cat_retardo_tipo
                                                        FROM public.cat_retardo_tipo
                                                        WHERE descripcion = UPPER(J.tipo_falta));");
        return $query;
    }

}
