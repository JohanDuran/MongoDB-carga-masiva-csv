<!DOCTYPE HTML>
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
		<!-- The Modal -->
		<div id="myModal" class="modal">

		  <!-- Modal content -->
		  <div class="modal-content">
		    <div class="modal-header">
		      <span class="close">&times;</span>
		      <h2>Monitoreo Agua</h2>
		    </div>
		    <div class="modal-body">
		      <p>En necesario hacer match de todos los parámetros obligatorios</p>
		      <p>Parámetros obligatorios: Lat, Lng</p>
		    </div>
		    <div class="modal-footer">
		      <h3>Universidad de Costa Rica - 2017</h3>
		    </div>
		  </div>
		</div>		

		<div class="center">
			<h2 class>Pareo</h2>
			<div class="alert alert-info ">Arrastre los elementos de la derecho con su correspondiente de la izquierda.</div>
		</div>
<!--<div class="alert alert-success center">
		Elementos cargados con exito Acá va código php posterior a la carga
	</div> -->	
			<!-- Seccion de exito -->
			<?php if (empty($errores)&& !empty($linea)):?><!-- Caso donde no existen errores, monstrar lo indicado --> 
				<div class="row">
					<div id="dinamicos" class="col-md-4 col-sm-4 col-xs-4 border-shadaw">
							<?php  $contador=50;?><!-- del 50 en adelante son los nuevos -->
							<?php foreach ($linea as $palabra):?>
								<!-- Las opciones dadas por el usuario -->
								<span name="contenedor" id='<?php echo $contador++;?>' class="btn btn-info double-size" ondrop="drop(event)" ondragover="allowDrop(event)"> 
									<?php 
										if (strlen($palabra) <= 13) {
											echo $palabra;
										}else{
											echo substr($palabra, 0,13);
										}
									?>
								</span>
							<?php endforeach;?>
					</div>
					<div id="estaticos" class="col-md-8 col-sm-8 col-xs-8 border-shadaw" ondrop="drop(event)" ondragover="allowDrop(event)">
						<?php  $contador=0;?> <!-- tiene 50 espacios en caso de necesitar mas cambiarlo arriba -->
						<!-- Todas las opciones para hacer match -->
						<?php foreach ($indices as $indice):?>
							<span id="<?php echo $contador++; ?>" class="same-size btn btn-success" draggable="true" ondragstart="drag(event)" >
								<?php echo $indice; ?>
							</span>
						<?php endforeach;?>
					</div>
				</div>
				<br>
				<br>
				<br>
				<form action="insertarEnBD.php" method="POST" onsubmit="return validateForm()" class="center">
					<input type="text" name="archivo" value="<?php echo $archivo ?>" class="oculto" id="archivo">
					<input type="text" name="colOrRow" value="<?php echo $colOrRow ?>" class="oculto" id="colOrRow">
					<input type="submit" class="btn btn-primary">
					<a href="index.php"><button class="btn btn-default">Cancelar</button></a>
				</form>
				<br>
				<br>
				<br>
				<br>
		<!-- Seccion de errores -->
		<?php else: ?>	<!-- Caso donde si existen errores, mostar errores y opcion de volver -->
			<?php foreach ($errores as $error => $value):?>
				<p><?php echo $value; ?></p>
			<?php endforeach;?>
		<?php endif; ?>
	</div>
		<!-- JQUERY -->
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.1.1.min.js"></script>
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<script src="js/scripts_cargar.js"></script>

    
</body>
</html>
