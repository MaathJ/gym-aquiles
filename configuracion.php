<?php
include_once('auth.php');
include_once("inc/estructura/parte_superior.php");
include('config/dbconnect.php');

$sql = "SELECT * FROM configurador_historial WHERE estado_conf = 'ACTIVO'";
$f = mysqli_query($cn, $sql);
$r = mysqli_fetch_assoc($f);
?>
<link rel="stylesheet" src="style.css" href="assets/css/configuracion/configuracion.css">
<div class="app-body-main-content">
    <div>
        <p>Pages<span> / Configuración</span></p>
        <h3>Configuración</h3>
    </div>
    <div class="main-content">
        <div class="container-configuracion">
            <form action="config_historial/R_configHist.php" method="post" enctype="multipart/form-data">
                <div class="form-configuracion">
                    <div class="fr-conf-inputs" style="flex: 1.2;">
                        <h1 style="margin-bottom: 10px;">INGRESE LOS DATOS A CAMBIAR:</h1>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-sm"><i class="fa-solid fa-building"></i></span>
                            </div>
                            <input type="text" name="txt_name" class="form-control" placeholder="Ingrese el nombre..." maxlength="20" value="<?php echo $r['txt_negocio'] ?>">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-sm"><i class="fa-solid fa-truck"></i></i></span>
                            </div>
                            <input type="text" name="txt_ruc" class="form-control" placeholder="Ingrese el numero de Ruc..." maxlength="8" value="<?php echo $r['ruc_negocio'] ?>">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-sm"><i class="fa-solid fa-location-dot"></i></span>
                            </div>
                            <input type="text" name="txt_direccion" class="form-control" placeholder="Ingrese su dirección..." maxlength="40" value="<?php echo $r['direccion_negocio'] ?>">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-sm"><i class="fa-solid fa-phone"></i></span>
                            </div>
                            <input type="text" name="txt_telefono" class="form-control" placeholder="Ingrese el número de telefono..." maxlength="9" value="<?php echo $r['telefono_negocio'] ?>">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-sm"><i class="fa-solid fa-palette"></i></span>
                            </div>
                            <input type="color" name="txt_color" class="form-control form-control-color" id="color-picker" value="<?php echo $r['color_negocio'] ?>">
                        </div>
                        <div class="input-group mb-3">
                            <input value="<?php echo $r['foto_conf'] ?>" type="file" name="foto" id="foto" accept="image/*">
                            <label class="btn_img btn-danger" for="foto">CAMBIAR FOTO</label>
                        </div>
                    </div>
                    <div class="fr-conf-image" style="flex: 1;">
                        <img src="<?php echo $r['foto_conf'] ?>" alt="avatar" id="img" width="400" height="400">
                    </div>
                </div>
                <div class="form-footer-configuracion">
                    <input type="hidden" name="color_value" id="color_value" value="<?php echo $r['color_negocio'] ?>">
                    <button type="submit" id="button-config">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let foto = document.getElementById("foto");

            fetch("config_historial/imagencargada.php")
                .then(response => response.text())
                .then(rutaImagen => {
                    foto.src = "./" + rutaImagen;
                });

            let inputPickerColor;
            window.addEventListener("load", changeColor, false);

            function changeColor() {
                inputPickerColor = document.querySelector('#color-picker')
                inputPickerColor.addEventListener("input", updateFirst, false);
                inputPickerColor.addEventListener("change", updateAll, false);
                inputPickerColor.select();

            }

            function updateFirst(event) {
                const span = document.querySelector("span");
                const buttons = document.getElementById("button-config");
                const colorValue = event.target.value;

                if (span || buttons) {
                    span.style.color = colorValue;
                    buttons.style.background = colorValue;
                    document.getElementById("color_value").value = colorValue; 
                }
            }


            function updateAll(event) {
                document.querySelectorAll("span").forEach((span) => {
                    span.style.color = event.target.value;
                });
            }
        });
    </script>
    <script src="assets/js/imagenes/imagenes2.js"></script>
    <style type="text/css">
        #foto {
            display: none;
        }

        .btn_img {
            width: 200px;
            text-align: center;
            border-radius: 10px;
            margin-top: 5px;
            padding-top: 5px;
            height: 35px;
        }

        .fr-conf-image {
            margin-left: 10px
        }
    </style>
    <?php
    include_once("inc/estructura/parte_inferior.php")
    ?>