var valorInicial = 1;
var textValor = document.getElementById('idEmpleadotable');
var buscar = document.getElementById("buscar");

function siguienteValor(){
    valorInicial++;
    document.getElementById('idEmpleadotable').textContent = valorInicial;
    buscarEmpleado();
}

function anteriorValor(){
    valorInicial--;
    if (valorInicial < 1) valorInicial = 1;
    document.getElementById('idEmpleadotable').textContent = valorInicial;
    buscarEmpleado();
}

function iniciarBusqueda(){
    let valorInicialAux = valorInicial;
    valorInicialAux --;
    let valoroff = valorInicialAux * 6;
    return valoroff;
}

///LA FUNCION RETORNA EL VALOR SIN ACENTOS, ESPACIOS EN BLANCA O CARACTERES ESPECIALES
function clearElement(value){
    return value.value.trim().toUpperCase().normalize('NFD').replace(/[\u0300-\u036f]/g,"");
}

///LA FUNCION RETORNA EL TOTAL DE CARACTERES DEL VALOR
function lengthValue(value){
    return value.length;
}