<?php
	session_start();
    date_default_timezone_set('America/Santiago');
    require('scripts/conexion.php');
    $conexion = new conexion_bd();
?>

<!doctype html>
<html lang="en">
	
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="icon" type="image/x-icon" href="IMG/logo1.png" />
		<title>Usuarios</title>
		
		<link href="../bootstrap5/css/bootstrap.min.css" rel="stylesheet">
        <link href="../fontawesome/css/fontawesome.css" rel="stylesheet">
        <link href="../fontawesome/css/brands.css" rel="stylesheet">
        <link href="../fontawesome/css/solid.css" rel="stylesheet">
        <link href="scripts/sweetalert2.min.css" rel="stylesheet">
		<link href="scripts/panel.css" rel="stylesheet">
		<link href="scripts/index.css" rel="stylesheet">
		<script src="../bootstrap5/js/bootstrap.bundle.min.js"></script>
        <script src="../jquery/jquery-3.7.1.min.js" crossorigin="anonymous"></script>
        <script src="scripts/sweetalert2.all.min.js"></script>
     </head>

  	<body>

        <main class="d-flex flex-nowrap vh-100">
  
            <div class="d-flex flex-column flex-shrink-0 p-3 bg-secondary" style="width: 200px;">
                <img class="mb-4" src="IMG/logo1.png" alt="" width="122" height="67">
                <b><?php echo $_SESSION['nombre']; ?></b>
                <hr>            
                <a href="panel.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
                    <span class="fs-4">Menu</span>
                </a>                
                <hr>

                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <a href="panel.php" class="nav-link active" aria-current="page">Registros</a>
                    </li>
                    <br>
                    <?php if ($_SESSION['perfil'] == "ADMIN") {  ?>
                    <li class="nav-item">
                        <a href="#" class="nav-link active" aria-current="page">Usuarios</a>
                    </li>
                    <br>
                    <li class="nav-item">
                        <a href="panela.php" class="nav-link active" aria-current="page">Tipo Documento</a>
                    </li>
                    <?php } ?>
                </ul>

                <hr>

                <div class="row">
                    <a href="BD/desconectar.php" class="btn btn-danger">Salir</a>
                </div>

            </div>
        

            <div class="row w-100">

                <div class="col-12">

                    <div class="card mt-5" style="max-width: 50%; margin-left: auto; margin-right: auto;">

                        <div class="card-header">

                            <div class="row justify-content-end">

                                <div class="col-3">
                                    <button class="btn btn-success" onclick="agregar();">Agregar</button>
                                </div>

                            </div>

                        </div>

                        <div class="card-body">
                            
                            <table class="table table-bordered table-striped" id="tabla-usuarios">
                                <thead>
                                    <tr class="text-center">
                                        <th>Usuario</th>
                                        <th>Contraseña</th>
                                        <th>Nombre</th>
                                        <th>Perfil</th>
                                        <th>Rut</th>
                                        <th>Correo</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $documentos = $conexion->consultar("SELECT * FROM usuarios ORDER BY usuario ASC");
                                        while($obtener_documento = $documentos->fetch_assoc()){
                                            ?>
                                                <tr>    
                                                    <td><?php echo $obtener_documento['usuario']; ?></td>
                                                    <td><?php echo $obtener_documento['contraseña']; ?></td>
                                                    <td><?php echo $obtener_documento['nombre']; ?></td>
                                                    <td><?php echo $obtener_documento['perfil']; ?></td>
                                                    <td><?php echo $obtener_documento['rut']; ?></td>
                                                    <td><?php echo $obtener_documento['correo']; ?></td>
                                                    <td><button class="btn btn-danger" onclick="eliminar('<?php echo $obtener_documento['usuario']; ?>');"><i class="fa-solid fa-trash-can fa-xs"></i></button></td>
                                                </tr>
                                            <?php
                                        }
                                    
                                    ?>                            
                                
                                </tbody>
                                
                            </table>
                                
                        </div>

                    </div>
                
                </div>

            </div>
        </main>

        <script>
            $(document).ready(function() {
                $('#filtro-area').on('change', function() {
                    var filtro = $(this).val().toLowerCase();
                    
                    $('#tabla-usuarios tbody tr').each(function() {
                    var area = $(this).find('td:eq(1)').text().toLowerCase();

                    if (filtro === '' || area.includes(filtro)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                    });
                });
            });

            function eliminar(usuario){

                Swal.fire({
                    text: "Seguro que quiere eliminar el usuario: "+usuario,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url:"scripts/scripts.php",
                            type: "post",
                            data: {
                                funcion: 4,
                                usuario: usuario
                            }
                        }).done(function(response){
                            location.reload();
                        });
                    }
                });

            }

            function agregar(){

                Swal.fire({
                    title: 'Registro Usuario',
                    html:
                        `<form method="post" action="scripts/scripts.php" enctype="multipart/form-data">
                            <table>
                                <tr>
                                    <td><b>Codigo:</b></td>
                                    <td><input class="form-control" id="usuario" name="usuario" required></td>
                                </tr>
                                <tr>
                                    <td><b>Contraseña:</b></td>
                                    <td><input class="form-control" id="contraseña" name="contraseña" autocomplete="off" required></td>
                                </tr>
                                <tr>
                                    <td><b>Nombre:</b></td>
                                    <td><input class="form-control" id="nombre" name="nombre" required></td>
                                </tr>
                                <tr>
                                    <td><b>Rut:</b></td>
                                    <td><input class="form-control" id="rut" name="rut"></td>
                                </tr>
                                <tr>
                                    <td><b>Correo:</b></td>
                                    <td><input type="email" class="form-control" id="correo" name="correo" required></td>
                                </tr>
                                <tr>
                                    <td><b>Perfil:</b></td>
                                    <td><select class="form-select mb-2" id="perfil" name="perfil">
                                        <option value="USER">USER</option>
                                        <option value="ADMIN">ADMIN</option>
                                    </select></td>
                                </tr>
                            </table>
                            <input type="hidden" id="funcion" name="funcion" value="5">
                            <br><button class="btn btn-success mb-2" type="submit">Agregar</button>
                        '</form>` ,
                    showCancelButton: false,
                    showConfirmButton: false
                });
                
            }

        </script>

  	</body>
</html>
