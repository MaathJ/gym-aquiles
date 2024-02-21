<?php  
include('../config/dbconnect.php');


$codigo = $_POST['cod'];
$nombre = $_POST['txtnombre'];
$apellido = $_POST['txtapellido'];
$dni = $_POST['txtdni'];
$telefono = $_POST['txttelefono'];
$edad = $_POST['txtedad'];
$cargo = $_POST['lstcargo'];
$estado = $_POST['lstestado'];

$turno = $_POST['lstturn'];

$archivo = $_FILES['foto2']["tmp_name"]; 
$nombres=$_FILES["foto2"]["name"];




if($archivo != null){


list($n,$e)=explode(".",$nombres);
    

if ($e=="png" || $e=="jpg"|| $e=="jpeg") {


$sql2="UPDATE operario set 
nombre_op = '$nombre', 
apellido_op = '$apellido',
 dni_op='$dni', 
 telefono_op ='$telefono', 
 edad_op ='$edad',
 id_ca = '$cargo',
 id_tu = '$turno',
estado_op ='$estado'
    WHERE id_op = $codigo";


mysqli_query($cn,$sql2);

    move_uploaded_file($archivo,"../assets/images/operario/".$dni.".jpg");
header('location: ../operario.php');

    }else{
header('location:../operario.php');

}

}else{


    $sql3="UPDATE operario set 
    nombre_op = '$nombre', 
    apellido_op = '$apellido',
     dni_op='$dni', 
     telefono_op ='$telefono', 
     edad_op ='$edad',
     id_ca = '$cargo',
     id_tu = '$turno',
    estado_op ='$estado'
        WHERE id_op = $codigo";

    $f = mysqli_query($cn, $sql3);
    header('location:../operario.php');

}

?>