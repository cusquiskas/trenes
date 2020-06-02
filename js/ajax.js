 function peticionAjax() {
  var dato = {
   metodo    : 'POST',
   direccion : '',
   caracteres: '',
   parametros: {},
   retorno   : function() { alert('no se ha especificado retorno'); },
   extra     : {},
   canal     : '',
   asincrono : true,
   contentType:'application/x-www-form-urlencoded' 
  };
  this.respuesta = function() {
   var http = (dato.asincrono)?this:this.xmlhttp;
   if (http.readyState==4) {
    var resultado = '';
    if (http.responseText==""||http.responseText==null) {
     try { dato.retorno (false, 'La llamada no ha devuelto datos' ); } catch(e) {} 
     return; //Ha llegado una cadena vacía del servidor, abortamos el resto de comprobaciones y devolvemos la situación
    }
    switch (dato.canal) {
     case 'JSON': try {resultado = (typeof JSON != 'undefined')?JSON.parse(http.responseText):eval("(function(){return " + http.responseText + ";})()"); } catch (e) { dato.retorno (false, 'No es un JSON v&aacute;lido'); return;} break;
     default    : resultado = http.responseText;
    }
    if (typeof dato.retorno == 'function') dato.retorno ((http.status==200&&(typeof resultado.success == 'undefined' || resultado.success))?true:false,resultado,dato.extra);
   }
  }
  this.pide = function (obj) {
   var chd,cad='';
   dato.metodo     =((typeof obj.metodo     == 'undefined')?dato.metodo:obj.metodo).toUpperCase();
   dato.direccion  = (typeof obj.direccion  == 'undefined')?dato.direccion:obj.direccion;
   dato.parametros = (typeof obj.parametros == 'undefined')?dato.parametros:obj.parametros;
   dato.retorno    = (typeof obj.retorno    == 'undefined')?dato.retorno:obj.retorno;
   dato.extra      = (typeof obj.extra      == 'undefined')?dato.extra:obj.extra;
   dato.asincrono  = (typeof obj.asincrono  == 'undefined')?dato.asincrono:obj.asincrono;
   dato.contentType   = (typeof obj.parametros  == 'undefined')?dato.contentType:(typeof obj.parametros.contentType  == 'undefined')?dato.contentType:obj.parametros.contentType;
   dato.caracteres = (typeof obj.caracteres == 'undefined')?dato.caracteres:obj.caracteres;
   dato.caracteres = ((dato.caracteres!=''&&dato.caracteres!=null)?'charset='+dato.caracteres:'');
   dato.canal      = dato.direccion.split('.');
   dato.canal      = dato.canal[dato.canal.length-1].toUpperCase();
   if (dato.canal == 'PHP') dato.canal = obj.parametros.xchn.toUpperCase();
   if (window.XMLHttpRequest) { this.xmlhttp=new XMLHttpRequest(); }
   else { this.xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
   if (dato.asincrono) this.xmlhttp.onreadystatechange = this.respuesta;
   for(chd in dato.parametros) { cad+= "&"+chd+"="+escape(String(dato.parametros[chd])); } cad = cad.substr(1);
   if (dato.metodo == 'POST' || dato.metodo == 'DELETE' ) {
    this.xmlhttp.open(dato.metodo,dato.direccion,dato.asincrono);  
    if (dato.contentType =='application/json'){
      this.xmlhttp.setRequestHeader("Content-type","application/json;"+dato.caracteres+"");
      this.xmlhttp.send(JSON.stringify(obj.parametros)); 
    }else{
      this.xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded;"+dato.caracteres+""); 
      this.xmlhttp.send(cad);
    }
    //this.xmlhttp.setRequestHeader('Access-Control-Allow-Origin', '*');
    //this.xmlhttp.setRequestHeader('Access-Control-Allow-Methods', '*');
   }else {
    this.xmlhttp.open("GET",dato.direccion+'?'+cad,dato.asincrono);
    //this.xmlhttp.setRequestHeader('Access-Control-Allow-Origin', '*');
    //this.xmlhttp.setRequestHeader('Access-Control-Allow-Methods', '*');
    this.xmlhttp.send();
   }
   if (!dato.asincrono) this.respuesta();
  }
 }
 
 function invocaAjax(obj) { 
  obj = obj||{};
  if (typeof obj.direccion == 'undefined' || obj.direccion.length == 0) {
   if (typeof obj.retorno == 'function') obj.retorno (false,'No se ha definido direcci&oacute;n de llamada');
   else alert('no se ha especificado retorno'); 
  } else {
   var conex = new peticionAjax(); 
   conex.pide(obj);
  }
 }