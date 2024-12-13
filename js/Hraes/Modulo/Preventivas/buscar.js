var valorInicial_pv = 1;
var idtable_pv = document.getElementById('idtable_pv');
var buscar_pv = document.getElementById("buscar_pv");

function siguienteValor_pv() {
    valorInicial_pv++;
    idtable_pv.textContent = valorInicial_pv;
    buscarPreventivas();
}

function anteriorValor_pv() {
    valorInicial_pv--;
    if (valorInicial_pv < 1) {
        valorInicial_pv = 1;
    }
    idtable_pv.textContent = valorInicial_pv;
    buscarPreventivas();
}

function iniciarBusqueda_pv() {
    let valorInicialAux = valorInicial_pv;
    valorInicialAux--;
    let valoroff = valorInicialAux * 3;
    return valoroff;
}
