
const BASE = window.location.origin + '/sirh';
const URL_FALTAS_EMAIL = BASE + '/App/Controllers/Central/FaltaC/faltas_email.php';



function fmtDDMMYYYY(isoDate){
  if(!isoDate) return '';
  const [y,m,d] = isoDate.split('-');
  return `${d}/${m}/${y}`;
}
function fmtHHMM(hhmmss){
  if(!hhmmss) return '';
  return hhmmss.slice(0,5);
}


function ocultarModalEmail2() {
  const cont = document.getElementById('correoContenido');
  if (!cont) {
    alert('No se encontró #correoContenido');
    return;
  }

  
  const clone = cont.cloneNode(true);

 
  const selector = clone.querySelector('#selector-fechas');
  if (selector) {
    selector.outerHTML = construirFraseFechas();
  }


  const prev = clone.querySelector('#previewFechas');
  if (prev) prev.remove();

  const html = `
<!DOCTYPE html><html><head><meta charset="UTF-8"></head>
<body style="margin:0;padding:0;background:#fff;">
  <div style="font-family:Arial,Helvetica,sans-serif;font-size:16px;line-height:1.6;color:#1f2d3d;">
    ${clone.innerHTML}
  </div>
</body></html>`.trim();


  try {
    if (navigator.clipboard && window.ClipboardItem) {
      const data = new ClipboardItem({
        'text/html': new Blob([html], { type: 'text/html' }),
        'text/plain': new Blob([html.replace(/<style[\s\S]*?<\/style>/gi, '').replace(/<[^>]+>/g, ' ').replace(/\s+/g, ' ').trim()], { type: 'text/plain' })
      });
      navigator.clipboard.write([data]).then(() => {
        window.notyf ? notyf.success('Contenido copiado con éxito') : alert('Copiado');
        $("#modal_mail").modal("hide");
      }).catch(err => {
        console.error(err);
        window.notyf ? notyf.error('No se pudo copiar (HTML)') : alert('No se pudo copiar');
      });
    } else {

      const ta = document.createElement('textarea');
      ta.value = html;
      document.body.appendChild(ta);
      ta.select();
      document.execCommand('copy');
      document.body.removeChild(ta);
      window.notyf ? notyf.success('Contenido copiado (fallback)') : alert('Copiado (fallback)');
      $("#modal_mail").modal("hide");
    }
  } catch (err) {
    console.error('Error al copiar:', err);
    window.notyf ? notyf.error('Error al copiar') : alert('Error al copiar');
  }
}



function renderFaltasEmail(resp){
  
  const tb = document.getElementById('tbodyFaltasEmail');
  if (!tb) return;

  if (!resp || resp.ok !== true) {
    tb.innerHTML = `<tr><td colspan="5" style="padding:10px;border:1px solid #ddd;text-align:center;color:#c00;">
      ${(resp && resp.msg) || 'Sin registros'}
    </td></tr>`;
    return;
  }
  if (!Array.isArray(resp.faltas) || resp.faltas.length === 0) {
    tb.innerHTML = `<tr><td colspan="5" style="padding:10px;border:1px solid #ddd;text-align:center;">Sin registros</td></tr>`;
    return;
  }

  let html = '';
  resp.faltas.forEach(r => {
    html += `
      <tr>
        <td style="padding:10px;border:1px solid #ddd;">${(r.puesto || '')}</td>
        <td style="padding:10px;border:1px solid #ddd;">${(r.nombre || '—')}</td>
        <td style="padding:10px;border:1px solid #ddd;">${fmtDDMMYYYY(r.fecha)}</td>
        <td style="padding:10px;border:1px solid #ddd;">${fmtHHMM(r.hora)}</td>
        <td style="padding:10px;border:1px solid #ddd;">${(r.estatus || '')}</td>
      </tr>`;
  });
  tb.innerHTML = html;
}

function ajaxErrorFaltasEmail(xhr){
  console.error('AJAX error', xhr?.status, xhr?.responseText);
  const tb = document.getElementById('tbodyFaltasEmail');
  if (tb) tb.innerHTML =
    `<tr><td colspan="5" style="padding:10px;border:1px solid #ddd;text-align:center;color:#c00;">Error al cargar</td></tr>`;
}

let _ctxMail = { idEmpleado: null, idFalta: null };

function getRangoFiltroFechas() {
  const desde = document.getElementById('filtro_desde')?.value || '';
  const hasta = document.getElementById('filtro_hasta')?.value || '';
  return { desde, hasta };
}


