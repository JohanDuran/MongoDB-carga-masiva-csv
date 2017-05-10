<?php 
	function limpiar($cadena){
		$cadena = str_replace(' ', '', $cadena);
		htmlspecialchars($cadena);
		return $cadena;
	}

	function parser($cadena,$delimiter){
		return explode($delimiter, $cadena);
	}

 ?>
