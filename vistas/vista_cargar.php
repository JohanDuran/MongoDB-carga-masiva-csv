<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Cargar</title>
</head>
<body>
	<!-- Seccion de exito -->
	<?php if (empty($errores)&& !empty($linea)):?><!-- Caso donde no existen errores, monstrar lo indicado --> 
		<?php foreach ($linea as $palabra => $value):?><!-- Las opciones dadas por el usuario -->
			<button><?php echo $value; ?></button>
		<?php endforeach;?>
		<br><br>
		<!-- Todas las opciones para hacer match -->
		<?php foreach ($indices as $indice => $value):?><!-- Las opciones dadas por el usuario -->
			<button><?php echo $value; ?></button>
		<?php endforeach;?>
		<br>
		<br>
		<br>
		<!-- Se muestra el json aun no se ha cargado con datos nuevos -->
		<?php 
			insertar($file_tmp,',');
		?>
		<!-- Seccion de errores -->
	<?php else: ?>	<!-- Caso donde si existen errores, mostar errores y opcion de volver -->
		<?php foreach ($errores as $error => $value):?>
			<p><?php echo $value; ?></p>
		<?php endforeach;?>
	<?php endif; ?>
</body>
</html>
