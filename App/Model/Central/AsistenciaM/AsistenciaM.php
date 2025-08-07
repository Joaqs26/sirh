<?php

class AsistenciaM
{

    public function listOfAsistencia($id)
    {
        $query = pg_query("SELECT
                                central.ctrl_asistencia_info.id_ctrl_asistencia_info,
                                central.ctrl_asistencia_info.no_dispositivo,
                                UPPER(central.cat_asistencia_ubicacion.descripcion),
                                UPPER(central.cat_asistencia_estatus.descripcion),
                                UPPER(central.ctrl_asistencia_info.observaciones)
                            FROM central.ctrl_asistencia_info
                            INNER JOIN central.cat_asistencia_ubicacion
                                ON central.ctrl_asistencia_info.id_cat_asistencia_ubicacion = 
                                    central.cat_asistencia_ubicacion.id_cat_asistencia_ubicacion
                            INNER JOIN central.cat_asistencia_estatus
                                ON central.ctrl_asistencia_info.id_cat_asistencia_estatus =
                                    central.cat_asistencia_estatus.id_cat_asistencia_estatus
                            WHERE central.ctrl_asistencia_info.id_tbl_empleados_hraes = $id
                            ORDER BY central.ctrl_asistencia_info.id_ctrl_asistencia_info DESC
                            LIMIT 1");
        return $query;
    }

    public function listOfJornada($id)
    {
        $query = pg_query("SELECT 
                                central.ctrl_jornada.id_ctrl_jornada,
                                UPPER(central.cat_jornada_turno.descripcion),
                                UPPER(central.cat_jornada_dias.descripcion),
                                CONCAT(TO_CHAR(central.cat_jornada_horario.hora_entrada, 'HH24:MI'), ' - ',
                                        TO_CHAR(central.cat_jornada_horario.hora_salida, 'HH24:MI'))
                            FROM central.ctrl_jornada
                            INNER JOIN central.cat_jornada_turno
                                ON central.ctrl_jornada.id_cat_jornada_turno = 
                                    central.cat_jornada_turno.id_cat_jornada_turno
                            INNER JOIN central.cat_jornada_dias
                                ON central.ctrl_jornada.id_cat_jornada_dias =
                                    central.cat_jornada_dias.id_cat_jornada_dias
                            INNER JOIN central.cat_jornada_horario
                                ON central.ctrl_jornada.id_cat_jornada_horario =
                                    central.cat_jornada_horario.id_cat_jornada_horario
                            WHERE central.ctrl_jornada.id_tbl_empleados_hraes = $id
                            ORDER BY central.ctrl_jornada.id_ctrl_jornada DESC
                            LIMIT 1");
        return $query;
    }

    public function editAsistenciaInfo($id)
    {
        $query = pg_query("SELECT * 
                            FROM central.ctrl_asistencia_info
                            WHERE id_tbl_empleados_hraes = $id
                            ORDER BY id_ctrl_asistencia_info ASC
                            LIMIT 1;");
        return $query;
    }

    public function editJornadaInfo($id)
    {
        $query = pg_query("SELECT * 
                            FROM central.ctrl_jornada
                            WHERE id_tbl_empleados_hraes = $id
                            ORDER BY id_ctrl_jornada DESC
                            LIMIT 1;");
        return $query;
    }

    function editAsistenciaInfoDB($conexion, $datos, $condicion)
    {
        $pg_update = pg_update($conexion, 'central.ctrl_asistencia_info', $datos, $condicion);
        return $pg_update;
    }

    function addAsistenciaInfoDB($conexion, $datos)
    {
        $pg_add = pg_insert($conexion, 'central.ctrl_jornada', $datos);
        return $pg_add;
    }


    function editJornadaInfoDB($conexion, $datos, $condicion)
    {
        $pg_update = pg_update($conexion, 'central.ctrl_jornada', $datos, $condicion);
        return $pg_update;
    }

    function addJornadaInfoDB($conexion, $datos)
    {
        $pg_add = pg_insert($conexion, 'central.ctrl_jornada', $datos);
        return $pg_add;
    }

    public function validateNoBiometrico($no_dispositivo, $id_tbl_empleados_hraes)
    {
        $query = pg_query("SELECT id_ctrl_asistencia_info
                            FROM central.ctrl_asistencia_info
                            WHERE no_dispositivo = $no_dispositivo
                            AND id_tbl_empleados_hraes <> $id_tbl_empleados_hraes;");
        return $query;
    }

    public function listadoAsistenciaAll($idEmpleado, $paginator)
    {
        $query = pg_query("WITH MinMaxHoras AS (
                                SELECT
                                    fecha,
                                    MIN(hora) AS hora_minima,
                                    MAX(hora) AS hora_maxima
                                FROM central.ctrl_asistencia
                                WHERE id_tbl_empleados_hraes = $idEmpleado
                                GROUP BY fecha
                            )
                            SELECT
                                ca.id_ctrl_asistencia,
                                TO_CHAR(ca.fecha, 'DD/MM/YYYY') AS fecha_formateada,
                                TO_CHAR(ca.hora, 'HH24:MI') AS hora_formateada,
                                CASE 
                                    WHEN ca.hora = mmh.hora_minima THEN 'PRIMER REGISTRO'
                                    WHEN ca.hora = mmh.hora_maxima THEN 'ÚLTIMO REGISTRO'
                                    ELSE 'REGISTRO INTERMEDIO'
                                END AS tipo_registro,
                                UPPER(ca.dispositivo) AS dispositivo,
                                UPPER(ca.verificacion) AS verificacion,
                                UPPER(ca.estado) AS estado,
                                UPPER(ca.evento) AS evento,
                                ca.id_user
                            FROM central.ctrl_asistencia ca
                            INNER JOIN MinMaxHoras mmh
                                ON ca.fecha = mmh.fecha
                                AND (ca.hora = mmh.hora_minima OR ca.hora = mmh.hora_maxima)
                            INNER JOIN central.ctrl_asistencia_info cai
                                ON cai.id_tbl_empleados_hraes = ca.id_tbl_empleados_hraes
                            WHERE ca.id_tbl_empleados_hraes = $idEmpleado
                              AND cai.id_cat_asistencia_ubicacion = 1
                            ORDER BY ca.fecha DESC, ca.hora
                            LIMIT 3 OFFSET $paginator;");
        return $query;
    }
    
    public function listadoAsistenciaBusq($idEmpleado, $busqueda, $paginator)
    {
        $query = pg_query("WITH MinMaxHoras AS (
                                SELECT
                                    fecha,
                                    MIN(hora) AS hora_minima,
                                    MAX(hora) AS hora_maxima
                                FROM central.ctrl_asistencia
                                WHERE id_tbl_empleados_hraes = $idEmpleado
                                GROUP BY fecha
                            )
                            SELECT
                                ca.id_ctrl_asistencia,
                                TO_CHAR(ca.fecha, 'DD/MM/YYYY') AS fecha_formateada,
                                TO_CHAR(ca.hora, 'HH24:MI') AS hora_formateada,
                                CASE 
                                    WHEN ca.hora = mmh.hora_minima THEN 'PRIMER REGISTRO'
                                    WHEN ca.hora = mmh.hora_maxima THEN 'ÚLTIMO REGISTRO'
                                    ELSE 'REGISTRO INTERMEDIO'
                                END AS tipo_registro,
                                UPPER(ca.dispositivo) AS dispositivo,
                                UPPER(ca.verificacion) AS verificacion,
                                UPPER(ca.estado) AS estado,
                                UPPER(ca.evento) AS evento,
                                ca.id_user
                            FROM central.ctrl_asistencia ca
                            INNER JOIN MinMaxHoras mmh
                                ON ca.fecha = mmh.fecha
                                AND (ca.hora = mmh.hora_minima OR ca.hora = mmh.hora_maxima)
                            INNER JOIN central.ctrl_asistencia_info cai
                                ON cai.id_tbl_empleados_hraes = ca.id_tbl_empleados_hraes
                            WHERE ca.id_tbl_empleados_hraes = $idEmpleado
                              AND cai.id_cat_asistencia_ubicacion = 1
                              AND (
                                  TO_CHAR(ca.fecha, 'DD/MM/YYYY')::TEXT LIKE '%$busqueda%' OR
                                  TO_CHAR(ca.hora, 'HH24:MI')::TEXT LIKE '%$busqueda%' OR
                                  TRIM(UPPER(UNACCENT(ca.dispositivo))) LIKE '%$busqueda%' OR
                                  TRIM(UPPER(UNACCENT(ca.verificacion))) LIKE '%$busqueda%' OR
                                  TRIM(UPPER(UNACCENT(ca.estado))) LIKE '%$busqueda%' OR
                                  TRIM(UPPER(UNACCENT(ca.evento))) LIKE '%$busqueda%'
                              )
                            ORDER BY ca.fecha DESC, ca.hora 
                            LIMIT 3 OFFSET $paginator;");
        return $query;
    }
    

    public function editAsistencia($id)
    {
        $query = pg_query("SELECT * 
                            FROM central.ctrl_asistencia
                            WHERE id_ctrl_asistencia =  $id;");
        return $query;
    }

    public function asistenciaIsNUll()
    {
        return $array = [
            'id_ctrl_asistencia' => null,
            'fecha' => null,
            'hora' => null,
            'dispositivo' => null,
            'verificacion' => null,
            'estado' => null,
            'evento' => null,
            'id_tbl_empleados_hraes' => null,
            'id_user' => null
        ];
    }

    function editarByArray($conexion, $datos, $condicion)
    {
        $pg_update = pg_update($conexion, 'central.ctrl_asistencia', $datos, $condicion);
        return $pg_update;
    }

    function agregarByArray($conexion, $datos)
    {
        $pg_add = pg_insert($conexion, 'central.ctrl_asistencia', $datos);
        return $pg_add;
    }

    function eliminarByArray($conexion, $condicion)
    {
        $pgs_delete = pg_delete($conexion, 'central.ctrl_asistencia', $condicion);
        return $pgs_delete;
    }

    public function getNameOfUser($id)
    {
        $query = pg_query("SELECT UPPER(nombre)
                            FROM public.users
                            WHERE id_user = $id;");
        return $query;
    }

    public function truncateTable($table)
    {
        $query = pg_query("TRUNCATE TABLE $table;");
        return $query;
    }

    public function addInfoAsistenciaTemp(
        $tableName,
        $tiempo,
        $no_empleado,
        $nombre = null,
        $apellido = null,
        $num_tarjeta = null,
        $dispositivo = null,
        $punto_evento = null,
        $verificacion = null,
        $estado = null,
        $evento = null,
        $notas = null
    ) {
        $query = pg_query("INSERT INTO $tableName (tiempo, no_empleado, nombre, apellido, num_tarjeta, dispositivo, punto_evento, verificacion, estado, evento, notas)
                           VALUES ('$tiempo', '$no_empleado', '$nombre', '$apellido', '$num_tarjeta', '$dispositivo', 
                                   '$punto_evento', '$verificacion', '$estado', '$evento', '$notas');");
        return $query;
    }
    

    public function getReporte()
    {
        $query = pg_query("WITH Filtradas AS (
    SELECT
        cti.id_tbl_empleados_hraes,
        TO_TIMESTAMP(cta.tiempo, 'MM/DD/YYYY HH24:MI') AS fecha_hora_real,
        TO_CHAR(TO_TIMESTAMP(cta.tiempo, 'MM/DD/YYYY HH24:MI'), 'YYYY-MM-DD')::DATE AS fecha,
        TO_CHAR(TO_TIMESTAMP(cta.tiempo, 'MM/DD/YYYY HH24:MI'), 'HH24:MI:SS') AS hora
    FROM central.ctrl_temp_asistencia cta
    INNER JOIN central.ctrl_asistencia_info cti
        ON cta.no_empleado::TEXT = cti.no_dispositivo::TEXT
    WHERE
        cti.id_cat_asistencia_estatus = 1
        AND TO_TIMESTAMP(cta.tiempo, 'MM/DD/YYYY HH24:MI')::TIME > '05:00:00'
),
Horas AS (
    SELECT
        id_tbl_empleados_hraes,
        fecha,
        MIN(hora) AS hora_minima,
        MAX(hora) AS hora_maxima
    FROM Filtradas
    GROUP BY id_tbl_empleados_hraes, fecha
)
SELECT DISTINCT ON (cti.id_tbl_empleados_hraes, fecha, hora)
    UPPER(emp.rfc),
    UPPER(emp.curp),
    UPPER(emp.nombre),
    UPPER(emp.primer_apellido),
    UPPER(emp.segundo_apellido),
    TO_CHAR(TO_TIMESTAMP(cta.tiempo, 'MM/DD/YYYY HH24:MI'), 'YYYY-MM-DD')::DATE AS fecha,
    TO_CHAR(TO_TIMESTAMP(cta.tiempo, 'MM/DD/YYYY HH24:MI'), 'HH24:MI:SS')::TIME AS hora,
    CASE
        WHEN TO_CHAR(TO_TIMESTAMP(cta.tiempo, 'MM/DD/YYYY HH24:MI'), 'HH24:MI:SS') = hm.hora_minima THEN 'PRIMER REGISTRO'
        WHEN TO_CHAR(TO_TIMESTAMP(cta.tiempo, 'MM/DD/YYYY HH24:MI'), 'HH24:MI:SS') = hm.hora_maxima THEN 'ÚLTIMO REGISTRO'
    END AS tipo_registro,
    UPPER(cta.dispositivo) AS dispositivo,
    UPPER(cta.verificacion) AS verificacion,
    UPPER(cta.estado) AS estado,
    UPPER(cta.evento) AS evento,
    cti.no_dispositivo
FROM central.ctrl_temp_asistencia cta
INNER JOIN central.ctrl_asistencia_info cti
    ON cta.no_empleado::TEXT = cti.no_dispositivo::TEXT
INNER JOIN central.tbl_empleados_hraes emp 
    ON cti.id_tbl_empleados_hraes = emp.id_tbl_empleados_hraes
INNER JOIN Horas hm
    ON cti.id_tbl_empleados_hraes = hm.id_tbl_empleados_hraes
   AND TO_CHAR(TO_TIMESTAMP(cta.tiempo, 'MM/DD/YYYY HH24:MI'), 'YYYY-MM-DD')::DATE = hm.fecha
   AND TO_CHAR(TO_TIMESTAMP(cta.tiempo, 'MM/DD/YYYY HH24:MI'), 'HH24:MI:SS') IN (hm.hora_minima, hm.hora_maxima)
WHERE cti.id_cat_asistencia_estatus = 1
ORDER BY cti.id_tbl_empleados_hraes, fecha, hora;");
        return $query;
    }

    public function addDataInTables()
    {
        $query = pg_query("INSERT INTO central.ctrl_asistencia (
    fecha, hora, dispositivo, verificacion, estado, evento, id_tbl_empleados_hraes
)
WITH Filtradas AS (
    SELECT
        cti.id_tbl_empleados_hraes,
        TO_TIMESTAMP(cta.tiempo, 'MM/DD/YYYY HH24:MI') AS fecha_hora_real,
        -- Fecha lógica: día anterior si es antes de 5:00 a.m.
        CASE 
            WHEN TO_CHAR(TO_TIMESTAMP(cta.tiempo, 'MM/DD/YYYY HH24:MI'), 'HH24:MI:SS')::time < TIME '05:00:00'
                THEN (TO_TIMESTAMP(cta.tiempo, 'MM/DD/YYYY HH24:MI') - INTERVAL '1 day')::date
            ELSE TO_TIMESTAMP(cta.tiempo, 'MM/DD/YYYY HH24:MI')::date
        END AS fecha,
        TO_CHAR(TO_TIMESTAMP(cta.tiempo, 'MM/DD/YYYY HH24:MI'), 'HH24:MI:SS')::time AS hora,
        UPPER(cta.dispositivo) AS dispositivo,
        UPPER(cta.verificacion) AS verificacion,
        UPPER(cta.estado) AS estado,
        UPPER(cta.evento) AS evento
    FROM central.ctrl_temp_asistencia cta
    INNER JOIN central.ctrl_asistencia_info cti
        ON cta.no_empleado::TEXT = cti.no_dispositivo::TEXT
    WHERE cti.id_cat_asistencia_estatus = 1
      AND cti.id_cat_asistencia_ubicacion = 1
     AND cti.no_dispositivo IS NOT NULL

),
MinMaxHoras AS (
    SELECT
        id_tbl_empleados_hraes,
        fecha,
        -- ✅ Entrada solo si >= 06:00
        MIN(hora) FILTER (WHERE hora >= TIME '06:00:00') AS hora_minima,
        -- ✅ Salida: última hora real hasta las 5:00 a.m. del día siguiente
        MAX(fecha_hora_real) FILTER (
            WHERE fecha_hora_real >= fecha::timestamp 
              AND fecha_hora_real < fecha::timestamp + INTERVAL '1 day 5 hours'
        ) AS salida_real
    FROM Filtradas
    GROUP BY id_tbl_empleados_hraes, fecha
),
FiltradasSalidaExtendida AS (
    SELECT f.*
    FROM Filtradas f
    JOIN MinMaxHoras mmh
        ON f.id_tbl_empleados_hraes = mmh.id_tbl_empleados_hraes
       AND f.fecha = mmh.fecha
       AND (
            f.hora = mmh.hora_minima
            OR f.fecha_hora_real = mmh.salida_real
       )
)
SELECT DISTINCT ON (id_tbl_empleados_hraes, fecha, hora)
    fecha,
    hora,
    dispositivo,
    verificacion,
    estado,
    evento,
    id_tbl_empleados_hraes
FROM FiltradasSalidaExtendida
ORDER BY id_tbl_empleados_hraes, fecha, hora;");
        return $query;
    }
    
    


    //listado para pbtener el total de asistencias
    public function listarAsistenciaDep($paginator)
    {
        $query = ("SELECT
                    CONCAT(UPPER(central.tbl_empleados_hraes.nombre), ' ',
                        UPPER(central.tbl_empleados_hraes.primer_apellido), ' ',
                        UPPER(central.tbl_empleados_hraes.segundo_apellido)),
                    UPPER(central.tbl_empleados_hraes.rfc),
                    TO_CHAR(central.ctrl_asistencia.fecha, 'DD-MM-YYYY'),
                    TO_CHAR(central.ctrl_asistencia.hora, 'HH24:MI'),
                    UPPER(central.ctrl_asistencia.dispositivo),
                    central.ctrl_asistencia.id_user,
                    central.tbl_empleados_hraes.id_tbl_empleados_hraes,
                    central.ctrl_asistencia.id_ctrl_asistencia  
                FROM central.tbl_empleados_hraes
                INNER JOIN central.ctrl_asistencia 
                    ON central.ctrl_asistencia.id_tbl_empleados_hraes =
                        central.tbl_empleados_hraes.id_tbl_empleados_hraes
                ORDER BY central.ctrl_asistencia.fecha ASC, central.ctrl_asistencia.hora desc
                LIMIT 5 OFFSET $paginator;");
        return $query;
    }
    public function listarAsistenciaDepBusqueda($busqueda, $paginator)
    {
        $query = ("SELECT
                        CONCAT(UPPER(central.tbl_empleados_hraes.nombre), ' ',
                            UPPER(central.tbl_empleados_hraes.primer_apellido), ' ',
                            UPPER(central.tbl_empleados_hraes.segundo_apellido)) AS nombre_completo,
                        UPPER(central.tbl_empleados_hraes.rfc) AS rfc,
                        TO_CHAR(central.ctrl_asistencia.fecha, 'DD-MM-YYYY') AS fecha,
                        TO_CHAR(central.ctrl_asistencia.hora, 'HH24:MI') AS hora,
                        UPPER(central.ctrl_asistencia.dispositivo) AS dispositivo,
                        central.ctrl_asistencia.id_user,
                        central.tbl_empleados_hraes.id_tbl_empleados_hraes,
                        central.ctrl_asistencia.id_ctrl_asistencia
                    FROM central.tbl_empleados_hraes
                    INNER JOIN central.ctrl_asistencia 
                        ON central.ctrl_asistencia.id_tbl_empleados_hraes = central.tbl_empleados_hraes.id_tbl_empleados_hraes
                    WHERE (
                        CONCAT(UPPER(central.tbl_empleados_hraes.nombre), ' ',
                            UPPER(central.tbl_empleados_hraes.primer_apellido), ' ',
                            UPPER(central.tbl_empleados_hraes.segundo_apellido)) LIKE '%$busqueda%' 
                        OR UPPER(central.tbl_empleados_hraes.rfc) LIKE '%$busqueda%' 
                        OR TO_CHAR(central.ctrl_asistencia.fecha, 'DD-MM-YYYY') LIKE '%$busqueda%' 
                        OR TO_CHAR(central.ctrl_asistencia.hora, 'HH24:MI') LIKE '%$busqueda%' 
                        OR UPPER(central.ctrl_asistencia.dispositivo) LIKE '%$busqueda%'
                    )
                     ORDER BY central.ctrl_asistencia.fecha ASC, central.ctrl_asistencia.hora desc
                    LIMIT 5 OFFSET $paginator;");
        return $query;
    }


    public function getInfoAsistencia($id)
    {
        $query = pg_query("SELECT
                                CONCAT(UPPER(central.tbl_empleados_hraes.nombre), ' ',
                                    UPPER(central.tbl_empleados_hraes.primer_apellido), ' ',
                                    UPPER(central.tbl_empleados_hraes.segundo_apellido)),
                                UPPER(central.tbl_empleados_hraes.rfc),
                                TO_CHAR(central.ctrl_asistencia.fecha, 'DD-MM-YYYY'),
                                TO_CHAR(central.ctrl_asistencia.hora, 'HH24:MI'),
                                UPPER(central.ctrl_asistencia.dispositivo),
                                UPPER(central.ctrl_asistencia.verificacion),
                                UPPER(central.ctrl_asistencia.estado),
                                UPPER(central.ctrl_asistencia.evento),
                                central.tbl_empleados_hraes.id_tbl_empleados_hraes
                            FROM central.ctrl_asistencia  
                            INNER JOIN central.tbl_empleados_hraes
                                ON central.ctrl_asistencia.id_tbl_empleados_hraes =
                                    central.tbl_empleados_hraes.id_tbl_empleados_hraes
                            WHERE central.ctrl_asistencia.id_ctrl_asistencia  = $id;");
        return $query;
    }

    public function isTruncate()
    {
        $query = pg_query("TRUNCATE TABLE central.reporte_faltas;");
        return $query;
    }

    public function insertFalta()
{
    // 1. Insertar faltas normales
    pg_query("INSERT INTO central.reporte_faltas (
    rfc, nombre, movil, no_dispositivo, fecha, hora, cantidad, estatus
)
SELECT 
    e.rfc,
    (e.nombre || ' ' || e.primer_apellido || ' ' || e.segundo_apellido) AS nombre_completo,
    t.movil,
    ai.no_dispositivo,
    f.fecha,
    f.hora,
    f.cantidad,
    re.descripcion AS estatus
FROM central.tbl_empleados_hraes e
INNER JOIN central.ctrl_asistencia_info ai ON e.id_tbl_empleados_hraes = ai.id_tbl_empleados_hraes
INNER JOIN central.ctrl_telefono_hraes t ON e.id_tbl_empleados_hraes = t.id_tbl_empleados_hraes AND t.id_cat_estatus = 1
INNER JOIN central.ctrl_faltas f ON e.id_tbl_empleados_hraes = f.id_tbl_empleados_hraes
INNER JOIN central.cat_retardo_estatus re ON f.id_cat_retardo_estatus = re.id_cat_retardo_estatus;
    ");

   // 2. Insertar acumulación de retardos como faltas
pg_query("INSERT INTO central.reporte_faltas (
    rfc, nombre, movil, no_dispositivo, fecha, hora, cantidad, estatus
)
SELECT  
    e.rfc,
    (e.nombre || ' ' || e.primer_apellido || ' ' || e.segundo_apellido) AS nombre_completo,
    t.movil,
    ai.no_dispositivo,
    a.fecha,
    a.hora,
    1 AS cantidad,
    'RETARDO' AS estatus
FROM central.ctrl_asistencia a
INNER JOIN central.tbl_empleados_hraes e ON e.id_tbl_empleados_hraes = a.id_tbl_empleados_hraes
INNER JOIN central.ctrl_asistencia_info ai ON ai.id_tbl_empleados_hraes = a.id_tbl_empleados_hraes
INNER JOIN central.ctrl_telefono_hraes t ON t.id_tbl_empleados_hraes = a.id_tbl_empleados_hraes AND t.id_cat_estatus = 1
WHERE a.fecha NOT IN (
    SELECT fecha FROM central.cat_dias_festivos
)
AND a.hora >= (
    SELECT C.hora_min_retardo
    FROM central.cat_asistencia_config C
    WHERE C.id_cat_asistencia_config = ai.id_cat_asistencia_config
)
AND a.hora <= (
    SELECT C.hora_max_retardo
    FROM central.cat_asistencia_config C
    WHERE C.id_cat_asistencia_config = ai.id_cat_asistencia_config
)
AND NOT EXISTS (
    SELECT 1 FROM central.masivo_ctrl_temp_faltas_just mj
    WHERE mj.rfc = e.rfc
    AND mj.fecha IS NOT NULL
    AND mj.fecha::date = a.fecha
)
AND NOT EXISTS (
    SELECT 1 FROM central.ctrl_incidencias ci
    WHERE ci.id_tbl_empleados_hraes = a.id_tbl_empleados_hraes
    AND ci.id_cat_incidencias IN (13, 14, 15)
    AND a.fecha BETWEEN ci.fecha_inicio AND ci.fecha_fin
)
AND e.rfc IN (
    SELECT e2.rfc
    FROM central.ctrl_asistencia a2
    INNER JOIN central.tbl_empleados_hraes e2 ON e2.id_tbl_empleados_hraes = a2.id_tbl_empleados_hraes
    INNER JOIN central.ctrl_asistencia_info ai2 ON ai2.id_tbl_empleados_hraes = a2.id_tbl_empleados_hraes
    WHERE a2.fecha NOT IN (
        SELECT fecha FROM central.cat_dias_festivos
    )
    AND a2.hora >= (
        SELECT C.hora_min_retardo
        FROM central.cat_asistencia_config C
        WHERE C.id_cat_asistencia_config = ai2.id_cat_asistencia_config
    )
    AND a2.hora <= (
        SELECT C.hora_max_retardo
        FROM central.cat_asistencia_config C
        WHERE C.id_cat_asistencia_config = ai2.id_cat_asistencia_config
    )
    AND NOT EXISTS (
        SELECT 1 FROM central.masivo_ctrl_temp_faltas_just mj
        WHERE mj.rfc = e2.rfc
        AND mj.fecha IS NOT NULL
        AND mj.fecha::date = a2.fecha
    )
    AND NOT EXISTS (
        SELECT 1 FROM central.ctrl_incidencias ci
        WHERE ci.id_tbl_empleados_hraes = a2.id_tbl_empleados_hraes
        AND ci.id_cat_incidencias IN (13, 14, 15)
        AND a2.fecha BETWEEN ci.fecha_inicio AND ci.fecha_fin
    )
    GROUP BY e2.rfc
    HAVING COUNT(*) >= 3
)
ORDER BY e.rfc, a.fecha;
");
}

 public function selectFaltas($fecha_inicio, $fecha_fin)
{
    // Escapar correctamente las variables para evitar inyección SQL
    $fecha_inicio = pg_escape_string($fecha_inicio);
    $fecha_fin = pg_escape_string($fecha_fin);

    $query = pg_query("SELECT rfc, unidad, coordinacion, puesto, nombre, movil, no_dispositivo, fecha, hora, cantidad, estatus
                       FROM central.reporte_faltas
                       WHERE fecha BETWEEN '$fecha_inicio' AND '$fecha_fin';");

    return $query;
}


}

