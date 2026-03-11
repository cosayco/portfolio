<?php
	date_default_timezone_set('America/Santiago');

	if(isset($_POST['usuario']) && isset($_POST['contraseña'])){
		$usuario = $_POST['usuario'];
		$contraseña = $_POST['contraseña'];

		require ('.assets/scripts/conexion.php');
	
		$conexion = new conexion_bd();
	
		$credenciales = $conexion->consultar("SELECT * FROM usuarios WHERE usuario = '$usuario' AND contraseña = '$contraseña'");	

		if($credenciales->num_rows > 0){
			$credenciales = $credenciales->fetch_assoc();
			session_start();
			$_SESSION['ativo'] = true;
			$_SESSION['nombre'] = $credenciales['nombre'];
			$_SESSION['usuario'] = $credenciales['usuario'];
			$_SESSION['id_area'] = $credenciales['id_area'];
			$_SESSION['perfil'] = $credenciales['perfil'];
			$_SESSION['rut'] = $credenciales['rut'];
			$_SESSION['correo'] = $credenciales['correo'];
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
		<link rel="icon" type="image/x-icon" href="./assets/img/logo1.png" />
		<title>Inicio</title>

		<link href="../assets/bootstrap5/css/bootstrap.min.css" rel="stylesheet">
        <link href="../assets/fontawesome/css/fontawesome.css" rel="stylesheet">
        <link href="../assets/fontawesome/css/brands.css" rel="stylesheet">
        <link href="../assets/fontawesome/css/solid.css" rel="stylesheet">
        <link href="../assets/scripts/sweetalert2.min.css" rel="stylesheet">
		<link href="./assets/scripts/panel.css" rel="stylesheet"> 
		<link href="./assets/scripts/index.css" rel="stylesheet">

		<script src="../assets/bootstrap5/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/jquery/jquery-3.7.1.min.js" crossorigin="anonymous"></script>
        <script src="../assets/scripts/sweetalert2.all.min.js"></script>
	</head>

  	<body class="text-center">
    
		<main class="form-signin w-100 m-auto">
			<form method="post" action="index.php">
				<img class="mb-4" src="./assets/img/logo1.png" alt="" width="72" height="57">
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
				if($_GET['error'] == 0){ ?>
					<script> 
					 Swal.fire(
 					  'Error Inicio',
  					  'Usuario no registrado o incorrecto.',
  					  'warning' ); 
					</script>
				<?php 	
				}else if($_GET['error'] == 1){ ?>
					<script> 
					 Swal.fire(
 					  'Cerrar Sesion',
  					  'Se ha cerrado la sesion sin problemas!',
  					  'success' ); 
					</script>
				<?php 	 
				} 
			}
			
		?>

  	</body>
</html>
