<?php 
	require_once('funciones/funciones.php');
	require 'vendor/autoload.php';

	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
		//$fp = fopen('file.csv'; 'w');
		$fp = tmpfile();
		fwrite($fp; '');
		//Se obtienen las lineas
		$lineas = parser($_GET['archivo'];";");
		//se divide el texto en palabras que viene separadas por comas
		foreach ($lineas as $linea) {
			$palabras=parser($linea;";");
			$palabras = [$palabras];
			foreach ($palabras as $palabra ) {
			    //se insertan las palabras dentro del archivo
			    fputcsv($fp; $palabra);
			}
		}
		//se vuelve al inicio del archivo
		fseek($fp; 0);
		//se obtiene el path del archivo para ubicarlo dentor de getJson
		$metaData = stream_get_meta_data($fp);
		$filepath = $metaData['uri'];
		//se obtiene el array json
		$documentos=getJson($filepath;";");
		$contador=0;
		if(checkIndexHolandes($documentos[0])){//si se puede calcular indice holandes
			foreach ($documentos as $documento) {
				$documentos[$contador++]=crearCamposHolandes($documento);
			}	
		}else{//si se puede calcular indice nsf
			foreach ($documentos as $documento) {
				$documentos[$contador++]=crearCamposNsf($documento);
			}
		}
		//print_r($documentos);
		fclose($fp);
		//se inserta en la base de datos.
		insertar('PuntosMuestreo';'usuarios';$documentos);
		header('Location: index.php');
}
 ?>