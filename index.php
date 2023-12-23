<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>


    <link rel="stylesheet" src="style.css" href="assets/css/login/login.css">

</head>
<body>
    <section class="container">
        <div class="login-container">
            <div class="form-container" >
                <div class="title-container">
                    <h1>GYM AQUILES</h1>
                    <img src="assets/images/background/image-3.png" alt="">
                </div>
                <form action="security.php"  method="post">
                    <input type="text" name="usuario" placeholder="Username" required/>
                    <input type="password" name="password" placeholder="Password" required />
                    <input type="submit" Value="Iniciar Sesion"/>
                </form>
            </div>
        </div>
    </section>
</body>
</html>
