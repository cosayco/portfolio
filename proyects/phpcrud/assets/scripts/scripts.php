<?php
    session_start();
    date_default_timezone_set('America/Santiago');
    $funcion = $_POST['funcion'];

    switch($funcion){

        case 1: //eliminar documento

            require('conexion.php');
            $conexion = new conexion_bd();

            $id_documento = $_POST['id_documento'];
        
            try{

                $conexion->consultar("DELETE FROM documentos WHERE id_documento = $id_documento");
                $response['success'] = true;
            }catch(Exception $e){
                $response['success'] = false;  

            }
            
            header('Content-Type: application/json');
            echo json_encode($response, JSON_FORCE_OBJECT);  

            break;

        case 2: //ultima visualizacion documento

            require('conexion.php');
            $conexion = new conexion_bd();

            $id_documento = $_POST['id_documento'];
            $usuario = $_SESSION['usuario'];
            $fecha = date('Y-m-d H:i:s');
        
            try{

                $conexion->consultar("UPDATE documentos SET usuario_visualizacion = '$usuario', fecha_visualizacion = '$fecha' WHERE id_documento = $id_documento");

                $response['fecha'] =  $usuario.' - '.date('d-m-Y H:i:s', strtotime($fecha));
                $response['success'] = true;
            }catch(Exception $e){
                $response['success'] = false;  

            }
            
            header('Content-Type: application/json');
            echo json_encode($response, JSON_FORCE_OBJECT);  

            break;

        case 3: //agregar documento

            require('conexion.php');
            $conexion = new conexion_bd();

            $usuario = $_SESSION['usuario'];
            $id_area = $_POST['idarea'];
            $fecha = date('Y-m-d H:i:s');
            $xdescripcion = $_POST['descripcion'];
            $xcodigo = $_POST['codigo'];
            $xrevision = $_POST['revision'];
            $xestado = $_POST['estado'];
            $xlink = $_POST['link'];
            $xingeniero = $_POST['ingeniero'];
            
            $conexion->consultar("INSERT INTO documentos VALUES(NULL,'$xdescripcion',$id_area,'$xcodigo','$xrevision','$xestado','$xingeniero','$xlink','$usuario','$fecha')");    

            header('Location: ../panel.php');

            break;
        
        case 4: //eliminar usuario

            require('conexion.php');
            $conexion = new conexion_bd();
    
            $xusuario = $_POST['usuario'];
            
            try{
                $conexion->consultar("DELETE FROM usuarios WHERE usuario = '$xusuario'");
                $response['success'] = true;
            }catch(Exception $e){
                $response['success'] = false;  
            }
                
            header('Content-Type: application/json');
            echo json_encode($response, JSON_FORCE_OBJECT);  
    
            break;
            
        case 5: //agregar usuario

            require('conexion.php');
            $conexion = new conexion_bd();
        
            $xusuario = $_POST['usuario'];
            $xcontraseña = $_POST['contraseña'];
            $xnombre = $_POST['nombre'];
            $xperfil = $_POST['perfil'];
            $xrut = $_POST['rut'];
            $xcorreo = $_POST['correo'];
        
            $conexion->consultar("INSERT INTO usuarios VALUES('$xusuario','$xcontraseña','$xnombre','$xperfil','$xrut','$xcorreo')");    
                    
            header('Location: ../panelu.php');
        
            break;

        case 6: //agregar tipo documento

            require('conexion.php');
            $conexion = new conexion_bd();
            $xdescripcion = $_POST['descripcion'];
            $conexion->consultar("INSERT INTO areas VALUES(NULL,'$xdescripcion')");    
                        
            header('Location: ../panela.php');
            break;

        case 7: //asignar ingeniero a documento

            require('conexion.php');
            $conexion = new conexion_bd();
            $xid_documento = $_POST['id_documento'];
            $xnombre = $_SESSION['nombre'];
            $conexion->consultar("UPDATE documentos SET ingeniero = '$xnombre', estado = 'Proceso' WHERE id_documento = '$xid_documento'");    
                            
            header('Location: ../panela.php');
               
            break;

        case 8: //actualizar documento

            require('conexion.php');
            $conexion = new conexion_bd();
    
            $xid_documento = $_POST['id_documento'];
            $xusuario = $_SESSION['usuario'];
            $xfecha = date('Y-m-d H:i:s');
            $xdescripcion = $_POST['descripcion'];
            $xcodigo = $_POST['codigo'];
            $xrevision = $_POST['revision'];
            $xestado = $_POST['estado'];
            $xlink = $_POST['link'];
            $xingeniero = $_POST['ingeniero'];
                
            $conexion->consultar("UPDATE documentos SET ingeniero='$xingeniero', estado='$xestado', codigo='$xcodigo', usuario_visualizacion='$xusuario', fecha_visualizacion='$xfecha', descripcion='$xdescripcion', link='$xlink', revision='$xrevision' WHERE id_documento = '$xid_documento'");    
            header('Location: ../panel.php');
   
            break;

    }
?>