<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>Cargar</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="css/estilos.css">
</head>
<body>
	<div class="container">
		<div class="center">
			<h2 class>Pareo</h2>
			<h3>Seleccione los elementos de la izquierda que corresponden a los de la derecha.</h3>
		</div>
			<!-- Seccion de exito -->
			<?php if (empty($errores)&& !empty($linea)):?><!-- Caso donde no existen errores, monstrar lo indicado --> 
				<div class="row">
					<div class="col-md-6 col-sm-6 col-xs-6 border-shadaw">
							<?php  $contador=0;?>
							<?php foreach ($linea as $palabra => $value):?>
								<!-- Las opciones dadas por el usuario -->
								<button class="btn btn-danger same-size" onclick="button_id(this)" value='<?=$contador?>'> 
									<?php echo $value; $contador++; ?>
									
								</button>
							<?php endforeach;?>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-6 border-shadaw">
						<!-- Se define una cantidad por fila igual a la presente en el if utilizando modulo -->
						<?php $cantidad_fila=0; ?>
						<!-- Todas las opciones para hacer match -->
						<?php foreach ($indices as $indice => $value):?>
							<!-- Las opciones dadas por el usuario -->
							<button  class="btn btn-primary same-size" ><?php echo $value; ?></button>
						<?php endforeach;?>
					</div>
				</div>
		<!-- Se muestra el json aun no se ha cargado con datos nuevos -->
		<?php 
			//insertar($file_tmp,',');
		?>
		<!-- Seccion de errores -->
		<?php else: ?>	<!-- Caso donde si existen errores, mostar errores y opcion de volver -->
			<?php foreach ($errores as $error => $value):?>
				<p><?php echo $value; ?></p>
			<?php endforeach;?>
		<?php endif; ?>
	
	</div>
    <script src="js/scripts.js"></script>
		<!-- JQUERY -->
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.1.1.min.js"></script>
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>
</html>
