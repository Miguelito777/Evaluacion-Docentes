<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Ejemplo Grillas</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/estilos.css">

	</head>
<body ="bodyindex">

<div class="container-fluid well" id="encabezado">
	<div class="row">
	<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2	 ">
	<img src="logo.png" class="img-responsive" id="log1">
	</div> 	
	<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 visible-xs visible-sm visible-md visible-lg">Conocereis la verdad y la verdad os hara libres</div>
	</div>

</div>
<div class="container-fluid well" id="dellogin">
	<div class="row">
		<div class="col-xs-12">
			<img src="logo.png" class="img-responsive" id="Log">
		</div>
	</div>
	<div class="login" action="check.php" method="POST">
			<div class="form-group">
				<input type="user" class="form-control" placeholder="Usuario" name="user" requerid autofocus>
			</div>		
			<div class="form-group">
				<input type="password" class="form-control" placeholder="Contraseña" name="pass" requerid>
			</div>	
		<a href="suite.php"><button class="btn btn-lg btn-primary btn-block" type="submit" >Iniciar sesión</button </a>	
	</div>
</div>






	<script type="js/jquery-1.11.2.min.js"></script>
	<script type="js/bootstrap.js"></script>
</body>
</html>