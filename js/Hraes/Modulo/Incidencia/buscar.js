var valorInicial_ins = 1;
var idtable_ins = document.getElementById('idtable_ins');
var buscar_ins = document.getElementById("buscar_ins");

function siguienteValor_ins(){
    valorInicial_ins++;
    idtable_ins.textContent = valorInicial_ins;
    buscarIncidencia();
}

function anteriorValor_ins(){
    valorInicial_ins--;
    if(valorInicial_ins < 1){
        valorInicial_ins = 1;
    }
    idtable_ins.textContent = valorInicial_ins;
    buscarIncidencia();
}

function iniciarBusqueda_ins(){
    let valorInicialAux = valorInicial_ins;
    valorInicialAux --;
    let valoroff = valorInicialAux * 3;
    return valoroff;
}
