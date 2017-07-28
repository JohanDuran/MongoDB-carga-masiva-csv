<?php
	require_once('funciones/funciones_calc_indices_color.php');

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

	function checkIndexGlobal($documento){
		$requeridos=getRequiredGlobal();
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
	    	$documentoInsert["indice_usado"]='holandes';
	    	$documentoInsert["val_indice"]=calcIndiceHolandes($documentoInsert);
	    	$documentoInsert["color"]=calcColorHolandes($documentoInsert["val_indice"]);
	    }else if($tipo == "nsf"){
	    	$requires = getRequiredNsf();
	    	$documentoInsert["indice_usado"]='nsf';
	    	$documentoInsert["val_indice"]=calcIndiceNsf($documentoInsert);
	    	$documentoInsert["color"]=calcColorNsf($documentoInsert["val_indice"]);
	    }elseif($tipo == "BMWP-CR"){
	    	$requires = getRequiredGlobal();
	    	$documentoInsert["indice_usado"]='BMWP-CR';
	    	$documentoInsert["val_indice"]=calcIndiceGlobal($documentoInsert);
	    	$documentoInsert["color"]=calcColorGlobal($documentoInsert["val_indice"]);
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

?>