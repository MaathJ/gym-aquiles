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
echo $nombres;

if($archivo !=null){
    $lastDotPosition = strrpos($nombres, ".");
    if ($lastDotPosition !== false) {
        $n = substr($nombres, 0, $lastDotPosition);
        $e = substr($nombres, $lastDotPosition + 1);
    } else {
        // Si no hay punto en el nombre del archivo, manejar según tus necesidades
        // Puedes asignar un valor predeterminado a $n y $e, o mostrar un mensaje de error, etc.
        $n = $nombres;
        $e = '';
    }

    $allowedExtensions = ['png', 'jpg', 'jpeg', 'JPG', 'JPEG'];
    $imageInfo = getimagesize($archivo);

    if ($imageInfo && in_array($e, $allowedExtensions) && ($imageInfo[2] == IMAGETYPE_JPEG || $imageInfo[2] == IMAGETYPE_PNG)) {
        //ACTUALIZAR ESTADO A INACTIVO
        $sql_in = "UPDATE configurador_historial SET estado_conf = 'INACTIVO'";
        mysqli_query($cn, $sql_in);

        //CREAR EL NUEVO REGISTRO
        $sql="INSERT INTO configurador_historial
            (txt_negocio, ruc_negocio, direccion_negocio, telefono_negocio, colorValue_negocio, estado_conf) 
            VALUES
            ('$name', '$ruc', '$dire', '$tele', '$colorValue', 'ACTIVO')";

        mysqli_query($cn, $sql);
        $id = mysqli_insert_id($cn);

        $ruta="assets/images/config/".$id.".jpg";
        move_uploaded_file($archivo,"../".$ruta);

        //ACTUALIZAR RUTA
        $sql_ruta = "UPDATE configurador_historial SET foto_conf = '$ruta' WHERE id_conf = $id";
        mysqli_query($cn, $sql_ruta);
        /* header('location: ../configuracion.php'); */
    }else{
        /* header('location:../configuracion.php'); */
    }
}else{
    echo "AS";
    /* header('location:../configuracion.php'); */
}


?>