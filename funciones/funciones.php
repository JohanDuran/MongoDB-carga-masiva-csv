<?php


	function verificarCsv($file_ext,$file_size){
		$extensiones= array("php","html","csv");
		$errors=array();
		if(in_array($file_ext,$extensiones)=== false){
		 	$errors[]="Extension no permitida";
		}

		if($file_size > 2097152){
			$errors[]='Tama;o excede limite';
		}

		return $errors;
	}

	function parser($cadena,$delimiter){
		return explode($delimiter, $cadena);
	}


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

	function getFields(){
			return ['usuario','temp_agua','velocidad_agua','area_cause_rio','PO2','DBO','NH4','DQO','EC','PO4','GYA','SD','Ssed','SST','SAAM','T','Aforo','ST','CF','pH','Fosfato','Nitrato','Turbidez','Sol_totales','nombre_institucion','nombre_estacion','fecha', 'kit_desc','lat','lng','alt','cod_prov','cond_cant','cod_dist','cod_rio','Color','DBO','NH4'];
	}

	function getRequiredHolandes(){
		return ['NH4','PO2','DBO'];
	}

	function getRequiredNsf(){
		return ['NH4','PO2','CF','pH'];
	}

	function getGenerals(){
		return ['usuario','fecha','indice_usado','val_indice','color','temp_agua','velocidad_agua','velocidad_agua','area_cauce_rio'];
	}

	function getOptionals(){
		return ['DQO','EC','PO4','GYA','SD','Ssed','SST','SAAM','T','Aforo','ST','CF','pH','Fosfato','Nitrato','Turbidez','Sol_totales'];
	}

	function getLocation(){
		return ['lat','lng'];
	}

	function getGeoreferenced(){
		return ['alt','cod_prov','cod_cant','cod_dist','cod_rio'];
	}

	function getPOI(){
		return ['nombre_institucion','nombre_estacion','kit_desc'];
	}


	function limpiar($cadena){
		$cadena = str_replace(' ', '', $cadena);
		htmlspecialchars($cadena);
		return $cadena;
	}

	function insertar($database,$collection,$datos){
	    try {
	        $connection = new MongoDB\Client;
	        $database = $connection->$database;
	        $collection = $database->$collection;
	    } catch (MongoConnectionException $e) {
	        echo "Error: " . $e->getMessage();
	    }

	    $collection->insertMany($datos, array('safe' => true));
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