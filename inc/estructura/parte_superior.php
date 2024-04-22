
<?php 

include_once('./config/dbconnect.php');


$sqlconf = "SELECT * FROM configurador_historial WHERE estado_conf = 'ACTIVO'";
$fconf = mysqli_query($cn, $sqlconf);

$rconf = mysqli_fetch_assoc($fconf)
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gym Aquiles</title>
    <link rel="icon" type="image/png" href="assets/images/logo/logo-gym-aquiles.png">
    <link rel="stylesheet" href="plantilla.css">
    <link rel="stylesheet" src="style.css" href="assets/css/datatables/datatables.css">
    <link rel="stylesheet" src="style.css" href="assets/css/bootstrap/bootstrap.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="app">
        <div class="app-header" id="header">
            <div class="app-header-logo">
                <div class="logo">
                    <span class="logo-icon">
                    <img src="<?php echo !empty($rconf['foto_conf']) ? $rconf['foto_conf'] : './assets/images/config/Company.jpg'; ?>" alt="">


                    </span>
                    <h1 class="logo-title">
                        <span><?php
                                include_once('./auth.php');
                                include_once('./config/dbconnect.php');
                                $sql_gym = "SELECT * from configurador_historial where estado_conf='ACTIVO'";
                                $fsqlgym = mysqli_query($cn, $sql_gym);
                                $rsqlgym = mysqli_fetch_assoc($fsqlgym);
                                if (!$rsqlgym) {
                                    $rsqlgym = array(
                                        'txt_negocio' => 'EMPRESA',
                                    );
                                }
                                echo $rsqlgym["txt_negocio"];
                                ?></span>
                    </h1>
                </div>
            </div>
            <div class="app-header-actions">
                <button class="user-profile">
                    <span style="text-transform: capitalize;">
                        <?php
                        if ($_SESSION["name_user"]) {
                            $user = $_SESSION["name_user"];
                            echo $user;
                        }

                        ?></span>
                    <span><img src="assets/images/avatar/avatar-1.jpg" alt=""></span>
                </button>
                <div class="app-header-actions-buttons">
                    <a id="button-config" href="./cerrar_sesion.php">Cerrar Sesion</a>
                </div>
            </div>
        </div>




        <!-- Barra de Navegación -->
        <div class="app-body">
            <div class="app-body-navigation">
                <div class="navigation-section">
                    <div class="navigation">
                        <span class="section">Navigation</span>
                        <!-- Principal -->
                        <li class="section-item">
                            <a href="principal.php">
                                <i class="fas fa-home"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <!-- Asistencia -->
                        <li class="section-item">
                            <a href="asistencia.php">
                                <i class="fas fa-address-card"></i>
                                <span>Asistencia</span>
                            </a>
                        </li>
                        <!-- Registro Asistencia -->
                        <li class="section-item-options" id="rAsistencias">
                            <div class="section-item-container">
                                <div class="section-item-box">
                                    <a class="item-options">
                                    <i class="fa-solid fa-calendar-days"></i>
                                        <span>Registro Asistencia</span>
                                    </a>
                                </div>
                                <span>
                                    <i class="fa-solid fa-chevron-down"></i>
                                </span>
                            </div>
                            <ul class="optionsxd3">
                                <li>
                                    <a href="asistencia_dia.php">
                                        <span>Asistencia Clase</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="asistencia_ma.php">
                                        <span>Asistencia Matriculados</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="tipo_rutina.php">
                                        <span>Tipo Rutina</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!-- Suscripciones -->
                        <li class="section-item-options" id="suscripciones">
                            <div class="section-item-container">
                                <div class="section-item-box">
                                    <a class="item-options">
                                    <i class="fa-solid fa-handshake"></i>
                                        <span>Suscripciones</span>
                                    </a>
                                </div>
                                <span>
                                    <i class="fa-solid fa-chevron-down"></i>
                                </span>
                            </div>
                            <ul class="optionsxd2">
                                <li>
                                    <a href="matricula.php">
                                        <span>Matricula</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="membresia.php">
                                        <span>Membresia</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="servicio.php">
                                        <span>Servicio</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="tipo_rutina.php">
                                        <span>Rutina</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="tipoPago.php">
                                        <span>Tipo de Pagos</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="section-item-options" id="rOperario">
                            <div class="section-item-container">
                                <div class="section-item-box">
                                    <a class="item-options">
                                    <i class="fa-solid fa-user-tie"></i>
                                        <span>Operario</span>
                                    </a>
                                </div>
                                <span>
                                    <i class="fa-solid fa-chevron-down"></i>
                                </span>
                            </div>
                            <ul class="optionsxd4">
                                <li>
                                    <a href="asistenciaop.php">
                                        <span>Asist. Operario</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="operario.php">
                                        <span>Operario</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="turno.php">
                                        <span>Turno</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="cargo.php">
                                        <span>Cargo</span>
                                    </a>
                                </li>

                            </ul>
                        </li>
                        <!-- Cliente -->
                        <li class="section-item">
                            <a href="cliente.php">
                                <i class="fas fa-solid fa-dumbbell"></i>
                                <span>Cliente</span>
                            </a>
                        </li>
                        <!-- Usuarios -->
                        <li class="section-item-options" id="usuario">
                            <div class="section-item-container">
                                <div class="section-item-box">
                                    <a class="item-options">
                                    <i class="fa-solid fa-user"></i>
                                        <span>Users</span>
                                    </a>
                                </div>
                                <span>
                                    <i class="fa-solid fa-chevron-down"></i>
                                </span>
                            </div>
                            <ul class="optionsxd">
                                <li>
                                    <a href="usuario.php">
                                        <span>Usuario</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="roles.php">
                                        <span>Roles</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Reportes -->
                        <li class="section-item-options" id="report">
                            <div class="section-item-container">
                                <div class="section-item-box">
                                    <a class="item-options">
                                    <i class="fa-solid fa-chart-column"></i>
                                        <span>Reportes</span>
                                    </a>
                                </div>
                                <span>
                                    <i class="fa-solid fa-chevron-down"></i>
                                </span>
                            </div>
                            <ul class="optionsxd5">
                                <li>
                                    <a href="report_general.php">
                                        <span>Registro Ingresos</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="cajas.php">
                                        <span>Caja Usuario</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="section-item">
                            <a href="configuracion.php" style="display: flex;  align-items: center;">
                                <i class="fa-solid fa-gear"></i>
                                <span>Configuración</span>
                            </a>
                        </li>


                    </div>



                </div>
            </div>



            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    var registroAsistencia = document.getElementById("rAsistencias");
                    var suscripciones = document.getElementById("suscripciones");
                    var operario = document.getElementById("rOperario");
                    var users = document.getElementById("usuario");

                    registroAsistencia.addEventListener("click", function() {
                        var sublista = registroAsistencia.querySelector(".optionsxd3");
                        sublista.classList.toggle("show");
                        var icono = registroAsistencia.querySelector("i.fa-solid.fa-chevron-down");
                        icono.classList.toggle("rotated");
                    });

                    suscripciones.addEventListener("click", function() {
                        var sublista = suscripciones.querySelector(".optionsxd2");
                        sublista.classList.toggle("show");
                        var icono = suscripciones.querySelector("i.fa-solid.fa-chevron-down");
                        icono.classList.toggle("rotated");
                    });

                    operario.addEventListener("click", function() {
                        var sublista = operario.querySelector(".optionsxd4");
                        sublista.classList.toggle("show");
                        var icono = operario.querySelector("i.fa-solid.fa-chevron-down");
                        icono.classList.toggle("rotated");
                    });

                    report.addEventListener("click", function() {
                        var sublista = report.querySelector(".optionsxd5");
                        sublista.classList.toggle("show");
                        var icono = report.querySelector("i.fa-solid.fa-chevron-down");
                        icono.classList.toggle("rotated");
                    });

                    users.addEventListener("click", function() {
                        var sublista = users.querySelector(".optionsxd");
                        sublista.classList.toggle("show");
                        var icono = users.querySelector("i.fa-solid.fa-chevron-down");
                        icono.classList.toggle("rotated");
                    });

                });
            </script>

            <style>
                .rotated {
                    transform: rotate(180deg);
                }

                .optionsxd3,
                .optionsxd2,
                .optionsxd,
                .optionsxd4,
                .optionsxd5 {
                    display: none;
                    animation: slideDown 0.5s ease;
                }

                .optionsxd3.show,
                .optionsxd2.show,
                .optionsxd.show,
                .optionsxd4.show ,
                .optionsxd5.show{
                    display: block;
                }

                @keyframes slideDown {
                    from {
                        opacity: 0;
                        transform: translateY(-10px);
                    }

                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }
            </style>