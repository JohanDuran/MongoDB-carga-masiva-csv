<?php


	function getJson($newFile,$delimiter){
		$data = csvToArray($newFile,$delimiter);
		// Set number of elements (minus 1 because we shift off the first row)
		$count = count($data) - 2;
		  
		//Use first row for names  
		$labels = array_shift($data);  
		foreach ($labels as $label) {
		  $keys[] = $label;
		}

		  
		// Bring it all together
		for ($j = 0; $j < $count; $j++) {
		  $d = array_combine($keys, $data[$j]);
		  $newArray[$j] = $d;
		}
		// Print it out as JSON
		return $newArray;
	}


	function csvToArray($file, $delimiter) { 
		$handle = fopen($file, 'r');
		if ($handle) { 
			$i = 0;
	    	while (($lineArray = fgetcsv($handle, 4000, $delimiter, '"')) !== FALSE) { 
		  	for ($j = 0; $j < count($lineArray); $j++) { 
	        	$arr[$i][$j] = $lineArray[$j];
	        } 
	      	$i++;
	      } 
	    fclose($handle); 
	  } 
	  return $arr;
	}


	function checkIndexHolandes($documento){
		$requeridos=getRequiredHolandes();
		foreach ($requeridos as $requerido) {
			if(!isset($documento[$requerido])){//en caso de que un campo no exista no se puede calcular indice
				return false;
			}
		}
		return true;
	}

	function checkIndexNsf($documento){
		$requeridos=getRequiredNsf();
		foreach ($requeridos as $requerido) {
			if(!isset($documento[$requerido])){//en caso de que un campo no exista no se puede calcular indice
				return false;
			}
		}
		return true;
	}

	function crearCamposIndice($documentoInsert, $tipo){
	    //Definición de documentos
	    $documento = array();
	    $Muestra = array();
	    $POI = array();
	    $obligatorios = array();
	    $opcionales = array();
	    $location = array();
	    $datos_geograficos = array();

	    $contador =0;
	    //Insercion de datos a documentos
	    $requires;
	    if($tipo=="holandes"){
	    	$requires = getRequiredHolandes();
	    	$documentoInsert["color"]=calc_indice_holandes();
	    }else if($tipo == "nsf"){
	    	$requires = getRequiredNsf();
	    	$documentoInsert["color"]=calc_indice_nsf();
	    }else{
	    	$requires =[];//caso sin indice
	    }
	    //datos obligatorios
	    foreach ($requires as $require) {
	    	if(isset($documentoInsert[$require])){
	    		$obligatorios[$require]=$documentoInsert[$require];
	    		unset($documentoInsert[$require]);
	    	}else{
	    		$obligatorios[$require]="ND";
	    	}
    	}
	    
    	//datos opcionales
	    $optionals = getOptionals();
	    foreach ($optionals as $optional) {
	    	if(isset($documentoInsert[$optional])){
	    		$opcionales[$optional]=$documentoInsert[$optional];
	    		unset($documentoInsert[$optional]);
	    	}else{
	    		//$opcionales[$optional]="ND";
	    	}
	    }

	    //datos generales
	    $generals = getGenerals();
	    foreach ($generals as $general) {
	    	if(isset($documentoInsert[$general])){
	    		$Muestra[$general]=$documentoInsert[$general];
	    		unset($documentoInsert[$general]);
	    	}else{
	    		$Muestra[$general]="ND";
	    	}
	    }

	    //datos de localización
	    $locations = getLocation();
	    foreach ($locations as $loc) {
	    	if(isset($documentoInsert[$loc])){
	    		$location[$loc]=$documentoInsert[$loc];
	    		unset($documentoInsert[$loc]);
	    	}else{
	    		$location[$loc]="ND";
	    	}
	    }


	    //datos de georeferencia
	    $georeferences = getGeoreferenced();
	    foreach ($georeferences as $georefere) {
	    	if(isset($documentoInsert[$georefere])){
	    		$datos_geograficos[$georefere]=$documentoInsert[$georefere];
	    		unset($documentoInsert[$georefere]);
	    	}else{
	    		$datos_geograficos[$georefere]="ND";
	    	}
	    }

	    //datos de POI
	    $pois = getPOI();
	    foreach ($pois as $poie) {
	    	if(isset($documentoInsert[$poie])){
	    		$POI[$poie]=$documentoInsert[$poie];
	    		unset($documentoInsert[$poie]);
	    	}else{
	    		$POI[$poie]="ND";
	    	}
	    }
	    
	    //Si queda algo se inserta en opcionales
	    foreach ($documentoInsert as $key=> $document) {
	    	$opcionales[$key]=$document;
	    }


	    $Muestra['obligatorios'] = $obligatorios;
	    $Muestra['opcionales'] = $opcionales;
	    $POI['location'] = $location;
	    $POI['datos_geograficos'] = $datos_geograficos;
	    
	    $documento['Muestra'] = $Muestra;
	    $documento['POI'] = $POI;
	    return $documento;
	}


	//Calculo indice Holandes
	//Método para calcular el índece Holandés
	function calc_indice_holandes(){
		$campos = getRequiredHolandes();
		$NH4=$campos["NH4"];
		$PO2=$campos["PO2"];
		$DBO=$campos["DBO"];
	    $puntos = 0;
	  //validacion PO2
	  if($PO2 >= 91 && $PO2 <= 100){
	    $puntos += 1;
	  }elseif(($PO2 >= 71 && $PO2 <= 90)||($PO2 >= 111 && $PO2 <= 120)){
	    $puntos += 2;
	  }elseif(($PO2 >= 51 && $PO2 <= 70)||($PO2 >= 121 && $PO2 <= 130)){
	    $puntos += 3;
	  }elseif($PO2 >= 31 && $PO2 <= 50){
	    $puntos += 4;
	  }else{
	    $puntos += 5;
	  }
	  //validacion DBO
	  if($DBO <= 3.0){
	    $puntos += 1;
	  }elseif($DBO >= 3.1 && $DBO <= 6.0){
	    $puntos += 2;
	  }elseif($DBO >= 6.1 && $DBO <= 9.0){
	    $puntos += 3;
	  }elseif($DBO >= 9.1 && $DBO <= 15.0){
	    $puntos += 4;
	  }else{
	    $puntos += 5;
	  }
	  //validacion NH4
	  if($NH4 < 0.50){
	    $puntos += 1;
	  }elseif($NH4 >= 0.50 && $NH4 <= 1.0){
	    $puntos += 2;
	  }elseif($NH4 >= 1.1 && $NH4 <= 2.0){
	    $puntos += 3;
	  }elseif($NH4 >= 2.1 && $NH4 <= 5.0){
	    $puntos += 4;
	  }else{
	    $puntos += 5;
	  }
	    return calc_color_holandes($puntos);
	     
	}

	//Método para calcular el color asociado al valor del índice
	function calc_color_holandes($puntos){
	    if($puntos == 3 ){
	    $respuesta = "Azul";
	  }elseif($puntos >= 4 && $puntos <= 6){
	    $respuesta = "Verde";
	  }elseif($puntos >= 7 && $puntos <= 9){
	    $respuesta = "Amarillo";
	  }elseif($puntos >= 10 && $puntos <= 12){
	    $respuesta = "Anaranjado";
	  }else{
	    $respuesta = "Rojo";
	  }
	    return $respuesta;
	}

	//Método para calcular el valor del indice NSF
	function calc_indice_nsf(){
		$campos = getRequiredNsf();
		$PO2 = $campos["PO2"];
		$DBO = $campos["DBO"];
		$CF = $campos["CF"];
		$pH = $campos["pH"];

	    $valorPO2 = -13.55+(1.17*$PO2);
	    $valorPO2 = $valorPO2*0.31;
	    $valorDBO = 96.67-(7*$DBO);
	    $valorDBO = $valorDBO*0.19;
	    $valorCF = 97.2-(26.6*log10($CF));
	    $valorCF = $valorCF*0.28;
	    $valorpH = 316.96-(29.85*$pH);
	    $valorpH = $valorpH*0.22;
	    
	    $respuesta = $valorPO2 + $valorDBO + $valorCF+ $valorpH;
	    return calc_color_nsf($respuesta);
	     
	}
	//Método para calcular el color asociado al valor del índice NSF
	function calc_color_nsf($puntos){
	    if($puntos >= 91 && $puntos <= 100){
	        $respuesta = "Azul";
	    }elseif($puntos >= 71 && $puntos <= 90){
	        $respuesta = "Verde";
	    }elseif($puntos >= 51 && $puntos <= 70){
	        $respuesta = "Amarillo";
	    }elseif($puntos >= 26 && $puntos <= 50){
	        $respuesta = "Anaranjado";
	    }else{
	        $respuesta = "Rojo";
	    }
	    return $respuesta;
	}

?>