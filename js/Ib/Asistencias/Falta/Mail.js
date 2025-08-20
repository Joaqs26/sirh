function ocultarModalEmail() {
    const html = $('#correoContenido').html(); // Obtener HTML con formato

    const blob = new Blob([html], { type: 'text/html' });
    const clipboardItem = new ClipboardItem({ 'text/html': blob });

    navigator.clipboard.write([clipboardItem])
        .then(() => {
            notyf.success('Contenido con formato copiado');
            $("#modal_mail").modal("hide");
        })
        .catch(err => {
            notyf.error('Error al copiar con formato');
            console.error('Error al copiar con formato:', err);
        });
}

function showMail(id) {
    $("#modal_mail").modal("show");
    console.log(id);
}

