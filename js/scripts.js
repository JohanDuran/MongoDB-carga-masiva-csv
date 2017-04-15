//Alert the id of an element.
function button_id(element){
	alert(element.id);
}

//Make elements draggable button-button
function allowDrop(ev) {
	if($(ev.target).children().length == 0 && ev.target.id>49){
    	ev.preventDefault();
    }
}

function drag(ev) {
	ev.dataTransfer.setData("text", ev.target.id);
}

function drop(ev) {
    	ev.preventDefault();
	    var data = ev.dataTransfer.getData("text");
	    //$(ev.target).append($('#'+data));
	    ev.target.appendChild(document.getElementById(data));

}