function showMail(idFalta) {
  _ctxMail = { idEmpleado: null, idFalta: Number(idFalta) };
  const tbody = document.getElementById('tbodyFaltasEmail');
  if (tbody) tbody.innerHTML = `<tr><td colspan="5" style="padding:10px;border:1px solid #ddd;text-align:center;">Cargando...</td></tr>`;
  $('#modal_mail').modal('show');


   ensureSelectorFechasInit();
    const { desde, hasta } = getRangoFiltroFechas();

  $.ajax({
    url: URL_FALTAS_EMAIL,
    type: 'POST',
    dataType: 'json',
    data: { id_falta: Number(idFalta), desde, hasta },
    success: renderFaltasEmail,
    error: ajaxErrorFaltasEmail
  });
}


function showMailEmpleado(idEmpleado) {
  _ctxMail = { idEmpleado: Number(idEmpleado), idFalta: null };
  const tbody = document.getElementById('tbodyFaltasEmail');
  if (tbody) tbody.innerHTML = `<tr><td colspan="5" style="padding:10px;border:1px solid #ddd;text-align:center;">Cargando...</td></tr>`;
  $('#modal_mail').modal('show');

  ensureSelectorFechasInit();

  const { desde, hasta } = getRangoFiltroFechas();

  $.ajax({
    url: URL_FALTAS_EMAIL,
    type: 'POST',
    dataType: 'json',
    data: { id_empleado: Number(idEmpleado), desde, hasta },
    success: renderFaltasEmail,
    error: ajaxErrorFaltasEmail
  });
}

document.addEventListener('DOMContentLoaded', () => {
  const btn = document.getElementById('btnFiltrarFaltas');
  if (!btn) return;

btn.addEventListener('click', () => {
    const { desde, hasta } = getRangoFiltroFechas();
    const tb = document.getElementById('tbodyFaltasEmail');
    if (tb) tb.innerHTML = `<tr><td colspan="5" style="padding:10px;border:1px solid #ddd;text-align:center;">Cargando...</td></tr>`;

    const payload = { desde, hasta };
    if (_ctxMail.idEmpleado) payload.id_empleado = _ctxMail.idEmpleado;
    if (_ctxMail.idFalta)    payload.id_falta    = _ctxMail.idFalta;

    $.ajax({
      url: URL_FALTAS_EMAIL,
      type: 'POST',
      dataType: 'json',
      data: payload,
      success: renderFaltasEmail,
      error: ajaxErrorFaltasEmail
    });
  });
});

const MESES_ES = ['enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre'];

function _getFecha(id){
  const v = document.getElementById(id)?.value;
  if(!v) return null;
  const [y,m,d] = v.split('-').map(Number);
  if(!y||!m||!d) return null;
  return new Date(y, m-1, d);
}
function _fmtLargo(d){
  return `${d.getDate()} de ${MESES_ES[d.getMonth()]} de ${d.getFullYear()}`;
}
function construirFraseFechas(){
  let f1 = _getFecha('fecha1');
  let f2 = _getFecha('fecha2');

  if(!f1 && !f2) return 'los días <strong>—</strong>';

  if(f1 && f2 && f2 < f1){ const t=f1; f1=f2; f2=t; }

  if(f1 && (!f2 || f1.getTime()===f2.getTime())) return `el día <strong>${_fmtLargo(f1)}</strong>`;

  if(f1 && f2){
    const mismoMesYAño = f1.getMonth()===f2.getMonth() && f1.getFullYear()===f2.getFullYear();
    if(mismoMesYAño){
      return `los días <strong>${f1.getDate()} y ${f2.getDate()} de ${MESES_ES[f1.getMonth()]} de ${f1.getFullYear()}</strong>`;
    }
    return `los días <strong>${_fmtLargo(f1)} y ${_fmtLargo(f2)}</strong>`;
  }
  return 'los días <strong>—</strong>';
}

function _onFechasChange(){
  const prev = document.getElementById('previewFechas');
  if(prev) prev.innerHTML = construirFraseFechas();


  const c = document.getElementById('conector');
  const v1 = document.getElementById('fecha1')?.value;
  const v2 = document.getElementById('fecha2')?.value;
  const showY = !!(v1 && v2 && v1 !== v2);
  if(c) c.classList.toggle('d-none', !showY);
}

let _fechasInit = false;
function ensureSelectorFechasInit(){

  if(!_fechasInit){
    ['fecha1','fecha2'].forEach(id=>{
      const el = document.getElementById(id);
      if(el) el.addEventListener('change', _onFechasChange);
    });
    _fechasInit = true;
  }

  _onFechasChange();
}
