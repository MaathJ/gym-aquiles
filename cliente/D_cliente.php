<?php  
include('../config/dbconnect.php');

if(isset($_GET['d'])) {
    $codigo = $_GET['d'];

    $sql = "DELETE FROM cliente WHERE id_cli = '$codigo'";

    if(mysqli_query($cn, $sql)) {
		header('location:../cliente.php');
    } else {
        echo "Error al eliminar el cliente: " . mysqli_error($cn);
    }
} 
?>
