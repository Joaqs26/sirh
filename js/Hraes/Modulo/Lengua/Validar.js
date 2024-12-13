function validarLEngua(){
    let id_cat_lengua = document.getElementById('id_cat_lengua').value.trim();

    if (validarData(id_cat_lengua,'Seleccione una lengua') 
    ){
        guardarLengua();
    }
}
                            

