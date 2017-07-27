<?php 
	require_once('funciones/funciones_comunes.php');
	require_once('funciones/funciones_cargar.php');
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		if(isset($_FILES['file'])){
			/*Se lee nombre, tamaño, nombre_temporal, tipo de archivo, extensión*/
			$file_name = $_FILES['file']['name'];
			$file_size =$_FILES['file']['size'];
			$file_tmp =$_FILES['file']['tmp_name'];
			$file_type=$_FILES['file']['type'];
			$file_ext=strtolower(end(explode('.',$_FILES['file']['name'])));
			$errores=verificarCsv($file_ext,$file_size);
			$handle = fopen($file_tmp, "r");
			$linea="";//guarda los encabezados separados en un vector
			$archivo=""; //guarda todas las lineas, separación entre líneas con ';'
			$indices=getFields();//funciones_cargar
			if ($handle) {/*Si se pudo leer*/
				//se llama a la funcion parser que separa por coma, archivo funciones.php
				$cont=0;
				while (($line=fgets($handle))!=false) {//mientras tenga lineas por leer
					if($cont==0){//se lee solo la primera linea, encabezados
						$linea = parser(limpiar($line),",");//Parser=funciones_comunes separa una hilera por un delimitador dado
					}else{
						$archivo.=limpiar($line).";";//limpiar= funciones_comunes
					}
					$cont++;
				}
				//si la linea de encabezados solo tiene una palabra no se acepta
				if(count($linea)==1){
					unset($linea);
					$errores[]="Archivo vacio, solamente tiene una linea";
				}
			    fclose($handle); 
			}else{
				$errores[]="No se puede leer el archivo";
			}
			require'vistas/vista_cargar.php';

		}
	}
?>