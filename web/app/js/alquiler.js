function buscarClientes(){
	//obtener valores
    var apellido = document.getElementById('form_apellido_busca').value;
    if (apellido == '')
		apellido = '0';
    var nombres = document.getElementById('form_nombres_busca').value;
    if (nombres == '')
		nombres = '0';
    var nrodoc = document.getElementById('form_nrodoc_busca').value;
    if (nrodoc == '')
		nrodoc = '0';
    
	var url = "/buscar/cliente/";
	var param = apellido + '/' + nombres + '/' + nrodoc;
	var div_respuesta = 'respuesta_cliente';

	llamarAjax(url, param, div_respuesta);

}

function llamarAjax(url, param, div){
    var pagina_requerida = false
        if (window.XMLHttpRequest) {
            pagina_requerida = new XMLHttpRequest()
        }
        else if (window.ActiveXObject){ 
            try {
                pagina_requerida = new ActiveXObject("Msxml2.XMLHTTP")
            } 
            catch (e){ 
                try{
                    pagina_requerida = new ActiveXObject("Microsoft.XMLHTTP")
                }
                catch (e){
                }
            }
        }
        else {
            return false
        }
        pagina_requerida.onreadystatechange=function(){ 
            if (pagina_requerida.readyState == 4 && (pagina_requerida.status==200 || window.location.href.indexOf("http")==-1))
                document.getElementById(div).innerHTML = pagina_requerida.responseText
        }

        

        pagina_requerida.open('GET',  url + param, true)
        pagina_requerida.send(null);
}

function seleccionarCliente(id, apellido, nombres, tipodoc, nrodoc, direccion, localidad, cpostal, provincia, pais, tfijo, tmovil, email, observaciones){
	document.getElementById('form_id_cliente').value = id; 
	document.getElementById('form_apellido').value = apellido;
	document.getElementById('form_nombres').value = nombres;
	document.getElementById('form_tipodoc').value = tipodoc;
	document.getElementById('form_nrodoc').value = nrodoc;
	document.getElementById('form_direccion').value = direccion;
	document.getElementById('form_localidad').value = localidad;
	document.getElementById('form_codigopostal').value = cpostal;
	document.getElementById('form_provincia').value = provincia;
	document.getElementById('form_pais').value = pais;
	document.getElementById('form_telefonofijo').value = tfijo; 
	document.getElementById('form_telefonomovil').value = tmovil;
	document.getElementById('form_email').value = email;
	document.getElementById('form_observaciones_cliente').value = observaciones;
}