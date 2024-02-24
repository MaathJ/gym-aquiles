<?php
include_once('../auth.php');
include_once('../config/dbconnect.php');

$id = $_POST['id_u'];
$fecha_ini = $_POST['u_fechadesde'];
$fecha_fin = $_POST['u_fechahasta'];
$estado = $_POST['u_lstestado'];
$id_cli = $_POST['u_lstcliente']; 
$id_me = $_POST['u_lstmembresia'];
$tpago = $_POST['u_lst_tp'];

$sql="update matricula set
    fechainicio_ma='$fecha_ini',
    fechafin_ma='$fecha_fin',
    estado_ma='$estado',
    id_tp = $tpago,
    id_cli='$id_cli',
    id_me='$id_me'
    where id_ma=$id";

mysqli_query($cn, $sql);

header('location: ../matricula.php');
?>