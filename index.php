<?php
	$insertado = 0;
	if($_SERVER["REQUEST_METHOD"]=="GET"){
		if(isset($_GET["insertado"])){
			$insertado=$_GET["insertado"];
		}
	} 
	require'vistas/vista_index.php';
?>