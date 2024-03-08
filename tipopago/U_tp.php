<?php
include_once('../auth.php');
include('../config/dbconnect.php');
 
$id = $_POST['id'];
$desc = $_POST['desc'];

$sql = "UPDATE tipo_pago SET desc_tp = '$desc' WHERE id_tp = $id";

$f = mysqli_query($cn,$sql);

//ACTUALIZAR FOTO
try {
    $archivo = $_FILES['foto']["tmp_name"]; 
    $nombres = $_FILES['foto']["name"];

    if($archivo !=null){
        list($n,$e)=explode(".", $nombres);
        if ($e=="png" || $e=="jpg" || $e=="jpeg") {
            move_uploaded_file($archivo,"../assets/images/tipoPago/" . $id . ".jpg");
        }
    }
} catch (\Throwable $th) {}

//  ALERTAS
if ($f) {
    echo '<script>window.location.href = "tipoPago.php";</script>';
    $_SESSION['success_message'] = 'Forma de pago actualizada';
} else {
    echo 'Fallo';
    $_SESSION['alert_message'] = 'Error al actualizar la forma de pago';
}

header("location: ../tipoPago.php");
?>  