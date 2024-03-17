<?php
include('../config/dbconnect.php');

$name = $_POST['txt_name'];
$ruc = $_POST['txt_ruc'];
$dire = $_POST['txt_direccion'];
$tele = $_POST['txt_telefono'];
$colorValue = $_POST['color_value'];

$ruta="";

//ACTUALIZAR ESTADO A INACTIVO
$sql_in = "UPDATE configurador_historial SET estado_conf = 'INACTIVO'";
mysqli_query($cn, $sql_in);

//CREAR EL NUEVO REGISTRO
$sql="INSERT INTO configurador_historial
    (txt_negocio, ruc_negocio, direccion_negocio, telefono_negocio, color_negocio, estado_conf) 
    VALUES
    ('$name', '$ruc', '$dire', '$tele', '$colorValue', 'ACTIVO')";

mysqli_query($cn, $sql);
$id = mysqli_insert_id($cn);

try {
    if(isset($_FILES['foto']) && $_FILES['foto']['error'] == UPLOAD_ERR_OK) {
        $foto_nombre = $_FILES['foto']['name'];
        $foto_temp = $_FILES['foto']['tmp_name'];

        $ruta = "../assets/images/config/" . $id . ".jpg";
        
        // Verificar si el directorio de destino existe
        if (!file_exists("../assets/images/config/")) {
            // Si no existe, intenta crearlo
            if (!mkdir("../assets/images/config/", 0755, true)) {
                throw new Exception("No se pudo crear el directorio de destino.");
            }
        }
        
        // Mover la imagen a la ubicación deseada
        if (!move_uploaded_file($foto_temp, $ruta)) {
            throw new Exception("Error al mover la imagen al directorio de destino.");
        }
        
        //ACTUALIZAR RUTA
        $sql_ruta = "UPDATE configurador_historial SET foto_conf = '$ruta' WHERE id_conf = $id";
        if (!mysqli_query($cn, $sql_ruta)) {
            throw new Exception("Error al actualizar la ruta de la imagen en la base de datos.");
        }
    }
} catch (Exception $e) {
    echo "Error al procesar la imagen: " . $e->getMessage();
}

header('location: ../configuracion.php');
?>