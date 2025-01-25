<?php

class ReporteM
{
	public function isTruncateTable($tableName)
	{
		$query = pg_query("TRUNCATE TABLE $tableName;");
		return $query;
	}

	public function isQueryAll($tableName)
	{
		$query = pg_query("INSERT INTO $tableName
			SELECT 
				central.tbl_empleados_hraes.id_tbl_empleados_hraes AS no_,
				central.ctrl_adic_emp_hraes.fecha_expedicion AS fecha_expedicion,
				UPPER(central.tbl_empleados_hraes.rfc) AS rfc,
				UPPER(central.tbl_empleados_hraes.curp) AS curp,
				UPPER(central.tbl_empleados_hraes.primer_apellido) AS apellido_paterno,
				UPPER(central.tbl_empleados_hraes.segundo_apellido) AS apellido_materno,
				UPPER(central.tbl_empleados_hraes.nombre) AS nombre,
				UPPER(central.tbl_empleados_hraes.num_empleado) AS num_empleado,
				UPPER(central.tbl_empleados_hraes.nacionalidad) AS nacionalidad,
				central.tbl_empleados_hraes.nss AS numero_seguro_social,
				UPPER(central.tbl_domicilios_hraes.calle1) AS calle,
				UPPER(central.tbl_domicilios_hraes.num_exterior1) AS num_exterior,
				UPPER(central.tbl_domicilios_hraes.num_interior1) AS num_interior,
				UPPER(central.tbl_domicilios_hraes.colonia1) AS colonia,
				UPPER(central.tbl_domicilios_hraes.codigo_postal1) AS codigo_postal,
				UPPER(central.tbl_domicilios_hraes.codigo_postal2) AS codigo_postal_fiscal,
				UPPER(central.tbl_domicilios_hraes.municipio1) AS municipio,
				UPPER(central.tbl_domicilios_hraes.entidad1) AS entidad,
				central.ctrl_telefono_hraes.telefono AS telefono,
				central.ctrl_telefono_hraes.movil AS movil,
				central.ctrl_medios_contacto_hraes.correo_electronico AS correo,
				central.ctrl_cuenta_clabe_hraes.clabe AS clabe,
				UPPER(public.cat_banco.nombre) AS banco,
				SUBSTRING(central.tbl_empleados_hraes.curp,11,1) AS genero,
				UPPER(public.cat_estado_civil.estado_civil) AS estado_civil,
				CONCAT(
				CASE WHEN SUBSTRING (central.tbl_empleados_hraes.curp,5,2) > '24' THEN 
						CONCAT('19',SUBSTRING(central.tbl_empleados_hraes.curp,5,2)) 
						ELSE CONCAT('20',SUBSTRING(central.tbl_empleados_hraes.curp,5,2))  END
				,'/',
				SUBSTRING (central.tbl_empleados_hraes.curp,7,2)
				,'/',
				SUBSTRING (central.tbl_empleados_hraes.curp,9,2)	
				) AS fecha_nacimiento,
				UPPER(public.cat_estado_nacimiento.nombre) AS estado_nacimiento,
				UPPER(public.cat_pais_nacimiento.nombre) AS pais_nacimiento,
				DATE_PART('year', AGE(NOW(), 
					TO_DATE(
						CONCAT(
							CASE WHEN SUBSTRING(central.tbl_empleados_hraes.curp, 5, 2) > '24' THEN 
									CONCAT('19', SUBSTRING(central.tbl_empleados_hraes.curp, 5, 2)) 
								ELSE CONCAT('20', SUBSTRING(central.tbl_empleados_hraes.curp, 5, 2)) 
							END,
							'/',
							SUBSTRING(central.tbl_empleados_hraes.curp, 7, 2),
							'/',
							SUBSTRING(central.tbl_empleados_hraes.curp, 9, 2)
						),
						'YYYY/MM/DD' 
					)
				)) AS edad,
				central.ctrl_adic_emp_hraes.fecha_ingreso_gob_fed AS fecha_ingreso_gob_fed,
				central.ctrl_adic_emp_hraes.vigencia_al AS fecha_ingreso_imss_bienestar,
				UPPER(public.tbl_movimientos.tipo_movimiento) AS movimiento_general,
				CONCAT(public.tbl_movimientos.codigo, ' ', UPPER(public.tbl_movimientos.nombre_movimiento)) AS movimieto_especifico,
				central.tbl_plazas_empleados_hraes.fecha_movimiento AS fecha_movimiento,
				central.tbl_control_plazas_hraes.num_plaza AS num_plaza_movimiento,
				UPPER(central.cat_puesto_hraes.codigo_puesto) AS codigo_puesto,
				UPPER(central.cat_puesto_hraes.nivel) AS nivel,
				UPPER(central.cat_puesto_hraes.nombre_posicion) AS nombre_posicion,
				--CONCAT(UPPER(public.cat_tipo_contratacion_hraes.tipo_contratacion), ' ', UPPER(public.cat_subtipo_contratacion_hraes.subtipo)) AS tipo_contratacion,
				UPPER(public.cat_nivel_estudios.nivel_estudios) AS ultimo_grado,
				UPPER(public.cat_carrera_hraes.carrera) AS des_ultimo_grado,
				REPLACE(central.ctrl_estudios_hraes.cedula, ' ', '')  AS cedula,
				UPPER(public.cat_especialidad_hraes.especialidad) AS especialidad,
				REPLACE(central.ctrl_especialidad_hraes.cedula, ' ', '') AS cedula_esp,
				--UPPER(public.capacidad.capacidad) AS capacidad_dif,
				CONCAT(UPPER(public.cat_lengua.identificador), ' ',UPPER(public.cat_lengua.descripcion)) AS lengua
			FROM central.tbl_empleados_hraes
			LEFT JOIN public.cat_estado_civil
				ON public.cat_estado_civil.id_cat_estado_civil =
				central.tbl_empleados_hraes.id_cat_estado_civil
			LEFT JOIN public.cat_pais_nacimiento 
				ON public.cat_pais_nacimiento.id_cat_pais_nacimiento  =
					central.tbl_empleados_hraes.id_cat_pais_nacimiento
			LEFT JOIN public.cat_estado_nacimiento
				ON public.cat_estado_nacimiento.id_cat_estado_nacimiento =
					central.tbl_empleados_hraes.id_cat_estado_nacimiento
			LEFT JOIN central.tbl_domicilios_hraes
				ON central.tbl_domicilios_hraes.id_tbl_empleados_hraes =
					central.tbl_empleados_hraes.id_tbl_empleados_hraes
			LEFT JOIN central.ctrl_cuenta_clabe_hraes
				ON central.ctrl_cuenta_clabe_hraes.id_tbl_empleados_hraes =
					central.tbl_empleados_hraes.id_tbl_empleados_hraes
			LEFT JOIN public.cat_banco
				ON public.cat_banco.id_cat_banco =
					central.ctrl_cuenta_clabe_hraes.id_cat_banco
			LEFT JOIN central.ctrl_telefono_hraes
				ON central.ctrl_telefono_hraes.id_tbl_empleados_hraes =
					central.tbl_empleados_hraes.id_tbl_empleados_hraes
			LEFT JOIN central.ctrl_medios_contacto_hraes
				ON central.ctrl_medios_contacto_hraes.id_tbl_empleados_hraes =
					central.tbl_empleados_hraes.id_tbl_empleados_hraes
			LEFT JOIN central.ctrl_estudios_hraes 
				ON central.ctrl_estudios_hraes.id_tbl_empleados_hraes =
					central.tbl_empleados_hraes.id_tbl_empleados_hraes
			LEFT JOIN public.cat_carrera_hraes
				ON public.cat_carrera_hraes.id_cat_carrera_hraes =
					central.ctrl_estudios_hraes.id_cat_carrera_hraes
			LEFT JOIN public.cat_nivel_estudios
				ON public.cat_nivel_estudios.id_cat_nivel_estudios =
					central.ctrl_estudios_hraes.id_cat_nivel_estudios
			LEFT JOIN central.ctrl_especialidad_hraes
				ON central.ctrl_especialidad_hraes.id_tbl_empleados_hraes =
					central.tbl_empleados_hraes.id_tbl_empleados_hraes
			LEFT JOIN public.cat_especialidad_hraes
				ON public.cat_especialidad_hraes.id_cat_especialidad_hraes =
					central.ctrl_especialidad_hraes.id_cat_especialidad_hraes
			LEFT JOIN central.ctrl_adic_emp_hraes	
				ON central.ctrl_adic_emp_hraes.id_ctrl_adic_emp_hraes =
					central.tbl_empleados_hraes.id_tbl_empleados_hraes
			LEFT JOIN central.tbl_plazas_empleados_hraes
				ON central.tbl_plazas_empleados_hraes.id_tbl_empleados_hraes = 
					central.tbl_empleados_hraes.id_tbl_empleados_hraes
			LEFT JOIN central.tbl_control_plazas_hraes
				ON central.tbl_plazas_empleados_hraes.id_tbl_control_plazas_hraes =
					central.tbl_control_plazas_hraes.id_tbl_control_plazas_hraes
			LEFT JOIN central.cat_puesto_hraes
				ON central.tbl_control_plazas_hraes.id_cat_puesto_hraes = 
					central.cat_puesto_hraes.id_cat_puesto_hraes
			LEFT JOIN central.ctrl_capacidad_dif_hraes
				ON central.ctrl_capacidad_dif_hraes.id_tbl_empleados_hraes =
					central.tbl_empleados_hraes.id_tbl_empleados_hraes
			
			LEFT JOIN central.ctrl_lengua
				ON central.ctrl_lengua.id_tbl_empleados_hraes =
					central.tbl_empleados_hraes.id_tbl_empleados_hraes
			LEFT JOIN public.cat_lengua
				ON public.cat_lengua.id_cat_lengua =
					central.ctrl_lengua.id_cat_lengua
			LEFT JOIN public.tbl_movimientos
				ON public.tbl_movimientos.id_tbl_movimientos =
					central.tbl_plazas_empleados_hraes.id_tbl_movimientos
					
			WHERE (central.ctrl_estudios_hraes.id_ctrl_estudios_hraes = 
				(SELECT MAX(central.ctrl_estudios_hraes.id_ctrl_estudios_hraes) 
				FROM central.ctrl_estudios_hraes
				WHERE central.ctrl_estudios_hraes.id_tbl_empleados_hraes 
					= central.tbl_empleados_hraes.id_tbl_empleados_hraes)
				OR central.ctrl_estudios_hraes.id_ctrl_estudios_hraes IS NULL)

			AND (central.ctrl_especialidad_hraes.id_ctrl_especialidad_hraes = 
				(SELECT MAX(central.ctrl_especialidad_hraes.id_ctrl_especialidad_hraes) 
				FROM central.ctrl_especialidad_hraes
				WHERE central.ctrl_especialidad_hraes.id_tbl_empleados_hraes 
					= central.tbl_empleados_hraes.id_tbl_empleados_hraes)
				OR central.ctrl_especialidad_hraes.id_ctrl_especialidad_hraes IS NULL)
				
			AND (central.tbl_domicilios_hraes.id_tbl_domicilios_hraes = 
				(SELECT MAX(central.tbl_domicilios_hraes.id_tbl_domicilios_hraes) 
				FROM central.tbl_domicilios_hraes
				WHERE central.tbl_domicilios_hraes.id_tbl_empleados_hraes 
					= central.tbl_empleados_hraes.id_tbl_empleados_hraes)
				OR central.tbl_domicilios_hraes.id_tbl_domicilios_hraes IS NULL)
				
			AND (central.ctrl_adic_emp_hraes.id_ctrl_adic_emp_hraes = 
				(SELECT MAX(central.ctrl_adic_emp_hraes.id_ctrl_adic_emp_hraes) 
				FROM central.ctrl_adic_emp_hraes
				WHERE central.ctrl_adic_emp_hraes.id_tbl_empleados_hraes 
					= central.tbl_empleados_hraes.id_tbl_empleados_hraes)
				OR central.ctrl_adic_emp_hraes.id_ctrl_adic_emp_hraes IS NULL)

			AND (central.ctrl_capacidad_dif_hraes.id_ctrl_capacidad_dif_hraes = 
				(SELECT MAX(central.ctrl_capacidad_dif_hraes.id_ctrl_capacidad_dif_hraes) 
				FROM central.ctrl_capacidad_dif_hraes
				WHERE central.ctrl_capacidad_dif_hraes.id_tbl_empleados_hraes 
					= central.tbl_empleados_hraes.id_tbl_empleados_hraes)
				OR central.ctrl_capacidad_dif_hraes.id_ctrl_capacidad_dif_hraes IS NULL)
				
			AND (central.ctrl_lengua.id_ctrl_lengua = 
				(SELECT MAX(central.ctrl_lengua.id_ctrl_lengua) 
				FROM central.ctrl_lengua
				WHERE central.ctrl_lengua.id_tbl_empleados_hraes 
					= central.tbl_empleados_hraes.id_tbl_empleados_hraes)
				OR central.ctrl_lengua.id_ctrl_lengua IS NULL)

			AND (central.tbl_plazas_empleados_hraes.id_tbl_plazas_empleados_hraes = 
				(SELECT MAX(central.tbl_plazas_empleados_hraes.id_tbl_plazas_empleados_hraes) 
				FROM central.tbl_plazas_empleados_hraes
				WHERE central.tbl_plazas_empleados_hraes.id_tbl_empleados_hraes 
					= central.tbl_empleados_hraes.id_tbl_empleados_hraes)
				OR central.tbl_plazas_empleados_hraes.id_tbl_plazas_empleados_hraes IS NULL)
				
			ORDER BY central.tbl_empleados_hraes.rfc ASC");
		return $query;
	}
}

