<?php
include('../config/dbconnect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['txt_nomb'];

    $sql = "INSERT INTO servicio(nombre_se) VALUES ('$nombre')";

    if(mysqli_query($cn, $sql)) {
        $response = array(
            'success' => true,
            'message' => 'Servicio Registrado exitosamente'
        );
        header('location:../rutina.php');
    } else {
        $response = array(
            'success' => false,
            'message' => 'Hubo un problema al agregar el servicio.'
        );
        header('location:../rutina.php');
    }

    echo json_encode($response);
    exit(); // Detener la ejecución del script después de enviar la respuesta
}


?>
