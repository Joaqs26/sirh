<?php

class row {
    public function returnArray($result) {
        $response = null; // ✅ Inicializar la variable antes de usarla

        if (pg_num_rows($result) > 0) {
            while ($row = pg_fetch_assoc($result)) {
                $response = $row;
            }
        }
        return $response;
    }
    
    public function returnArrayById($result) {
        $response = null; // ✅ Inicializar la variable antes de usarla

        if (pg_num_rows($result) > 0) {
            while ($row = pg_fetch_row($result)) {
                $response = $row;
            }
        }
        return $response;
    }
}
?>