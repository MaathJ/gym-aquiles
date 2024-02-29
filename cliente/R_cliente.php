<?php
session_start();
include('../config/dbconnect.php');


$nombre = $_POST['txtnombre'];
$apellido = $_POST['txtapellido'];
$dni = $_POST['txtdni'];
$telefono = $_POST['txttelefono'];
$edad = $_POST['txtedad'];
$direccion = $_POST['txtdireccion'];
$genero = $_POST['lstgenero'];

$enfermedad = $_POST['txtenfermedad'];

$archivo = $_FILES['foto']["tmp_name"];
$nombres = $_FILES["foto"]["name"];

if ($archivo != null) {
    list($n, $e) = explode(".", $nombres);
    if ($e == "png" || $e == "jpg" || $e == "jpeg") {
        $verificarDni = mysqli_fetch_assoc(mysqli_query(
            $cn,
            "SELECT dni_cli from cliente where dni_cli='$dni'"
        ));
        if (!empty($verificarDni)) {
			$_SESSION['error_client'] = 'El dni '. $dni . ', ya se encuentra registrado';
            header('Location: ../cliente.php');
            exit();
        }

        $sql = "insert into cliente(nombre_cli, apellido_cli, dni_cli, telefono_cli, edad_cli, genero_cli, direccion_cli, estado_cli, enfermedad_cli) values ('$nombre','$apellido','$dni','$telefono','$edad','$genero','$direccion','ACTIVO','$enfermedad')";
        $f = mysqli_query($cn, $sql);
        move_uploaded_file($archivo, "../assets/images/cliente/" . $dni . ".jpg");
        $_SESSION['register_client']=true;
        header('location: ../cliente.php');
    } else {
        header('location:../cliente.php');
    }
} else {
    header('location:../cliente.php');
}
