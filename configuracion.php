<?php
include_once('auth.php');
include_once("inc/estructura/parte_superior.php");
include('config/dbconnect.php');

$sql = "SELECT * FROM configurador_historial WHERE estado_conf = 'ACTIVO'";
$f = mysqli_query($cn, $sql);
$r = mysqli_fetch_assoc($f);

if (!$r) {
    $r = array(
        'txt_negocio' => '',
        'ruc_negocio' => '',
        'direccion_negocio' => '',
        'telefono_negocio' => '',
        'color_negocio' => '',
        'foto_conf' => ''
    );
}
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
                        <h1 style="margin-bottom: 10px;">DATOS DE LA EMPRESA:</h1>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-sm"><i class="fa-solid fa-building"></i></span>
                            </div>
                            <input type="text" name="txt_name" class="form-control" placeholder="Ingrese el nombre..." maxlength="20" value="<?php echo isset($r['txt_negocio']) ? $r['txt_negocio'] : '' ?>">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-sm"><i class="fa-solid fa-truck"></i></i></span>
                            </div>
                            <input type="text" name="txt_ruc" class="form-control" placeholder="Ingrese el numero de Ruc..." maxlength="10" value="<?php echo isset($r['ruc_negocio']) ? $r['ruc_negocio'] : '' ?>">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-sm"><i class="fa-solid fa-location-dot"></i></span>
                            </div>
                            <input type="text" name="txt_direccion" class="form-control" placeholder="Ingrese su dirección..." maxlength="40" value="<?php echo isset($r['direccion_negocio']) ? $r['direccion_negocio'] : ''   ?>">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-sm"><i class="fa-solid fa-phone"></i></span>
                            </div>
                            <input type="text" name="txt_telefono" class="form-control" placeholder="Ingrese el número de telefono..." maxlength="9" value="<?php echo isset($r['telefono_negocio']) ? $r['telefono_negocio'] : '' ?>">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-sm"><i class="fa-solid fa-palette"></i></span>
                            </div>
                            <input type="color" name="txt_color" class="form-control form-control-color" id="color-picker" value="<?php echo isset($r['color_negocio']) ? $r['color_negocio'] : '' ?>">
                        </div>
                        <div class="input-group mb-3">

                        </div>
                    </div>
                    <div class="fr-conf-image" style="flex: 1;">
                        <div class="col-md-12">
                            <div class="row" style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
                                <img src="<?php echo !empty($r['foto_conf']) ? $r['foto_conf'] : './assets/images/config/Company.jpg'; ?>" alt="avatar" id="img" width="400" height="400" style="object-fit: cover; border-radius: 100%;">

                                <input type="file" value="<?php echo isset($r['foto_conf']) ? $r['foto_conf'] : '' ?>" name="foto" id="foto" accept="image/*">
                                <label class="btn_img btn-danger" for="foto">CAMBIAR FOTO</label>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="form-footer-configuracion">
                    <input type="hidden" name="color_value" id="color_value" value="<?php echo $r['color_negocio'] ?>">
                    <button type="submit" class="btn btn-primary" style="width: 200px;" id="button-config">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function crearFileDesdeRuta(ruta) {
                const nombreArchivo = ruta.split("/").pop();
                const tipoArchivo = "image/jpeg"; // Reemplaza "image/jpeg" con el tipo de imagen real

                const file = new File([""], nombreArchivo, {
                    type: tipoArchivo,
                });

                return file;
            }

            function crearArrayArchivos(file) {
                const files = [file];

                return files;
            }

            function cargarImagen(ruta) {
                const file = crearFileDesdeRuta(ruta);
                const files = crearArrayArchivos(file);
                console.log(files);
                document.getElementById("foto").files = files;
            }


            function obtenerRutaImagen() {
                $.ajax({
                    url: "config_historial/imagencargada.php", // Reemplaza "ruta/al/archivo_php.php" con la ruta real al archivo PHP
                    method: "GET",
                    dataType: "json",
                    success: function(rutaImagen) {
                        cargarImagen(rutaImagen);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        // Mostrar mensaje al usuario
                        alert("Error al obtener la ruta de la imagen: " + textStatus);

                        // Registrar error en la consola
                        console.error("Error AJAX:", jqXHR, textStatus, errorThrown);
                    },
                });
            }



            // Obtener la ruta de la imagen y cargarla
            obtenerRutaImagen();

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