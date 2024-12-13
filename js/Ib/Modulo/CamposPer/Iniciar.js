var id_tbl_empleados_hraes = document.getElementById('id_tbl_empleados_hraes').value;

function iniciarCampos(){
    camposPersonDetalles(id_tbl_empleados_hraes);
}

function camposPersonDetalles(id_object){
    $.post("../../../../App/Controllers/Central/CamposPerC/DetallesC.php", {
        id_object: id_object
    },
        function (data) {
            var jsonData = JSON.parse(data);
            var entity = jsonData.response; 

            
            //$("#id_tbl_empleados_hraes").val(id_object);
            $("#id_ctrl_campos_pers_hraes").val(entity.id_ctrl_campos_pers_hraes);
            
            $("#porcentaje_ahorro_s").val(entity.porcentaje_ahorro_s);
            $("#dias_medio_sueldo").val(entity.dias_medio_sueldo);
            $("#dias_sin_sueldo").val(entity.dias_sin_sueldo);
            $("#reintegro_faltas_retardos").val(entity.reintegro_faltas_retardos);
            $("#porcentaje_svi").val(entity.porcentaje_svi);
            $("#importe_festivo").val(entity.importe_festivo);
            $("#importe_horas_ex").val(entity.importe_horas_ex);
            $("#importe_prima_dominical").val(entity.importe_prima_dominical);
            $("#importe_descuentos_indebidos").val(entity.importe_descuentos_indebidos);
            $("#importe_recuperacion_pagos_indebidos").val(entity.importe_recuperacion_pagos_indebidos);
            $("#dias_sansion_adma").val(entity.dias_sansion_adma);
            $("#regimen_pen").val(entity.regimen_pen);
            $("#quinquenio").val(entity.quinquenio);
            $("#num_hijos").val(entity.num_hijos);
            $("#num_dias_jornada_dominical").val(entity.num_dias_jornada_dominical);
            $("#num_dias_guardia_festiva").val(entity.num_dias_guardia_festiva);
            $("#aplicar_juguetes").val(entity.aplicar_juguetes);
            $("#apoyo_titulacion").val(entity.apoyo_titulacion);
            $("#licencia_manejo").val(entity.licencia_manejo);
        }
    );
    //$("#agregar_editar_campos_personalizados").modal("show");
}

function agregarEditarByDbCamposPersonalizados() {
    //var id_tbl_empleados_hraes = $("#id_tbl_empleados_hraes").val();
    var id_ctrl_campos_pers_hraes = $("#id_ctrl_campos_pers_hraes").val();

    var porcentaje_ahorro_s = $("#porcentaje_ahorro_s").val();
    var dias_medio_sueldo = $("#dias_medio_sueldo").val();
    var dias_sin_sueldo = $("#dias_sin_sueldo").val();
    var reintegro_faltas_retardos = $("#reintegro_faltas_retardos").val();
    var porcentaje_svi = $("#porcentaje_svi").val();
    var importe_festivo = $("#importe_festivo").val();
    var importe_horas_ex = $("#importe_horas_ex").val();
    var importe_prima_dominical = $("#importe_prima_dominical").val();
    var importe_descuentos_indebidos = $("#importe_descuentos_indebidos").val();
    var importe_recuperacion_pagos_indebidos = $("#importe_recuperacion_pagos_indebidos").val();
    var dias_sansion_adma = $("#dias_sansion_adma").val();
    var regimen_pen = $("#regimen_pen").val();
    var quinquenio = $("#quinquenio").val();
    var num_hijos = $("#num_hijos").val();
    var num_dias_jornada_dominical = $("#num_dias_jornada_dominical").val();
    var num_dias_guardia_festiva = $("#num_dias_guardia_festiva").val();
    var aplicar_juguetes = $("#aplicar_juguetes").val();
    var apoyo_titulacion = $("#apoyo_titulacion").val();
    var licencia_manejo = $("#licencia_manejo").val();

    $.post("../../../../App/Controllers/Central/CamposPerC/AgregarEditarC.php", {
        id_tbl_empleados_hraes: id_tbl_empleados_hraes,
        id_ctrl_campos_pers_hraes: id_ctrl_campos_pers_hraes,
        porcentaje_ahorro_s: porcentaje_ahorro_s,
        dias_medio_sueldo: dias_medio_sueldo,
        dias_sin_sueldo: dias_sin_sueldo,
        reintegro_faltas_retardos: reintegro_faltas_retardos,
        porcentaje_svi: porcentaje_svi,
        importe_festivo: importe_festivo,
        importe_horas_ex: importe_horas_ex,
        importe_prima_dominical: importe_prima_dominical,
        importe_descuentos_indebidos: importe_descuentos_indebidos,
        importe_recuperacion_pagos_indebidos: importe_recuperacion_pagos_indebidos,
        dias_sansion_adma: dias_sansion_adma,
        regimen_pen: regimen_pen,
        quinquenio: quinquenio,
        num_hijos: num_hijos,
        num_dias_jornada_dominical: num_dias_jornada_dominical,
        num_dias_guardia_festiva: num_dias_guardia_festiva,
        aplicar_juguetes: aplicar_juguetes,
        apoyo_titulacion: apoyo_titulacion,
        licencia_manejo: licencia_manejo,

    },
        function (data) {
            if (data == 'edit'){
                mensajeExito('Información modificada con éxito');
            } else if (data == 'add') {
                mensajeExito('Información agregada con éxito');  
            } else {
                mensajeError(data);
            }
            //$("#agregar_editar_campos_personalizados").modal("hide");
            iniciarCampos();
        }
    );
}