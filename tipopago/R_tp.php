<?php 
include_once('../auth.php');
include('../config/dbconnect.php');
$desc = $_POST['desc'];

$sql="INSERT INTO tipo_pago (desc_tp) VALUES ('$desc')";

$f = mysqli_query($cn,$sql);

//  IMAGEN
try {
    $archivo = $_FILES['foto2']["tmp_name"]; 
    $nombres = $_FILES['foto2']["name"];

    if ($archivo != null) {
        list($n, $e) = explode(".", $nombres);
        if ($e == "png" || $e == "jpg" || $e == "jpeg") {
            $id = mysqli_insert_id($cn);
            move_uploaded_file($archivo, "../assets/images/tipoPago/" . $id . ".jpg");
        }
    }
} catch (\Throwable $th) {}

//  ALERTAS
if ($f) {
    echo '<script>window.location.href = "tipoPago.php";</script>';
    $_SESSION['success_message'] = 'Forma de pago registrada exitosamente';
} else {
    echo 'Fallo';
    $_SESSION['alert_message'] = 'Error al registrar la forma de pago';
}

header("location: ../tipoPago.php");
?>