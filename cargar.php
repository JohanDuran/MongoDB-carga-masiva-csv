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
			if ($handle) {/*Si se pudo leer*/
				$linea = parser(fgets($handle));
				if(count($linea)===1){
					unset($linea);
					$errores[]="Archivo vacio";
				}
			    fclose($handle); 
			}else{
				$errores[]="No se puede leer el archivo";
			}
			$indices=array('Institucion','email','Estacion','Nombre','Fecha','Hora','Latitud','Longitud','Location','pO2','dbo','nh4','Color','Porcentaje O2','DBO','NH4','CF','pH','Fosfato','Nitrato','t','turbidez','Sólidos totales','DQO','EC','PO4','GYA','SD','Ssed','SST','ST','SAAM','Aforo');
			require'vistas/vista_cargar.php';

		}
	}
?>