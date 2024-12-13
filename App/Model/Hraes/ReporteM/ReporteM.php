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
				public.tbl_empleados_hraes.id_tbl_empleados_hraes AS no_,
				public.ctrl_adic_emp_hraes.fecha_expedicion AS fecha_expedicion,
				UPPER(public.tbl_empleados_hraes.rfc) AS rfc,
				UPPER(public.tbl_empleados_hraes.curp) AS curp,
				UPPER(public.tbl_empleados_hraes.primer_apellido) AS apellido_paterno,
				UPPER(public.tbl_empleados_hraes.segundo_apellido) AS apellido_materno,
				UPPER(public.tbl_empleados_hraes.nombre) AS nombre,
				UPPER(public.tbl_empleados_hraes.num_empleado) AS num_empleado,
				UPPER(public.tbl_empleados_hraes.nacionalidad) AS nacionalidad,
				public.tbl_empleados_hraes.nss AS numero_seguro_social,
				UPPER(public.tbl_domicilios_hraes.calle1) AS calle,
				UPPER(public.tbl_domicilios_hraes.num_exterior1) AS num_exterior,
				UPPER(public.tbl_domicilios_hraes.num_interior1) AS num_interior,
				UPPER(public.tbl_domicilios_hraes.colonia1) AS colonia,
				UPPER(public.tbl_domicilios_hraes.codigo_postal1) AS codigo_postal,
				UPPER(public.tbl_domicilios_hraes.codigo_postal2) AS codigo_postal_fiscal,
				UPPER(public.tbl_domicilios_hraes.municipio1) AS municipio,
				UPPER(public.tbl_domicilios_hraes.entidad1) AS entidad,
				public.ctrl_telefono_hraes.telefono AS telefono,
				public.ctrl_telefono_hraes.movil AS movil,
				public.ctrl_medios_contacto_hraes.correo_electronico AS correo,
				public.ctrl_cuenta_clabe_hraes.clabe AS clabe,
				UPPER(public.cat_banco.nombre) AS banco,
				SUBSTRING(public.tbl_empleados_hraes.curp,11,1) AS genero,
				UPPER(public.cat_estado_civil.estado_civil) AS estado_civil,
				CONCAT(
				CASE WHEN SUBSTRING (public.tbl_empleados_hraes.curp,5,2) > '24' THEN 
						CONCAT('19',SUBSTRING(public.tbl_empleados_hraes.curp,5,2)) 
						ELSE CONCAT('20',SUBSTRING(public.tbl_empleados_hraes.curp,5,2))  END
				,'/',
				SUBSTRING (public.tbl_empleados_hraes.curp,7,2)
				,'/',
				SUBSTRING (public.tbl_empleados_hraes.curp,9,2)	
				) AS fecha_nacimiento,
				UPPER(public.cat_estado_nacimiento.nombre) AS estado_nacimiento,
				UPPER(public.cat_pais_nacimiento.nombre) AS pais_nacimiento,
				DATE_PART('year', AGE(NOW(), 
					TO_DATE(
						CONCAT(
							CASE WHEN SUBSTRING(public.tbl_empleados_hraes.curp, 5, 2) > '24' THEN 
									CONCAT('19', SUBSTRING(public.tbl_empleados_hraes.curp, 5, 2)) 
								ELSE CONCAT('20', SUBSTRING(public.tbl_empleados_hraes.curp, 5, 2)) 
							END,
							'/',
							SUBSTRING(public.tbl_empleados_hraes.curp, 7, 2),
							'/',
							SUBSTRING(public.tbl_empleados_hraes.curp, 9, 2)
						),
						'YYYY/MM/DD' 
					)
				)) AS edad,
				public.ctrl_adic_emp_hraes.fecha_ingreso_gob_fed AS fecha_ingreso_gob_fed,
				public.ctrl_adic_emp_hraes.vigencia_al AS fecha_ingreso_imss_bienestar,
				UPPER(public.tbl_movimientos.tipo_movimiento) AS movimiento_general,
				CONCAT(public.tbl_movimientos.codigo, ' ', UPPER(public.tbl_movimientos.nombre_movimiento)) AS movimieto_especifico,
				public.tbl_plazas_empleados_hraes.fecha_movimiento AS fecha_movimiento,
				public.tbl_control_plazas_hraes.num_plaza AS num_plaza_movimiento,
				UPPER(public.cat_puesto_hraes.codigo_puesto) AS codigo_puesto,
				UPPER(public.cat_puesto_hraes.nivel) AS nivel,
				UPPER(public.cat_puesto_hraes.nombre_posicion) AS nombre_posicion,
				CONCAT(UPPER(public.cat_tipo_contratacion_hraes.tipo_contratacion), ' ', UPPER(public.cat_subtipo_contratacion_hraes.subtipo)) AS tipo_contratacion,
				UPPER(public.cat_nivel_estudios.nivel_estudios) AS ultimo_grado,
				UPPER(public.cat_carrera_hraes.carrera) AS des_ultimo_grado,
				REPLACE(public.ctrl_estudios_hraes.cedula, ' ', '')  AS cedula,
				UPPER(public.cat_especialidad_hraes.especialidad) AS especialidad,
				REPLACE(public.ctrl_especialidad_hraes.cedula, ' ', '') AS cedula_esp,
				UPPER(public.capacidad.capacidad) AS capacidad_dif,
				CONCAT(UPPER(public.cat_lengua.identificador), ' ',UPPER(public.cat_lengua.descripcion)) AS lengua
			FROM public.tbl_empleados_hraes
			LEFT JOIN public.cat_estado_civil
				ON public.cat_estado_civil.id_cat_estado_civil =
				public.tbl_empleados_hraes.id_cat_estado_civil
			LEFT JOIN public.cat_pais_nacimiento 
				ON public.cat_pais_nacimiento.id_cat_pais_nacimiento  =
					public.tbl_empleados_hraes.id_cat_pais_nacimiento
			LEFT JOIN public.cat_estado_nacimiento
				ON public.cat_estado_nacimiento.id_cat_estado_nacimiento =
					public.tbl_empleados_hraes.id_cat_estado_nacimiento
			LEFT JOIN public.tbl_domicilios_hraes
				ON public.tbl_domicilios_hraes.id_tbl_empleados_hraes =
					public.tbl_empleados_hraes.id_tbl_empleados_hraes
			LEFT JOIN public.ctrl_cuenta_clabe_hraes
				ON public.ctrl_cuenta_clabe_hraes.id_tbl_empleados_hraes =
					public.tbl_empleados_hraes.id_tbl_empleados_hraes
			LEFT JOIN public.cat_banco
				ON public.cat_banco.id_cat_banco =
					public.ctrl_cuenta_clabe_hraes.id_cat_banco
			LEFT JOIN public.ctrl_telefono_hraes
				ON public.ctrl_telefono_hraes.id_tbl_empleados_hraes =
					public.tbl_empleados_hraes.id_tbl_empleados_hraes
			LEFT JOIN public.ctrl_medios_contacto_hraes
				ON public.ctrl_medios_contacto_hraes.id_tbl_empleados_hraes =
					public.tbl_empleados_hraes.id_tbl_empleados_hraes
			LEFT JOIN public.ctrl_estudios_hraes 
				ON public.ctrl_estudios_hraes.id_tbl_empleados_hraes =
					public.tbl_empleados_hraes.id_tbl_empleados_hraes
			LEFT JOIN public.cat_carrera_hraes
				ON public.cat_carrera_hraes.id_cat_carrera_hraes =
					public.ctrl_estudios_hraes.id_cat_carrera_hraes
			LEFT JOIN public.cat_nivel_estudios
				ON public.cat_nivel_estudios.id_cat_nivel_estudios =
					public.ctrl_estudios_hraes.id_cat_nivel_estudios
			LEFT JOIN public.ctrl_especialidad_hraes
				ON public.ctrl_especialidad_hraes.id_tbl_empleados_hraes =
					public.tbl_empleados_hraes.id_tbl_empleados_hraes
			LEFT JOIN public.cat_especialidad_hraes
				ON public.cat_especialidad_hraes.id_cat_especialidad_hraes =
					public.ctrl_especialidad_hraes.id_cat_especialidad_hraes
			LEFT JOIN public.ctrl_adic_emp_hraes	
				ON public.ctrl_adic_emp_hraes.id_ctrl_adic_emp_hraes =
					public.tbl_empleados_hraes.id_tbl_empleados_hraes
			LEFT JOIN public.tbl_plazas_empleados_hraes
				ON public.tbl_plazas_empleados_hraes.id_tbl_empleados_hraes = 
					public.tbl_empleados_hraes.id_tbl_empleados_hraes
			LEFT JOIN public.tbl_control_plazas_hraes
				ON public.tbl_plazas_empleados_hraes.id_tbl_control_plazas_hraes =
					public.tbl_control_plazas_hraes.id_tbl_control_plazas_hraes
			LEFT JOIN public.cat_puesto_hraes
				ON public.tbl_control_plazas_hraes.id_cat_puesto_hraes = 
					public.cat_puesto_hraes.id_cat_puesto_hraes
			LEFT JOIN public.cat_tipo_subtipo_contratacion_hraes
				ON public.cat_tipo_subtipo_contratacion_hraes.id_cat_tipo_subtipo_contratacion_hraes =
					public.tbl_control_plazas_hraes.id_cat_tipo_subtipo_contratacion_hraes
			LEFT JOIN public.cat_tipo_contratacion_hraes
				ON public.cat_tipo_contratacion_hraes.id_cat_tipo_contratacion_hraes =
					public.cat_tipo_subtipo_contratacion_hraes.id_cat_tipo_contratacion_hraes
			LEFT JOIN public.cat_subtipo_contratacion_hraes	
				ON public.cat_subtipo_contratacion_hraes.id_cat_subtipo_contratacion_hraes =
					public.cat_tipo_subtipo_contratacion_hraes.id_cat_subtipo_contratacion_hraes
			LEFT JOIN public.ctrl_capacidad_dif_hraes
				ON public.ctrl_capacidad_dif_hraes.id_tbl_empleados_hraes =
					public.tbl_empleados_hraes.id_tbl_empleados_hraes
			LEFT JOIN public.capacidad
				ON public.capacidad.id_capacidad =
					public.ctrl_capacidad_dif_hraes.id_cat_capacidad_dif_hraes
			LEFT JOIN public.ctrl_lengua
				ON public.ctrl_lengua.id_tbl_empleados_hraes =
					public.tbl_empleados_hraes.id_tbl_empleados_hraes
			LEFT JOIN public.cat_lengua
				ON public.cat_lengua.id_cat_lengua =
					public.ctrl_lengua.id_cat_lengua
			LEFT JOIN public.tbl_movimientos
				ON public.tbl_movimientos.id_tbl_movimientos =
					public.tbl_plazas_empleados_hraes.id_tbl_movimientos
					
			WHERE (public.ctrl_estudios_hraes.id_ctrl_estudios_hraes = 
				(SELECT MAX(public.ctrl_estudios_hraes.id_ctrl_estudios_hraes) 
				FROM public.ctrl_estudios_hraes
				WHERE public.ctrl_estudios_hraes.id_tbl_empleados_hraes 
					= public.tbl_empleados_hraes.id_tbl_empleados_hraes)
				OR public.ctrl_estudios_hraes.id_ctrl_estudios_hraes IS NULL)

			AND (public.ctrl_especialidad_hraes.id_ctrl_especialidad_hraes = 
				(SELECT MAX(public.ctrl_especialidad_hraes.id_ctrl_especialidad_hraes) 
				FROM public.ctrl_especialidad_hraes
				WHERE public.ctrl_especialidad_hraes.id_tbl_empleados_hraes 
					= public.tbl_empleados_hraes.id_tbl_empleados_hraes)
				OR public.ctrl_especialidad_hraes.id_ctrl_especialidad_hraes IS NULL)
				
			AND (public.tbl_domicilios_hraes.id_tbl_domicilios_hraes = 
				(SELECT MAX(public.tbl_domicilios_hraes.id_tbl_domicilios_hraes) 
				FROM public.tbl_domicilios_hraes
				WHERE public.tbl_domicilios_hraes.id_tbl_empleados_hraes 
					= public.tbl_empleados_hraes.id_tbl_empleados_hraes)
				OR public.tbl_domicilios_hraes.id_tbl_domicilios_hraes IS NULL)
				
			AND (public.ctrl_adic_emp_hraes.id_ctrl_adic_emp_hraes = 
				(SELECT MAX(public.ctrl_adic_emp_hraes.id_ctrl_adic_emp_hraes) 
				FROM public.ctrl_adic_emp_hraes
				WHERE public.ctrl_adic_emp_hraes.id_tbl_empleados_hraes 
					= public.tbl_empleados_hraes.id_tbl_empleados_hraes)
				OR public.ctrl_adic_emp_hraes.id_ctrl_adic_emp_hraes IS NULL)

			AND (public.ctrl_capacidad_dif_hraes.id_ctrl_capacidad_dif_hraes = 
				(SELECT MAX(public.ctrl_capacidad_dif_hraes.id_ctrl_capacidad_dif_hraes) 
				FROM public.ctrl_capacidad_dif_hraes
				WHERE public.ctrl_capacidad_dif_hraes.id_tbl_empleados_hraes 
					= public.tbl_empleados_hraes.id_tbl_empleados_hraes)
				OR public.ctrl_capacidad_dif_hraes.id_ctrl_capacidad_dif_hraes IS NULL)
				
			AND (public.ctrl_lengua.id_ctrl_lengua = 
				(SELECT MAX(public.ctrl_lengua.id_ctrl_lengua) 
				FROM public.ctrl_lengua
				WHERE public.ctrl_lengua.id_tbl_empleados_hraes 
					= public.tbl_empleados_hraes.id_tbl_empleados_hraes)
				OR public.ctrl_lengua.id_ctrl_lengua IS NULL)

			AND (public.tbl_plazas_empleados_hraes.id_tbl_plazas_empleados_hraes = 
				(SELECT MAX(public.tbl_plazas_empleados_hraes.id_tbl_plazas_empleados_hraes) 
				FROM public.tbl_plazas_empleados_hraes
				WHERE public.tbl_plazas_empleados_hraes.id_tbl_empleados_hraes 
					= public.tbl_empleados_hraes.id_tbl_empleados_hraes)
				OR public.tbl_plazas_empleados_hraes.id_tbl_plazas_empleados_hraes IS NULL)
				
			ORDER BY public.tbl_empleados_hraes.rfc ASC");
		return $query;
	}
}

