<!-- MODALE_UPLOAD_FALTA -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true" id="modal_mail">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header background-modal">
                <div class="container">
                    <div class="row">
                        <div class="col-2">
                            <img src="../../../../assets/sirh/logo_carga_masiva.png" style="max-width: 100%;">
                        </div>
                        <div class="col-10">
                            <h1 style="color:white; font-family: 'Montserrat'; font-size: 40px;">Plantilla para correo
                                electrónico</h1>
                            <p style="color:white;">Copia el contenido de la siguiente plantilla en el correo que deseas
                                enviar. Esta plantilla corresponde a las faltas registradas durante la quincena en la
                                que se generó la incidencia.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div id="correoContenido">
                <div class="div-spacing"></div>
                <div class="card-body"
                    style="font-family: Arial, sans-serif; font-size: 16px; line-height: 1.6; text-align: justify; padding: 30px;">

                    <p><strong>Referente a la circular <span
                                style="font-weight:bold;">UAF-CRH-6065-2024</span>,</strong>
                        con fecha de 19 de diciembre de 2024, mediante la cual se informa sobre el registro en
                        biométrico al
                        personal IMSS-BIENESTAR adscrito a oficinas centrales; me permito informarle lo siguiente:</p>

                    <p>
                    <p>
                      Con la finalidad de esclarecer su situación respecto a las incidencias de las que se tienen
                      registro en la asistencia de su jornada laboral en la <strong>primera quincena de julio</strong>; para
                      cualquier aclaración, deberá presentarse
                      <span id="selector-fechas" class="selector-fechas">
                        <input type="date" id="fecha1" class="date-input" aria-label="Fecha 1">
                        <span id="conector" class="mx-1 d-none">y</span>
                        <input type="date" id="fecha2" class="date-input" aria-label="Fecha 2 (opcional)">
                        <span id="previewFechas" class="ml-2 text-muted">(elige una o dos fechas)</span>
                      </span>;
                      en la <strong>Oficina de Control de Asistencia</strong>, ubicada en Gustavo E. Campa No. 54, Colonia
                      Guadalupe Inn, piso 3, a un costado de las escaleras de emergencia; en un horario de 9:00 a
                      15:00 y de 17:00 a 19:00 horas. Cabe mencionar que <strong>son las únicas fechas para recepción y
                      atención de las mismas</strong>.
                    </p>


<!-- Previsualización (opcional) 
<div id="previewFechas" class="text-muted mt-2">
  Se copiará: <strong>—</strong>
