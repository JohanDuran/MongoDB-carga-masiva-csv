<?php 
	require_once('funciones/funciones.php');
	require 'vendor/autoload.php';

	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
		//$fp = fopen('file.csv', 'w');
		$fp = tmpfile();
		fwrite($fp, '');
		$lineas = parser($_GET['archivo'],";");
		foreach ($lineas as $linea) {
			$palabras=parser($linea,",");
			$palabras = [$palabras];
			foreach ($palabras as $palabra ) {
			    fputcsv($fp, $palabra);
			}
		}
		//se vuelve al inicio del archivo
		fseek($fp, 0);
		$metaData = stream_get_meta_data($fp);
		$filepath = $metaData['uri'];
		//se obtiene el array json
		$datos=getJson($filepath,",");
		fclose($fp);
		//se inserta en la base de datos.
		insertar('PuntosMuestreo','usuarios',$datos);
}
 ?>