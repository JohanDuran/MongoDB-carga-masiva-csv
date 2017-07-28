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
			foreach ($palabras as $palabra) {
			    //se insertan las palabras dentro del archivo
			    fputcsv($fp, $palabra);
			}
		}
		//se vuelve al inicio del archivo
		fseek($fp, 0);
		//se obtiene el path del archivo para ubicarlo dentro de getJson
		$metaData = stream_get_meta_data($fp);
		$filepath = $metaData['uri'];
		//se obtiene con los datos
		$documentos=getJson($filepath,",");
		//echo json_encode($documentos);
		//contador para cada "documento dentro del array"
		$contador=0;
		$newDocs=[];
		//se verifica cada documento independientemente, luego se pasa al siguiente.
		foreach ($documentos as $documento) {
			if(checkIndexHolandes($documento)){//si se puede calcular indice holandes
				$newDocs[$contador++]=crearCamposIndice($documento,"holandes");
			}elseif (checkIndexNsf($documento)) {
				$newDocs[$contador++]=crearCamposIndice($documento,"nsf");
			}elseif (checkIndexGlobal($documento)) {
				$newDocs[$contador++]=crearCamposIndice($documento,"BMWP-CR");
			}else{
				$newDocs[$contador++]=crearCamposIndice($documento,"noIndex");
			}			
		}
		echo json_encode($newDocs);
		/*Version antigua.
		if(checkIndexHolandes($documentos[0])){//si se puede calcular indice holandes
			foreach ($documentos as $documento) {
				$documentos[$contador++]=crearCamposIndice($documento,"holandes");
			}	
		}else if(checkIndexNsf($documentos[0])){//si se puede calcular indice nsf
			foreach ($documentos as $documento) {
				$documentos[$contador++]=crearCamposIndice($documento,"nsf");
			}
		}else if(checkIndexGlobal($documentos[0])){//verificar si se puede calcular global
			foreach ($documentos as $documento) {
				$documentos[$contador++]=crearCamposIndice($documento,"BMWP-CR");
			}
		}else{//ni holandes ni nsf se carga todo en opcionales.
			foreach ($documentos as $documento) {
				$documentos[$contador++]=crearCamposIndice($documento,"noIndex");
			}
		}*/
		fclose($fp);
		
		//se inserta en la base de datos.
		insertar('PuntosMuestreo','usuarios',$newDocs);
		header('Location: index.php?insertado=1');
}
 ?>