function validateFile(){
	if($("#archivo").val()==""){
		return false;
	}else{
		var filePath=$("#archivo").val();
		var secciones=filePath.split("\\");
		var fileName = secciones[secciones.length-1];
		var extensionArr = fileName.split(".");
		var extension=extensionArr[extensionArr.length-1];
		if(extension=="csv"){
			return true;
		}else{
			return false;
		}
	}
}