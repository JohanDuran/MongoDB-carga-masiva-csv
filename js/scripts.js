//del 50 en adelante son los elementos cargados por el usuario
//del 0 al 49 son los elementos por defecto

//Se genera un estilo sobre el campo para indicar si se puede o no soltar el elemento que esta siendo arrastrado
function allowDrop(ev) {
	//si es un elemento cargado por el usuario y no tiene hijos o es el div que contiene los datos por defecto permitir soltar, caso contrario no. 
	if(ev.target.id =="estaticos" ||($(ev.target).children().length == 0 && ev.target.id>49)){
    	ev.preventDefault();
    }
}

//evento que se genera al seleccionar un marcador
function drag(ev) {
	ev.dataTransfer.setData("text", ev.target.id);
}


//Indica que hacer al soltar el elemento
function drop(ev) {
    	ev.preventDefault();
	    var data = ev.dataTransfer.getData("text");
	    //$(ev.target).append($('#'+data));
	    ev.target.appendChild(document.getElementById(data));
}


function validateForm(){
	var cantidadEncabezados =50+ $("#dinamicos").children().length;
	var textoEncabezados='';
	for (var i = 50; i < cantidadEncabezados; i++) {
		var id = "#"+i;
		var cantidadHijos=$(id).children().length;
		var text="";
		if(cantidadHijos!=0){
			text=$("#"+i).children().text().trim();
		}else{
			text=$("#"+i).text().trim();
			alert(text);
		}
		if(i!=cantidadEncabezados-1){
			textoEncabezados+=text+",";
		}else{
			textoEncabezados+=text;
		}
	}
	var textoArchivo = $("#archivo").val();
	$("#archivo").val('');
	$("#archivo").val(textoEncabezados+";"+textoArchivo);
	alert($("#archivo").val());
	return true;
}

function validateFile(){
	if($("#archivo").val()==""){
		return false;
	}else{
		return true;
	}
}


