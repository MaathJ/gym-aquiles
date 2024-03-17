<?php
include_once('config/dbconnect.php');
?>

<style>
.inputuser:hover{
  background-color: aliceblue !important;
  color: #000000 !important;
  transition: 1s !important;    
  
}

.inputuser:focus{
  background-color: aliceblue !important;
  color: #000000 !important;
  transition: 1s !important;

}
/* Estilo para el color del placeholder en estado :focus */
.inputuser:focus::placeholder {
  color: #000000 !important;
}

/* Estilo para el color del placeholder en estado :hover */
.inputuser:hover::placeholder {
  color: #000000 !important;
}

</style>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>


    <link rel="stylesheet" src="style.css" href="assets/css/login/login.css">
    <link rel="icon" href="assets/images/logo-gym-aquiles.png">

</head>
<body>
    <div class="body__login">
        <div class="form__container">
            <div class="logo__form">
                <img class="form__logo__zeus" src="assets/images/logo/logo-gym-aquiles.png" alt="Logo">
            </div>
                <form class="login__form" action="security.php" method="POST">
                    <label for="user">
                        Usuario
                    </label>
                        <input class="inputuser" type="text" name="usuario" placeholder="Username" required/>
                        <label for="password">
                        Contraseña
                        </label>
                        <input class="inputuser" type="password" name="password" placeholder="Password" required />
                        <input type="submit" class="sesion" Value="Iniciar Sesión"/>
                </form>
            </div>
        </div>
    </div>
</body>
</html>



