<?php

	date_default_timezone_set('America/Santiago');

	if(isset($_POST['usuario']) && isset($_POST['contraseña'])){

		$usuario = $_POST['usuario'];
		$contraseña = $_POST['contraseña'];

		require ('BD/conexion.php');
	
		$conexion = new conexion_bd();
	
		$credenciales = $conexion->consultar("SELECT * FROM usuarios WHERE usuario = '$usuario' AND contraseña = '$contraseña'");	

		if($credenciales->num_rows > 0){
			$credenciales = $credenciales->fetch_assoc();
			session_start();
			$_SESSION['ativo'] = true;
			$_SESSION['nombre'] = $credenciales['nombre'];
			$_SESSION['usuario'] = $credenciales['usuario'];
			$_SESSION['id_area'] = $credenciales['id_area'];
			header('Location: panel.php');
		}else{
			header('Location: index.php?error=0');
		}

	}

?>

<!doctype html>
<html lang="en">
	
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="icon" type="image/x-icon" href="IMG/logo.png" />
		<title>Inicio</title>
		<link href="CSS/index.css" rel="stylesheet">

		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
	</head>

  	<body class="text-center">
    
		<main class="form-signin w-100 m-auto">
			<form method="post" action="index.php">
				<img class="mb-4" src="IMG/logo.png" alt="" width="72" height="57">
				<h1 class="h3 mb-3 fw-normal">Ingrese sus credenciales</h1>

				<div class="form-floating">
					<input type="text" class="form-control" id="usuario" name="usuario" required>
					<label for="usuario">Usuario</label>
				</div>

				<div class="form-floating">
					<input type="password" class="form-control" id="contraseña" name="contraseña" required>
					<label for="contrasela">Contraseña</label>
				</div>

				<button class="w-100 btn btn-lg btn-primary" type="submit">Ingresar</button>

			</form>
		</main>

		<?php 

			if(isset($_GET['error'])){
				if($_GET['error'] == 0){
					echo "<script>alert('Usuario no registrado o incorrecto.')</script>";
				}else if($_GET['error'] == 1){
					echo "<script>alert('Session cerrada.')</script>";
				} 
			}
			
		?>

  	</body>
</html>
