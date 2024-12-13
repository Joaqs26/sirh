<?php

$timestamp = 'NOW()';
class BitacoraM
{
    function agregarByArray($conexion, $datos,$nombre)
    {
        $pg_add = pg_insert($conexion, $nombre, $datos);
        return $pg_add;
    }
}
