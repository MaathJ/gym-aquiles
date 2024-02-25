<?php
include_once('../config/dbconnect.php');

$id = $_POST['id_u'];
$fecha_ini = $_POST['fechadesde'];
$fecha_fin = $_POST['fechahasta'];
$estado = $_POST['lstestado'];
$id_cli = $_POST['lstcliente']; 
$id_me = $_POST['lstmembresia'];

$sql="update matricula set
    fechainicio_ma='$fecha_ini',
    fechafin_ma='$fecha_fin',
    estado_ma='$estado',
    id_cli='$id_cli',
    id_me='$id_me'
    where id_ma=$id";

mysqli_query($cn, $sql);

header('location: ../matricula.php');
?>