<?php 
	require_once('funciones/funciones.php');
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		if(isset($_FILES['file'])){
			$file_name = $_FILES['file']['name'];
			$file_size =$_FILES['file']['size'];
			$file_tmp =$_FILES['file']['tmp_name'];
			$file_type=$_FILES['file']['type'];
			$file_ext=strtolower(end(explode('.',$_FILES['file']['name'])));
			$errores=verificarCsv($file_ext,$file_size);
			$handle = fopen($file_tmp, "r");
			$linea="";
			$archivo="";
			$indices=getFilds();
			if ($handle) {/*Si se pudo leer*/
				//se llama a la funcion parser que separa por coma, archivo funciones.php
				$cont=0;
				while (($line=fgets($handle))!=false) {
					if($cont==0){
						$linea = parser(limpiar($line),",");//se lee solo la primera linea, encabezados	
					}else{
						$archivo.=limpiar($line).";";
					}
					$cont++;
				}
				//si la linea solo tiene una palabra no se acepta
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