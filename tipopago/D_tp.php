<?php  
session_start();
include('../config/dbconnect.php');

$codigo = $_POST['txt_id'];
$nombre_pago = "";

try {
    $sql_select = "SELECT desc_tp FROM tipo_pago WHERE id_tp = $codigo";
    $result = mysqli_query($cn, $sql_select);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        $nombre_pago = $row['desc_tp'];
        $sql = "DELETE FROM tipo_pago WHERE id_tp = $codigo";
        mysqli_query($cn, $sql);
        $_SESSION['deleted_message'] = "Tipo de pago eliminado: $nombre_pago";
    } else {
        $_SESSION['deleted_message'] = "No se pudo obtener la información del tipo de pago: $id";
    }
} catch (Exception $e) {
    $_SESSION['error_message'] = "Error al eliminar el tipo de pago: $nombre_pago";
}

header('location: ../tipoPago.php');
?>
