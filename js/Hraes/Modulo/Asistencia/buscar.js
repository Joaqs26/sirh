var valorInicial_ss = 1;
var idtable_ass = document.getElementById('idtable_ass');
var buscar_ass = document.getElementById("buscar_ass");

function siguienteValor_ss(){
    valorInicial_ss++;
    idtable_ass.textContent = valorInicial_ss;
    buscarAsistencia();
}

function anteriorValor_ss(){
    valorInicial_ss--;
    if(valorInicial_ss < 1){
        valorInicial_ss = 1;
    }
    idtable_ass.textContent = valorInicial_ss;
    buscarAsistencia();
}

function iniciarBusqueda_ss(){
    let valorInicialAux = valorInicial_ss;
    valorInicialAux --;
    let valoroff = valorInicialAux * 3;
    return valoroff;
}
