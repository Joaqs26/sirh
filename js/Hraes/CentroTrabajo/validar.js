function validarCentro() {

    let nombre = document.getElementById('nombre').value.trim();
    let clave_centro_trabajo = document.getElementById('clave_centro_trabajo').value.trim();
    let colonia = document.getElementById('colonia').value.trim();
    let num_exterior = document.getElementById('num_exterior').value.trim();
    let num_interior = document.getElementById('num_interior').value.trim();
    let latitud = document.getElementById('latitud').value.trim();
    let longitud = document.getElementById('longitud').value.trim();
    let codigo_postal = document.getElementById('codigo_postal').value.trim();
    let pais = document.getElementById('pais').value.trim();
    let id_cat_entidad = document.getElementById('id_cat_entidad').value.trim();
    let id_cat_zona_economica = document.getElementById('id_cat_zona_economica').value.trim();
    let id_cat_region = document.getElementById('id_cat_region').value.trim();
    let id_estatus_centro = document.getElementById('id_estatus_centro').value.trim();

    if (validarData(nombre, 'Nombre') &&
        validarData(clave_centro_trabajo, 'Clave') &&
        validarData(colonia, 'Colonia') &&
        validarData(num_exterior, 'Número exterior') &&
        validarData(latitud, 'Latitud') &&
        validarData(longitud, 'Longitud') &&
        validarData(codigo_postal, 'Código póstal') &&
        validarData(pais, 'País') &&
        validarData(id_cat_entidad, 'Entidad') &&
        validarData(id_cat_zona_economica, 'Zona económica ') &&
        validarData(id_cat_region, 'Región') &&
        validarData(id_estatus_centro, 'Estatus')
    ) {
        validarInfo(codigo_postal, clave_centro_trabajo);
    }
}

function validarInfo(codigo_postal, clave_centro_trabajo) {
    $.post("../../../../App/Controllers/Hrae/CentroTrabajoC/ValidateC.php", {
        codigo_postal: codigo_postal,
        clave_centro_trabajo: clave_centro_trabajo,

    },
        function (data) {
            console.log(data);
            let jsonData = JSON.parse(data);
            let bool = jsonData.bool;
            let message = jsonData.message;

            if (bool) {
                agregarEditarByDb();
            } else {
                notyf.error(message);
            }
        }
    );
}

