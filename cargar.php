<?php 
	require_once('funciones/funciones_comunes.php');
	require_once('funciones/funciones_cargar.php');
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		if(isset($_FILES['file'])){
			//se verifica si el archivo está definido por filas o por columnas
			if(isset($_POST['colOrRow'])&&($_POST['colOrRow']=='col'||$_POST['colOrRow']=='row')){
				$colOrRow=$_POST['colOrRow'];
			}else{//por defecto si se inyectó algo distinto o no se selecciona nada, se utiliza por columnas que es el csv común y correcto.
				$colOrRow='col';
			}
			/*Se lee nombre, tamaño, nombre_temporal, tipo de archivo, extensión*/
			$file_name = $_FILES['file']['name'];
			$file_size =$_FILES['file']['size'];
			$file_tmp =$_FILES['file']['tmp_name'];
			$file_type=$_FILES['file']['type'];
			$file_ext=strtolower(end(explode('.',$_FILES['file']['name'])));
			$errores=verificarCsv($file_ext,$file_size);
			$handle = fopen($file_tmp, "r+");//se lee el archivo, sin necesidad de escritura.
			//si es un archivo por filas se lee y escribe sobre el, se deja abierto para la siguiente sección, así lo encuentra como si se definiera por columnas. 
			if($colOrRow=='row'&&$handle){
				$matrixDoc = [];
				$cont=0;//posición dentro de la matriz.
				//primero se lee todo en un vector, ya que se necesita leer por filas. Una columna, todas las filas.
				while (($line=fgets($handle))!=false) {//mientras tenga lineas por leer
					$linea = parser(limpiar($line),",");//Parser=funciones_comunes separa una hilera por un delimitador dado
					$linea[count($linea)-1] = trim(preg_replace('/\s+/', ' ', $linea[count($linea)-1]));//se elimina el salto de línea del ultimo elemento de la línea leída.
					//en este punto la línea actual es un vector.
					$matrixDoc[$cont]=$linea;
					$cont++;
				}
				//en este punto se tiene una matriz, cada espacio de matrixDoc es una fila del archivo.
				//se debe iterar para cada columna todas las filas.
				$newFile='';
				$cantidadFilas = count($matrixDoc[0]);//se toma de referencia la primer fila del texto original. ej nombre, juan, Luis
				$cantidadColumnas = count($matrixDoc)-1;//el tamaño de matrixDoc indica la cantidad de columnas. Ej nombre, apellido1, apellido2
				for($i=0;$i<$cantidadFilas;$i++){
					$cont=0;
					foreach ($matrixDoc as $col) {
						if($cont<$cantidadColumnas){
							$newFile.=$col[$i].',';
						}elseif($i<$cantidadFilas-1){//se agrega salto de línea al último elemento de la lista.
							$newFile.=$col[$i]."\n";
						}else{//solo aplica para la última fila en ser escrita, ya que no se quiere una línea vacía.
							$newFile.=$col[$i];
						}
						$cont++;
					}
				}
				file_put_contents($file_tmp,$newFile);//se sobre-escribe el archivo.
				rewind($handle);//una vez sobre-escrito se devuelve el puntero al inicio del archivo.
			}
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