<?php 
include_once('../auth.php');
include_once('../config/dbconnect.php');
date_default_timezone_set('America/Lima');
// Obtener la fecha y hora actual en formato peruano
$usuario = $_SESSION["usuario"];
$fechadesde = $_POST['a_fechadesde'];
$fechahasta = $_POST['a_fechahasta'];
$estado = 'EN ESPERA';
$fechaActual = date('Y-m-d H:i:s');
$cliente = $_POST['a_lstcliente'];
$membresia = $_POST['a_lstmembresia'];
$tpago = $_POST["a_lst_tp"];

$sql = "INSERT INTO matricula (fechainicio_ma, fechafin_ma, estado_ma,fecharegistro_ma, id_cli, id_me, id_us,id_tp)
        VALUES('$fechadesde', '$fechahasta', '$estado','$fechaActual', '$cliente', $membresia, $usuario,$tpago)";
$fregister = mysqli_query($cn, $sql);

if ($fregister) {
    echo '<script>window.location.href = "matricula.php";</script>';

    $_SESSION['success_message'] = 'Matrícula registrada exitosamente';
} else {
    echo 'Fallo';
    $_SESSION['alert_message'] = 'Error al registrar la matrícula';

}
header('location: ../matricula.php');
?>