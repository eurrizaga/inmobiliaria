
function buscarPropietarios(){
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
                document.getElementById('propietarios_lista').innerHTML=pagina_requerida.responseText
        }

        //obtener valores
        var apellido = document.getElementById('form_apellido').value;
        if (apellido == '')
    		apellido = '0';
        var nombres = document.getElementById('form_nombres').value;
        if (nombres == '')
    		nombres = '0';
        var nrodoc = document.getElementById('form_nrodoc').value;
        if (nrodoc == '')
    		nrodoc = '0';
        var num_carpeta = document.getElementsByName('form[num_carpeta]')[1].value;
        if (num_carpeta == '')
    		num_carpeta = '0';

        pagina_requerida.open('GET',  "/buscar/propietario/" + apellido + "/" + nombres + "/" + nrodoc + "/" + num_carpeta, true)
        pagina_requerida.send(null);
}

