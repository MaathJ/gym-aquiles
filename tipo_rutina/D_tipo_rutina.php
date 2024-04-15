<?php  
include('../config/dbconnect.php');

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['txt_id'])) {
    $codigo = $_POST['txt_id'];

    $sql = "DELETE FROM tipo_rutina WHERE id_tiru = '$codigo'";

    if (mysqli_query($cn, $sql)) {
        $response = array(
            'success' => true,
            'message' => 'El tipo de rutina con el código ' . $codigo . ' ha sido eliminado correctamente.'
        );
    } else {
        $response = array(
            'success' => false,
            'message' => 'Error al eliminar el tipo de rutina con el código ' . $codigo . ': ' . mysqli_error($cn)
        );
    }

    mysqli_close($cn);
} else {
    $response = array(
        'success' => false,
        'message' => 'No se proporcionó un código para eliminar.'
    );
}

echo json_encode($response);
header('location: ../tipo_rutina.php');
?>
