function getId(o){return document.getElementById(o)}
function getForm(o){return document.forms[o]}
function oculta(o){o.style.display='none'}
function irA(d,e){e=e||"";var f=getForm('navegador');f.irA.value=d;f.extra.value=e;f.scroll.value=((typeof(document.body.scrollTop)=='undefined')?document.documentElement.scrollTop:document.body.scrollTop);f.submit()}
var _ctrlFecha = {locale:'es', format:'DD/MM/YYYY'};