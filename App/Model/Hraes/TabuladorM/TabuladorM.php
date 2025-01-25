<?php

class modelTabulacion   
{
        function Tabulador($id_object)
            {
                $listado = pg_query("SELECT codigo_puesto_actual, sueldo_base, ayuda_gastos_actualizacion, 
asignacion_bruta, compensacion_servicios, compensacion_polivalencia, total_bruto_mensual,
total_neto_mensual, sueldo_quincenal_neto
FROM public.cat_tabulador
where codigo_puesto_actual = $id");
                return $listado;
            }
        }

