<?php
include_once('auth.php');
include('inc/estructura/parte_superior.php');
//Trae el modal y el script
include_once('ticket_extension.php');
//--------------------------
?>
<link rel="stylesheet" src="style.css" href="assets/css/asistencia/asistencia.css">
<div class="app-body-main-content">
    <div>
        <p>Pages<span> / Asistencia</span></p>
        <h3>Asistencia</h1>
    </div>
    <div class="main-content">
        <div class="main-content-matriculados" style="flex: 2">
            <div class="matriculados">
                <input type="text" id="buscador" placeholder="Ingrese su DNI">
            </div>
            <div class="matriculados-info">
            </div> 
            
        </div>
        <div class="main-content-inscripcion" style="flex: 1">
            <div class="inscripcion-content">
                <h2 style="color:#f05941; text-transform: capitalize; font-weight:bolder;">Inscripciones por dia</h2>
                <section class="form-clase">
                    <label for="tittle_nombres">Nombres y Apellidos:</label><br>
                    <input required type="text" id="txt_nombre" name="txt_nombre" placeholder="Ingresa el nombre completo.."><br>
                    <label for="lst_rutina">Rutina</label>
                    <select id="lst_rutina" name="text_rutina" class="form-select">
                    <?php 
                        include('config/dbconnect.php');
                        $sql_2 = "select * from tipo_rutina";
                        $f = mysqli_query($cn,$sql_2);
                        while($r = mysqli_fetch_assoc($f)){
                    ?>
                        <option value="<?php echo $r['id_tiru'] ?>"><?php echo $r['nombre_tiru'] ?></option>
                    <?php } ?>
                    </select>

                    <!-- Medio de pago -->
                    <label for="tipo_pago">
                        Tipo de pago:
                    </label>
                    <select class="form-select" name="lst_tp" id="lst_tp" required>
                        <option disabled selected value="0">Selecciona un tipo de pago</option>

                        <?php
                        $sql_tp = "SELECT * FROM tipo_pago";
                        $f_tp = mysqli_query($cn, $sql_tp);

                        while ($r_tp = mysqli_fetch_assoc($f_tp)) {
                        ?>
                            <option value="<?php echo $r_tp['id_tp'] ?>"><?php echo $r_tp['desc_tp'];?></option>

                        <?php } ?>
                    </select>

                    <input class="btn-regis" type="submit" value="Registrar" id="registro_hoy">
                </section>
            </div>
        </div>
    </div>
</div>

<?php
include_once("inc/estructura/parte_inferior.php")
?>

<script>
$(document).ready(function () {
    var timeoutId;

    $('#buscador').on('keydown', function (event) {
        if (event.which === 13) {
            event.preventDefault();
            search();
        }
    });

    function search() {
        var searchTerm = $('#buscador').val();

        if (searchTerm.length >= 3) {
            $.ajax({
                type: 'POST',
                url: 'buscador.php',
                data: { searchTerm: searchTerm },
                success: function (response) {
                    if (response.trim() !== "") {
                        if (response.includes('Ya ingresó hoy')) {
                            // Si la respuesta contiene la alerta de asistencia duplicada, muestra la alerta y no actualices la página
                            Swal.fire({
                                icon: 'warning',
                                title: '¡No puede ingresar!',
                                text: 'Quiere ingresar dos veces , ya registro su ingreso anteriormente',
                            });
                        } else {
                            // Mostrar alerta de éxito
                            Swal.fire({
                                icon: 'success',
                                title: 'Se registró con Éxito',
                                text: 'Su ingreso',
                                showConfirmButton: false
                            });

                            // Actualizar el contenido de matriculados-info con los resultados de la búsqueda
                            $('.matriculados-info').html(response);

                            // Limpiar el contenido después de 15 segundos
                            clearTimeout(timeoutId);
                            timeoutId = setTimeout(function () {
                                $('.matriculados-info').empty();
                            }, 15000);

                            // Limpiar el campo de búsqueda después de mostrar los resultados
                            $('#buscador').val("");
                        }
                    } else {
                        // Mostrar alerta de error
                        Swal.fire({
                            icon: 'warning',
                            title: 'SE ACABÓ SU MATRÍCULA O NO ESTÁ MATRICULADO',
                            text: 'Verifique en los matriculados'
                        });

                        // Limpiar el contenido si el término de búsqueda no devuelve resultados
                        $('.matriculados-info').empty();

                        // Limpiar el campo de búsqueda después de mostrar la alerta de error
                        $('#buscador').val("");
                    }
                }
            });
        } else {
            // Mostrar alerta de error si el término de búsqueda es menor a 3 caracteres
            Swal.fire({
                icon: 'error',
                title: 'Ingrese al menos 3 caracteres',
                text: 'Vuelva a intentarlo'
            });

            // Limpiar el contenido si el término de búsqueda es menor a 3 caracteres
            $('.matriculados-info').empty();

            // Limpiar el campo de búsqueda después de mostrar la alerta de error
            $('#buscador').val("");
        }
    }
});

//AJAX PARA ASISTENCIA HOY
$(document).ready(function () {
    var timeoutId;

    $('#registro_hoy').on('click', function (event) {
        var txt_nombre = $('#txt_nombre').val();
        var lst_rutina = $('#lst_rutina').val();
        var lst_tp = $('#lst_tp').val();

        if (txt_nombre !== "" && lst_rutina !== 0 && lst_tp !== 0) {
            $.ajax({
                type: 'POST',
                url: 'asistencia_dia/R_asistencia_dia.php',
                data: { txt_nombre: txt_nombre,
                        lst_rutina: lst_rutina,
                        lst_tp: lst_tp},
                success: function (response) {
                    if (response.trim() !== "") {
                        // Mostrar alerta de éxito
                        Swal.fire({
                            icon: 'success',
                            title: 'Se registró con Éxito',
                            text: 'Su ingreso',
                            showConfirmButton: false
                        });

                        // Actualizar el contenido de matriculados-info con los resultados de la búsqueda
                        $('.matriculados-info').html(response);

                        // Limpiar el contenido después de 15 segundos
                        clearTimeout(timeoutId);
                        timeoutId = setTimeout(function () {
                            $('.matriculados-info').empty();
                        }, 15000);

                        // Limpiar el campo de búsqueda después de mostrar los resultados
                        $('#txt_nombre').val("");
                        $('#lst_rutina').val(0);
                        $('#lst_tp').val(0);
                    } else {
                        // Mostrar alerta de error
                        Swal.fire({
                            icon: 'warning',
                            title: 'Registro falliso',
                            text: 'Verifique los campos registrados'
                        });

                        // Limpiar el contenido si el término de búsqueda no devuelve resultados
                        $('.matriculados-info').empty();
                    }
                }
            });
        } else {
            // Mostrar alerta de error si el término de búsqueda es menor a 3 caracteres
            Swal.fire({
                icon: 'error',
                title: 'Registro fallido',
                text: 'Vuelva a intentarlo'
            });

            // Limpiar el contenido si el término de búsqueda es menor a 3 caracteres
            $('.matriculados-info').empty();

            // Limpiar el campo de búsqueda después de mostrar la alerta de error
            $('#txt_nombre').val("");
            $('#lst_rutina').val(0);
            $('#lst_tp').val(0);
        }
    });
});
</script>