var READY_STATE_UNINITIALIZED=0;
var READY_STATE_LOADING=1;
var READY_STATE_LOADED=2;
var READY_STATE_INTERACTIVE=3;
var READY_STATE_COMPLETE=4;
 
var peticion_http;
 
function cargaContenido(parametros, funcion, p) 
{
	
  peticion_http = inicializa_xhr();
 
  if(peticion_http) 
  {
  
    peticion_http.onreadystatechange = funcion;
 
    if(p != 99)
    {
    	peticion_http.open("POST", parametros, true);
    	peticion_http.send(null);
    }
    else 
    {    	
    	peticion_http.open("POST", "carga.php?pagina=" + p, true);
    	peticion_http.send(null);
    }
        
  }
  
}
 
function inicializa_xhr() 
{
  if(window.XMLHttpRequest)return new XMLHttpRequest();
  else if(window.ActiveXObject)return new ActiveXObject("Microsoft.XMLHTTP");
}

function muestraPublicacion(){if(peticion_http.readyState == READY_STATE_COMPLETE)if(peticion_http.status == 200)document.getElementById("section").innerHTML = peticion_http.responseText;}

function muestraContenido(){if(peticion_http.readyState == READY_STATE_COMPLETE)if(peticion_http.status == 200)document.getElementById("estado_"+p).innerHTML = peticion_http.responseText;}
 
function pagina(p){cargaContenido("carga.php?pagina="+p, muestraPublicacion,p);}

function grabarResultado(idzona,nrofecha,idpartido,idlocal,idvisitante)
{
	var glocal = document.getElementById('glocal_'+idlocal).value;
	var gvisitante = document.getElementById('gvisitante_'+idvisitante).value;
	if(glocal == null)glocal = 0;
	if(gvisitante == null)gvisitante = 0;
	p=idlocal;
	cargaResultados("grabar.php?idzona="+idzona+"&nrofecha="+nrofecha+"&idpartido="+idpartido+"&idlocal="+idlocal+"&idvisitante="+idvisitante+"&glocal="+glocal+"&gvisitante="+gvisitante, muestraContenido,p);
}

function cargaResultados(parametros, funcion, p) 
{
  peticion_http = inicializa_xhr();
  if(peticion_http) 
  {
    peticion_http.onreadystatechange = funcion;
   	peticion_http.open("POST", parametros, true);
   	peticion_http.send(null);       
  }
}

$(function() {$( "#fecha" ).datepicker({dateFormat: 'dd/mm/yy'});});