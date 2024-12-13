var valorInicial_lg = 1;
var idtable_lg = document.getElementById('idtable_lg');
var buscar_lg = document.getElementById("buscar_lg");

function siguienteValor_lg(){
    valorInicial_lg++;
    idtable_lg.textContent = valorInicial_lg;
    buscarLengua();
}

function anteriorValor_lg(){
    valorInicial_lg--;
    if(valorInicial_lg < 1){
        valorInicial_lg = 1;
    }
    idtable_lg.textContent = valorInicial_lg;
    buscarLengua();
}

function iniciarBusqueda_lg(){
    let valorInicialAux = valorInicial_lg;
    valorInicialAux --;
    let valoroff = valorInicialAux * 3;
    return valoroff;
}
