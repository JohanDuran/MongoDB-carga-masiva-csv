/*Eventos para el modal*/
// Get the modal
var modal = document.getElementById('myModal');

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}


/*
*
*  seccion general
* 
*/



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
	var cantidadEncabezados =50+ $("#dinamicos").children().length;//indica cuantos elementos tiene que leer a partir de 50 que es el primero.
	var textoEncabezados='';
	var islat=false;//obligatorio
	var islng=false;//obligatorio

	for (var i = 50; i < cantidadEncabezados; i++) {
		var id = "#"+i;
		var cantidadHijos=$(id).children().length;
		var text="";
		//si tiene más de elemento arrastrado se ese valor
		//caso contrario el suyo
		if(cantidadHijos!=0){
			text=$("#"+i).children().text().trim();
		}else{
			text=$("#"+i).text().trim();
		}
		//Todos las columnas con coma menos la última
		if(i!=cantidadEncabezados-1){
			textoEncabezados+=text+",";
		}else{
			textoEncabezados+=text;
		}

		//se verifican campos obligatorios
		if(text=="lat"){
			islat=true;
		}else if(text=="lng"){
			islng=true;
		}
	}

	if(islat && islng){//si existen los campos obligatorios se permite enviar, caso contrario no.
		var textoArchivo = $("#archivo").val();
		$("#archivo").val('');
		$("#archivo").val(textoEncabezados+";"+textoArchivo);
		console.log($("#archivo").val());
		return true;
	}else{
		// When the user clicks the button, open the modal 
		modal.style.display = "block";
		return false;
	}
}



