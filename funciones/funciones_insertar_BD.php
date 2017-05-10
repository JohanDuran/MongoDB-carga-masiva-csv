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

	function crearCamposHolandes($documentoInsert){
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
	    $requires = getRequiredHolandes();
	    foreach ($requires as $require) {
	    	if(isset($documentoInsert[$require])){
	    		$obligatorios[$require]=$documentoInsert[$require];
	    	}else{
	    		$obligatorios[$require]="ND";
	    	}
	    	}
	    

	    $optionals = getOptionals();
	    foreach ($optionals as $optional) {
	    	if(isset($documentoInsert[$optional])){
	    		$opcionales[$optional]=$documentoInsert[$optional];
	    	}else{
	    		$opcionales[$optional]="ND";
	    	}
	    }

	    $generals = getGenerals();
	    foreach ($generals as $general) {
	    	if(isset($documentoInsert[$general])){
	    		$Muestra[$general]=$documentoInsert[$general];
	    	}else{
	    		$Muestra[$general]="ND";
	    	}
	    }

	    $Muestra['obligatorios'] = $obligatorios;
	    $Muestra['opcionales'] = $opcionales;

	    $locations = getLocation();
	    foreach ($locations as $loc) {
	    	if(isset($documentoInsert[$loc])){
	    		$location[$loc]=$documentoInsert[$loc];
	    	}else{
	    		$location[$loc]="ND";
	    	}
	    }


	    $georeferences = getGeoreferenced();
	    foreach ($georeferences as $georefere) {
	    	if(isset($documentoInsert[$georefere])){
	    		$datos_geograficos[$georefere]=$documentoInsert[$georefere];
	    	}else{
	    		$datos_geograficos[$georefere]="ND";
	    	}
	    }

	    $pois = getPOI();
	    foreach ($pois as $poie) {
	    	if(isset($documentoInsert[$poie])){
	    		$POI[$poie]=$documentoInsert[$poie];
	    	}else{
	    		$POI[$poie]="ND";
	    	}
	    }
	    $POI['location'] = $location;
	    $POI['datos_geograficos'] = $datos_geograficos;
	    
	    $documento['Muestra'] = $Muestra;
	    $documento['POI'] = $POI;
	    return $documento;
	}

	function crearCamposNsf($documento){
		return ['u'=>2];
	}
?>