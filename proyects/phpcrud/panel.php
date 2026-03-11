<?php
	session_start();
    date_default_timezone_set('America/Santiago');
    require('./assets/scripts/conexion.php');
    $conexion = new conexion_bd();   
?>

<!doctype html>
<html lang="en">
	
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="icon" type="image/x-icon" href="./assets/img/logo1.png" />
		<title>Documentos</title>

		<link href="../bootstrap5/css/bootstrap.min.css" rel="stylesheet">
        <link href="../fontawesome/css/fontawesome.css" rel="stylesheet">
        <link href="../fontawesome/css/brands.css" rel="stylesheet">
        <link href="../fontawesome/css/solid.css" rel="stylesheet">
        <link href="./assets/scripts/sweetalert2.min.css" rel="stylesheet">
		<link href="./assets/scripts/panel.css" rel="stylesheet">
		<link href="./assets/scripts/index.css" rel="stylesheet">
		<script src="../bootstrap5/js/bootstrap.bundle.min.js"></script>
        <script src="../jquery/jquery-3.7.1.min.js" crossorigin="anonymous"></script>
        <script src="./assets/scripts/sweetalert2.all.min.js"></script>
    </head>
  	<body>

        <main class="d-flex flex-nowrap vh-100">
            <div class="d-flex flex-column flex-shrink-0 p-3 bg-secondary" style="width: 200px;">
                <img class="mb-4" src="./assets/img/logo1.png" alt="" width="122" height="67">
                <b><?php echo $_SESSION['nombre']; ?></b>
                <hr>            
                <a href="panel.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
                    <span class="fs-4">Menu</span>
                </a>                
                <hr>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <a href="#" class="nav-link active" aria-current="page">Registros</a>
                    </li>
                    <br>
                <?php if ($_SESSION['perfil'] == "ADMIN") {  ?>
                    <li class="nav-item">
                        <a href="panelu.php" class="nav-link active" aria-current="page">Usuarios</a>
                    </li>
                    <br>
                    <li class="nav-item">
                        <a href="panela.php" class="nav-link active" aria-current="page">Tipo Documento</a>
                    </li>
                <?php } ?>    
                </ul>
                <hr>
                <div class="row">
                    <a href="./assets/scripts/desconectar.php" class="btn btn-danger">Salir</a>
                </div>
            </div>

            <div class="row w-100">
                <div class="col-15">
                    <div class="card mt-5" style="max-width: 100%; margin-left: auto; margin-right: auto;">
                        <div class="card-header bg-secondary">
                            <b>Busqueda Documentos por:</b><hr>
                            <div class="row">
                                <div class="col-md-2">
                                    <b>Tipo: </b><select class="form-select" id="filtro-area">
                                        <option value="">Todos</option>
                                        <?php
                                            $areas = $conexion->consultar("SELECT descripcion FROM areas ORDER BY descripcion DESC");
                                            while($obtener_area = $areas->fetch_assoc()){
                                                ?>
                                                        <option><?php echo $obtener_area['descripcion']; ?></option>
                                                <?php
                                            }
                                        ?>  
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <b>Texto: </b><br>
                                    <input name="buscacodigo" id="buscacodigo">
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="container bg-light">
                                <br>
                                <form method="post" action="./assets/scripts/scripts.php" enctype="multipart/form-data" id="form">
                                <div class="row">
                                    <div class="col-md-2">
                                        <select class="form-select" id="idarea" name="idarea">
                                            <?php $areas = $conexion->consultar("SELECT id_area, descripcion FROM areas ORDER BY descripcion DESC");
                                                while($obtener_area = $areas->fetch_assoc()){ ?>
                                                    <option value="<?php echo $obtener_area['id_area'] ?>"><?php echo $obtener_area['descripcion']; ?></option>
                                            <?php } ?>  
                                        </select>
                                    </div>    
                                    <div class="col-md-4">
                                        <input type="text" id="descripcion" name="descripcion" class="form-control" placeholder="Ingresa Descripcion" required>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="url" id="link" name="link" class="form-control" placeholder="Ingresa Enlace Drive">
                                    </div>
                                    <input type="text" id="ingeniero" name="ingeniero" value="" hidden="true">
                                    <input type="text" id="codigo" name="codigo" value="" hidden="true">
                                    <input type="text" id="revision" name="revision" value="0" hidden="true">
                                    <input type="text" id="estado" name="estado" value="Pendiente" hidden="true">
                                    <input type="hidden" id="funcion" name="funcion" value="3">
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-info btn-block">Agregar Documento</button>
                                    </div>
                                </div>
                                </form>
                                <br>
                            </div>

                            <table class="table table-bordered table-striped" id="tabla-usuarios">
                                <thead class="thead-dark text-center">
                                    <th scope="col">N°</th>
                                    <th scope="col">Tipo</th>
                                    <th scope="col">Descripcion</th>
                                    <th scope="col">Codigo</th>
                                    <th scope="col">Revision</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col">Ingeniero</th>
                                    <th scope="col">Drive</th>
                                    <th scope="col">Ult. Modificacion</th>
                                    <th scope="col"><?php if ($_SESSION['perfil'] == "ADMIN") {  ?>Acciones<?php } ?></th>
                                </thead>
                                <tbody id="documentos">
                                    <?php
                                        $documentos = $conexion->consultar("SELECT ds.descripcion AS descripcion, ar.descripcion AS area, ds.usuario_visualizacion, ds.fecha_visualizacion, ds.id_documento, ds.codigo, ds.revision, ds.estado, ds.ingeniero, ds.link FROM documentos ds INNER JOIN areas ar ON ds.id_area = ar.id_area ORDER BY ds.id_documento DESC");
                                        while($obtener_documento = $documentos->fetch_assoc()){
                                            ?>
                                                <tr>    
                                                    <td><?php echo $obtener_documento['id_documento']; ?></td>
                                                    <td><?php echo $obtener_documento['area']; ?></td>
                                                    <td><?php echo $obtener_documento['descripcion'] ?></td>
                                                    <td><?php echo $obtener_documento['codigo'] ?></td>
                                                    <td><?php echo $obtener_documento['revision'] ?></td>
                                                    <td><?php echo $obtener_documento['estado'] ?></td>
                                                    <td><?php echo $obtener_documento['ingeniero'] ?></td>
                                                    <td><?php if ($obtener_documento['link'] <> "") { ?>
                                                        <a href="<?php echo $obtener_documento['link']; ?>" target="_blank" onclick="ultima_visualizacion(<?php echo $obtener_documento['id_documento']; ?>);"><i class="fa-solid fa-link fa-beat fa-xs"></i></a>
                                                        <?php } ?></td>
                                                    <td><?php echo $obtener_documento['usuario_visualizacion'].' - '.date('d-m-y H:i', strtotime($obtener_documento['fecha_visualizacion'])); ?></td>
                                                    <td><?php if ($_SESSION['perfil'] == "ADMIN") {?>
                                                            <button class="btn btn-danger" onclick="eliminar(<?php echo $obtener_documento['id_documento']; ?>);">
                                                            <i class="fa-solid fa-trash-can fa-xs"></i></button> 
                                                        <?php if ($obtener_documento['estado'] == "Proceso") {?><button class="btn btn-success" onclick="editar(<?php echo $obtener_documento['id_documento']; ?>,'<?php echo $obtener_documento['area']; ?>','<?php echo $obtener_documento['descripcion']; ?>','<?php echo $obtener_documento['codigo']; ?>','<?php echo $obtener_documento['revision']; ?>','<?php echo $obtener_documento['estado']; ?>','<?php echo $obtener_documento['ingeniero']; ?>','<?php echo $obtener_documento['link']; ?>');" alt="Editar">
                                                            <i class="fa-solid fa-pen-to-square fa-xs"></i></button><?php } ?>
                                                            <?php if ($obtener_documento['estado'] == "Pendiente" or $obtener_documento['estado'] == "Finalizado") { ?>
                                                                <button class="btn btn-info" onclick="asignar(<?php echo $obtener_documento['id_documento']; ?>);"><i class="fa-solid fa-location-pin fa-xs"></i></button>
                                                            <?php } ?>
                                                        <?php } ?></td>
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
                $('#buscacodigo').on('keyup', function() {
                    var value = $(this).val().toLowerCase();
                    $("#tabla-usuarios tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                    });
                });
            });

            function eliminar(id_documento){

                Swal.fire({
                    text: "Seguro que quiere eliminar el documento "+id_documento,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url:"./assets/scripts/scripts.php",
                            type: "post",
                            data: {
                                funcion: 1,
                                id_documento: id_documento
                            }
                        }).done(function(response){
                            location.reload();
                        });
                    }
                });

            }

            function asignar(id_documento){

                Swal.fire({
                    text: "Confirma su asignacion al documento "+id_documento+" para su proceso ?",
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url:"./assets/scripts/scripts.php",
                            type: "post",
                            data: {
                                funcion: 7,
                                id_documento: id_documento
                            }       
                        }).done(function(response){
                            location.reload();
                        });
                    }
                });
            }       

            function ultima_visualizacion(id_documento){

                $.ajax({
                    url:"./assets/scripts/scripts.php",
                    type: "post",
                    data: {
                        funcion: 2,
                        id_documento: id_documento
                    }
                }).done(function(response){
                    $('#'+id_documento).text(response.fecha);
                    location.reload();
                });
                
            }

            function editar(id_documento,area,descripcion,codigo,revision,estado,ingeniero,link){

                Swal.fire({
                title: 'Modificar Documento '+id_documento,
                html:
                    `<form method="post" action="./assets/scripts/scripts.php" enctype="multipart/form-data">
                        <table>
                            <tr>
                                <td>Documento:</td>
                                <td><b>${area}</b></td>
                            </tr>    
                                <td>Descripcion:</td>
                                <td><input class="form-control" id="descripcion" name="descripcion" value="${descripcion}" required></td>
                            <tr>    
                                <td>Codigo:</td>
                                <td><input class="form-control" id="codigo" name="codigo" value="${codigo}" required></td>
                            </tr>
                            <tr>
                                <td>Revision:</td>
                                <td><input class="form-control" id="revision" name="revision" value="${revision}" required></td>
                            </tr>
                            <tr>
                                <td>Ingeniero:</td>
                                <td><input class="form-control" id="ingeniero" name="ingeniero" value="${ingeniero}" required></td>
                            </tr>
                            <tr>
                                <td>Estado:</td>
                                <td><select class="form-select mb-2" id="estado" name="estado" value="${estado}">
                                        <option value="Proceso">Proceso</option>
                                        <option value="Finalizado">Finalizado</option>
                                    </select></td>
                            </tr>
                            <tr>
                                <td>Enlace:</td>
                                <td><input type="url" class="form-control" id="link" name="link" value="${link}" required></td>
                            </tr>
                        </table>    
                        <input type="hidden" id="funcion" name="funcion" value="8">
                        <input type="hidden" id="id_documento" name="id_documento" value="${id_documento}">
                        <br>
                        <div class="row g-2 align-items-center">
                            <div class="col-auto">
                                <button class="btn btn-success mb-2" type="submit">Actualizar Documento</button>
                            </div>    
                        </div>    
                        <br>
                    </form>` ,
                showCancelButton: false,
                showConfirmButton: false
                });

            }            
        </script>

  	</body>
</html>
