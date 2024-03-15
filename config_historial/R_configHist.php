<?php
include('../config/dbconnect.php');

$name = $_POST['txt_name'];
$ruc = $_POST['txt_ruc'];
$dire = $_POST['txt_direccion'];
$tele = $_POST['txt_telefono'];
$colorValue = $_POST['color_value'];

$ruta="";

$archivo = $_FILES['foto']["tmp_name"]; 
$nombres=$_FILES["foto"]["name"];

if($archivo != null){
    $lastDotPosition = strrpos($nombres, ".");
    if ($lastDotPosition !== false) {
        $n = substr($nombres, 0, $lastDotPosition);
        $e = substr($nombres, $lastDotPosition + 1);
    } else {
        // Manejo del nombre del archivo si no hay punto en el nombre
        $n = $nombres;
        $e = '';
    }

    $allowedExtensions = ['png', 'jpg', 'jpeg'];
    $imageInfo = getimagesize($archivo);

    if ($imageInfo && in_array($e, $allowedExtensions) && ($imageInfo[2] == IMAGETYPE_JPEG || $imageInfo[2] == IMAGETYPE_PNG)) {
        // Actualizar estado a INACTIVO
        $sql_in = "UPDATE configurador_historial SET estado_conf = 'INACTIVO'";
        mysqli_query($cn, $sql_in);

        // Insertar nuevo registro
        $sql="INSERT INTO configurador_historial
            (txt_negocio, ruc_negocio, direccion_negocio, telefono_negocio, color_negocio, estado_conf) 
            VALUES
            ('$name', '$ruc', '$dire', '$tele', '$colorValue', 'ACTIVO')";

        mysqli_query($cn, $sql);
        $id = mysqli_insert_id($cn);

        $ruta="assets/images/config/".$id.".jpg";
        move_uploaded_file($archivo,"../".$ruta);

        // Actualizar ruta
        $sql_ruta = "UPDATE configurador_historial SET foto_conf = '$ruta' WHERE id_conf = $id";
        mysqli_query($cn, $sql_ruta);
        // Redirigir a la página de configuración
        header('location: ../configuracion.php'); 
        exit();
    } else {
        // Redirigir a la página de configuración si la imagen no es válida
        header('location:../configuracion.php'); 
        exit();
    }
} else {
    // No se proporcionó ningún archivo, establecer una imagen por defecto
    $rutaDefecto = "assets/images/config/Company.jpg";
    $sql_in = "UPDATE configurador_historial SET estado_conf = 'INACTIVO'";
        mysqli_query($cn, $sql_in);
    // Insertar nuevo registro con ruta por defecto
    $sql="INSERT INTO configurador_historial
        (txt_negocio, ruc_negocio, direccion_negocio, telefono_negocio, color_negocio, estado_conf, foto_conf) 
        VALUES
        ('$name', '$ruc', '$dire', '$tele', '$colorValue', 'ACTIVO', '$rutaDefecto')";

    mysqli_query($cn, $sql);
    $id = mysqli_insert_id($cn);

    // Redirigir a la página de configuración
    header('location:../configuracion.php'); 
    exit();
}

?>