</div>-->


                    <p>Es importante que acuda con las incidencias que <strong>se hayan entregado en tiempo y
                            forma</strong>
                        que justifiquen las omisiones que obran en su registro como se detallan a continuación:</p>

                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
                            <thead>
                                <tr style="background-color: #28a745;">
                                    <th style="color: white; font-weight: bold; padding: 10px; border: 1px solid #ddd;">
                                        PUESTO</th>
                                    <th style="color: white; font-weight: bold; padding: 10px; border: 1px solid #ddd;">
                                        NOMBRE</th>
                                    <th style="color: white; font-weight: bold; padding: 10px; border: 1px solid #ddd;">
                                        FECHA</th>
                                    <th style="color: white; font-weight: bold; padding: 10px; border: 1px solid #ddd;">
                                        HORA
                                    </th>
                                    <th style="color: white; font-weight: bold; padding: 10px; border: 1px solid #ddd;">
                                        ESTATUS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Aquí van las filas dinámicamente o estáticas -->
                                <tr>
                                    <td style="padding: 10px; border: 1px solid #ddd;">Ejemplo</td>
                                    <td style="padding: 10px; border: 1px solid #ddd;">Juan Pérez</td>
                                    <td style="padding: 10px; border: 1px solid #ddd;">07/08/2025</td>
                                    <td style="padding: 10px; border: 1px solid #ddd;">09:10</td>
                                    <td style="padding: 10px; border: 1px solid #ddd;">Sin justificar</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div style="text-align: center; margin-top: 40px;">
                        <p style="margin: 0; font-weight: bold;">A T E N T A M E N T E</p>
                        <br>
                        <br>
                        <br>
                        <p style="margin: 0; font-weight: bold;">CONTROL DE ASISTENCIA</p>
                    </div>
                </div>
                <br>

                <div class="div-spacing"></div>
                <div class="modal-footer" style="justify-content: center;">
                    <button onclick="ocultarModalEmail();" type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fa fa-check"></i> Copiar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
  // --- utilidades de fecha en español ---
  const MESES_ES = ['enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre'];
  function getFecha(id){
    const v = document.getElementById(id)?.value;
    if(!v) return null;
    const [y,m,d] = v.split('-').map(Number);
    if(!y||!m||!d) return null;
    return new Date(y, m-1, d);
  }
  function fmtFecha(d){
    return `${d.getDate()} de ${MESES_ES[d.getMonth()]} de ${d.getFullYear()}`;
  }
  function construirFraseFechas(){
    let f1 = getFecha('fecha1');
    let f2 = getFecha('fecha2');

    if(!f1 && !f2) return 'los días <strong>—</strong>';

    // ordena si el usuario puso al revés
    if(f1 && f2 && f2 < f1){ const t = f1; f1 = f2; f2 = t; }

    if(f1 && (!f2 || f1.getTime()===f2.getTime())){
      return `el día <strong>${fmtFecha(f1)}</strong>`;
    }
    if(f1 && f2){
      const mismoMesYAño = f1.getMonth()===f2.getMonth() && f1.getFullYear()===f2.getFullYear();
      if(mismoMesYAño){
        return `los días <strong>${f1.getDate()} y ${f2.getDate()} de ${MESES_ES[f1.getMonth()]} de ${f1.getFullYear()}</strong>`;
      } else {
        return `los días <strong>${fmtFecha(f1)} y ${fmtFecha(f2)}</strong>`;
      }
    }
    return ;
  }

  // opcional: mantener la vista previa actualizada
  function actualizarPreview(){
    const prev = document.getElementById('previewFechas');
    if(prev) prev.innerHTML =  construirFraseFechas();
  }
  ['fecha1','fecha2'].forEach(id=>{
    const el = document.getElementById(id);
    if(el) el.addEventListener('change', actualizarPreview);
  });
  actualizarPreview();

  // --- copiar reemplazando el selector por la frase ---
  async function copiarPlantillaCorreo() {
    // 1) clona solo el contenido del email
    const cont = document.querySelector('#contenidoEmail');
    if(!cont){
      alert('No se encontró #contenidoEmail');
      return;
    }
    const clone = cont.cloneNode(true);

    // 2) reemplaza el span con inputs por la frase final
    const selector = clone.querySelector('#selector-fechas');
    if(selector){
      selector.outerHTML = construirFraseFechas();
    }
    // 3) elimina la vista previa si está dentro
    const prev = clone.querySelector('#previewFechas');
    if(prev) prev.remove();

    // 4) arma HTML final "email-safe"
    const html = `
<!DOCTYPE html><html><head><meta charset="UTF-8"></head>
<body style="margin:0;padding:0;background:#fff;">
  <div style="font-family:Arial,Helvetica,sans-serif;font-size:16px;line-height:1.6;color:#1f2d3d;">
    ${clone.innerHTML}
  </div>
</body></html>`.trim();

    // 5) también un texto plano como fallback
    const text = html
      .replace(/<style[\s\S]*?<\/style>/gi, '')
      .replace(/<[^>]+>/g, ' ')
      .replace(/\s+/g, ' ')
      .trim();

    try {
      if (navigator.clipboard && window.ClipboardItem) {
        const data = new ClipboardItem({
          'text/html': new Blob([html], { type: 'text/html' }),
          'text/plain': new Blob([text], { type: 'text/plain' })
        });
        await navigator.clipboard.write([data]);
        window.notyf ? notyf.success('Plantilla copiada con las fechas seleccionadas') : alert('Copiado con fechas');
      } else {
        // fallback
        const ta = document.createElement('textarea');
        ta.value = html;
        document.body.appendChild(ta);
        ta.select();
        document.execCommand('copy');
        document.body.removeChild(ta);
        window.notyf ? notyf.success('Plantilla copiada (fallback)') : alert('Copiado (fallback)');
      }
    } catch (err) {
      console.error(err);
      alert('No se pudo copiar. Revisa permisos del portapapeles.');
    }
  }
</script>

