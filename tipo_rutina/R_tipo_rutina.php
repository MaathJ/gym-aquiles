<?php  
include('../config/dbconnect.php');

// Obtener los datos del formulario
$n = $_POST['txtnombre'];
$p = $_POST['txtprecio'];

// Preparar la consulta SQL para insertar el tipo de rutina
$sql = "INSERT INTO tipo_rutina(nombre_tiru, precio_tiru) VALUES ('$n', '$p')";

// Ejecutar la consulta SQL
if(mysqli_query($cn, $sql)) {
    // Si la consulta se ejecuta con éxito, generar un mensaje de éxito
    $response = array(
        'success' => true,
        'message' => 'El tipo de rutina "' . $n . '" con precio S/' . $p . ' ha sido insertado correctamente.'
    );
} else {
    // Si hay un error en la consulta, generar un mensaje de error
    $response = array(
        'success' => false,
        'message' => 'Hubo un problema al insertar el tipo de rutina.'
    );
}

// Devolver la respuesta como JSON
echo json_encode($response);

// Redirigir de vuelta a la página de tipo_rutina.php
// No se ejecutará si la respuesta es enviada como JSON, ya que la página se redirigirá antes de imprimir cualquier cosa.
// header("location: ../tipo_rutina.php");
?>
