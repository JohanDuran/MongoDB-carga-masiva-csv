<?php 
	require_once('funciones/funciones_datos.php');
	require_once('funciones/funciones_BD.php');
	require_once('funciones/funciones_comunes.php');
	require_once('funciones/funciones_insertar_BD.php');
	require 'vendor/autoload.php';

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		//$fp = fopen('file.csv', 'w');
		$fp = tmpfile();
		fwrite($fp, '');
		//Se obtienen las lineas
		$lineas = parser($_POST['archivo'],";");
		//se divide el texto en palabras que viene separadas por comas
		foreach ($lineas as $linea) {
			$palabras=parser($linea,",");
			$palabras = [$palabras];
			foreach ($palabras as $palabra ) {
			    //se insertan las palabras dentro del archivo
			    fputcsv($fp, $palabra);
			}
		}
		//se vuelve al inicio del archivo
		fseek($fp, 0);
		//se obtiene el path del archivo para ubicarlo dentor de getJson
		$metaData = stream_get_meta_data($fp);
		$filepath = $metaData['uri'];
		//se obtiene con los datos
		$documentos=getJson($filepath,",");
		//contador para cada "documento dentro del array"
		$contador=0;
		if(checkIndexHolandes($documentos[0])){//si se puede calcular indice holandes
			foreach ($documentos as $documento) {
				$documentos[$contador++]=crearCamposIndice($documento,"holandes");
			}	
		}else if(checkIndexNsf($documentos[0])){//si se puede calcular indice nsf
			foreach ($documentos as $documento) {
				$documentos[$contador++]=crearCamposIndice($documento,"nsf");
			}
		}else{//ni holandes ni nsf se carga todo en opcionales.
			foreach ($documentos as $documento) {
				$documentos[$contador++]=crearCamposIndice($documento,"noIndex");
			}
		}
		fclose($fp);
		
		//se inserta en la base de datos.
		insertar('PuntosMuestreo','usuarios',$documentos);
		header('Location: index.php?insertado=1');
}
 ?>