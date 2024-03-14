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

$ruta="assets/images/config/".$id.".jpg";

try {
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
            move_uploaded_file($archivo,"../".$ruta);
            //ACTUALIZAR RUTA
            $sql_ruta = "UPDATE configurador_historial SET foto_conf = '$ruta' WHERE id_conf = $id";
            mysqli_query($cn, $sql_ruta);
        }
    }else{
        echo "AS";
        $directorio = '../assets/images/config';

        // Obtener la lista de archivos de imagen en la carpeta
        $archivos = glob($directorio . '/*.jpg'); // Cambia el patrón según el tipo de imágenes que tengas

        // Verificar si se encontraron archivos
        if ($archivos) {
            // Extraer los números de los nombres de archivo y encontrar el máximo
            $maximo_numero = 0;
            foreach ($archivos as $archivo) {
                $numero = intval(basename($archivo, '.jpg'));
                $maximo_numero = max($maximo_numero, $numero);
            }

            // Construir el nombre del archivo de la última imagen
            $ultima_imagen = $directorio . '/' . $maximo_numero . '.jpg';
            
            // Imprimir la ruta de la última imagen
            echo 'La última imagen es: ' . $ultima_imagen;

            if(rename($ultima_imagen, $directorio . '/' . $id . '.jpg')){
                $sql_ruta = "UPDATE configurador_historial SET foto_conf = '$ruta' WHERE id_conf = $id";
                mysqli_query($cn, $sql_ruta);
            }
        } else {
            echo 'No se encontraron imágenes en la carpeta especificada.';
        }
    }
} catch (\Throwable $th) {
    
}

header('location: ../configuracion.php')
?>