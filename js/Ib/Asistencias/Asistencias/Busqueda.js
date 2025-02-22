var valorInicial_ass = 1;
var idtable_ass = document.getElementById('idtable_ass');
var buscar_asistencia = document.getElementById("buscar_asistencia");
//var buscar = document.getElementById("buscarUsuario").value.trim();


function siguienteValor_ass(){
    valorInicial_ass++;
    idtable_ass.textContent = valorInicial_ass;
    buscarAsistencia();
}

function anteriorValor_ass(){
    valorInicial_ass--;
    if(valorInicial_ass < 1){
        valorInicial_ass = 1;
    }
    idtable_ass.textContent = valorInicial_ass;
    buscarAsistencia();
}

function iniciarBusqueda(){
    let valorInicial_assAux = valorInicial_ass;
    valorInicial_assAux --;
    let valoroff = valorInicial_assAux * 5;
    return valoroff;
}

///LA FUNCION RETORNA EL VALOR SIN ACENTOS, ESPACIOS EN BLANCA O CARACTERES ESPECIALES
function clearElement(value){
    return value.value.trim().toUpperCase().normalize('NFD').replace(/[\u0300-\u036f]/g,"");
}

///LA FUNCION RETORNA EL TOTAL DE CARACTERES DEL VALOR

