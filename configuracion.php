<?php
include_once('auth.php');
include_once("inc/estructura/parte_superior.php");
include('config/dbconnect.php');
?>
<link rel="stylesheet" src="style.css" href="assets/css/configuracion/configuracion.css">
<div class="app-body-main-content">
    <div>
        <p>Pages<span> / Configuración</span></p>
        <h3>Configuración</h3>
    </div>
    <div class="main-content">
        <div class="container-configuracion">
            <div class="form-configuracion" >
                <div class="fr-conf-inputs" style="flex: 1.2;">
                    <h1 style="margin-bottom: 10px;">INGRESE LOS DATOS A CAMBIAR:</h1>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-sm"><i class="fa-solid fa-building"></i></span>
                        </div>
                        <input type="text" class="form-control" placeholder="Ingrese el nombre..."   >
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-sm"><i class="fa-solid fa-truck"></i></i></span>
                        </div>
                        <input type="text" class="form-control" placeholder="Ingrese el numero de Ruc..."  >
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-sm"><i class="fa-solid fa-location-dot"></i></span>
                        </div>
                        <input type="text" class="form-control" placeholder="Ingrese su dirección..."  >
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-sm"><i class="fa-solid fa-phone"></i></span>
                        </div>
                        <input type="text" class="form-control" placeholder="Ingrese el número de telefono..."  >
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-sm"><i class="fa-solid fa-palette"></i></span>
                        </div>
                        <input type="color" class="form-control form-control-color" id="color-picker" value="#563d7c">
                    </div>
                </div>
                <div class="fr-conf-image" style="flex: 1;">
                    <img src="assets/images/logo/logo-gym-aquiles.png" alt="">
                </div>
            </div>
            <div class="form-footer-configuracion">
                <button id="button-config">Guardar</button>
            </div>
        </div>
    </div>

<script>
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
    const buttons = document.getElementById("button-config")
    const colorValue = event.target.value;

    if (span || buttons) {
        span.style.color = colorValue;
        buttons.style.background = colorValue;
        console.log(colorValue);
    }
    
}

function updateAll(event) {
    document.querySelectorAll("span").forEach((span) => {
        span.style.color = event.target.value;
    });
}

</script>
    <?php
    include_once("inc/estructura/parte_inferior.php")
    ?>