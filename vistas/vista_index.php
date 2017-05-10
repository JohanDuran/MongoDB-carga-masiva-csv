<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Seleccione</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="css/estilos.css">
</head>
<body>
	<div class="container">
	    <h2>Subir archivos csv</h2>
		<form action="cargar.php" method="post" onsubmit="return validateFile()" enctype="multipart/form-data">
		<div class="form-group">
			<label for="fileToUpload">Seleccione archivo:</label>
		    <input type="file" id="archivo" class="filestyle" data-buttonName="btn-primary" name="file" id="fileToUpload">
		</div>
	    	<input type="submit" class="btn btn-default" value="Cargar archivo" name="submit">
		</form>
	</div>



	<!-- JQUERY -->
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.1.1.min.js"></script>

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/bootstrap-filestyle.min.js"> </script>
	<script src="js/scripts_index.js"></script>

</body>
</html>