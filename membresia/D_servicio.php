<?php
include('../config/dbconnect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['txt_id'])) {
    $id = $_POST['txt_id'];

    $sql = "DELETE FROM servicio WHERE id_se = $id";

    if(mysqli_query($cn, $sql)) {
        $response = array(
            'success' => true,
            'message' => 'El servicio con ID ' . $id . ' ha sido eliminado exitosamente'
        );
    } else {
        $response = array(
            'success' => false,
            'message' => 'Hubo un problema al eliminar el servicio'
        );
    }

    echo json_encode($response);
} else {
    $response = array(
        'success' => false,
        'message' => 'No se recibió el ID del servicio'
    );

    echo json_encode($response);
}
?>

