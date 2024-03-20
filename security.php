<?php 
session_start();
include('config/dbconnect.php');

$usuario= $_POST["usuario"];
$password= $_POST["password"];

$sql = "SELECT * FROM usuario WHERE usuario_us = '$usuario' AND password_us = '$password' AND estado_us='ACTIVO'";
$f = mysqli_query($cn, $sql);
$r = mysqli_fetch_assoc($f);

$valor=$r["id_us"];
$codigo = $r["id_us"];

if($r){
   $_SESSION["usuario"]=$valor;
   $_SESSION["auth"]=1;
   $_SESSION["codigo"] = $codigo;
   $_SESSION["name_user"] =$usuario;

    $mensajeIngre="USUARIO correcto";

   header('location:principal.php');
    
	  echo '<script>window.location.href = "principal.php"</script>';
 exit();
 }else if($valor==null){ 

    $_SESSION["auth"]=0;
    $mensaje="USUARIO INCORRECTO";

    header('location:index.php?msjincorrecto='.$mensaje);
//    echo '<script>window.location.href = "index.php?msjincorrecto=' . $mensaje . '";</script>';

 }

?>