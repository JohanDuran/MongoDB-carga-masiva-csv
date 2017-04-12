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

function parser($cadena){
	return explode(",", $cadena);
}


function insertar($newFile,$delimiter){
	$data = csvToArray($newFile,$delimiter);
	// Set number of elements (minus 1 because we shift off the first row)
	$count = count($data) - 1;
	  
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
	echo json_encode($newArray);
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
?>