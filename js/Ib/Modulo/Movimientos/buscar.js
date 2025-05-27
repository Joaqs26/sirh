var valorInicial_mv = 1;
var idtable_mv = document.getElementById('idtable_mv');
var buscar_mv = document.getElementById("buscar_mv_text");

function siguienteValor_mv(){
    valorInicial_mv++;
    idtable_mv.textContent = valorInicial_mv;
    buscarMovimiento();
}

function anteriorValor_mv(){
    valorInicial_mv--;
    if(valorInicial_mv < 1){
        valorInicial_mv = 1;
    }
    idtable_mv.textContent = valorInicial_mv;
    buscarMovimiento();
}

function iniciarBusqueda_mv(){
    let valorInicialAux = valorInicial_mv;
    valorInicialAux --;
    let valoroff = valorInicialAux * 5;
    return valoroff;
}
